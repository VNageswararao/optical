<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_master extends CI_Controller {
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
        
        $this->load->model('Item_model');
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Item_model->ajax_call($param);
           echo json_encode($response);
    }
	public function index()
	{
          $data['title']='Optical::Item Master';
          $data['activecls']='item_master';
          $var_array=array($this->session->office_id);
          $last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('item_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
          $data['codeno']=$code;
          $data['category']=$this->Item_model->getcategory($var_array);
		  $data['hsncode'] = $this->Item_model->gethsncode($var_array);
          $data['brand']=$this->Item_model->getbrand($var_array);
          $data['company']=$this->Item_model->getcompany($var_array);
          $data['tax']=$this->Item_model->gettax($var_array);
          //print_r($data);exit;
          $content=$this->load->view('master/item_master',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	private function fetch_data($code,$name,$category_id,$brand_id,$company_id,$hsn_code,$gst_type,$tax,$cgst,$sgst,$description,$status) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'code'=>$code,
            'name'=>$name,
            'category_id'=>$category_id,
            'brand_id'=>$brand_id,
            'company_id'=>$company_id,
            'hsn_code'=>$hsn_code,
            'gst_type'=>$gst_type,
			'hsn_master_id' => $this->input->post('hsn_master_id'),
            'tax'=>$tax,
            'cgst'=>$cgst,
            'sgst'=>$sgst,
            'description'=>$description,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }
    public function saveitem()
	{
		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[15]|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[250]');
		$this->form_validation->set_rules('category_id', 'category', 'trim|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('company_id', 'Company Name', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('hsn_code', 'HSN code', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('gst_type', 'Gst type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('tax', 'tax', 'trim|min_length[1]|max_length[2]|numeric');
		$this->form_validation->set_rules('cgst', 'cgst', 'trim|min_length[1]|max_length[3]|numeric');
		$this->form_validation->set_rules('sgst', 'sgst', 'trim|min_length[1]|max_length[3]|numeric');
		$this->form_validation->set_rules('description', 'Description', 'trim|min_length[1]|max_length[1000]');
		$this->form_validation->set_rules('status', 'status', 'trim|min_length[1]|max_length[1]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$code=trim(htmlentities($this->input->post('code')));
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$category_id=trim(htmlentities($this->input->post('category_id')));
	    	$brand_id=trim(htmlentities($this->input->post('brand_id')));
	    	$company_id=trim(htmlentities($this->input->post('company_id')));
	    	$hsn_code=trim(htmlentities($this->input->post('hsn_code')));
	    	$gst_type=trim(htmlentities($this->input->post('gst_type')));
	    	$tax=trim(htmlentities($this->input->post('tax')));
	    	$cgst=trim(htmlentities($this->input->post('cgst')));
	    	$sgst=trim(htmlentities($this->input->post('sgst')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Item_model->checkitem($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    	$data=$this->fetch_data($code,$name,$category_id,$brand_id,$company_id,$hsn_code,$gst_type,$tax,$cgst,$sgst,$description,$status);
	    	$getresult=$this->Item_model->savedata($data);
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
	    		  $this->error='Code and Item  Name  already Used';
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

	public function getsavedata()
	{
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$getid=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($getid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Item_model->deletecheckitem($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Item_model->GetData($var_array);
			//	print_r($getresult);
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

	public function gettaxdetails()
	{
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$getid=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($getid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Item_model->gettaxid($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		$getresult=$this->Item_model->gettaxdata($var_array);
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

	public function edititem()
	{
	    $this->form_validation->set_rules('edit_itemid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    $this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[15]|numeric');
        $this->form_validation->set_rules('edit_name', 'Name', 'trim|required|min_length[1]|max_length[250]');
        $this->form_validation->set_rules('edit_category_id', 'category', 'trim|min_length[1]|max_length[1000]|numeric');
        $this->form_validation->set_rules('edit_brand_id', 'Brand', 'trim|min_length[1]|max_length[1000]|numeric');
        $this->form_validation->set_rules('edit_company_id', 'Company Name', 'trim|required|min_length[1]|max_length[1000]|numeric');
        $this->form_validation->set_rules('edit_hsn_code', 'HSN code', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_gst_type', 'Gst type', 'trim|required|min_length[1]|max_length[1]|numeric');
        $this->form_validation->set_rules('edit_tax', 'tax', 'trim|min_length[1]|max_length[2]|numeric');
        $this->form_validation->set_rules('edit_cgst', 'cgst', 'trim|min_length[1]|max_length[3]|numeric');
        $this->form_validation->set_rules('edit_sgst', 'sgst', 'trim|min_length[1]|max_length[3]|numeric');
        $this->form_validation->set_rules('edit_description', 'Description', 'trim|min_length[1]|max_length[1000]');
        $this->form_validation->set_rules('edit_status', 'status', 'trim|min_length[1]|max_length[1]|numeric');
      if($this->form_validation->run() == TRUE)
      {
	        $edit_itemid=trim(htmlentities($this->input->post('edit_itemid')));
	        $code=trim(htmlentities($this->input->post('edit_code')));
            $name=trim(htmlentities($this->input->post('edit_name')));
            $category_id=trim(htmlentities($this->input->post('edit_category_id')));
            $brand_id=trim(htmlentities($this->input->post('edit_brand_id')));
            $company_id=trim(htmlentities($this->input->post('edit_company_id')));
            $hsn_code=trim(htmlentities($this->input->post('edit_hsn_code')));
            $tax=trim(htmlentities($this->input->post('edit_tax')));
            $gst_type=trim(htmlentities($this->input->post('edit_gst_type')));
            $cgst=trim(htmlentities($this->input->post('edit_cgst')));
            $sgst=trim(htmlentities($this->input->post('edit_sgst')));
            $description=trim(htmlentities($this->input->post('edit_description')));
            $status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_itemid,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Item_model->editcheckitem_master($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    	$data=$this->fetch_data($code,$name,$category_id,$brand_id,$company_id,$hsn_code,$gst_type,$tax,$cgst,$sgst,$description,$status);
	    		$getresult=$this->Item_model->updatedata($data,$edit_itemid);
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

	public function deleteitem_master()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_itemid=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($delete_itemid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Item_model->deletecheckitem($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Item_model->deletedata($delete_itemid);
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
	
	public function gethsncodeval()
	{
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		if ($this->form_validation->run() == TRUE) {
			$getid = trim(htmlentities($this->input->post('getid')));
			$var_array = array($getid, $this->session->userdata('office_id'));
			$chk_duplication = $this->Item_model->gethsncode1($var_array);
			if ($chk_duplication[0]['cnt'] == 1) {
				$getresult = $this->Item_model->gethsncodedata($var_array);
				if ($getresult) {
					$this->msg = 'success';
					$this->error = '';
					$this->error_message = '';
					echo json_encode(array(
						'msg'           => $this->msg,
						'error'         => $this->error,
						'error_message' => $this->error_message,
						'getdata' => $getresult
					));
					exit;
				} else {
					$this->msg = '';
					$this->error = 'Failed to get data';
					$this->error_message = '';
					echo json_encode(array(
						'msg'           => $this->msg,
						'error'         => $this->error,
						'error_message' => $this->error_message
					));
					exit;
				}
			} else {
				$this->msg = '';
				$this->error = 'HSN ID Not Found';
				$this->error_message = '';
				echo json_encode(array(
					'msg'           => $this->msg,
					'error'         => $this->error,
					'error_message' => $this->error_message
				));
				exit;
			}
		} else {
			$this->msg = '';
			$this->error = '';
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
