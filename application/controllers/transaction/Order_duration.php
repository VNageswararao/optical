<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_duration extends CI_Controller {
  private $msg;
  private $error;
  private $error_message;
  private $randval;
  private $er;
  public function __construct() {
        parent::__construct();
        if (!isset($this->session->optical_login))
         {
          redirect('login');
         }
        
         $this->load->model('Order_duration_model');
		 $this->load->model('Common_model');
       
    }
  public function index()
  {
    $data['title']='Optical::Order Duration';
    $data['activecls']='Order_duration';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
    $data['getcustomer']=$this->Common_model->getcustomerdata($var_array);
    $data['getitem']=$this->Common_model->getitemdata($var_array);
    $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
    $data['getcategory']=$this->Common_model->getcategory($var_array);
    $data['getlens']=$this->Common_model->getlensmaster($var_array);
    $data['getstaff']=$this->Common_model->GetStaffData($var_array);
    $data['getsupp']=$this->Common_model->getsupplierdataval($var_array);
    $content=$this->load->view('transaction/Order_duration/insert',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }
  
	public function fore_month_data(){
           $param=$_REQUEST;
           $page="Four_month";

           $response=$this->Order_duration_model->ajax_call($param,$page);
           echo json_encode($response);
    }
	public function eight_month_data(){
           $param=$_REQUEST;
           $page="eight_month";

           $response1=$this->Order_duration_model->ajax_call($param,$page);
           echo json_encode($response1);
    }
	public function twelve_months_data(){
           $param=$_REQUEST;
           $page="twelve_months";

           $response2=$this->Order_duration_model->ajax_call($param,$page);
           echo json_encode($response2);
    }

}
