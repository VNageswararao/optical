<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller {
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
        
        $this->load->model('Tax_model');
    }
	public function index()
	{
          $data['title']='Optical::Tax Master';
          $data['activecls']='Tax';
          $content=$this->load->view('master/tax',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	 public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Tax_model->ajax_call($param);
           echo json_encode($response);
    }
    public function savetaxmaster()
	{
		$this->form_validation->set_rules('name', 'Tax', 'trim|required|min_length[1]|max_length[2]|numeric');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Tax_model->checktax($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($name,$description,$status);
	    		$getresult=$this->Tax_model->savedata($data);
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
	    		  $this->error='Tax already Used';
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

	private function fetch_data($name,$description,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'name'=>$name,
            'description'=>$description,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }

    public function edittax()
	{
		$this->form_validation->set_rules('edit_taxid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_name', 'Name', 'trim|required|min_length[1]|max_length[2]|numeric');
    	$this->form_validation->set_rules('edit_description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_taxid=trim(htmlentities($this->input->post('edit_taxid')));
	    	$name=trim(htmlentities($this->input->post('edit_name')));
	    	$description=trim(htmlentities($this->input->post('edit_description')));
	    	$status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_taxid,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Tax_model->editchecktax($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($name,$description,$status);
	    		$getresult=$this->Tax_model->updatedata($data,$edit_taxid);
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
	    		  $this->error='Tax already Used';
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

	public function deletetax()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_taxid=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($delete_taxid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Tax_model->deletechktax($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Tax_model->deletedata($delete_taxid);
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
