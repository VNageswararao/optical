<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_tracking extends CI_Controller {
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
        
         $this->load->model('Common_model');
         $this->load->model('Sales_models');
       
    }
  public function index()
  {
    $data['title']='Optical::Order Tracking';
    $data['activecls']='Order_tracking';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
	$data['getcustomersales']=$this->Sales_models->getcustomersalesdata($var_array);

    $content=$this->load->view('transaction/Order_tracking/insert',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }

  
public function tracking()   // summary 
  {
	  
	  $this->form_validation->set_rules('getid', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric');
      if($this->form_validation->run() == TRUE)
      {
		$sales_id=trim(htmlentities($this->input->post('getid')));
        $var_array=array($sales_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
		  $getresult=$this->Sales_models->Getcustomerdataindsales($var_array);
          $getpaidamount=$this->Sales_models->getpaidamount($var_array);
          $getstatus=$this->Sales_models->Getmastertable($var_array);
			//print_r($getstatus[0]['status']);exit;
			 $headersection.=' <div class="col-12 fw-bold col-md-10 hh-grayBox pt45 pb20">
									<h3 style="font-weight: bold;">Invoice Number :  '.$getstatus[0]['invoice_number'].'</h3>
									</div>';
									
			if($getstatus[0]['status']==1){
				 
				  
				  $headersection.=' 
								<div class="col-12 col-md-10 hh-grayBox pt45 pb20">
									<div class="row justify-content-between">
										<div class="order-tracking completed">
											<span class="is-complete"></span>
											<p>Inprogress Sales Date<br><span>'.$getstatus[0]['sales_date'].'</span></p>
										</div>
										
										<div class="order-tracking">
											<span class="is-complete"></span>
											<p>Sent to Fitting</p>
										</div>
										
										<div class="order-tracking ">
											<span class="is-complete"></span>
											<p>Ready<br></p>
										</div>
										
										<div class="order-tracking">
											<span class="is-complete"></span>
											<p>Expected Del Date<br><span>'.$getstatus[0]['expected_del_date'].'</span></p>
										</div>
									</div>
								</div>';
			}
			 elseif ($getstatus[0]['status']==4) {
				 
				  
				  $headersection.=' 
								<div class="col-12 col-md-10 hh-grayBox pt45 pb20">
									<div class="row justify-content-between">
										<div class="order-tracking completed">
											<span class="is-complete"></span>
											<p>Inprogress Sales Date<br><span>'.$getstatus[0]['sales_date'].'</span></p>
										</div>
										
										<div class="order-tracking completed">
											<span class="is-complete"></span>
											<p>Sent to Fitting<br><span>'.$getstatus[0]['stf_date'].'</span></p>
										</div>
										
										<div class="order-tracking ">
											<span class="is-complete"></span>
											<p>Ready<br></p>
										</div>
										
										<div class="order-tracking">
											<span class="is-complete"></span>
											<p>Expected Del Date<br><span>'.$getstatus[0]['expected_del_date'].'</span></p>
										</div>
									</div>
								</div>';
			}
			elseif ($getstatus[0]['status']==3) {
				 
			$headersection.=' 
							<div class="col-12 col-md-10 hh-grayBox pt45 pb20">
								<div class="row justify-content-between">
									<div class="order-tracking completed">
										<span class="is-complete"></span>
										<p>Inprogress Sales Date<br><span>'.$getstatus[0]['sales_date'].'</span></p>
									</div>
									
									<div class="order-tracking completed">
										<span class="is-complete"></span>
										<p>Sent to Fitting<br><span>'.$getstatus[0]['stf_date'].'</span></p>
									</div>
									
									<div class="order-tracking completed">
										<span class="is-complete "></span>
										<p>Ready To Delivery</span></p>
									</div>
									
									<div class="order-tracking">
										<span class="is-complete"></span>
										<p>Expected Del Date<br><span>'.$getstatus[0]['expected_del_date'].'</span></p>
									</div>
								</div>
							</div>';
			}
			else{
				$headersection.=' 
							<div class="col-12 col-md-10 hh-grayBox pt45 pb20">
								<div class="row justify-content-between">
									<div class="order-tracking completed">
										<span class="is-complete"></span>
										<p>Inprogress Sales Date<br><span>'.$getstatus[0]['sales_date'].'</span></p>
									</div>
									
									<div class="order-tracking completed">
										<span class="is-complete"></span>
										<p>Sent to Fitting<br><span>'.$getstatus[0]['stf_date'].'</span></p>
									</div>
									
									<div class="order-tracking completed">
										<span class="is-complete "></span>
										<p>Ready To Delivery</span></p>
									</div>
									
									<div class="order-tracking completed">
										<span class="is-complete "></span>
										<p>Delivered Date<br><span>'.$getstatus[0]['expected_del_date'].'</span></p>
									</div>
								</div>
							</div>';
				
			}
              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $headersection
                ));
                  exit;
          }
        else
        {
          $this->msg='';
            $this->error=' No Customer Found';
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