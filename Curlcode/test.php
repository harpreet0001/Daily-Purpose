<?php 
define('DEBUG', true);
ini_set('display_errors', 1);
error_reporting(-1);
set_time_limit(0);
$servername = "localhost";
$username   = "megatanw_dev";
$password   = "Sylvina1!Noobs";
$dbname     = "megatanw_dev";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$cronlimit_query       = 'select * from cron_limit';
$cronlimit_Result      = mysqli_query($conn, $cronlimit_query);
$cronlimit             = $cronlimit_Result->fetch_assoc();

$limitVar  = $cronlimit['cronlimit'];

//$orders_query = 'select * from isc_orders  where NOT (ordcustid = 0) order by orderid  asc limit 0,1000 ';
echo $orders_query = 'select * from isc_orders order by orderid asc limit '.$limitVar.',1000 ';
$order_Result = mysqli_query($conn, $orders_query);

$i=0;


while($order = $order_Result->fetch_assoc())
{
  $check_exist_order_query  = 'select * from big_orders where noorderid='.$order['orderid'];
  $check_exist_order_result = mysqli_query($conn, $check_exist_order_query);

  if(mysqli_num_rows($check_exist_order_result) > 0)
  {
      echo 'already exist'.'<br>';
  }
  else
  {
    $isValid = 1;
    $productsArr = [];
    
    $products_query            = 'select * from isc_order_products where orderorderid='.$order['orderid'];
    $products_Result           = mysqli_query($conn, $products_query);

    $order_shipment_query      = 'select * from isc_order_shipping where order_id='.$order['orderid'].' limit 1';
    $order_shipment_Result     = mysqli_query($conn, $order_shipment_query);

    if(mysqli_num_rows($order_shipment_Result) > 0)
    {
      $order_shipment            = $order_shipment_Result->fetch_assoc();
      $shippingaddress_query     = 'select * from isc_order_addresses where id='.$order_shipment['order_address_id'].' limit 1';
      $shippingaddress_Result    = mysqli_query($conn, $shippingaddress_query);
      $shippingaddress           = $shippingaddress_Result->fetch_assoc();
    }
    else
    {
         $shippingaddress = array();

         $shippingaddress['first_name']     = '';
         $shippingaddress['last_name']      = '';
         $shippingaddress['company']        = '';
         $shippingaddress['address_1']      = '';
         $shippingaddress['address_2']      = '';
         $shippingaddress['city']           = '';
         $shippingaddress['state']          = '';
         $shippingaddress['zip']            = '';
         $shippingaddress['country']        = '';
         $shippingaddress['country_iso2']   = '';
         $shipping_phone                    = '';
         $shipping_email                    = '';
    }

    $shipment_query      = 'select * from isc_shipments where shiporderid='.$order['orderid'].' limit 1';
    $shipment_Result     = mysqli_query($conn, $shipment_query);
    $shipment            = $shipment_Result->fetch_assoc();
      
    $big_customer_query  = 'select * from big_customers where custnooid='.$order['ordcustid'].' limit 1';
    $big_customer_Result = mysqli_query($conn, $big_customer_query);
    $big_customer        = $big_customer_Result->fetch_assoc();

    while($product = $products_Result->fetch_assoc())
    {

        $big_product_query     = 'select * from big_products where productnooId='.$product['ordprodid'].' limit 1';
        $big_product_Result    = mysqli_query($conn, $big_product_query);
        $big_product           = $big_product_Result->fetch_assoc();

        if($big_product == '')
        {
           $isValid = 0;
        }

        $product = [


               'productId'        => (int)$big_product['productId'],
               'productnooId'     => (int)$product['orderprodid'],
               'productName'      => mysqli_real_escape_string($conn,utf8_encode($product['ordprodname'])),
               'productType'      => $product['ordprodtype'],
               'productBasePrice' => (float)$product['base_price'],
               'productQuantity'  => (int)$product['ordprodqty']
        ];

        $productsArr[] = $product;
          
      }


       //  //store data to big_orders
           
        $noorderid = $order['orderid'];
        $orderdate = $order['orddate'];
        $ordstatus = $order['ordstatus'];

        if($order['ordcustid'] == 0)
        {
            $customer_id = 0;
        }
        else
        {
            $customer_id = $big_customer['customerid'] !='' ? $big_customer['customerid'] : -1;
        }

        $billing_first_name    = mysqli_real_escape_string($conn,$order['ordbillfirstname']);
        $billing_last_name     = mysqli_real_escape_string($conn,$order['ordbilllastname']);
        $billing_company       = mysqli_real_escape_string($conn,$order['ordbillcompany']);
        $billing_street_1      = mysqli_real_escape_string($conn,$order['ordbillstreet1']);
        $billing_street_2      = mysqli_real_escape_string($conn,$order['ordbillstreet2']);
        $billing_city          = mysqli_real_escape_string($conn,$order['ordbillsuburb']);
        $billing_state         = mysqli_real_escape_string($conn,$order['ordbillstate']);
        $billing_zip           = mysqli_real_escape_string($conn,$order['ordbillzip']);
        $billing_country       = mysqli_real_escape_string($conn,$order['ordbillcountry']);
        $billing_country_iso2  = mysqli_real_escape_string($conn,$order['ordbillcountrycode']);
        $billing_phone         = $order['ordbillphone'];
        $billing_email         = mysqli_real_escape_string($conn,$order['ordbillemail']);

        $shipping_first_name   = mysqli_real_escape_string($conn,$shippingaddress['first_name']);
        $shipping_last_name    = mysqli_real_escape_string($conn,$shippingaddress['last_name']);
        $shipping_company      = mysqli_real_escape_string($conn,$shippingaddress['company']);
        $shipping_street_1     = mysqli_real_escape_string($conn,$shippingaddress['address_1']);
        $shipping_street_2     = mysqli_real_escape_string($conn,$shippingaddress['address_2']);
        $shipping_city         = mysqli_real_escape_string($conn,$shippingaddress['city']);
        $shipping_state        = mysqli_real_escape_string($conn,$shippingaddress['state']);
        $shipping_zip          = mysqli_real_escape_string($conn,$shippingaddress['zip']);
        $shipping_country      = mysqli_real_escape_string($conn,$shippingaddress['country']);
        $shipping_country_iso2 = mysqli_real_escape_string($conn,$shippingaddress['country_iso2']);
        $shipping_phone        = $shippingaddress['phone'];
        $shipping_email        = mysqli_real_escape_string($conn,$shippingaddress['email']);

        $tracking_number       = $shipment['shiptrackno'];
        $comments              = mysqli_real_escape_string($conn, $shipment['shipcomments']);
        $shipping_provider     = "";
        $method                = mysqli_real_escape_string($conn,$shipment['shipmethod']);
        $module                = mysqli_real_escape_string($conn,$shipment['shipping_module']);
        
        $jsonProducts          = json_encode($productsArr,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

    
        $bigorders_query       =  "insert into big_orders(
                                                             noorderid,
                                                             orderdate,
                                                             customer_id,
                                                             billing_first_name,
                                                             billing_last_name,
                                                             billing_company,
                                                             billing_street_1,
                                                             billing_street_2,
                                                             billing_city,
                                                             billing_state,
                                                             billing_zip,
                                                             billing_country,
                                                             billing_country_iso2,
                                                             billing_phone,
                                                             billing_email,
                                                             shipping_first_name,
                                                             shipping_last_name,
                                                             shipping_company,
                                                             shipping_street_1,
                                                             shipping_street_2,
                                                             shipping_city,
                                                             shipping_state,
                                                             shipping_zip,
                                                             shipping_country,
                                                             shipping_country_iso2,
                                                             shipping_phone,
                                                             shipping_email,
                                                             status_id,
                                                             products,
                                                             tracking_number,
                                                             comments,
                                                             shipping_provider,
                                                             method,
                                                             module,
                                                             isValid

                                                         ) 
                                                         values (
                                                             
                                                            $noorderid,
                                                            $orderdate,
                                                            $customer_id,
                                                            '$billing_first_name',
                                                            '$billing_last_name',
                                                            '$billing_company',
                                                            '$billing_street_1', 
                                                            '$billing_street_2',
                                                            '$billing_city',
                                                            '$billing_state',   
                                                            '$billing_zip',
                                                            '$billing_country',
                                                            '$billing_country_iso2',
                                                            '$billing_phone',
                                                            '$billing_email',
                                                            '$shipping_first_name',
                                                            '$shipping_last_name',
                                                            '$shipping_company',
                                                            '$shipping_street_1',
                                                            '$shipping_street_2',
                                                            '$shipping_city',
                                                            '$shipping_state',
                                                            '$shipping_zip',
                                                            '$shipping_country',
                                                            '$shipping_country_iso2',
                                                            '$shipping_phone',
                                                            '$shipping_email',
                                                            $ordstatus,
                                                            '$jsonProducts',
                                                            '$tracking_number',
                                                            '$comments',
                                                            '$shipping_provider',
                                                            '$method',
                                                            '$module',
                                                            '$isValid'
                                                         )";
          
          

          

            $result = mysqli_query($conn, $bigorders_query);

            $i++;
            $limitVar++;

            $update_cronlimit_query   = 'update cron_limit set cronlimit='.$limitVar;
            $update_cronlimit_Result  = mysqli_query($conn, $update_cronlimit_query);
            echo $i.'<br>';
            if(!$result)
            {
                printf("Error: %s\n", mysqli_error($conn)).'<br>';  
                echo $i.'---'.$bigorders_query;      
            }
        }
                                                         
}










//comment: code to set noocustomer id to table big_customers
// $noocustomerquey = 'select * from isc_customers limit 35000,10000';

// $noocustomerRows = mysqli_query($conn, $noocustomerquey);

// $i=0;

// while($noocustomerRow = $noocustomerRows->fetch_row())
// {
//   $noocustomerId    = $noocustomerRow[0];
//   $noocustomerEmail = $noocustomerRow[6];

//   $bigcustomerquery = "update big_customers set custnooid=$noocustomerId where custconemail='$noocustomerEmail'";


//   $result = mysqli_query($conn, $bigcustomerquery);
     
//      ++$i;
//   echo $i.'--'.$result.'--'.$bigcustomerquery.'<br>';

// }

?>