<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {
	private $msg;
	private $error;
    private $error_message;
    private $randval;
	public function __construct() {
        parent::__construct();
        if (!isset($this->session->optical_login))
         {
		 	redirect('login');
         }
        
        $this->load->model('Group_model','dm',true);
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->dm->ajax_call($param);
           echo json_encode($response);
    }
	public function index()
	{
      $data['title']='Pharmacy::Group';
      $data['activecls']='Group';
      $var_array=array($this->session->office_id);
      $last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('group_master')
                         ->where(array('office_id'=>$this->session->office_id,'type'=>1))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
      $data['codeno']=$code;
      $content=$this->load->view('master/group',$data,true);
      $this->load->view('includes/layout',['content'=>$content]);
	}

	 private function fetch_data($type,$code,$name,$description,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'type'=>1,
            'code'=>$code,
            'name'=>$name,
            'description'=>$description,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }

	public function savegroup()
	{
		$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$code=trim(htmlentities($this->input->post('code')));
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($type,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->dm->checkgroup($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($type,$code,$name,$description,$status);
	    		$getresult=$this->dm->savedata($data);
	    		if($getresult)
	    		{
		    		  $this->msg='Saved Successfully';
		    		  $this->error='';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message
					      ));
			            exit;
	    		}
	    		else
	    		{
	    			  $this->msg='';
		    		  $this->error='Failed to save';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message
					      ));
			            exit;
	    		}
	    	}
	    	else
	    	{
	    		$this->msg='';
	    		  $this->error='Code and Name already Used';
	    		  $this->error_message ='';
	              echo json_encode(array(
			        'msg'           => $this->msg,
			        'error'         => $this->error,
			        'error_message' => $this->error_message
			      ));
	            exit;
	    	}
	    }
	    else
	    {
	    		  $this->msg='';
	    		  $this->error='';
	    		  $this->error_message = $this->form_validation->error_array();
	              echo json_encode(array(
			        'msg'           => $this->msg,
			        'error'         => $this->error,
			        'error_message' => $this->error_message
			      ));
	            exit;
	    }
	}

	public function editgroup()
	{
		$this->form_validation->set_rules('edit_groupid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('edit_name', 'Name', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('edit_description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_groupid=trim(htmlentities($this->input->post('edit_groupid')));
	    	$type=trim(htmlentities($this->input->post('edit_type')));
	    	$code=trim(htmlentities($this->input->post('edit_code')));
	    	$name=trim(htmlentities($this->input->post('edit_name')));
	    	$description=trim(htmlentities($this->input->post('edit_description')));
	    	$status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_groupid,$type,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->dm->editcheckgroup($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($type,$code,$name,$description,$status);
	    		$getresult=$this->dm->updatedata($data,$edit_groupid);
	    		if($getresult)
	    		{
		    		  $this->msg='Updated Successfully';
		    		  $this->error='';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message
					      ));
			            exit;
	    		}
	    		else
	    		{
	    			  $this->msg='';
		    		  $this->error='Failed to Update';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message
					      ));
			            exit;
	    		}
	    	}
	    	else
	    	{
	    		  $this->msg='';
	    		  $this->error='Code and Name already Used';
	    		  $this->error_message ='';
	              echo json_encode(array(
			        'msg'           => $this->msg,
			        'error'         => $this->error,
			        'error_message' => $this->error_message
			      ));
	            exit;
	    	}
	    }
	    else
	    {
	    		  $this->msg='';
	    		  $this->error='';
	    		  $this->error_message = $this->form_validation->error_array();
	              echo json_encode(array(
			        'msg'           => $this->msg,
			        'error'         => $this->error,
			        'error_message' => $this->error_message
			      ));
	            exit;
	    }
	}

	public function deletegroup()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_groupid=trim(htmlentities($this->input->post('id')));
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$var_array=array($delete_groupid,$type,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->dm->deletecheckgroup($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->dm->deletedata($delete_groupid);
	    		if($getresult)
	    		{
		    		  $this->msg='Deleted Successfully';
		    		  $this->error='';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message
					      ));
			            exit;
	    		}
	    		else
	    		{
	    			  $this->msg='';
		    		  $this->error='Failed to Delete';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message
					      ));
			            exit;
	    		}
	    	}
	    	else
	    	{
	    		$this->msg='';
	    		  $this->error='Delete ID Not Found';
	    		  $this->error_message ='';
	              echo json_encode(array(
			        'msg'           => $this->msg,
			        'error'         => $this->error,
			        'error_message' => $this->error_message
			      ));
	            exit;
	    	}
	    }
	    else
	    {
	    		  $this->msg='';
	    		  $this->error='';
	    		  $this->error_message = $this->form_validation->error_array();
	              echo json_encode(array(
			        'msg'           => $this->msg,
			        'error'         => $this->error,
			        'error_message' => $this->error_message
			      ));
	            exit;
	    }
	}
}
