<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
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
        
        $this->load->model('Company_model');
    }
	public function index()
	{
          $data['title']='Optical::Company';
          $data['activecls']='company';
          $last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('company')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
          $data['codeno']=$code;
          $content=$this->load->view('master/company',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Company_model->ajax_call($param);
           echo json_encode($response);
    }
    private function fetch_data($code,$name,$description,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'code'=>$code,
            'name'=>$name,
            'description'=>$description,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }

    public function savecompany()
	{
		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$code=trim(htmlentities($this->input->post('code')));
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Company_model->checkcompany($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$description,$status);
	    		$getresult=$this->Company_model->savedata($data);
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

	public function editcompany()
	{
		$this->form_validation->set_rules('edit_companyid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('edit_name', 'Name', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('edit_description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_companyid=trim(htmlentities($this->input->post('edit_companyid')));
	    	$code=trim(htmlentities($this->input->post('edit_code')));
	    	$name=trim(htmlentities($this->input->post('edit_name')));
	    	$description=trim(htmlentities($this->input->post('edit_description')));
	    	$status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_companyid,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Company_model->editcheckcompany($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$description,$status);
	    		$getresult=$this->Company_model->updatedata($data,$edit_companyid);
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

	public function deletecompany()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_companyid=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($delete_companyid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Company_model->deletecheckcompany($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Company_model->deletedata($delete_companyid);
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
