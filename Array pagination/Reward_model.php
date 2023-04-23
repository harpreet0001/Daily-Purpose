<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reward_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /* to get reward list*/   
    public function rewardList() 
    {
       return  $this->db->select('tblrewards.*,tblleads_status.name as lead_status_name')
                        ->from('tblrewards')
                        ->join('tblleads_status','tblrewards.lead_status_id =tblleads_status.id','left')
                        ->where('tblrewards.reward_type','automatic')
                        ->order_by("tblrewards.id", "desc")
                        ->get()
                        ->result();
        // return $this->db->get('tblrewards')->result();
    }

    /* to get particular reward*/   
    public function reward() 
    {   
        $id = $this->input->post('reward_id');
        $this->db->where('id',$id);
        return $this->db->get('tblrewards')->row();
    }

    /*to save reward*/
    public function saveReward()
    {
        $data = array(

            'task'                => $this->input->post('task'),
            'lead_status_id'      => $this->input->post('lead_status_id'),
            'deal_status'         => $this->input->post('deal_status'),
            'staff_agents_ids'    => json_encode($this->input->post('staff_agents_ids')),
            'reward_type'         => 'automatic',
            'reward_points'       => $this->input->post('reward_points'),
            'due_day'             => $this->input->post('due_day'),
            'status'              => $this->input->post('status')

        );

        $result = $this->db->insert('tblrewards',$data);
        return $result;
    }

    /*to update reward*/
    public function updateReward()
    {
        $id                = $this->input->post('reward_id');
        $task              = $this->input->post('task');
        $reward_points     = $this->input->post('reward_points');
        $lead_status_id    = $this->input->post('lead_status_id');
        $deal_status       = $this->input->post('deal_status');
        $staff_agents_ids  = json_encode($this->input->post('staff_agents_ids'));
        $due_day           = $this->input->post('due_day');
        $status            = $this->input->post('status');

        $this->db->set('task',$task);
        $this->db->set('reward_points',$reward_points);
        $this->db->set('lead_status_id',$lead_status_id);
        $this->db->set('deal_status',$deal_status);
        $this->db->set('staff_agents_ids',$staff_agents_ids);
        $this->db->set('due_day',$due_day);
        $this->db->set('status',$status);

        $this->db->where('id',$id);

        $result = $this->db->update('tblrewards');
        return $result;    
    }
    
    /*to delete reward*/
    public function deleteReward()
    {
        $id = $this->input->post('reward_id');
        $this->db->where('id',$id);

        $result = $this->db->delete('tblrewards');
        return $result;
    }

    /*to get agents list*/
    public function getStaffAgentsList() {
          
        $this->db->select('*');
        $this->db->where(['admin' => 0 , 'active' => 1]);
        $this->db->from('tblstaff');
        $query  = $this->db->get();  
        $result = $query->result();
        return $result;
    }

    /*to get list of reward requests*/
    public function rewardRequestList($staff_agent_id = null,$approved_status = null) {

        $this->db->select(
                           'tbl_reward_requests.*,
                           tblusers.first_name as user_first_name ,
                           tblusers.last_name as user_last_name ,
                           tblusers.email as user_email,
                           tblstaff.firstname as agent_first_name ,
                           tblstaff.lastname as agent_last_name ,
                           tblstaff.email as agent_email,
                           tblleads_status.name as lead_status_name'
                       );
        $this->db->from('tbl_reward_requests');
        $this->db->join('tblusers','tbl_reward_requests.user_id=tblusers.id','left');
        $this->db->join('tblstaff','tbl_reward_requests.staff_agent_id=tblstaff.staffid','left');
        $this->db->join('tblleads_status','tbl_reward_requests.lead_status_id=tblleads_status.id','left');

        if(!is_null($staff_agent_id)) {
            $this->db->where('tbl_reward_requests.staff_agent_id',$staff_agent_id);
        }

        if(!is_null($approved_status)) {
            $this->db->where('tbl_reward_requests.approved_status',$approved_status);
        }

        $query  = $this->db->get();  
        $result = $query->result();  
        return $result;        
    }

}
