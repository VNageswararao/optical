<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller {
	
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
        
        $this->load->model('Change_password_model');
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Change_password_model->ajax_call($param);
           echo json_encode($response);
    }
	public function index()
	{
          $data['title']='Optical::Change Password';
          $data['activecls']='Change Password';
           $var_array=array($this->session->office_id);
          $last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('classification')
                         ->where(array('office_id'=>$this->session->office_id,'type'=>2))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
          $data['codeno']=$code;
          $content=$this->load->view('master/change_password',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	
    public function Change_password_action()
	{
		$this->form_validation->set_rules('oldpwd', 'Old Password', 'trim|required|min_length[1]|max_length[25]');
		$this->form_validation->set_rules('newpwd', 'New Password', 'trim|required|min_length[1]|max_length[25]');
		$this->form_validation->set_rules('cpwd', 'Confirm Password', 'trim|required|min_length[1]|max_length[25]');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$oldpwd=trim(htmlentities($this->input->post('oldpwd')));
	    	$newpwd=trim(htmlentities($this->input->post('newpwd')));
	    	$cpwd=trim(htmlentities($this->input->post('cpwd')));
	    	
	    	
	    	$var_array=array($oldpwd,$this->session->userdata('login_id'));
	    	$chk_duplication=$this->Change_password_model->checkpwd($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		if($newpwd!=$cpwd)
	    		{
	    			 echo json_encode(array('msg'=>'','error'=>'New Password && Confirm Password Mismatched','error_message'=>''));
	           		 exit;
	    		}
	    		$data=array($newpwd,$oldpwd,$this->session->userdata('login_id'));
	    		$getresult=$this->Change_password_model->updatedatapassword($data);
	    		if($getresult)
	    		{
		    		  $this->msg='Password Changed Successfully';
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
	    		  $this->error='Old password Not Matched';
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
