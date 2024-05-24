<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Controller {
	private $msg;
	private $error;
    private $error_message;
    private $randval;
	public function __construct() 
	{
        parent::__construct();
        if (!isset($this->session->optical_login))
         {
		 	redirect('login');
         }
        
        $this->load->model('Frame_model');
    }
	public function index()
	{
          $data['title']='Optical::Model';
          $data['activecls']='Model';
          $content=$this->load->view('master/model',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	public function ajax_call(){
           $param=$_REQUEST;
           $type=3;
           $response=$this->Frame_model->ajax_call($param,$type);
           echo json_encode($response);
    }
     private function fetch_data($type,$code,$name,$description,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'type'=>$type,
            'code'=>$code,
            'name'=>$name,
            'description'=>$description,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }

	public function saveframe()
	{
		$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('name', 'Model', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$code=trim(htmlentities($this->input->post('code')));
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($type,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Frame_model->checkframe($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($type,$code,$name,$description,$status);
	    		$getresult=$this->Frame_model->savedata($data);
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
	    		  $this->error='Code and Model already Used';
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

	public function editframe()
	{
		$this->form_validation->set_rules('edit_frameid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('edit_name', 'Model', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('edit_description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_frameid=trim(htmlentities($this->input->post('edit_frameid')));
	    	$type=trim(htmlentities($this->input->post('edit_type')));
	    	$code=trim(htmlentities($this->input->post('edit_code')));
	    	$name=trim(htmlentities($this->input->post('edit_name')));
	    	$description=trim(htmlentities($this->input->post('edit_description')));
	    	$status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_frameid,$type,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Frame_model->editcheckframe($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($type,$code,$name,$description,$status);
	    		$getresult=$this->Frame_model->updatedata($data,$edit_frameid);
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
	    		  $this->error='Code and Model already Used';
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

	public function deleteframe()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_frameid=trim(htmlentities($this->input->post('id')));
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$var_array=array($delete_frameid,$type,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Frame_model->deletecheckframe($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Frame_model->deletedata($delete_frameid);
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
