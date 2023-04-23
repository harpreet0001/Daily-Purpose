<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Catalouge extends AdminController
{
	protected $path = 'admin/catalog/';
    protected $baseUrl = 'http://api.loyaltysource.com:8080';
    protected $apiKey  = 'UmF0ZXNob3AgSW5jOlJhdGVzaG9wMjAyMSE=';

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('cart');
        $this->load->helper(array('url','common_helper'));

        cartIntialize();
    }

    public function cart() {
    	$this->load->view($this->path.'cart');
    }

    /*Add Product To Cart*/
    /*=====================================================================*/
    public function AddToCart() {

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            $data = array(
                    'id'      => $this->input->post('product_id'),
                    'qty'     => $this->input->post('product_qty'),
                    'price'   => $this->input->post('product_price'),
                    'name'    => $this->input->post('product_name'),
                    'options' => array('image' => $this->input->post('product_image'),'lsProductId' => $this->input->post('lsProductId'))
            );

            /*check duplicte entry*/
            if($this->checkDuplicate($data['id'])) {
   
                $item = $this->productById($data['id']);
                if(count($item) > 0) {
                    $data = array(
                            'rowid' => $item['rowid'],
                            'qty'   => (int)$item['qty']+1
                    );
                    /*updating cart*/
                    $this->cart->update($data);

                    /*updating db cart*/
                     $this->add_product_db($this->input->post('product_id'),$_SESSION['staff_user_id'],$data['qty']);
                    /*updating db cart end*/
                    
                    http_response_code(200); 
                    echo json_encode(['status'  => 1, 'message' => 'Item added to cart','count' => $this->cart->total_items()]);
                }
                
            }
            else {
                /*add to cart*/
                $this->cart->product_name_rules = '[:print:]'; /*use to allow special characters*/
                $this->cart->insert($data);

                /*updating db cart*/
                    $this->add_product_db($this->input->post('product_id'),$_SESSION['staff_user_id'],1);
                /*updating db cart end*/

                http_response_code(200); 
                echo json_encode(['status'  => 1, 'message' => 'Item added to cart','count' => $this->cart->total_items()]);
            }
 
        }
        else {
                http_response_code(500); 
                echo json_encode(['status'  => 0, 'message' => 'Invalid request method']);
        }

    }

     /*Remove Product From Cart*/
    /*=====================================================================*/
    public function RemoveFromCart() {

    	if($this->input->server('REQUEST_METHOD') == 'POST') {

    		$rowid = $this->input->post('rowid');

    		if($rowid) {

    			/*check if item exist in cart by row id*/
		    	$item = $this->productByRowId($rowid);
		    	if(count($item) > 0 ) {

					$data = array(

					    'rowid' => $rowid,
					    'qty'   => 0
					);
                    
                    /*removing item from cart by passing qty => 0*/ 
					$this->cart->update($data);

                    /*updating db cart*/
                    $this->remove_product_db($this->input->post('product_id'),$_SESSION['staff_user_id']);
                   /*updating db cart end*/

					http_response_code(200); 
                    echo json_encode([  
                    	                'status'       => 1,
                    	                'message'      => 'Item removed successfully',
                    	                'redirect_url' => $this->input->post('redirect_url') 
                    	            ]);	
		    	}
		    	else {

		    		http_response_code(404); 
                    echo json_encode(['status'  => 0, 'message' => 'Item not found']);
		           
		    	}

    		} else {

    			http_response_code(500); 
                echo json_encode(['status'  => 0, 'message' => 'invalid parameters']);

    		}

    	} else {

                http_response_code(500); 
                echo json_encode(['status'  => 0, 'message' => 'Invalid request method']);
        }


    }
    
    /*=====================================================================*/

    /*Destroy Cart*/
     public function destroyCart() {

        $this->cart->destroy();
        $this->destroy_cart_db($_SESSION['staff_user_id']);
        redirect(admin_url('catalog/cart'));
     }
    /*=====================================================================*/


    /*Add Item to Wishlist*/
    /*=====================================================================*/
    public function AddToWishlist() {

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            $product_id = $this->input->post('product_id');
            $user_id    = $_SESSION['staff_user_id'];
            if(!empty($product_id) && !empty($user_id)) {

               $wishlist = $this->wishlist($user_id);

               if(count((array)$wishlist) > 0) {
                   $wishlist_items = json_decode($wishlist->products);

                   if(count($wishlist_items) > 0) {

                       /*check item eist in wishlist*/
                       if(in_array($product_id, $wishlist_items)) {

                            /*remove item from wishlist*/
                            unset($wishlist_items[array_search($product_id,$wishlist_items)]);
                            /*remove item from wishlist*/

                            $wishlist_items = array_values($wishlist_items);

                             $data =  json_encode($wishlist_items);
                             $this->db->set('products',$data);
                             $this->db->where('user_id',$user_id);
                             $this->db->update('tbl_catalouge_wishlist');
                             http_response_code(200); 
                             echo json_encode(['status' => 1, 'message' => 'Item removed from wishlist']);


                       }
                       else {
                             
                             /*add item to wishlist*/
                             array_push($wishlist_items,$product_id);
                             /*add item to wishlist*/

                             $data = json_encode($wishlist_items);
                             $this->db->set('products',$data);
                             $this->db->where('user_id',$user_id);
                             $this->db->update('tbl_catalouge_wishlist');
                             http_response_code(200); 
                             echo json_encode(['status' => 1, 'message' => 'Item added to wishlist']);

                       }

                   } else {

                        $data = ['products' => json_encode([$product_id])];
                        /*add item to wishlist*/
                        $this->db->where('user_id',$user_id);
                        $this->db->update('tbl_catalouge_wishlist',$data);
                        http_response_code(200); 
                        echo json_encode(['status' => 1, 'message' => 'Item added to wishlist']);

                   }

               } else {
                  
                    $data = ['user_id'  => $user_id,'products' => json_encode([$product_id])];
                    /*add item to wishlist*/
                    $this->db->insert('tbl_catalouge_wishlist',$data);
                    http_response_code(200); 
                    echo json_encode(['status' => 1, 'message' => 'Item added to wishlist']);
               }

            } else {
                http_response_code(404); 
                echo json_encode(['status' => 0, 'message' => 'Invalid request parameters']);
            }
            
        } else {
            http_response_code(404); 
            echo json_encode(['status'  => 0,'message' => 'Invalid request method']);
        }
    }
    /*=====================================================================*/

    /*wishlist*/
     public function catalougeWishlist() {

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            $user_id = $_SESSION['staff_user_id'];
            if(!empty($user_id)) {

               $wishlist = $this->wishlist($user_id);

                if(count((array)$wishlist)) {

                   $wishlist_items_ids = json_decode($wishlist->products);
                   $db_products_data   = $this->db_catalog_products();
                   $products           = json_decode($db_products_data->products);
                   $wishlist_products  = [];
                   if(count($products)) {

                        $wishlist_products = array_filter($products,function($product) use($wishlist_items_ids) {

                            if(in_array($product->id,$wishlist_items_ids)) {
                                return true;
                             }
                        });

                        $wishlist_products = array_values($wishlist_products);
                        $data['wishlist_products'] = $wishlist_products;
                        http_response_code(200);
                        echo json_encode([

                                        'status'  => 1,
                                        'message' => 'Data found',
                                        'data'   => $this->load->view('admin/catalog/wishlist_products',$data,true)

                                        ]);

                        
                    }
                }
                else{
                   
                   http_response_code(200);
                   echo json_encode([

                                    'status'  => 1,
                                    'message' => 'Data Not found',
                                    'data'    => 'No Item in wishlist'

                                    ]);
                }

            } else { 

                http_response_code(404); 
                echo json_encode(['status'  => 0,'message' => 'User id not found']);

            }

        } else {

            http_response_code(404); 
            echo json_encode(['status'  => 0,'message' => 'Invalid request method']);
         }

     }
    /*=====================================================================*/


    /*Catalog-Checkout*/
    public function cartCheckout() {
      return $this->load->view($this->path.'checkout');
    }
    /*=====================================================================*/


    /*Catalog Product*/
    public function catalog_product($product_id) {
        
        if(!empty($product_id)) {
            $data['product'] = $this->db_productById($product_id);
            if($data['product']){
              $data['product']->otherImagesArray = $this->imagesByLsProductId($data['product']->lsProductId);
              $this->load->view($this->path.'product',$data);
            }
        }

    }
    /*=====================================================================*/
    

    /*shipping-cost*/
    public function getRegionShippingCost() {
        
        /*Helper function file:commom_helper*/
        $amount = calculateShippig($this->input->get('region_code'));

        echo json_encode(['amount' => $amount]);
    }
    /*=====================================================================*/


    /*creating Order*/
    public function createOrder() {
        
        if($this->input->server('REQUEST_METHOD') == 'POST') {

            $user_id = $_SESSION['staff_user_id'];
            
            /*==================shipping details==================*/
             $shipping = null;
             $province = '';
             $order_shipping_points = 0;
             $order_items_points = 0;
             $order_total_points = 0;

             $db_shipping_regions = shippingRegions();

             foreach ($db_shipping_regions as $db_shipping_region) {
                 if($db_shipping_region['region_code'] == $_POST['region_code']) { $shipping = $db_shipping_region; break;}
             }

             if(!is_null($shipping)) { 

                $province = $shipping['region'];
                $order_shipping_points = priceToRewardPoints((float)$shipping['amount']);
            }
            /*==================shipping details end==================*/

            if((int)$this->cart->total_items() > 0 && !is_null($user_id) && !empty($user_id)) {

                /*check points before placing a order*/
                $total_reward_points = totalRewardPoints($user_id);
                if($total_reward_points <= 0 || $total_reward_points < priceToRewardPoints($this->cart->total())+$order_shipping_points) {
                       
                    http_response_code(404);
                    echo json_encode(['status' => 0, 'message' => 'Error while creating a order']);
                    return false;
                }

                $items        = array();
                $creationDate = date("c", time());
                /*==================customer details==================*/
                $customer     = array(

                                    'companyName'     => isset($_POST['company_name']) ? $_POST['company_name'] : '',
                                    'deliveryAddress' => array(

                                                            'city'         => isset($_POST['city'])        ? $_POST['city']        : '',
                                                            'complement'   => isset($_POST['complement'])  ? $_POST['complement']  : '',
                                                            'country'      => isset($_POST['country'])     ? $_POST['country']     : '',
                                                            'postalCode'   => isset($province)             ? $province    : '',
                                                            'province'     => isset($_POST['region_code']) ? $_POST['region_code'] : '',
                                                            'street'       => isset($_POST['street'])      ? $_POST['street']      : ''
                                                        ),
                                    'emailAddress' => isset($_POST['email'])        ? $_POST['email']        : '',
                                    'firstName'    => isset($_POST['first_name'])   ? $_POST['first_name']   : '',
                                    'lastName'     => isset($_POST['last_name'])    ? $_POST['last_name']    : '',
                                    'note'         => isset($_POST['note'])         ? $_POST['note']         : '',
                                    'number'       => isset($_POST['number'])       ? $_POST['number']       : '',
                                    'phoneNumber'  => isset($_POST['phone_number']) ? $_POST['phone_number'] : ''
                                );

                /*==================customer details end==================*/
                
                /*==================Cart-Items==================*/
                foreach($this->cart->contents() as $item) {

                    $order_items_points += (float)$item['price'] * 100;

                    $data    = array(
                                'internalOrderLineNumber' => 0,
                                'internalProductId'       => $item['id'],
                                'lsProductId'             => $item['options']['lsProductId'],
                                'quantity'                => (int)$item['qty'],
                                );

                    $items[] = $data;
                }

                $order_total_points =  $order_items_points+$order_shipping_points;
                //*==================Cart-Items End==================*/

                $order_detail = array(
                                'creationDate'    => $creationDate,
                                'customer'        => $customer,
                                'internalOrderId' => '',
                                'items'           => $items
                                );
                
                $internal_order_id = ''; /*get client order id if exist(required)*/
                $this->db->select('*')->from('tbl_catalouge_orders')->where(['user_id' => $user_id,'used' => 0]);
                $query       = $this->db->get();
                $queryresult = $query->row();
                
                if($queryresult) { $internal_order_id = $queryresult->internal_order_id; }
                
                /*create internal_order_id if doesnot exist*/
                if(is_null($internal_order_id) || empty($internal_order_id)) {
                     
                    $internal_order_id = 'order_'.$this->generateRandomString(20);
                    //*create client order id (required)*/
                    $this->db->insert('tbl_catalouge_orders',['user_id' => $user_id, 'internal_order_id' => $internal_order_id]);
                    $this->db->select('*')->from('tbl_catalouge_orders')
                                          ->where(['user_id' => $user_id,'used' => 0]);//*get client order id (required)*/
                    $query             = $this->db->get();
                    $queryresult       = $query->row();
                    $internal_order_id = $queryresult->internal_order_id;
                }

                if(!empty($internal_order_id)) {

                    $order_detail['internalOrderId'] = $internal_order_id;
                    
                    /*==================CURL-REQUEST==================*/
                    $result = makeRequest(

                        $this->baseUrl,
                        '/api/orders',
                        'POST',
                        [
                           'Authorization: '.$this->apiKey,
                           'Accept: application/json',
                           'Content-Type: application/json'
                        ],
                        $order_detail
                    ); 
                    /*==================CURL-REQUEST-END==================*/

                    if($result['status'] == 1) {

                        /*=====store-order-to-database=====*/
                        $order_res = json_decode($result['data']);

                        $order_db  = array(

                            'customer_details'  => json_encode($order_res->customer),
                            'creation_date'     => date('Y-m-d H:i:s'),
                            'order_items'       => json_encode($order_res->items),
                            'ls_event_id'       => $order_res->lsEventId,
                            'required_by_date'  => $order_res->requiredByDate,
                            'order_status'      => $order_res->status,
                            'used'              => 1,
                            'order_shipping_points' => $order_shipping_points,
                            'order_items_points' => $order_items_points,
                            'order_total_points' => $order_total_points

                        );

                        $this->db->where('internal_order_id',$internal_order_id);
                        $this->db->update('tbl_catalouge_orders',$order_db);

                        /*==================modifyRewardPoints==================*/
                          modifyRewardPoints(
                                               $user_id,
                                               'sub',
                                               priceToRewardPoints($this->cart->total())+$order_shipping_points
                                            );
                        /*==================modifyRewardPoints End==================*/          

                        /*==================Destroy-Cart==================*/
                         $this->destroy_cart_db($user_id);
                         $this->cart->destroy();
                        /*==================Destroy-Cart-End==================*/   
                        
                        http_response_code(201); 
                        echo json_encode([
                                           'status'       => 1,
                                           'message'      => 'Order created successfully',
                                           'redirect_url' => admin_url('rewards')
                                        ]);
                        return false;
                    }
                    else {

                        http_response_code(404);
                        echo json_encode(['status' => 0, 'message' => 'Error while creating a order']);
                        return false;

                    }
                }        
            }
            
            http_response_code(404);
            echo json_encode(['status' => 0, 'message' => 'Error while creating a order']);
            return false;
        }

        http_response_code(404); 
        echo json_encode(['status' => 0, 'message' => 'Invalid request type']);
        return false;
    }
    /*=====================================================================*/
    
    /*catalouge-orders*/
     public function myCatalougeOrders() {

         $this->db->select('*');
         $this->db->from('tbl_catalouge_orders');
         if(!is_null($this->input->get('user_id'))) {
            $this->db->where('user_id',(int)$this->input->get('user_id'));
         }
         
         $query  = $this->db->get();
         $data['orders'] = $query->result();

         echo json_encode([
              
             'status' => 1,
             'data'   => $this->load->view($this->path.'orders',$data,TRUE)
         ]);     
        
     }
    /*=====================================================================*/

    /*get-order-detail*/
    public function order_detail() {

       $internal_order_id = $this->input->get('internal_order_id');

       $result = makeRequest(

            $this->baseUrl,
            '/api/orders/'.$internal_order_id,
            'GET',
            [
               'Authorization: '.$this->apiKey,
               'Accept: application/json',
               'Content-Type: application/json'
            ],
            []
        );

       if($result) {
         
         http_response_code(200);
         echo json_encode([
              
              'status'  => 1,
              'message' => 'Data Found',
              'data'    => $this->load->view($this->path.'order_detail',$result,TRUE)
         ]);
       }
       else {
         http_response_code(404);
        echo json_encode([
              
              'status'  => 0,
              'message' => 'Data Found',
         ]);

       }

       
    }
    /*=====================================================================*/

    /*Check dupliacte entry in Cart*/
    /*=====================================================================*/
    protected function checkDuplicate($id) {

           foreach ($this->cart->contents() as $item) {
               if($item['id'] == $id) {
                   return true;
               }
            }

           return false;
      }
    /*=====================================================================*/

    /*get item by id*/
    /*=====================================================================*/
    protected function productById($id) {

            foreach ($this->cart->contents() as $item) {
               if($item['id'] == $id) {
                   return $item;
               }
            }

            return [];

    }
    /*=====================================================================*/

    /*get product by slug*/
    protected function db_productBySlug($slug) {

        /*get products from db*/  
        $this->db->select('*');
        $this->db->from('tbl_catalouge_products');
        $query       = $this->db->get();
        $productData = $query->row();
        $products    = json_decode($productData->products);

        if(count($products)) {
            foreach($products as $product) {
               
               $productNameArr = $product->namesArray;
               $productName    = $productNameArr[0]->value;
               $productName    = replaceFn($productName,' ','-');

               if($productName == $slug) {

                   return $product;
               }
            }
        }

        return false;
    }
    /*=====================================================================*/

    /*get product by id*/
    protected function db_productById($id) {

        /*get products from db*/  
        $this->db->select('*');
        $this->db->from('tbl_catalouge_products');
        $query       = $this->db->get();
        $productData = $query->row();
        $products    = json_decode($productData->products);

        if(count($products)) {
            foreach($products as $product) {

               if($product->id == $id) {
                   return $product;
               }
            }
        }

        return false;
    }
    /*=====================================================================*/
    
    /*get item by row id*/
    /*=====================================================================*/
    protected function productByRowId($rowid) {
        
        foreach ($this->cart->contents() as $item) {
               if($item['rowid'] == $rowid) {
                   return $item;
               }
            }

        return [];

    }
    /*=====================================================================*/

    /*get wishlist items*/
    protected function wishlist($user_id = null) {
        
        $this->db->select('*');
        $this->db->from('tbl_catalouge_wishlist');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        $response = $query->row();
        return $response;
    }

    /*getDB catalog products*/
    public function db_catalog_products() {

        /*get products from db*/  
        $this->db->select('*');
        $this->db->from('tbl_catalouge_products');
        $query       = $this->db->get();
        $productData = $query->row();
        return $productData;
    }
   /*=====================================================================*/
   

   /*add product to db while addding  to cart*/
   protected function add_product_db($product_id,$user_id,$quantity=1) {
      
       /*get cart products from db*/
       $this->db->select('*');
       $this->db->from('tbl_catalouge_cart');
       $this->db->where('user_id',$user_id);
       $query = $this->db->get();
       $db_cart = $query->row();

       if(count((array)$db_cart) > 0) {

           $db_cart_products = json_decode($db_cart->products);

           if(count($db_cart_products) > 0) {
                 
               $isInArray = in_array($product_id,array_column($db_cart_products,'product_id'));

               if($isInArray) {

                    foreach ($db_cart_products as $db_cart_product) {
                        
                        if($db_cart_product->product_id == $product_id){
                            $db_cart_product->product_count = $quantity;
                        }
                    }

                    $data = $db_cart_products;
                }
                else {
                    
                    array_push($db_cart_products, (object) ['product_id' => $product_id,'product_count' => 1]);

                    $data = $db_cart_products;
                }                   
           }
           else {

                $data = ['product_id' => $product_id,'product_count' => 1];
           } 

           $this->db->where('user_id',$user_id);
           $this->db->set('products',json_encode($data));      
           $this->db->update('tbl_catalouge_cart');
       }
       else
       {
           $data = ['product_id' => $product_id,'product_count' => 1];
           $this->db->insert('tbl_catalouge_cart',['user_id' => $user_id,'products' => json_encode([$data])]);
       }

   }
   /*=====================================================================*/


    /*remove product from db while removing from cart*/
    protected function remove_product_db($product_id,$user_id) { 

       /*get cart products from db*/
       $this->db->select('*');
       $this->db->from('tbl_catalouge_cart');
       $this->db->where('user_id',$user_id);
       $query = $this->db->get();
       $db_cart = $query->row();

       if(count((array)$db_cart) > 0) {

          $db_cart_products = json_decode($db_cart->products); 

          if(count($db_cart_products) > 0) {

            $isInArray = in_array($product_id,array_column($db_cart_products,'product_id'));

            if($isInArray) {

                foreach ($db_cart_products as $index => $db_cart_product) {
                        
                    if($db_cart_product->product_id == $product_id){
                        
                        unset($db_cart_products[$index]);
                        $db_cart_products = array_values($db_cart_products);
                        break;
                    }
                }

                $this->db->where('user_id',$user_id);
                if(count($db_cart_products) > 0) {

                    $this->db->set('products',json_encode($db_cart_products)); 
                    $this->db->where('user_id',$user_id);     
                    $this->db->update('tbl_catalouge_cart');

                } else {
                    $this->db->delete('tbl_catalouge_cart');
                }
            }
          }   
       }
    }
    /*=====================================================================*/

    /*destroy cart*/
    protected function destroy_cart_db($user_id) { 
        
          $this->db->where('user_id',$user_id);
          $this->db->delete('tbl_catalouge_cart');
    }
    /*=====================================================================*/

    /*create random string*/
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /*=====================================================================*/

    public function cronJOB() {

        /*==================Category CURL-REQUEST==================*/
        $result = makeRequest(

            $this->baseUrl,
            '/api/categories',
            'GET',
            [
               'Authorization: '.$this->apiKey,
               'Accept: application/json',
               'Content-Type: application/json'
            ],
            []
        ); 
        /*=================Category =CURL-REQUEST-END==================*/

        if($result['status'] == 1) {
            
            $categories = json_decode($result['data']);

            $this->db->truncate('tbl_catalouge_categories');
            foreach ($categories as $key => $category) {
                
                $data = array(

                      'category_id'       => $category->id,
                      'category_parentId' => $category->parentId,
                      'category_name'     => $category->name[0]->value,
                      'category_details'  => json_encode($category)
                );

                $this->db->insert('tbl_catalouge_categories',$data);

            }
        }
       /*==================Product-CURL-REQUEST==================*/
        $result = makeRequest(

            $this->baseUrl,
            '/api/product/fullCatalog',
            'GET',
            [
               'Authorization: '.$this->apiKey,
               'Accept: application/json',
               'Content-Type: application/json'
            ],
            []
        ); 
        if($result['status'] == 1) {

            $this->db->truncate('tbl_catalouge_products');
            $data = array('products' => $result['data']);
            $this->db->insert('tbl_catalouge_products',$data);
        }

    /*=================Product-CURL-REQUEST-END==================*/

    }



    /*==================catalouge-product-image=======================*/
      public function imagesByLsProductId($lsProductId) {
          
          $data   = array();
          $result = makeRequest(

                        $this->baseUrl,
                        '/api/product/images/'.$lsProductId,
                        'GET',
                        [
                           'Authorization: '.$this->apiKey,
                           'Accept: application/json',
                           'Content-Type: application/json'
                        ]
                    ); 

          if($result['status'] == 1) {

              $imageData = json_decode($result['data']);

              foreach ($imageData as $imgObj) { $data[] = $imgObj->pathName;  }
          } 

          return $data;
      }
    /*==================catalouge-product-image=======================*/

    /*=====================================================================*/
    function categoryGroup() {
        
        $this->db->select('*');
        $this->db->from('tbl_catalouge_categories');
        $query = $this->db->get();  
        $categories = $query->result();

        $data = array();
       
        //group-category
        foreach ($categories as $groupKey => $category) {
           
            if($category->category_parentId == 0){

                $group_category = array(

                  'id'           => $category->category_id,
                  'name'         => $category->category_name,
                  'categoryList' => array()
                );
                
                array_push($data,$group_category);
                unset($categories[$groupKey]);
            }
        }
        
        //categoryList
        foreach ($data as $dataKey => $group_category) {

          foreach ($categories as $catKey => $category) {
             
            if($category->category_parentId == $group_category['id']) {

                $categoryData = array(

                  'id'           => $category->category_id,
                  'name'         => $category->category_name,
                  'parentName'   => $group_category['name'],
                  'typeList' => array()
                );
                 
                array_push($data[$dataKey]['categoryList'],$categoryData);
                unset($categories[$catKey]);
            }
          }
        }

      //typeList
      foreach ($data as $dataKey => $group_category) {
 
          $categoryLists = $group_category['categoryList'];

          foreach ($categoryLists as $catListKey => $categoryList) {

             foreach ($categories as $catKey => $category) {

                if($category->category_parentId == $categoryList['id']) {

                    $typeListData = array(

                         'id'          => $category->category_id,
                         'name'        => $category->category_name,
                         'parentName'  => $categoryList['name'],
                    );

                  array_push($data[$dataKey]['categoryList'][$catListKey]['typeList'],$typeListData);
                  unset($categories[$catKey]);
                }


             }
            
          }
      }
        
      echo json_encode($data);
    }
    /*=====================================================================*/
}    