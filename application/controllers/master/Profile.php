<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
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
        
        $this->load->model('Profile_model');
    }
	public function index()
	{
          $data['title']='Optical::Profile';
          $data['activecls']='Profile';
          $var_array=array($this->session->userdata('office_id'));
          $data['getofficedata']=$this->Profile_model->getprofile($var_array);
          $content=$this->load->view('master/profile',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	public function saveprofile()
	{
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('license_no', 'License No', 'trim|min_length[1]|max_length[40]');
		$this->form_validation->set_rules('company_mobile', 'Company Mobile', 'trim|required|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('company_phone', 'Company Phone', 'trim|min_length[10]|max_length[20]|numeric');
		$this->form_validation->set_rules('email_id', 'Email ID', 'trim|min_length[1]|max_length[100]|valid_email');
		$this->form_validation->set_rules('address', 'Address', 'trim|min_length[1]|max_length[600]');
		$this->form_validation->set_rules('printable_company_name', 'Printable Company Name', 'trim|required|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('printable_company_phone', 'Printable Company Phone', 'trim|required|min_length[10]|max_length[20]|numeric');
		$this->form_validation->set_rules('printable_company_mobile', 'Printable Company Mobile', 'trim|required|min_length[10]|max_length[15]|numeric');
		$this->form_validation->set_rules('printable_emailid', 'Printable Email ID', 'trim|required|min_length[1]|max_length[38]|valid_email');
		$this->form_validation->set_rules('printable_company_address', 'Printable Company Address', 'trim');
		$this->form_validation->set_rules('logo','Profile Logo','callback_file_check');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$billprint_gst=trim(htmlentities($this->input->post('billprint_gst')));
	    	$company_name=trim(htmlentities($this->input->post('company_name')));
	    	$license_no=trim(htmlentities($this->input->post('license_no')));
	    	$company_mobile=trim(htmlentities($this->input->post('company_mobile')));
	    	$company_phone=trim(htmlentities($this->input->post('company_phone')));
	    	$email_id=trim(htmlentities($this->input->post('email_id')));
	    	$address=trim(htmlentities($this->input->post('address')));
	    	$gstin_no=trim(htmlentities($this->input->post('gstin_no')));
	    	$printable_company_name=trim(htmlentities($this->input->post('printable_company_name')));
	    	$printable_company_phone=trim(htmlentities($this->input->post('printable_company_phone')));
	    	$printable_company_mobile=trim(htmlentities($this->input->post('printable_company_mobile')));
	    	$printable_emailid=trim(htmlentities($this->input->post('printable_emailid')));
	    	$printable_company_address=trim(htmlentities($this->input->post('printable_company_address')));
	    	$declaration=trim(htmlentities($this->input->post('declaration')));

	    	$var_array=array($this->session->userdata('office_id'));
	    	$chk_duplication=$this->Profile_model->checkprofile($var_array);
	    	$data=$this->fetch_data($company_name,$license_no,$company_mobile,$company_phone,$email_id,$address,$printable_company_name,$printable_company_phone,$printable_company_mobile,$printable_emailid,$printable_company_address,$declaration,$gstin_no,$billprint_gst);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$getresult=$this->Profile_model->savedata($data);
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
	    		$getresult=$this->Profile_model->updatedata($data,$this->session->userdata('office_id'));
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

	private function fetch_data($company_name,$license_no,$company_mobile,$company_phone,$email_id,$address,$printable_company_name,$printable_company_phone,$printable_company_mobile,$printable_emailid,$printable_company_address,$declaration,$gstin_no,$billprint_gst) 
    {
if($this->input->post('fin_year_settings')==2 || $this->input->post('fin_year_settings')==0)
{
	$fin_year='';
	$starting_bill_no='';
}
else
{
	$fin_year=$this->input->post('fin_year');
	$starting_bill_no=$this->input->post('starting_bill_no');
}
        $office_id=$this->session->office_id;
        return array(
            'company_name'=>$company_name,
            'license_no'=>$license_no,
            'company_mobile'=>$company_mobile,
            'company_phone'=>$company_phone,
            'email_id'=>$email_id,
            'address'=>$address,
            'registered_name'=>$this->input->post('registered_name'),
            'printable_company_code'=>$this->input->post('printable_company_code'),
            'printable_company_name'=>$printable_company_name,
            'printable_company_phone'=>$printable_company_phone,
            'printable_company_mobile'=>$printable_company_mobile,
            'printable_emailid'=>$printable_emailid,
            'declaration'=>$declaration,
            'gstin_no'=>$gstin_no,
            'billprint_gst'=>$billprint_gst,
            'printable_company_address'=>$printable_company_address,
            'logo'=>$this->session->flashdata('profile_pic'),
            'login_id'=>$this->session->userdata('login_id'),
            'fin_year' => $fin_year,
		     'fin_year_settings' => $this->input->post('fin_year_settings'),
		     'starting_bill_no' => $starting_bill_no
           );
    }
    private function removeupdate() 
    {
        return array(
            'logo'=>'',
            'login_id'=>$this->session->userdata('login_id')
           );
    }
    public function file_check($parameter){
        
         if(isset($_FILES['logo']['name']))
         {
        $str=$_FILES['logo']['name'];
        $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png');
        $mime = get_mime_by_extension($str);
        if(isset($str) && $str!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                
                return $this->upload();
            }else{
                $this->form_validation->set_message('file_check', 'Please select only jpeg/jpg/png file.');
                return false;
            }
        }else{
            if($this->input->post('profile_pic'))
            {
                $this->session->set_flashdata('profile_pic',$this->input->post('profile_pic'));
                return true;
            }
             $this->session->set_flashdata('profile_pic','temp.jpg');
             return true;
        }
         }  else {
             $this->session->set_flashdata('profile_pic','temp.jpg');
             return true;
         }
    }
    private function upload() {
		$host_tvm = 'optical';
        $config['upload_path']   = 'images/profile/'; 
        $config['allowed_types'] = 'jpg|png|jpeg'; 
        $config['max_size']      = 2000; 
        $config['file_name']  = $host_tvm;
        // $config['max_width']     = 1024; 
        // $config['max_height']    = 768;  
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload('logo')) {
            //$this->session->set_flashdata('msg',"Image Upload Failed");
           // return $error = array('error' => $this->upload->display_errors()); 
            $this->form_validation->set_message('file_check', $this->upload->display_errors());
            return false;
           }

        else { 
            
              $this->session->set_flashdata('profile_pic',$this->upload->data('file_name'));
            //return $data = $this->upload->data('file_name'); 
            //$this->load->view('upload_success', $data); 
            return TRUE;
}
}

public function removelogo()
	{
		$this->form_validation->set_rules('id', 'Remove Logo', 'trim|required|min_length[1]|max_length[100]');
		
	    if($this->form_validation->run() == TRUE)
	    {
	    	$id=trim(htmlentities($this->input->post('id')));
	    	$var_array=array($this->session->userdata('office_id'));
	    	if($id==$this->session->userdata('office_id')){
	    	$chk_duplication=$this->Profile_model->checkprofile($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$data=$this->removeupdate();
	    		$getresult=$this->Profile_model->removelogo($data,$id);
	    		if($getresult)
	    		{
		    		  $this->msg='Removed Logo Successfully';
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
		    		  $this->error='Failed to Remove Logo';
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
	    		  $this->error_message = 'Removed ID Not Found.please refresh page';
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
	    		  $this->error_message = 'Removed ID Not Found.please refresh page';
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
