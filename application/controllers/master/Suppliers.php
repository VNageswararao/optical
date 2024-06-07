<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {
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
        
        $this->load->model('Supplier_model');
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Supplier_model->ajax_call($param);
           echo json_encode($response);
    }
	public function index()
	{
          $data['title']='Optical::Suppliers';
          $data['activecls']='suppliers';
          $var_array=array($this->session->office_id);
          $data['category']=$this->Supplier_model->getcategory($var_array);
          $content=$this->load->view('master/suppliers',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	private function fetch_data($code,$name,$gender,$mobile,$alter_mobile,$email_id,$address,$description,$contact_person_name,$contact_person_mobile,$gstin_type,$gst_no,$category_id,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'code'=>$code,
            'name'=>$name,
            'gender'=>$gender,
            'mobile'=>$mobile,
            'alter_mobile'=>$alter_mobile,
            'email_id'=>$email_id,
            'address'=>$address,
            'description'=>$description,
            'contact_person_name'=>$contact_person_name,
            'contact_person_mobile'=>$contact_person_mobile,
            'gstin_type'=>$gstin_type,
            'gst_no'=>$gst_no,
            'category_id'=>$category_id,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }
	public function savesupplier()
	{
		//$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[15]|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('alter_mobile', 'Alter Mobile', 'trim|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('email_id', 'Email ID', 'trim|min_length[1]|max_length[130]');
		$this->form_validation->set_rules('contact_person_name', 'Contact person name', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('contact_person_mobile', 'Contact Person Mobile', 'trim|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('address', 'Address', 'trim|min_length[1]|max_length[60]');
		$this->form_validation->set_rules('description', 'Description', 'trim|min_length[1]|max_length[70]');
		$this->form_validation->set_rules('gstin_type', 'gst type', 'trim|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('gst_no', 'gst no', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('category_id', 'category', 'trim|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('status', 'status', 'trim|min_length[1]|max_length[1]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('supplier')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }


	    	$code=$code;
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$gender=trim(htmlentities($this->input->post('gender')));
	    	$mobile=trim(htmlentities($this->input->post('mobile')));
	    	$alter_mobile=trim(htmlentities($this->input->post('alter_mobile')));
	    	$email_id=trim(htmlentities($this->input->post('email_id')));
	    	$address=trim(htmlentities($this->input->post('address')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$contact_person_name=trim(htmlentities($this->input->post('contact_person_name')));
	    	$contact_person_mobile=trim(htmlentities($this->input->post('contact_person_mobile')));
	    	$gstin_type=trim(htmlentities($this->input->post('gstin_type')));
	    	$gst_no=trim(htmlentities($this->input->post('gst_no')));
	    	$category_id=trim(htmlentities($this->input->post('category_id')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($code,$name,$mobile,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Supplier_model->checksupplier($var_array);
	    	// if($chk_duplication[0]['cnt']==0)
	    	// {
	    		$data=$this->fetch_data($code,$name,$gender,$mobile,$alter_mobile,$email_id,$address,$description,$contact_person_name,$contact_person_mobile,$gstin_type,$gst_no,$category_id,$status);
	    		$getresult=$this->Supplier_model->savedata($data);
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
	    	// }
	    	// else
	    	// {
	    	// 	$this->msg='';
	    	// 	  $this->error='Code and Supplier Name already Used';
	    	// 	  $this->error_message ='';
	     //          echo json_encode(array(
			   //      'msg'           => $this->msg,
			   //      'error'         => $this->error,
			   //      'error_message' => $this->error_message
			   //    ));
	     //        exit;
	    	// }
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

	public function getsavedata()
	{
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$getid=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($getid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Supplier_model->deletechecksupplier($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Supplier_model->GetData($var_array);
	    		if($getresult)
	    		{
		    		  $this->msg='success';
		    		  $this->error='';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message,
					        'getdata' => $getresult
					      ));
			            exit;
	    		}
	    		else
	    		{
	    			  $this->msg='';
		    		  $this->error='Failed to get data';
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
	    		  $this->error='Edit ID Not Found';
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

	public function editsupplier()
	{
	$this->form_validation->set_rules('edit_supplierid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	$this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[15]|numeric');
    $this->form_validation->set_rules('edit_name', 'Name', 'trim|required|min_length[1]|max_length[30]');
    $this->form_validation->set_rules('edit_gender', 'Gender', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('edit_mobile', 'Mobile', 'trim|required|min_length[10]|max_length[15]|numeric');
    $this->form_validation->set_rules('edit_alter_mobile', 'Alter Mobile', 'trim|min_length[10]|max_length[15]|numeric');
    $this->form_validation->set_rules('edit_email_id', 'Email ID', 'trim|min_length[1]|max_length[130]');
    $this->form_validation->set_rules('edit_contact_person_name', 'Contact person name', 'trim|min_length[1]|max_length[30]');
    $this->form_validation->set_rules('edit_contact_person_mobile', 'Contact Person Mobile', 'trim|min_length[10]|max_length[15]|numeric');
    $this->form_validation->set_rules('edit_address', 'Address', 'trim|min_length[1]|max_length[60]');
    $this->form_validation->set_rules('edit_description', 'Description', 'trim|min_length[1]|max_length[70]');
    $this->form_validation->set_rules('edit_gstin_type', 'gst type', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('edit_gst_no', 'gst no', 'trim|min_length[1]|max_length[30]');
    $this->form_validation->set_rules('edit_category_id', 'category', 'trim|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('edit_status', 'status', 'trim|min_length[1]|max_length[1]|numeric');
      if($this->form_validation->run() == TRUE)
      {
	        $edit_supplierid=trim(htmlentities($this->input->post('edit_supplierid')));
	        $code=trim(htmlentities($this->input->post('edit_code')));
	        $name=trim(htmlentities($this->input->post('edit_name')));
	        $gender=trim(htmlentities($this->input->post('edit_gender')));
	        $mobile=trim(htmlentities($this->input->post('edit_mobile')));
	        $alter_mobile=trim(htmlentities($this->input->post('edit_alter_mobile')));
	        $email_id=trim(htmlentities($this->input->post('edit_email_id')));
	        $address=trim(htmlentities($this->input->post('edit_address')));
	        $description=trim(htmlentities($this->input->post('edit_description')));
	        $contact_person_name=trim(htmlentities($this->input->post('edit_contact_person_name')));
	        $contact_person_mobile=trim(htmlentities($this->input->post('edit_contact_person_mobile')));
	        $gstin_type=trim(htmlentities($this->input->post('edit_gstin_type')));
	        $gst_no=trim(htmlentities($this->input->post('edit_gst_no')));
	        $category_id=trim(htmlentities($this->input->post('edit_category_id')));
	        $status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_supplierid,$code,$name,$mobile,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Supplier_model->editchecksupplier($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$gender,$mobile,$alter_mobile,$email_id,$address,$description,$contact_person_name,$contact_person_mobile,$gstin_type,$gst_no,$category_id,$status);
	    		$getresult=$this->Supplier_model->updatedata($data,$edit_supplierid);
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

	public function deletesupplier()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_customerid=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($delete_customerid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Supplier_model->deletechecksupplier($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Supplier_model->deletedata($delete_customerid);
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
