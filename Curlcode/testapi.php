<?php 

define('DEBUG', true);
ini_set('display_errors', 1);
error_reporting(1);
set_time_limit(0);

$servername = "localhost";
$username   = "megatanw_dev";
$password   = "Sylvina1!Noobs";
$dbname     = "megatanw_dev";
$conn       = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//----API VARIABLES
$storeHash    = 's78lylaaae';
$x_auth_token = '8bpsdnbnpexnov6vv6bkkuoufm8rq3j';

//--------curl to create a order---------------
$ch = curl_init('https://api.bigcommerce.com/stores/'.$storeHash.'/v2/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);

// Set HTTP Header for POST request 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Content-Type: application/json',
    'x-auth-token: '.$x_auth_token
));

//syncd       : Order sync to Bigcommerce successfully
//isValid     : Product not found in Bigcommerce eg: Product id = 5. If is_valid = 1 then prodcu matched else is_valid = 0
//is_error    : if sync error then 1 else 0
//customer_id : if -1 then not exist in bigcommerce, else if 0 then guest else valid user id

$cronlimit_query    = 'select * from cron_limit';
$cronlimit_Result   = mysqli_query($conn, $cronlimit_query);
$cronlimit          = $cronlimit_Result->fetch_assoc();
$limitVar           = $cronlimit['cronlimit'];

$orders_query = 'select * from big_orders where customer_id <> -1 and syncd = 0 and isValid=1 and is_error = 0 order by id asc limit '.$limitVar.',500';
//$orders_query = 'select * from big_orders where customer_id <> -1 and syncd = 0 and isValid=1 and noorderid= 107';
$order_Result = mysqli_query($conn, $orders_query);

echo '<pre>';
if(mysqli_num_rows($order_Result) > 0)
{
   while($order = $order_Result->fetch_assoc())
   {   
        $billing_phone = $order['billing_phone'];
        $billing_email = $order['billing_email'];

        if($billing_phone == '')
        {
            $billing_phone = '0000000000';
        }

        if($billing_email == '')
        {
            $billing_email = 'megatanerror@gmail.com';
        }
        
        $billing_address = [
  
              'first_name'     =>  $order['billing_first_name'],
              'last_name'      =>  $order['billing_last_name'],
              'street_1'       =>  $order['billing_street_1'],
              'street_2'       =>  $order['billing_street_2'],
              'city'           =>  $order['billing_city'],
              'state'          =>  $order['billing_state'],
              'zip'            =>  $order['billing_zip'],
              'country'        =>  $order['billing_country'],
              'country_iso2'   =>  $order['billing_country_iso2'],
              'email'          =>  $billing_email,
              'phone'          =>  $billing_phone,
        ];

        $shipping_phone = $order['shipping_phone'];
        $shipping_email = $order['shipping_email'];

        if($shipping_phone == '')
        {
            $shipping_phone = $billing_phone;
        }

        if($shipping_email == '')
        {
            $shipping_email = $billing_email;
        }

        $shipping_address = [
  
            [
                  'first_name'     =>  $order['shipping_first_name'],
                  'last_name'      =>  $order['shipping_last_name'],
                  'street_1'       =>  $order['shipping_street_1'],
                  'street_2'       =>  $order['shipping_street_2'],
                  'city'           =>  $order['shipping_city'],
                  'state'          =>  $order['shipping_state'],
                  'zip'            =>  $order['shipping_zip'],
                  'country'        =>  $order['shipping_country'],
                  'country_iso2'   =>  $order['shipping_country_iso2'],
                  'email'          =>  $shipping_email,
                  'phone'          =>  $shipping_phone,
            ]
        ];

        $products = json_decode($order['products']);

        $productsArr = array();

        for($i = 0; $i<count($products); $i++)
        {
             $product = $products[$i];

             $productsArr[] = [
                                 'product_id' => $product->productId,
                                 'quantity'   => (int)$product->productQuantity
                              ];
        }

        $data = array(
              
              'billing_address'    => $billing_address,
              'shipping_addresses' => $shipping_address,
              'products'           => $productsArr,
              'status_id'          => $order['status_id'],
          );

        if($order['customer_id'] != 0) //if not givent auto set to guest
        {
           $data['customer_id'] = $order['customer_id'];
        }

        //Create Order start
        $payload = json_encode($data); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        print_r($result);
        $dataRes   = json_decode($result);
        print_r($dataRes);

        if(!isset($dataRes->id))
        {
           $error_query        = 'update big_orders set is_error=1 where noorderid='.$order['noorderid'];
           $error_query_Result = mysqli_query($conn, $error_query);
        }
        else if(isset($dataRes->id) && $dataRes->id != '')
        {
            echo 'order created-->'.$dataRes->id.' <br>';
            $syncd_query        = 'update big_orders set syncd=1 where noorderid='.$order['noorderid'];
            $syncd_query_Result = mysqli_query($conn, $syncd_query);

            //------update cron limit----------
              $limitVar++;
              $update_cronlimit_query   = 'update cron_limit set cronlimit='.$limitVar;
              $update_cronlimit_Result  = mysqli_query($conn, $update_cronlimit_query);
            //---------------------------------

            $orderId = $dataRes->id;

            if($order['tracking_number'] != '')
            {
               //--------curl to get order products start---------------
                $chOrderProductUrl = 'https://api.bigcommerce.com/stores/'.$storeHash.'/v2/orders/'.$orderId.'/products';
                $chOrderProduct = curl_init($chOrderProductUrl);
                curl_setopt($chOrderProduct, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chOrderProduct, CURLINFO_HEADER_OUT, true);
                curl_setopt($chOrderProduct, CURLOPT_CUSTOMREQUEST, 'GET');

                // Set HTTP Header for POST request 
                curl_setopt($chOrderProduct, CURLOPT_HTTPHEADER, array(
                    'accept: application/json',
                    'Content-Type: application/json',
                    'x-auth-token: '.$x_auth_token
                ));

                $result_products = json_decode(curl_exec($chOrderProduct));
                curl_close($chOrderProduct);
                //--------curl to get order products End-----------------

                //--------curl to set order shipment start---------------
                $itemsArr = array();

                for($i=0; $i<count($result_products); $i++)
                {
                     $product = $result_products[$i];

                     $itemsArr[] = [
                            
                                     'order_product_id' => $product->id,
                                     'quantity'         => (int)$product->quantity
                                   ];
                }

                $shipment_data = [
                                      'tracking_number'   => $order['tracking_number'],
                                      'comments'          => $order['comments'],
                                      'order_address_id'  => $result_products[0]->order_address_id,
                                      'shipping_provider' => $order['shipping_provider'],
                                      'items'             => $itemsArr
                                 ];

                  $chOrderShipUrl = 'https://api.bigcommerce.com/stores/'.$storeHash.'/v2/orders/'.$orderId.'/shipments';
                  $chOrderShip = curl_init($chOrderShipUrl);
                  curl_setopt($chOrderShip, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($chOrderShip, CURLINFO_HEADER_OUT, true);
                  curl_setopt($chOrderShip, CURLOPT_POST, true);

                  // Set HTTP Header for POST request 
                  curl_setopt($chOrderShip, CURLOPT_HTTPHEADER, array(
                      'accept: application/json',
                      'Content-Type: application/json',
                      'x-auth-token: '.$x_auth_token
                  ));
                  
                  $shipment_payload = json_encode($shipment_data);
                  curl_setopt($chOrderShip, CURLOPT_POSTFIELDS, $shipment_payload);
                  $result_ship = curl_exec($chOrderShip);
                  curl_close($chOrderShip);

                  echo'order shiped---> <br>';
                 
                //--------curl to set order shipment End-----------------                

                
               //-------------------------------- 
               

            }
            
        }else{}

      echo '------------------------------<br><br>';
   }
}

// Close cURL session handle
curl_close($ch);

?>