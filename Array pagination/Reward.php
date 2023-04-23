<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reward extends AdminController
{
    /**
     * Codeigniter Instance
     * Expenses detailed report filters use $ci
     * @var object
     */
    protected $baseUrl = 'http://api.loyaltysource.com:8080';
    protected $apiKey  = 'UmF0ZXNob3AgSW5jOlJhdGVzaG9wMjAyMSE=';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reward_model');
        $this->load->helper('common_helper');
        $this->load->model('dashboard_model');
        $this->load->library('cart');

        cartIntialize();
    }
    
    /*
        function to return view
    */
    public function index(){

        $data['leadstatusRows']  = $this->getLeadStatusRows();
        $data['staffAgentsListRows']  = $this->Reward_model->getStaffAgentsList();

        if(isset($_SESSION['staff_user_id']))
        {
            if(is_admin()) {

                $data['pointEarnRows'] = $this->Reward_model->rewardRequestList(null,1);
                /* helper function filename common_helper.php*/
                $data['milestone_Data'] = json_decode(getAdminMilestoneData($_SESSION['staff_user_id']));

            } else {

                $data['pointEarnRows']  = $this->Reward_model->rewardRequestList($_SESSION['staff_user_id'],1);
                /* helper function filename common_helper.php*/
                $data['milestone_Data'] = json_decode(getAgentMilestoneData($_SESSION['staff_user_id'])); 

            }
        }

        /*get-catalouge-categories*/
          $data['catalouge_categories_list'] = $this->db_catalouge_categories(false);
          $data['category_groups'] = json_decode($this->categoryGroup());
        /**/

        $this->load->view('admin/reward_point/rewards',$data);
    }
    /*=====================================================================*/
    
    /*
        function to get reward list
    */
    public function show(){
        $data=$this->Reward_model->rewardList();
        echo json_encode($data);
    }
    /*=====================================================================*/
    
    /*
        function to get particular reward
    */
    public function get(){
        $data['rewardRow']=$this->Reward_model->reward();
        $data['is_checked_all'] = $this->checkAllStaffAgentsSelected(json_decode($data['rewardRow']->staff_agents_ids));
        echo json_encode($data);
    }
    /*=====================================================================*/
    
    /*
        function to save reward
    */
    public function save(){
      
       if($this->input->server('REQUEST_METHOD') == 'POST') {

            /*validation start*/

                 $this->load->helper(array('form')); 
                 $this->load->library('form_validation');

                 $this->form_validation->set_rules('task', 'task', 'required'); 
                 $this->form_validation->set_rules('reward_points', 'reward point', 'required');
                 $this->form_validation->set_rules('due_day', 'due day', 'required|numeric');
                 $this->form_validation->set_rules('status', 'status', 'required');
            /*validation end*/

            if($this->form_validation->run()) {

                /*check request action*/
                $action = $this->input->post('action');
                if($action == 'save') {
                    $data=$this->Reward_model->saveReward();
                    http_response_code(201);
                    echo json_encode(['data' => $data,'status' => 1]);

                } else if($action == 'update') {
                    $data=$this->Reward_model->updateReward();
                    http_response_code(200);
                    echo json_encode(['data' => $data,'status' => 1]);

                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'record is not saved','status' => 0]);
                }

            }
            else {

                /*if form validation fails*/
                $validation = $this->form_validation->error_array();
                $field = array();
                foreach($validation as $key => $value) {
                    array_push($field,$key);
                }
                $reply = array(
                    'code'       => 404,
                    'field'      => $field,
                    'validation' => $validation,
                    'message'    => 'Submission failed due to validation error.'
                );
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Internal Server Problem', true, 404);
                header('Content-Type: application/json; charset=UTF-8');
                print json_encode($reply);
            }

            
       }
       else {

            http_response_code(404);
            echo json_encode(['error' => 'invalid request type','status' => 0]);
       }
    }
    /*=====================================================================*/
    
    /*
        function to update reward
    */
    public function update(){

        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $data=$this->Reward_model->updateReward();
            echo json_encode($data);

        }
    }
    /*=====================================================================*/
    
    /*
        function to delete reward
    */
    public function delete(){

        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $data=$this->Reward_model->deleteReward();
            echo json_encode($data);
        }
    }
    /*=====================================================================*/


    /*
        function to leadstatus
    */
    public function getLeadStatusRows(){

        $leadstatusRows = $this->db->get('tblleads_status')->result();
        if(count($leadstatusRows)) {
            return $leadstatusRows;
        }

        return [];
    }
    /*=====================================================================*/
    
    /*
        function to check-all-sttaf-ids-selected
    */
    public function checkAllStaffAgentsSelected($staff_agents_ids_Arr) {

        $staff_agents       = $this->Reward_model->getStaffAgentsList();
        $staff_agents_count = count($staff_agents); 

        $selected_staff_agents_count = count($staff_agents_ids_Arr);

        if($staff_agents_count == $selected_staff_agents_count) {
            return 1;
        }

        return 0;
    }
    /*=====================================================================*/

    /*
        rewardrequests (automatic)
    */
    public function getRewardRequests() {
        
        $reward_requests = $this->Reward_model->rewardRequestList();
        echo json_encode($reward_requests);
    }
    /*=====================================================================*/

    /*
        change reward request status (automatic)
    */
    public function changeRewardRequestStatus() {

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            $data = $this->input->post();
            $reward_request_id = $data['reward_request_id'];
            $approve_status    = $data['approve_status'];  /*1 => Approved, 2 => Declined*/

            if(!empty($reward_request_id) && !empty($approve_status)) {

                $this->db->select('*');
                $this->db->from('tbl_reward_requests');
                $this->db->where('id',$reward_request_id);
                $query = $this->db->get();
                $reward_request = $query->row();

                /*change status*/
                $this->db->where('id',$reward_request->id)->update('tbl_reward_requests',array(

                    'approved_status' => $approve_status,
                    'approved_date'   => date('Y-m-d')
                ));

                if($approve_status == 1)
                {
                    
                    /*==================modifyRewardPoints==================*/
                              modifyRewardPoints(
                                                   $reward_request->staff_agent_id,
                                                   'add',
                                                   $reward_request->reward_points
                                                );
                    /*==================modifyRewardPoints End==================*/  
                }
                $approve_message = 'Reward approved successfully!';
                if($approve_status == 2) {
                    $approve_message = 'Reward declined';
                }
                http_response_code(200); 
                echo json_encode([
                                      'status'         => '1',
                                      'approve_status' => $approve_status,
                                      'approve_message'=> $approve_message,
                                      'message'        => 'status changed successfully'
                                ]);

            }
            else {

              http_response_code(500); 
              echo json_encode(['status' => '0','message' => 'error while changing status']);
            }
            
        }

    }
    /*=====================================================================*/

    
    /*Catalog Categories*/
    protected function get_cataglog_catgeories() {

        return makeRequest(
                            $this->baseUrl,
                            '/api/categories',
                            'GET',
                            [
                               'Authorization: '.$this->apiKey,
                               'Accept: application/json',
                               'Content-Type: application/json'
                            ]

                          ); 
      }
    /*=====================================================================*/


    /*
      *DB Catalog Products
    */
    public function get_cataglog_products() {


        /*get products from db*/  
        $this->db->select('*');
        $this->db->from('tbl_catalouge_products');
        $query       = $this->db->get();
        $productData = $query->row();
        $products    = json_decode($productData->products);

        /*filter by group-and-category-and-type*/

            $group    = (int)$this->input->get('group');
            $category = (int)$this->input->get('category');
            $type     = (int)$this->input->get('type');
            $categoriesArr = array();

            /*--------------------------------*/
              $group_name    = '';
              $category_name = '';
              $type_name     = '';
            /*-------------------------------*/

            if(!empty($type)) {

                $categoriesArr = [$group,$category,$type];
                
                /*to-get-group,category,type name*/
                $db_categories = $this->db->select('*')
                                      ->from('tbl_catalouge_categories')
                                      ->where_in('category_id',$categoriesArr)
                                      ->get()->result();

                if($db_categories) {

                    foreach ($db_categories as $db_category) {
                        
                        if($db_category->category_id == $group)    { $group_name = $db_category->category_name;}
                        if($db_category->category_id == $category) { $category_name = $db_category->category_name;}
                        if($db_category->category_id == $type)     { $type_name = $db_category->category_name;}
                    }
                }
                /*to-get-group,category,type name end */                    
            }
            elseif(!empty($category)) {
              
                $categoriesArr = [$group,$category];
               
                /*to-get-group,category name*/
                $db_categories = $this->db->select('*')
                                      ->from('tbl_catalouge_categories')
                                      ->where_in('category_id',$categoriesArr)
                                      ->get()->result();

                if($db_categories) {

                    foreach ($db_categories as $db_category) {
                        
                        if($db_category->category_id == $group)    { $group_name = $db_category->category_name;}
                        if($db_category->category_id == $category) { $category_name = $db_category->category_name;}
                    }
                }
                /*to-get-group,category name end*/       

                $child_categories = $this->db->select('*')
                                       ->from('tbl_catalouge_categories')
                                       ->where('category_parentId',$category)
                                       ->get()->result();
                if($child_categories) {

                    foreach ($child_categories as $child_category) {
                        
                        $categoriesArr[] = $child_category->category_id;
                    }
                }
            }
            else if(!empty($group)) {

                $categoriesArr = [$group];
                
                /*to-get-group name*/
                $db_categories = $this->db->select('*')
                                      ->from('tbl_catalouge_categories')
                                      ->where_in('category_id',$categoriesArr)
                                      ->get()->result();

                if($db_categories) {

                    foreach ($db_categories as $db_category) {
                        
                        if($db_category->category_id == $group)    { $group_name = $db_category->category_name;}
                    }
                }
                /*to-get-group name end*/   

                $child_categories = $this->db->select('*')
                                       ->from('tbl_catalouge_categories')
                                       ->where('category_parentId',$group)
                                       ->get()->result();

                if($child_categories) {

                    foreach ($child_categories as $child_category) {
                        
                        $categoriesArr[] = $child_category->category_id;

                        $sub_child_categories = $this->db->select('*')
                                       ->from('tbl_catalouge_categories')
                                       ->where('category_parentId',$child_category->category_id)
                                       ->get()->result();

                        if($sub_child_categories) {

                            foreach ($sub_child_categories as $sub_child_category) {

                                  $categoriesArr[] = $sub_child_category->category_id;
                            }
                        }               
                    }
                }
            }


        if(count($categoriesArr) > 0) {
 

            $products = array_filter($products,function($product) use($categoriesArr){
                         if (in_array($product->categoryId,$categoriesArr) && $product->status == 'Available') { return true; }
                         return false;
                       });

            $products = array_values($products);

        }

        /*filter by group-and-category-and-type*/


        /*filter by category*/
        //$category_id = (int)$this->input->get('category_id');
        // $category_name = '';
        // if(!empty($category_id)) {

        //     /*get category*/
        //     $category = $this->db->select('*')
        //                      ->from('tbl_catalouge_categories')
        //                      ->where('category_id',$category_id)
        //                      ->get()
        //                      ->row();
        //     $category_name = $category->category_name;   

        //     $products = array_filter($products,function($product) use($category_id){
        //                  if ($product->categoryId == $category_id && $product->status == 'Available') { return true; }
        //                  return false;
        //                });

        //     $products = array_values($products);

        // }
        /*filter by category*/

        /*filter by search*/
        $search = $this->input->get('search');
        if(!empty($search)) {

            $search   = strtolower(trim($search));    
            $products = array_filter($products,function($product) use($search){

                            $productNameArr = $product->namesArray;
                            $productName    = strtolower($productNameArr[0]->value);
                            if (strpos($productName, $search) !== false && $product->status == 'Available') { return true; }
                            return false;
                       });

            $products = array_values($products);
        }
        /*filter by search end*/

        /*sortby  Asc/Desc*/
        $sort = $this->input->get('sort');
        if(!empty($sort)) {

            $sort_arr = explode(',',$sort);

            /*sortby  Brand Asc/Desc*/
            if($sort_arr[0] == 'brand' && $sort_arr[1] == 'asc') {
              array_multisort(array_column($products, 'brand'), SORT_ASC, $products);
            } 
            else if($sort_arr[0] == 'brand' && $sort_arr[1] == 'desc') {
               array_multisort(array_column($products, 'brand'), SORT_DESC, $products);
            }
            
            /*sortby  Name Asc/Desc*/
            if($sort_arr[0] == 'name' && $sort_arr[1] == 'asc') {
              
                usort($products, function($a, $b) {
                    return strcasecmp($a->namesArray[0]->value,$b->namesArray[0]->value);
                });

            } else if($sort_arr[0] == 'name' && $sort_arr[1] == 'desc') {
    
                usort($products, function($a, $b) {
                    return - strcasecmp($a->namesArray[0]->value,$b->namesArray[0]->value);
                });

            }
        }
        /*sortby brand Asc/Desc*/

        $productsCount = count($products);

        $page = 1; /*default page value*/
        if(!empty($this->input->get('page'))) {
           $page = (int)$this->input->get('page');
        }
        $results_per_page  = 50;  
        $page_first_result = ($page-1) * $results_per_page;
        $page_last_result  = $page_first_result+$results_per_page;
        
        /*check starting index not exceed total items*/
        if($page_last_result > $productsCount) {
            $page_last_result = $productsCount;
        }

        $number_of_page = ceil ( $productsCount / $results_per_page); 
         
        /*pagination*/
        $pagination = ''; 
        if($productsCount > 0 && $number_of_page > 0) {
           $pagination = $this->pagination(admin_url('catalog/products'), $page, $number_of_page, $prev_next=true);
        } 

           
        $response = [
              
            'status'  => 1,
            'message' => ($page_first_result <= $productsCount) ? 'Data Found' : 'No Data Found',
            'data'    => $this->load->view('admin/catalog/products',[
                           'data'              => $products,
                           'productsCount'     => $productsCount,
                           'page_first_result' => $page_first_result,
                           'page_last_result'  => $page_last_result,
                           'results_per_page'  => $results_per_page,
                           'page'              => $page,
                           'number_of_page'    => $number_of_page,
                           'search'            => $search,
                           'pagination'        => $pagination,
                           'sort'              => $sort,
                           'catalouge_categories_list' => $this->db_catalouge_categories(false),
                           'category_groups'   => json_decode($this->categoryGroup()),
                           'group'             => (int)$this->input->get('group'),
                           'category'          => (int)$this->input->get('category'), 
                           'type'              => (int)$this->input->get('type'),    
                           'group_name'        => $group_name,
                           'category_name'     => $category_name,
                           'type_name'         => $type_name
                        ],
                        TRUE),
          //  'category' => $category_id,
            
        ];
        echo json_encode($response);

      }
    /*=====================================================================*/

    /*
      *DB Catalog Categories
    */

    protected function db_catalouge_categories($parent=true) {

        $this->db->select('*');
        $this->db->from('tbl_catalouge_categories');
        if(!$parent)
        {
           $this->db->where('category_parentId !=',0); 
        }
        $query = $this->db->get(); 
        $db_catalouge_categories_list = $query->result();

        return $db_catalouge_categories_list;
    }

    /*
      *custom pagination
    */

    protected function pagination($base_url, $cur_page, $number_of_pages, $prev_next=false) {

        $ends_count = 1;  //how many items at the ends (before and after [...])
        $middle_count = 2;  //how many items before and after current page
        $dots = false;
        $html  = '';
        $html .= '<ul class="pagination">';

        if ($prev_next && $cur_page && 1 < $cur_page) {  //print previous button?
          
          $html .= '<li>';
          $html .= '<a href = "'.$base_url.'" class="paginate" data-page="'.($cur_page-1).'">&laquo; Previous</a>';  
          $html .= '</li>';
  
        }

        for ($i = 1; $i <= $number_of_pages; $i++) {

          if ($i == $cur_page) {

               $html .= '<li class="active"><a>'.$i.'</a></li>';
               $dots = true;
          } else {
               if ($i <= $ends_count || ($cur_page && $i >= $cur_page - $middle_count && $i <= $cur_page + $middle_count) || $i > $number_of_pages - $ends_count) { 

                    $html .= '<li><a href="'.$base_url.'" class="paginate" data-page="'.$i.'">'.$i.'</a></li>';

                    $dots = true;
               } elseif ($dots) {
                    $html .= '<li><a>&hellip;</a></li>';
                    $dots = false;
               }
          }
        }

        if ($prev_next && $cur_page && ($cur_page < $number_of_pages || -1 == $number_of_pages)) { //print next button?
          $html .= '<li class="next "><a href="'.$base_url.'" class="paginate" data-page="'.($cur_page+1).'">Next &raquo;</a></li>';
        }

        return $html;
    }


    /*
      *milestone-category-triggers
    */
    function milestone_category_triggers() {

        $milestone_category_id = (int)$this->input->get('milestone_category_id');

        if(!is_null($milestone_category_id) && !empty($milestone_category_id)) {

            $this->db->select('*');
            $this->db->from('tbl_milestone_trigger');
            $this->db->where('id',$milestone_category_id);
            $query  = $this->db->get();
            $result = $query->row(); 

            if($result) {

                http_response_code(200); 
                echo json_encode(['status' => 1, 'message' => 'Data Found', 'data' => json_decode($result->triggers)]);
            }
            else 
            { 
                http_response_code(404);
                echo json_encode(['status' => 1, 'message' => 'Data Not Found']);
            }
        }
        else {

            http_response_code(404);
            echo json_encode(['status' => 1, 'message' => 'Data Not Found']);
        }

    }
    /*=====================================================================*/

    /*
     * Save Milestone
    */
    public function milestone_save() {

        if($this->input->server('REQUEST_METHOD') == 'POST') {

            $data = array(

                 'milestone_category_id' => $this->input->post('milestone_category_id'),
                 'milestone_trigger_id'  => $this->input->post('milestone_trigger_id'),
                 'agents_list'           => json_encode($this->input->post('agents_list')),
                 'points'                => $this->input->post('points'),
                 'due_date'              => date('Y-m-d',(strtotime($this->input->post('due_date')))),
            );

            if($this->input->post('active')) 
            { $data['active'] = 1; }
            else
            { $data['active'] = 0; }

            /*check request action*/
            $action = $this->input->post('action');

            if($action == 'add') {

                $this->db->insert('tbl_milestones',$data);

                http_response_code(201);
                echo json_encode(['data' => $data,'status' => 1]);

            } else if($action == 'update') {
                
                $milestone_id = $this->input->post('milestone_id');
                $this->db->where('id',$milestone_id); 
                $this->db->update('tbl_milestones',$data);

                http_response_code(201);
                echo json_encode(['data' => $data,'status' => 1]);

            } else {

                http_response_code(400);
                echo json_encode(['error' => 'record is not saved','status' => 0]);
            }
        }  
    }
    /*=====================================================================*/
    
    /*
     * Save Milestone
    */
    public function milestone_list() {

        $result =   $this->db->select('tbl_milestones.*,tbl_milestone_trigger.id as m_t_id,tbl_milestone_trigger.category_name,tbl_milestone_trigger.triggers')
                         ->from('tbl_milestones')
                         ->join('tbl_milestone_trigger','tbl_milestones.milestone_category_id=tbl_milestone_trigger.id','left')
                         ->order_by("tbl_milestones.id", "desc")
                         ->get()
                         ->result();

        if($result) {

            http_response_code(200);
            echo json_encode(['status' => 1, 'message' => 'Data Found' ,'data' => $result]);

        } else {
           
           http_response_code(404);
           echo json_encode(['status' => 0, 'message' => 'Data Not Found']);
        }      
    }
    /*=====================================================================*/
    

    /*
     * Save Milestone
    */ 
    public function milestone_delete() { 

       if($this->input->server('REQUEST_METHOD') == 'POST') { 

           $id = $this->input->post('id');
           if(!is_null($id) && !empty($id)){

                $this->db->where('id',$id);
                $this->db->delete('tbl_milestones');

                http_response_code(201);
                echo json_encode(['status' => 1, 'message' => 'Data deleted successfully']);
           }
           else {

              http_response_code(404);
              echo json_encode(['status' => 0, 'message' => 'Data not found']);
           }

       }else {

           http_response_code(404);
           echo json_encode(['status' => 0, 'message' => 'Invalid request type']);
       }
    }
    /*=====================================================================*/
    

    /*
     * get Milestone
    */
    function milestone_get() {

        if($this->input->server('REQUEST_METHOD') == 'POST') { 

           $id = $this->input->post('id');
           if(!is_null($id) && !empty($id)){
                
                $this->db->select('*');
                $this->db->where('id',$id);
                $this->db->from('tbl_milestones');
                $query = $this->db->get();
                $result = $query->row();

                http_response_code(200);
                echo json_encode(['status' => 1, 'message' => 'Data found','data' => $result]);
           }
           else {

              http_response_code(404);
              echo json_encode(['status' => 0, 'message' => 'Data not found']);
           }

        }else {

           http_response_code(404);
           echo json_encode(['status' => 0, 'message' => 'Invalid request type']);
        }

    }
    /*=====================================================================*/

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
        
      return json_encode($data);
    }
    /*=====================================================================*/

}    
