<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
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
        
        $this->load->model('Customer_model');
    }
	public function index()
	{
          $data['title']='Optical::Customers';
          $data['activecls']='customers';
          $var_array=array($this->session->office_id);
      $last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('customer')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
      $data['codeno']=$code;
          $content=$this->load->view('master/customers',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	 public function searchclient(){

      // Search term
      $searchTerm = $this->input->post('searchTerm');

      // Get users
      $response = $this->Customer_model->getUsers($searchTerm);

      echo json_encode($response);
   }
	public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Customer_model->ajax_call($param);
           echo json_encode($response);
    }
	private function fetch_data($code,$name,$gender,$mobile,$customer_alter_mobile,$email_id,$mrd,$address,$description,$resph1,$resph2,$resph3,$resph4,$recyl1,$recyl2,$recyl3,$recyl4,$reaxis1,$reaxis2,$reaxis3,$reaxis4,$reva1,$reva2,$reva3,$reva4,$material,$cr,$usage,$type,$ipd,$pdre,$le,$segment,$lle,$prestype,$status) 
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
            'alter_mobile'=>$customer_alter_mobile,
            'email_id'=>$email_id,
            'mrd'=>$mrd,
            'address'=>$address,
            'description'=>$description,
            'resph1'=>$resph1,
            'resph2'=>$resph2,
            'resph3'=>$resph3,
            'resph4'=>$resph4,
            'recyl1'=>$recyl1,
            'recyl2'=>$recyl2,
            'recyl3'=>$recyl3,
            'recyl4'=>$recyl4,
            'reaxis1'=>$reaxis1,
            'reaxis2'=>$reaxis2,
            'reaxis3'=>$reaxis3,
            'reaxis4'=>$reaxis4,
            'reva1'=>$reva1,
            'reva2'=>$reva2,
            'reva3'=>$reva3,
            'reva4'=>$reva4,
            'material'=>$material,
            'cr'=>$cr,
            'gst'=>$this->input->post('gst'),
            'usage'=>$usage,
            'type'=>$type,
            'ipd'=>$ipd,
            'pdre'=>$pdre,
            'le'=>$le,
            'segment'=>$segment,
            'lle'=>$lle,
            'prestype'=>$prestype,
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }
    public function savecustomer()
	{
		$host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[15]|numeric');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|min_length[1]|max_length[1]|numeric');
		//$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('customer_alter_mobile', 'Alter Mobile', 'trim|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('email_id', 'Email ID', 'trim|min_length[1]|max_length[30]|valid_email');
		$this->form_validation->set_rules('address', 'Address', 'trim|min_length[1]|max_length[60]');
		$this->form_validation->set_rules('description', 'Description', 'trim|min_length[1]|max_length[70]');
		$this->form_validation->set_rules('resph1', 'sph', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('resph2', 'sph', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('resph3', 'sph', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('resph4', 'sph', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('recyl1', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('recyl2', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('recyl3', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('recyl4', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reaxis1', 'axis', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reaxis2', 'axis', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reaxis3', 'axis', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reaxis4', 'axis', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reva1', 'v/a', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reva2', 'v/a', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reva3', 'v/a', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('reva4', 'v/a', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('material', 'material', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('cr', 'CR', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('usage', 'Usage', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('type', 'type', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('ipd', 'ipd', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('pdre', 'pdre', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('le', 'le', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('segment', 'segment', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('lle', 'le', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('prestype', 'type', 'trim|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('status', 'status', 'trim|min_length[1]|max_length[1]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$code=trim(htmlentities($this->input->post('code')));
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$gender=trim(htmlentities($this->input->post('gender')));
	    	$mobile=trim(htmlentities($this->input->post('mobile')));
	    	$customer_alter_mobile=trim(htmlentities($this->input->post('customer_alter_mobile')));
	    	$email_id=trim(htmlentities($this->input->post('email_id')));
	    	$mrd=trim(htmlentities($this->input->post('mrd')));
	    	$address=trim(htmlentities($this->input->post('address')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$resph1=trim(htmlentities($this->input->post('resph1')));
	    	$resph2=trim(htmlentities($this->input->post('resph2')));
	    	$resph3=trim(htmlentities($this->input->post('resph3')));
	    	$resph4=trim(htmlentities($this->input->post('resph4')));
	    	$recyl1=trim(htmlentities($this->input->post('recyl1')));
	    	$recyl2=trim(htmlentities($this->input->post('recyl2')));
	    	$recyl3=trim(htmlentities($this->input->post('recyl3')));
	    	$recyl4=trim(htmlentities($this->input->post('recyl4')));
	    	$reaxis1=trim(htmlentities($this->input->post('reaxis1')));
	    	$reaxis2=trim(htmlentities($this->input->post('reaxis2')));
	    	$reaxis3=trim(htmlentities($this->input->post('reaxis3')));
	    	$reaxis4=trim(htmlentities($this->input->post('reaxis4')));
	    	$reva1=trim(htmlentities($this->input->post('reva1')));
	    	$reva2=trim(htmlentities($this->input->post('reva2')));
	    	$reva3=trim(htmlentities($this->input->post('reva3')));
	    	$reva4=trim(htmlentities($this->input->post('reva4')));
	    	$material=trim(htmlentities($this->input->post('material')));
	    	$cr=trim(htmlentities($this->input->post('cr')));
	    	$usage=trim(htmlentities($this->input->post('usage')));
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$ipd=trim(htmlentities($this->input->post('ipd')));
	    	$pdre=trim(htmlentities($this->input->post('pdre')));
	    	$le=trim(htmlentities($this->input->post('le')));
	    	$segment=trim(htmlentities($this->input->post('segment')));
	    	$lle=trim(htmlentities($this->input->post('lle')));
	    	$prestype=trim(htmlentities($this->input->post('prestype')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($code,$name,$mobile,$this->session->userdata('office_id'));
	    	//$chk_duplication=$this->Customer_model->checkcustomer($var_array);
	    	// if($chk_duplication[0]['cnt']==0)
	    	// {
	    		$data=$this->fetch_data($code,$name,$gender,$mobile,$customer_alter_mobile,$email_id,$mrd,$address,$description,$resph1,$resph2,$resph3,$resph4,$recyl1,$recyl2,$recyl3,$recyl4,$reaxis1,$reaxis2,$reaxis3,$reaxis4,$reva1,$reva2,$reva3,$reva4,$material,$cr,$usage,$type,$ipd,$pdre,$le,$segment,$lle,$prestype,$status);
	    		$getresult=$this->Customer_model->savedata($data);
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
	    	// 	  $this->error='Code and Customer Name already Used';
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

	private function order_fetch_data($of_iopleft,$iop_right,$of_dominateye,$of_add_lft,$of_pd4,$of_pd3,$of_pd2,$of_pd1,$of_add_ryt,$resph1,$resph2,$resph3,$resph4,$recyl1,$recyl2,$recyl3,$recyl4,$reaxis1,$reaxis2,$reaxis3,$reaxis4,$reva1,$reva2,$reva3,$reva4) 
    {
       
        return array(
            'of_iopleft'=>$of_iopleft,
            'iop_right'=>$iop_right,
            'of_dominateye'=>$of_dominateye,
            'of_add_lft'=>$of_add_lft,
            'of_pd4'=>$of_pd4,
            'of_pd3'=>$of_pd3,
            'of_pd2'=>$of_pd2,
            'of_pd1'=>$of_pd1,
            'of_add_ryt'=>$of_add_ryt,
            'resph1'=>$resph1,
            'resph2'=>$resph2,
            'resph3'=>$resph3,
            'resph4'=>$resph4,
            'recyl1'=>$recyl1,
            'recyl2'=>$recyl2,
            'recyl3'=>$recyl3,
            'recyl4'=>$recyl4,
            'reaxis1'=>$reaxis1,
            'reaxis2'=>$reaxis2,
            'reaxis3'=>$reaxis3,
            'reaxis4'=>$reaxis4,
            'reva1'=>$reva1,
            'reva2'=>$reva2,
            'reva3'=>$reva3,
            'reva4'=>$reva4
           );
    }

	 public function orderformsave()
	{
		
		

		
	    	$of_customerid=trim(htmlentities($this->input->post('of_customerid')));
	    	$of_salesid=trim(htmlentities($this->input->post('of_salesid')));
	    	$of_iopleft=trim(htmlentities($this->input->post('of_iopleft')));
	    	$iop_right=trim(htmlentities($this->input->post('iop_right')));
	    	$of_dominateye=trim(htmlentities($this->input->post('of_dominateye')));
	    	$of_add_lft=trim(htmlentities($this->input->post('of_add_lft')));
	    	$of_pd4=trim(htmlentities($this->input->post('of_pd4')));
	    	$of_pd3=trim(htmlentities($this->input->post('of_pd3')));
	    	$of_pd2=trim(htmlentities($this->input->post('of_pd2')));
	    	$of_pd1=trim(htmlentities($this->input->post('of_pd1')));
	    	$of_add_ryt=trim(htmlentities($this->input->post('of_add_ryt')));
	    	$resph1=trim(htmlentities($this->input->post('of_resph1')));
	    	$resph2=trim(htmlentities($this->input->post('of_resph2')));
	    	$resph3=trim(htmlentities($this->input->post('of_resph3')));
	    	$resph4=trim(htmlentities($this->input->post('of_resph4')));
	    	$recyl1=trim(htmlentities($this->input->post('of_recyl1')));
	    	$recyl2=trim(htmlentities($this->input->post('of_recyl2')));
	    	$recyl3=trim(htmlentities($this->input->post('of_recyl3')));
	    	$recyl4=trim(htmlentities($this->input->post('of_recyl4')));
	    	$reaxis1=trim(htmlentities($this->input->post('of_reaxis1')));
	    	$reaxis2=trim(htmlentities($this->input->post('of_reaxis2')));
	    	$reaxis3=trim(htmlentities($this->input->post('of_reaxis3')));
	    	$reaxis4=trim(htmlentities($this->input->post('of_reaxis4')));
	    	$reva1=trim(htmlentities($this->input->post('of_reva1')));
	    	$reva2=trim(htmlentities($this->input->post('of_reva2')));
	    	$reva3=trim(htmlentities($this->input->post('of_reva3')));
	    	$reva4=trim(htmlentities($this->input->post('of_reva4')));
	    	$data=$this->order_fetch_data($of_iopleft,$iop_right,$of_dominateye,$of_add_lft,$of_pd4,$of_pd3,$of_pd2,$of_pd1,$of_add_ryt,$resph1,$resph2,$resph3,$resph4,$recyl1,$recyl2,$recyl3,$recyl4,$reaxis1,$reaxis2,$reaxis3,$reaxis4,$reva1,$reva2,$reva3,$reva4);
	    		$getresult=$this->Customer_model->updatedata($data,$of_customerid);
	    		if($getresult)
	    		{
	    			if($of_salesid>0)
	    			{
	    				$getresult_OF=$this->Customer_model->Get_order_form($of_salesid);
	    				
	    					$cntcn=$getresult_OF[0]['cnt'];
	    					if($cntcn==0)
	    					{
	    						$last_invoice_number=$this->db->select('max(order_number) as last_invoice_number')
		                         ->from('sales_master')
		                         ->where(array('1'=>1))
		                         ->get()->row()->last_invoice_number;
		           				 if($last_invoice_number>0){$invoice_number=$last_invoice_number;} else { $invoice_number= 1;}
								 $curdate=date('Y-m-d');
								 $ortime=date('H:i:s');
			    				$sql = "update sales_master set order_form_flag=1,order_number=$invoice_number+1,order_form_date='$curdate',order_time='$ortime' where    sales_id=$of_salesid";
		    					$result_row=$this->db->query($sql); 

		    					$sql = "update sales_master_history set order_form_flag=1,order_number=$invoice_number+1,order_form_date='$curdate',order_time='$ortime' where    sales_id=$of_salesid";
		    					$result_row=$this->db->query($sql); 
	    					}
	    				

	    				
	    			}
	    			

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

	public function editcustomer()
	{
		$this->form_validation->set_rules('edit_customerid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_code', 'Code', 'trim|required|min_length[1]|max_length[15]|numeric');
		$this->form_validation->set_rules('edit_mrd', 'MRD NO', 'trim|required|min_length[1]|max_length[15]');
        $this->form_validation->set_rules('edit_name', 'Name', 'trim|required|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_gender', 'Gender', 'trim|required|min_length[1]|max_length[1]|numeric');
        $this->form_validation->set_rules('edit_mobile', 'Mobile', 'trim|required|min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('edit_customer_alter_mobile', 'Alter Mobile', 'trim|min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('edit_email_id', 'Email ID', 'trim|min_length[1]|max_length[30]|valid_email');
        $this->form_validation->set_rules('edit_address', 'Address', 'trim|min_length[1]|max_length[60]');
        $this->form_validation->set_rules('edit_description', 'Description', 'trim|min_length[1]|max_length[70]');
        $this->form_validation->set_rules('edit_resph1', 'sph', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_resph2', 'sph', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_resph3', 'sph', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_resph4', 'sph', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_recyl1', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('edit_recyl2', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('edit_recyl3', 'cyl', 'trim|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('edit_recyl4', 'cyl', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reaxis1', 'axis', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reaxis2', 'axis', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reaxis3', 'axis', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reaxis4', 'axis', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reva1', 'v/a', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reva2', 'v/a', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reva3', 'v/a', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_reva4', 'v/a', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_material', 'material', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_cr', 'CR', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_usage', 'Usage', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_type', 'type', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_ipd', 'ipd', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_pdre', 'pdre', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_le', 'le', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_segment', 'segment', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_lle', 'le', 'trim|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('edit_prestype', 'type', 'trim|min_length[1]|max_length[1]|numeric');
        $this->form_validation->set_rules('edit_status', 'status', 'trim|min_length[1]|max_length[1]|numeric');
        if($this->form_validation->run() == TRUE)
        {
            $edit_customerid=trim(htmlentities($this->input->post('edit_customerid')));
            $code=trim(htmlentities($this->input->post('edit_code')));
            $name=trim(htmlentities($this->input->post('edit_name')));
            $gender=trim(htmlentities($this->input->post('edit_gender')));
            $mobile=trim(htmlentities($this->input->post('edit_mobile')));
            $customer_alter_mobile=trim(htmlentities($this->input->post('edit_customer_alter_mobile')));
            $email_id=trim(htmlentities($this->input->post('edit_email_id')));
            $mrd=trim(htmlentities($this->input->post('edit_mrd')));
            $address=trim(htmlentities($this->input->post('edit_address')));
            $description=trim(htmlentities($this->input->post('edit_description')));
            $resph1=trim(htmlentities($this->input->post('edit_resph1')));
            $resph2=trim(htmlentities($this->input->post('edit_resph2')));
            $resph3=trim(htmlentities($this->input->post('edit_resph3')));
            $resph4=trim(htmlentities($this->input->post('edit_resph4')));
            $recyl1=trim(htmlentities($this->input->post('edit_recyl1')));
	    	$recyl2=trim(htmlentities($this->input->post('edit_recyl2')));
	    	$recyl3=trim(htmlentities($this->input->post('edit_recyl3')));
	    	$recyl4=trim(htmlentities($this->input->post('edit_recyl4')));
            $reaxis1=trim(htmlentities($this->input->post('edit_reaxis1')));
            $reaxis2=trim(htmlentities($this->input->post('edit_reaxis2')));
            $reaxis3=trim(htmlentities($this->input->post('edit_reaxis3')));
            $reaxis4=trim(htmlentities($this->input->post('edit_reaxis4')));
            $reva1=trim(htmlentities($this->input->post('edit_reva1')));
            $reva2=trim(htmlentities($this->input->post('edit_reva2')));
            $reva3=trim(htmlentities($this->input->post('edit_reva3')));
            $reva4=trim(htmlentities($this->input->post('edit_reva4')));
            $material=trim(htmlentities($this->input->post('edit_material')));
            $cr=trim(htmlentities($this->input->post('edit_cr')));
            $usage=trim(htmlentities($this->input->post('edit_usage')));
            $type=trim(htmlentities($this->input->post('edit_type')));
            $ipd=trim(htmlentities($this->input->post('edit_ipd')));
            $pdre=trim(htmlentities($this->input->post('edit_pdre')));
            $le=trim(htmlentities($this->input->post('edit_le')));
            $segment=trim(htmlentities($this->input->post('edit_segment')));
            $lle=trim(htmlentities($this->input->post('edit_lle')));
            $prestype=trim(htmlentities($this->input->post('edit_prestype')));
            $status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_customerid,$code,$name,$mobile,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Customer_model->editcheckcustomer($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$gender,$mobile,$customer_alter_mobile,$email_id,$mrd,$address,$description,$resph1,$resph2,$resph3,$resph4,$recyl1,$recyl2,$recyl3,$recyl4,$reaxis1,$reaxis2,$reaxis3,$reaxis4,$reva1,$reva2,$reva3,$reva4,$material,$cr,$usage,$type,$ipd,$pdre,$le,$segment,$lle,$prestype,$status);
	    		$getresult=$this->Customer_model->updatedata($data,$edit_customerid);
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

	public function deletecustomer()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_customerid=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($delete_customerid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Customer_model->deletecheckcustomer($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Customer_model->deletedata($delete_customerid);
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

	public function getsavedata()
	{
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$getid=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($getid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Customer_model->deletecheckcustomer($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Customer_model->GetData($var_array);
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

	public function getorderform_cus_data()
	{
		$orderf='';
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$sales_id=trim(htmlentities($this->input->post('sales_id')));
	    	$getid=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($getid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Customer_model->deletecheckcustomer($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Customer_model->GetData($var_array);
	    		if($getresult)
	    		{
	    			if($sales_id>0)
	    			{
	    				$getresult_OF=$this->Customer_model->Get_order_form($sales_id);
	    				if($getresult_OF)
	    				{
	    					$cntcn=$getresult_OF[0]['cnt'];
	    					if($cntcn==1)
	    					{
	    						$orderf='<div class="col-md-12">
                                     <button onclick="printcustomer_orderform('.$sales_id.')" style="float:right;" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>
                                 </div>';
	    					}
	    				}
	    			}
		    		  $this->msg='success';
		    		  $this->error='';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'orderf'         => $orderf,
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
	    		  $this->error='Customer ID Not Found';
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

	public function printcustomer() 
  {
      $this->Customer_model->print_bill($this->input->post('data_generatebill'),$this->session->userdata('office_id'));
  }

}
