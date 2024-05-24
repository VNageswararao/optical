<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_registration extends CI_Controller {
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
        
        $this->load->model('Staff_model','sm',true);
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->sm->ajax_call($param);
           echo json_encode($response);
    }
	public function index()
	{
      $data['title']='Optical::Staff Registration';
      $data['activecls']='staff_registration';
      $var_array=array($this->session->office_id);
      $last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('staff')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
      $data['codeno']=$code;
      $content=$this->load->view('master/staff',$data,true);
      $this->load->view('includes/layout',['content'=>$content]);
	}

	 private function fetch_data($code,$name,$mobile,$email,$address,$description,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'code'=>$code,
            'name'=>$name,
            'mobile'=>$mobile,
            'email'=>$email,
            'address'=>$address,
            'description'=>$description,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }

	public function savestaff()
	{
		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('name', 'Staff Name', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('mobile', 'Staff Mobile', 'trim|required|min_length[10]|max_length[13]|numeric');
		$this->form_validation->set_rules('email', 'Staff Email', 'trim|min_length[1]|max_length[55]|valid_email');
		$this->form_validation->set_rules('address', 'Staff Address', 'trim');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$code=trim(htmlentities($this->input->post('code')));
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$mobile=trim(htmlentities($this->input->post('mobile')));
	    	$email=trim(htmlentities($this->input->post('email')));
	    	$address=trim(htmlentities($this->input->post('address')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($code,$name,$mobile,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->sm->checkstaff($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$mobile,$email,$address,$description,$status);
	    		$getresult=$this->sm->savedata($data);
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
	    		  $this->error='Code or  Name or Mobile No already Used';
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

	public function editstaff()
	{
		$this->form_validation->set_rules('edit_staffid', 'Staff ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('edit_name', 'Staff Name', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('edit_mobile', 'Staff Mobile', 'trim|required|min_length[10]|max_length[13]|numeric');
		$this->form_validation->set_rules('edit_email', 'Staff Email', 'trim|min_length[1]|max_length[55]|valid_email');
		$this->form_validation->set_rules('edit_address', 'Staff Address', 'trim');
    	$this->form_validation->set_rules('edit_description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_staffid=trim(htmlentities($this->input->post('edit_staffid')));
	    	$code=trim(htmlentities($this->input->post('edit_code')));
	    	$name=trim(htmlentities($this->input->post('edit_name')));
	    	$mobile=trim(htmlentities($this->input->post('edit_mobile')));
	    	$email=trim(htmlentities($this->input->post('edit_email')));
	    	$address=trim(htmlentities($this->input->post('edit_address')));
	    	$description=trim(htmlentities($this->input->post('edit_description')));
	    	$status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_staffid,$code,$name,$mobile,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->sm->editstaff($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$mobile,$email,$address,$description,$status);
	    		$getresult=$this->sm->updatedata($data,$edit_staffid);
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

	public function deletestaff()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_staffid=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($delete_staffid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->sm->deletecheckstaff($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->sm->deletedata($delete_staffid);
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
