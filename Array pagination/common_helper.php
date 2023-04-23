<?php

defined('BASEPATH') or exit('No direct script access allowed');

function getDetails($staff_id){
  $ci = &get_instance();
  return $ci->db->where("staffid",$staff_id)->where("admin","1")->get("tblstaff")->row();
}

/*appendCurrency*/
function appendCurrency($value)
{
   return '$ '.$value;
}

function replaceFn($value,$replaceTo,$replaceWith) {
    
    return str_replace($replaceTo, $replaceWith, $value);
}

/*to add `automatic` reward*/
function addDealReward($deal_status,$deal_id,$staff_agent_id,$user_id=null) {
    
    $ci = &get_instance();
    if($deal_status == 'added') {
         
        /*Get All deals having deal status === 'added'*/ 
    	$reward_deals_all =  $ci->db->from('tblrewards')
    	                            ->where('deal_status',$deal_status)
    	                            ->where('reward_type','automatic')
    	                            ->get()->result();

    	if(count($reward_deals_all) > 0) {


	        /*filter acc to expiry date*/
	        $current_date = date('Y-m-d');
	        $reward_deals_dateFilter = array_filter($reward_deals_all,function($reward_deal) use($current_date){
	 
	          $reward_deal_expire_date   = date('Y-m-d',strtotime($reward_deal->created_at.' + '.$reward_deal->due_day.' days'));
	          $current_date_obj          = date_create($current_date);
	          $reward_deal_expire_date_obj = date_create($reward_deal_expire_date); 

	          $diff =  date_diff($current_date_obj, $reward_deal_expire_date_obj);

	            if($diff->format("%R%a") > 0){
	            	return true;
	            }

	            return false;
	        });

	        if(count($reward_deals_dateFilter) > 0) {

		        /*filter acc to staff_agent_id*/
		        $reward_deals = array_filter($reward_deals_dateFilter,function($reward_deal) use($staff_agent_id){
		 
		            $staff_agents_ids = json_decode($reward_deal->staff_agents_ids);
		            if(in_array($staff_agent_id,$staff_agents_ids)){
		            	return true;
		            }

		            return false;
		        });

		        if(count($reward_deals) > 0) {

		        	/*add eligible reward_deal to tbl_reward_requests*/
			        foreach ($reward_deals as $reward_deal) {

				       $reward_deal_data = array(

				            'deal_id'         => $deal_id,
				            'user_id'         => $user_id,
				            'staff_agent_id'  => $staff_agent_id,
				            'deal_status'     => $deal_status,
				            'task_name'       => $reward_deal->task,
				            'reward_points'   => $reward_deal->reward_points,
				            'reward_type'     => 'automatic',
				            'approved_status' => 0, //pending
				       );

				       /*save data to tbl_reward_requests*/
				       $ci->db->insert('tbl_reward_requests',$reward_deal_data);
			       
			        }

			        return true;
		        }

		        return false;
	        }
              
            return false; 
    	}

        return false; 
    }

    return false;
}


/*to add `pipeline` reward*/
function addPipelineReward($lead_status_id,$staff_agent_id,$user_id=null) {
    
    $ci = &get_instance();

    if(!is_null($lead_status_id) && !is_null($staff_agent_id) && !is_null($user_id)) {
       
        /*Get All rewards having deal status === 'added'*/ 
    	$rewards_all =  $ci->db->from('tblrewards')
                            ->where('lead_status_id',$lead_status_id)
                            ->where('reward_type','automatic')
                            ->get()->result();

        if(count($rewards_all) > 0) {

	        /*filter acc to expiry date*/
	        $current_date = date('Y-m-d');
	        $reward_dateFilter = array_filter($rewards_all,function($reward) use($current_date){
	 
	          $reward_expire_date     = date('Y-m-d',strtotime($reward->created_at.' + '.$reward->due_day.' days'));
	          $current_date_obj       = date_create($current_date);
	          $reward_expire_date_obj = date_create($reward_expire_date); 

	          $diff =  date_diff($current_date_obj, $reward_expire_date_obj);

	            if($diff->format("%R%a") > 0){
	            	return true;
	            }

	            return false;
	        });

	        if(count($reward_dateFilter) > 0) {

		        /*filter acc to staff_agent_id*/
		        $rewards = array_filter($reward_dateFilter,function($reward) use($staff_agent_id){
		 
		            $staff_agents_ids = json_decode($reward->staff_agents_ids);
		            if(in_array($staff_agent_id,$staff_agents_ids)){
		            	return true;
		            }

		            return false;
		        });

		        if(count($rewards) > 0) {

		        	/*add eligible reward to tbl_reward_requests*/
			        foreach ($rewards as $reward) {

				       $reward_req_data = array(

				            'user_id'         => $user_id,
				            'staff_agent_id'  => $staff_agent_id,
				            'task_name'       => $reward->task,
				            'reward_points'   => $reward->reward_points,
				            'reward_type'     => 'automatic',
				            'lead_status_id'  => isset($reward->lead_status_id) ? $reward->lead_status_id : Null,
				            'approved_status' => 0, //pending
				       );

				       /*save data to tbl_reward_requests*/
				       $ci->db->insert('tbl_reward_requests',$reward_req_data);
			       
			        }

			        return true;
		        }

		        return false;
	        }

	    }                       
    }

}


/*to add `manual` reward*/
function addManualDealReward($reward_type,$manual_reward_id,$agentsArr) {

    $ci = &get_instance();
    if($reward_type == 'manual') {

        /*get manual reward by $manual_reward_id*/
        $ci->db->where(['id' => $manual_reward_id,'reward_type' => 'manual']);
        $query = $ci->db->get('tblrewards');
        $manual_reward = $query->row();
        if(!$manual_reward) {
           http_response_code(500);
           return json_encode(['error' => 'manual reward doesnot exist','status' => 0]);
        }
        /*check expiry date of manual reward*/
        $current_date = date('Y-m-d');
        $manual_reward_expire_date = date('Y-m-d',strtotime($manual_reward->created_at.' + '.$manual_reward->due_day.' days'));
	    $current_date_obj = date_create($current_date);
	    $manual_reward_expire_date_obj = date_create($manual_reward_expire_date); 

	    $diff =  date_diff($current_date_obj, $manual_reward_expire_date_obj);
        if($diff->format("%R%a") <= 0){
           http_response_code(500);
           return json_encode(['error' => 'manual reward expired','status' => 0]);
        }
        if(count($agentsArr)  > 0){

        	foreach($agentsArr as $agentId) {

        		$manual_reward_data = array(

			        'staff_agent_id'  => $agentId,
			        'task_name'       => $manual_reward->task,
			        'reward_points'   => $manual_reward->reward_points,
			        'reward_type'     => 'manual',
			        'approved_status' => 1, //approved
			        'approved_date'   => date('Y-m-d')
				);

				/*==================modifyRewardPoints==================*/
                              modifyRewardPoints(
                                                   $agentId,
                                                   'add',
                                                   $manual_reward->reward_points
                                                );
                /*==================modifyRewardPoints End==================*/ 

				/*save data to tbl_reward_requests*/
				$ci->db->insert('tbl_reward_requests',$manual_reward_data);
        	}
            http_response_code(201); 
        	return json_encode(['message' => 'Manual reward assigned successfully','status' => 1]);	

        } else {
          http_response_code(500); 	
          return json_encode(['error' => 'invalid agents list','status' => 0]);	
        }
    }
    http_response_code(500);
    return json_encode(['error' => 'invalid reward type','status' => 0]);
}

/*agent milestone data*/
function getAgentMilestoneData($agentId = null) {
    
    $ci = &get_instance();

    $total_milestones     = 0;
    $requested_milestones = 0;
    $approve_milestones   = 0;
    $declined_milestones  = 0;
    $total_reward_points  = 0;
    $earn_reward_points   = 0;

    if(!is_null($agentId)) {

		/*get total milestones*/
		$total_rewards =  $ci->db->from('tblrewards')->where('reward_type','automatic')->get()->result();

		if(count($total_rewards) > 0) {
	
			/*filter acc to id*/
		        $rewards = array_filter($total_rewards,function($reward) use($agentId){
		 
		            $staff_agents_ids = json_decode($reward->staff_agents_ids);
		            if(in_array($agentId,$staff_agents_ids)){
		            	return true;
		            }

		            return false;
		        }); 

		        if($rewards_count = count($rewards) > 0) {

					/*get agent reward requests*/
					$total_rewards_requests =  $ci->db->from('tbl_reward_requests')
					                         ->where('staff_agent_id',$agentId)
					                         ->get()
					                         ->result(); 
		            
			       foreach($total_rewards_requests as $reward_request) {

			       	  $total_reward_points += $reward_request->reward_points;

			       	  if($reward_request->reward_type == 'automatic') {

                            ++$total_milestones;

				       	    if($reward_request->approved_status == 0) {
	                            ++$requested_milestones;
				       	    }

				       	    if($reward_request->approved_status == 1) {
	                            ++$approve_milestones;

	                            $earn_reward_points += $reward_request->reward_points;
				       	    }

				       	    if($reward_request->approved_status == 2) {
	                            ++$declined_milestones;
				       	    }
			       	  }

			       }

		        } 

		}

    }

    $data = array(

				    'total_milestones'     => $total_milestones,
				    'requested_milestones' => $requested_milestones,
				    'approve_milestones'   => $approve_milestones,
				    'declined_milestones'  => $declined_milestones,
				    'total_reward_points'  => $total_reward_points,
				    'earn_reward_points'   => $earn_reward_points
				);

				return json_encode($data);

}

/*get milestone data for admin*/
function getAdminMilestoneData($age) {

   $ci = &get_instance();

    $total_milestones     = 0;
    $requested_milestones = 0;
    $approve_milestones   = 0;
    $declined_milestones  = 0;
    $total_reward_points  = 0;
    $earn_reward_points   = 0;

    if(is_admin()) {
        
        /*total reward requests*/
    	$total_rewards_requests =  $ci->db->from('tbl_reward_requests')
    	                                  ->get()
					                      ->result(); 

		foreach($total_rewards_requests as $reward_request) {

       	    $total_reward_points += $reward_request->reward_points;

       	    if($reward_request->reward_type == 'automatic') {

                ++$total_milestones;

	       	    if($reward_request->approved_status == 0) {
                    ++$requested_milestones;
	       	    }

	       	    if($reward_request->approved_status == 1) {
                    ++$approve_milestones;

                    $earn_reward_points += $reward_request->reward_points;
	       	    }

	       	    if($reward_request->approved_status == 2) {
                    ++$declined_milestones;
	       	    }
       	    }

		}			                      

    }

    $data = array(

				    'total_milestones'     => $total_milestones,
				    'requested_milestones' => $requested_milestones,
				    'approve_milestones'   => $approve_milestones,
				    'declined_milestones'  => $declined_milestones,
				    'total_reward_points'  => $total_reward_points,
				    'earn_reward_points'   => $earn_reward_points
				);


	return json_encode($data);

}

function checkRewardNotification($agentId = null) {

	$ci = &get_instance();

	if(!is_null($agentId)) {

	    $unread_reward_requests  =  $ci->db->from('tbl_reward_requests')
						                         ->where('readby_user',0)
						                         ->where('approved_status',0)
						                         ->where('staff_agent_id',$agentId)
						                         ->get()
						                         ->num_rows(); 				                         
	    if($unread_reward_requests > 0) {

	    	return json_encode([
                  
                  'status' => 1,
	              'unread_count' => $unread_reward_requests,
	              'message' => "You earned <a href='".admin_url('rewards')."?t=tab3'> points </a>"
	    	]);
	    }

	}

	return json_encode([
                  'status' => 0,
	              'unread_count' => 0,
	              'message' => 'You have no unread reward requests'
	    	]);

}


function setRewardNotification($agentId = null) {

   $ci = &get_instance();

   if(!is_null($agentId)) {

       $ci->db->where('staff_agent_id',$agentId)
              ->where('approved_status !=',0)
              ->update('tbl_reward_requests',[

		            'readby_user' => 1
		       ]);
   }

   return json_encode([
                  'status' => 1,
	              'message' => 'updated'
	    	]);

}


/*curl request function*/
function makeRequest($baseUrl,$requestUrl,$requestMethod='GET',$headers=[],$body=[]) {

    $url = $baseUrl.$requestUrl;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestMethod);

	if($requestMethod == 'POST') {

		curl_setopt($ch, CURLOPT_POST, 1);
		if(count($body) > 0){
        	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
		}
	}

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);

	if ($result === false)
    {  
        return [
                  'status'  => 0,
                  'message' => curl_error($ch), 
               ];
    }

	return [
                'status'  => 1,
                'message' => 'Data found',
                'data'    => $result
           ];
}
/*curl request function*/


/*wishlist-icon*/
function wishlist_icon($url,$product_id,$classes=[],$checkInWishlist=false,$text='',$option=[]) {

    if($checkInWishlist) {

    	if(isset($_SESSION['staff_user_id'])) {

    		$ci = &get_instance();

            $user_id = $_SESSION['staff_user_id'];

    		$ci->db->select('*');
	        $ci->db->from('tbl_catalouge_wishlist');
	        $ci->db->where('user_id',$user_id);
	        $query    = $ci->db->get();
	        $wishlist = $query->row();

	        if(count((array)$wishlist) > 0) { 
                  
                $wishlist_items = json_decode($wishlist->products);
                if(count($wishlist_items) > 0) {

                	if(in_array($product_id, $wishlist_items)) { 
                		array_push($classes,'added');  
                	}
                }
	        }
    	}
    }

    $classes = implode(' ',$classes);

	return '<a href = "'.$url.'" 
                class =  "'.$classes.'"
                onclick="return add_to_wishlist('.$product_id.',this)"
                >
                 <i class="fa fa-heart-o" aria-hidden="true"></i> '. $text.'
            </a>';

}

/*wishlist-icon end*/


/*Intialize cart on login*/
function cartIntialize() {

	$ci = &get_instance();
	$ci->load->library('cart');
    
	if(isset($_SESSION['staff_user_id']) && count((array)$ci->cart->contents()) <= 0 ) {

       $user_id = $_SESSION['staff_user_id'];
       $cart = [];

       /*get cart items of user*/
        $ci->db->select('*');
        $ci->db->from('tbl_catalouge_cart');
        $ci->db->where('user_id',$user_id);
        $query = $ci->db->get();
        $db_cart = $query->row();
        if(count((array)$db_cart) > 0) {

           $db_cart_products = json_decode($db_cart->products);
           if(count($db_cart_products) > 0) {
              
               /*get db products*/
                $ci->db->select('*');
                $ci->db->from('tbl_catalouge_products');
                $query = $ci->db->get();
                $db_products_data = $query->row();

                if(count((array)$db_products_data) > 0) {

                   $db_products = json_decode($db_products_data->products);

                    foreach ($db_products as $key => $product) {

                    	if(count($db_cart_products) <= 0) {	break; }
                         
                        foreach ($db_cart_products as $key => $db_cart_product) {
                         
                            if($product->id == $db_cart_product->product_id) {
                                
                                $productNameArr = $product->namesArray;
                                $productName    = $productNameArr[0]->value;

                                $productImageArr = $product->imagesArray;
                                $productImage    = $productImageArr[2]->url;
                                $lsProductId     = $product->lsProductId;
                            	$cart[] = array(
								                    'id'      => $db_cart_product->product_id,
								                    'qty'     => (int)$db_cart_product->product_count,
								                    'price'   => $product->price,
								                    'name'    => $productName,
								                    'options' => array('image' => $productImage,'lsProductId' => $lsProductId)
							                    );

                            	unset($db_cart_products[$key]);

                            }     	
                        }
                    }       
               }
           }
        }

        /*Intialize cart if item exist in database cart on Login*/
        if(count($cart)) {
            
            /*Adding Items to cart*/
            foreach ($cart as $key => $data) {
        		$ci->cart->insert($data);
            }
        }
	}
}
/*Intialize cart on login End*/

function priceToRewardPoints($value) {

	return $value*100;
}


/*calculate shipping cost*/
 function calculateShippig($region_code = 'AVG_CANADA') {

 	$ci = &get_instance();

 	$ci->db->select('*');
 	$ci->db->from('tbl_shipping_cost');
 	$ci->db->where('region_code',$region_code);
 	$result = $ci->db->get()->row();
    
    $amount = 0;
 	if(count((array) $result) > 0) {
 	    $amount = $result->amount;	 
 	}
 	else {

 		$ci->db->select('*');
	 	$ci->db->from('tbl_shipping_cost');
	 	$ci->db->where('region_code','AVG_CANADA');
	 	$result = $ci->db->get()->row();
	 	$amount = $result->amount;
 	}

 	return $amount;

 }
/*calculate shipping cost end*/

/*get-product-detail*/
function getProductDetail($productId =null) {

	if(!is_null($productId) && !empty($productId)){

		/*get products from db*/  
		$ci = &get_instance();
        $ci->db->select('*');
        $ci->db->from('tbl_catalouge_products');
        $query       = $ci->db->get();
        $productData = $query->row();
        $products    = json_decode($productData->products);
        $data        = null;
        if(count($products)) {
            foreach($products as $product) {

               if($product->id == $productId) {
                   $data = $product;
                   break;
               }
            }
        }
		return $product;

	}else {

		return [];
	}

}
/*get-product-detail-end*/

/*regions*/
function shippingRegions(){

    $ci = &get_instance();
 	$ci->db->select('*');
 	$ci->db->from('tbl_shipping_cost');
 	$shipping_regions = $ci->db->get()->result_array();

 	if(count($shipping_regions) <= 0) {
       
       return [];     
 	}

 	return $shipping_regions;

}
/*regions cost*/


/*check-total-reward-points*/
function totalRewardPoints($staff_agent_id) {

	$ci = &get_instance();
	$ci->db->select('*');
	$ci->db->from('tbl_reward_points');
	$ci->db->where('staff_agent_id',(int)$staff_agent_id);
	$query = $ci->db->get();
	$result = $query->row();

	if($result) {
		return $result->points;
	}

	return 0;

}
/*check-total-reward-points-end*/

/*modify-user-reward-points*/
function modifyRewardPoints($staff_agent_id,$action='add',$points) {

    $ci = &get_instance();
	$ci->db->select('*');
	$ci->db->from('tbl_reward_points');
	$ci->db->where('staff_agent_id',(int)$staff_agent_id);
	$query  = $ci->db->get();
	$result = $query->row();
	if(!$result){
      /*create if result doesnot exist*/
      $ci->db->insert('tbl_reward_points',['staff_agent_id' => $staff_agent_id,'points' => 0]);

      $ci->db->select('*');
	  $ci->db->from('tbl_reward_points');
	  $ci->db->where('staff_agent_id',(int)$staff_agent_id);
	  $query  = $ci->db->get();
	  $result = $query->row();
	}
	$total_points = $result->points;

	if($action == 'add') {
		$total_points += $points;
	}
	else if($action == 'sub') {
		$total_points -= $points;
	}

	$ci->db->set('points',$total_points);
	$ci->db->where('staff_agent_id',(int)$staff_agent_id);
	$ci->db->update('tbl_reward_points');

}
/*modify-user-reward-points-end*/


/*get-brand-by-id*/
/*=====================================================================*/
  function getBrand($brand_id = null) {

  	  if(!is_null($brand_id) && !empty($brand_id)){
            
          $ci = &get_instance();
          $ci->db->select('*');
          $ci->db->from('tbl_catalouge_brands');
          $ci->db->where('brand_id',$brand_id);
          $query = $ci->db->get();
          $brand = $query->row();

          return $brand;
  	  }
  	  else { return null; }
  }
/*=====================================================================*/


/*Save New Data Function Starts Here*/

function renderData($tableName="",$tableData="",$where="",$orderBy=""){
  $ci = &get_instance();
  // print_r($tableData);die();
  if(!empty($where)){
    $updated_at = date("Y-m-d h:i:s");
    $tableData['updated_at'] = $updated_at;
    return $ci->db->where($where)->update($tableName,$tableData);
  }else{
    return $ci->db->insert($tableName,$tableData);
  }
}

/*Save New Data Function Ends Here*/


/*Activity Log Data Function Start Here*/

function activityLog($type="",$condition="",$client_id=""){
    $ci = &get_instance();
    $id = $_SESSION['staff_user_id'];
    $superUserDetails = $ci->db->where('staffid',$id)->get('tblstaff')->row();
    $name = ucfirst($superUserDetails->firstname.' '.$superUserDetails->lastname);
    if ($_SESSION['staff_user_id'] && $superUserDetails->admin == 1) {
        $text = 'Admin '.$name.' '.$condition.' '.$type.' data';
    }else{
        $text = 'Agent '.$name.' '.$condition.' '.$type.' data';
    }
    $activityLogData = array(
        'description'    => $text,
        'staffid'        => $name,
        'customer_id'    => $client_id,
        'agent_id'       => $_SESSION['staff_user_id'],
        'date'           => date("Y-m-d h:i:s"),
    );
    return $ci->db->insert('tblactivity_log',$activityLogData);
}

/*Activity Log Data Function End Here*/


/*Check For Province Name*/

function checkProvince($name=""){
	switch ($name) {
		case 'NL':
			$province = 'Newfoundland and Labrador';
			break;
		case 'PE':
			$province = 'Prince Edward Island';
			break;
		case 'NS':
			$province = 'Nova Scotia';
			break;
		case 'NB':
			$province = 'New Brunswick';
			break;
		case 'QC':
			$province = 'Quebec';
			break;
		case 'ON':
			$province = 'Ontario';
			break;
		case 'MB':
			$province = 'Manitoba';
			break;
		case 'SK':
			$province = 'Saskatchewan';
			break;
		case 'AB':
			$province = 'Alberta';
			break;
		case 'BC':
			$province = 'British Columbia';
			break;
		case 'YT':
			$province = 'Yukon';
			break;
		case 'NT':
			$province = 'Northwest Territories';
			break;
		case 'NU':
			$province = 'Nunavut';
			break;
		default:
			$province = '';
			break;
	}
	return $province;
}

/*Check For Province Name*/