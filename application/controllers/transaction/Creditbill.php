<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Creditbill extends CI_Controller {
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
        
        $this->load->model('Creditbill_m');
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
        $this->load->model('Purchase_report_model');
    }
  public function index()
  {
    $data['title']='Pharmacy::Creditbill';
    $data['activecls']='Creditbill';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
    $data['getcustomer']=$this->Common_model->getcustomerdata($var_array);
    $data['getitem']=$this->Common_model->getitemdata($var_array);
    $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
    $data['getcategory']=$this->Common_model->getcategory($var_array);
    $data['getlens']=$this->Common_model->getlensmaster($var_array);
    $data['getstaff']=$this->Common_model->GetStaffData($var_array);
    $data['getsupp']=$this->Common_model->getsupplierdataval($var_array);

    $getuserdesgn=  $this->db->get_where("sales_master","1=1")->row_array();
    if(!isset($getuserdesgn['credit_bill_payment']))
  {
      $this->db->query("ALTER TABLE `sales_master`  ADD `credit_bill_payment` INT(11) NOT NULL DEFAULT '0' COMMENT '0:Pending,1:payment done'  AFTER `sales_id`;");
      $this->db->query("ALTER TABLE `sales_master_history`  ADD `credit_bill_payment` INT(11) NOT NULL DEFAULT '0' COMMENT '0:Pending,1:payment done'  AFTER `sales_id`;");
  }

    $content=$this->load->view('transaction/creditbill/insert',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }

    public function getsummary()
    {
      $this->form_validation->set_rules('sum_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sum_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdate')))));
        $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todate')))));
        $sum_customer=trim(htmlentities($this->input->post('sum_customer')));
        $sum_modeofpay=trim(htmlentities($this->input->post('sum_modeofpay')));
        $staff=trim(htmlentities($this->input->post('staff')));
        $status=trim(htmlentities($this->input->post('status')));
        $supplier_id=trim(htmlentities($this->input->post('supplier_id')));
        $getresult=$this->Creditbill_m->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$this->session->userdata('office_id'),$staff,$status,$supplier_id);
      if($getresult)
      {
        $staffcond='';
        $cus='';
        if($sum_customer)
    {
      $cus= ' and sales_master.customer_id='.$sum_customer;
    }
       if($staff)
      {
        $staffcond= ' and  staff.staff_id='.$staff;
      }

      $modedata=$this->Creditbill_m->getmodemodel($this->session->userdata('office_id'));
      $u=1;
       $cli='';
       $sst='';
     
     
      


      

      


        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_sum">
            <thead>
                    <tr>
                         <th>Action</th>
                         <th>Staff</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>User Name</th>
                         <th>Modeofpay</th>
                         <th>CASH</th>
                         <th>CARD</th>
                         <th>PAYTM</th>
                         <th>OTHERS</th>
                         <th>Total Qty</th>
                         <th>Discount Amount</th>
                         <th>Net Amount</th>
                        
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        $sumadamount='0.00';
        $sumbalamount='0.00';
        foreach ($getresult as $data) {
           $sales_id= $data['sales_id'];
        if($data['credit_bill_payment']==1)
        {
          $cancel='<button type="button" class="btn btn-icon btn-success mr-1 mb-1"><i class="la la-check-circle"></i></button>';
        }
        else 
        {
           $cancel="<button type='button'  onclick=\"creditbilpayment('$sales_id');\" class='btn btn-icon btn-danger  mr-1 mb-1'><i class='la la-credit-card'></i></button>";
        }
        
            $html.='<tr>
                  <td>'.$cancel.'</td>
                  <td>'.$data['staffname'].'</td>
                  <td>'.$data['cusname'].'</td>
                 
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['username'].'</td>
                  <td>'.$data['mode'].'</td>
                  <td>'.number_format((float)$data['cash']
                  ,2,'.', '').'</td>
                  <td>'.number_format((float)$data['card']
                  ,2,'.', '').'</td>
                  <td>'.number_format((float)$data['paytm']
                  ,2,'.', '').'</td>
                  <td>'.number_format((float)$data['others']
                  ,2,'.', '').'</td>
                  <td>'.$data['total_qty'].'</td>
                  
                  <td>'.number_format((float)$data['discount_amount']
            ,2,'.', '').'</td>
                  <td>'.number_format((float)$data['netamount']
            ,2,'.', '').'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$data['netamount'];
               
        }
              $html.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                   
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  <th></th>
                    <th></th>
                    <th>Total</th>
                    <th>'.number_format((float)$sumnetamount
            ,2,'.', '').'</th>
                  
                  </tr>
                  </tbody>
                  </table>';
        

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $html
                ));
                  exit;
          }
          else
          {
              $this->msg='';
              $this->error='No Data Found';
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

  public function paymentdone()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_salesid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_salesid,$this->session->userdata('office_id'));
          $getresult=$this->Creditbill_m->paymentdonec($delete_salesid);
          if($getresult)
          {
              $this->msg='Payment Done Successfully';
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
              $this->error='Failed to payment';
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

  public function print($sum_fromdate,$sum_todate)
  {
error_reporting(0);
    $office_id=$this->session->userdata('office_id');
    $sum_modeofpay='';
    $staff='';
    $status='';
    $sum_customer='';
    $supplier_id='';
   $getresult=$this->Creditbill_m->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$this->session->userdata('office_id'),$staff,$status,$supplier_id);
    //print_r($getresult);exit;
    $data['logo'] = "";
    
    $office=$this->db->get_where('office',"office_id=$office_id")->row();
    $data['logo']=($office->logo=='')?'':"<img style='width:10%;max-height:100px' src='". base_url('images/profile/')."$office->logo'>";
    
    $data['company_name']=$office->printable_company_name;
    $data['company_address']=$office->printable_company_address;
    $data['company_mobile']=$office->printable_company_mobile;
    $data['company_land_phone']=$office->printable_company_phone;
    $data['company_email']=$office->printable_emailid;
    $data['company_gst']=$office->license_no;
    $data['print_declaration']=$office->declaration;
    $data['gstin_no']=$office->gstin_no;
    $data['fdate']=trim(htmlentities(date('d/m/Y',strtotime($sum_fromdate))));
    $data['tdate']=trim(htmlentities(date('d/m/Y',strtotime($sum_todate))));
   
    

    if($getresult)
      {
       
      
       $conn='';
     

        $htmld='
         <table style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
            <thead>
                    <tr>
                         <th>SL NO</th>
                        
                         <th>Customer Name</th>
                        
                         <th>Date</th>
                         <th>Invoice No</th>
                        
                         <th>Modeofpay</th>
                         <th>Total Qty</th>
                      
                         <th>Discount Amount</th>
                         
                         <th>Net Amount</th>
                        
                     </tr>
                     </thead>
                   <tbody>';
         $sl=1;
        $sumnetamount='0.00';
        $sumadamount='0.00';
        $sumbalamount='0.00';
        foreach ($getresult as $datar) {
           $sales_id= $datar['sales_id'];
        
        
            $htmld.='<tr>
                  <td>'.$sl.'</td>
                
                  <td>'.$datar['cusname'].'</td>
                 
                  <td>'.$datar['sales_date'].'</td>
                  <td>'.$datar['invoice_number'].'</td>
                
                  <td>'.$datar['mode'].'</td>
                  <td>'.$datar['total_qty'].'</td>
                  
                  <td>'.number_format((float)$datar['discount_amount']
            ,2,'.', '').'</td>
                  <td>'.number_format((float)$datar['netamount']
            ,2,'.', '').'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$datar['netamount'];
               
        }
              $htmld.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                   
                   
                    <th></th>
                    <th></th>
                    <th></th>
                   
                  <th></th>
                    <th></th>
                    <th>Total</th>
                    <th>'.number_format((float)$sumnetamount
            ,2,'.', '').'</th>
                  
                  </tr>
                  </tbody>
                  </table>';
        
          
           
          }
          $data['htmldata']=$htmld;
        //  print_r($data);exit;


     $html=$this->load->view("reports/salesreportprint",$data, true); 
                   $print_config=[
                                    'format' => 'A4',
                                    'margin_left' => 10,
                                    'margin_right' => 10,
                                    'margin_top' => 10,
                                    'margin_bottom' => 10,
                                    'margin_header' => 0,
                                    'margin_footer' => 0,
                                ];

            $mpdf = new \Mpdf\Mpdf($print_config);
            $pdfFilePath ="print-".time().".pdf"; 
            $labName=$company_name;
            $mpdf->SetWatermarkText($labName,0.03);
            $mpdf->showWatermarkText = true;
            $mpdf -> SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
  }

   public function getdetailed()
    {
      $this->form_validation->set_rules('det_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
      $this->form_validation->set_rules('det_lens', 'Lens', 'trim|min_length[1]|max_length[20]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_todate')))));
        $det_customer=trim(htmlentities($this->input->post('det_customer')));
        $det_modeofpay=trim(htmlentities($this->input->post('det_modeofpay')));
        $det_item=trim(htmlentities($this->input->post('det_item')));
        $det_lens=trim(htmlentities($this->input->post('det_lens')));
     $getresult=$this->Creditbill_m->getdetailedreportmodel($det_fromdate,$det_todate,$det_customer,$det_modeofpay,$this->session->userdata('office_id'),$det_item,$det_lens);
      if($getresult)
      {
        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Item Code</th>
                         <th>Item Name</th>
                         <th>Quantity</th>
                         <th>Rate</th>
                         <th>Total</th>
                         <th>Batch No</th>
                         <th>Expiry Date</th>
                       
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        $sumqty='0.00';
        foreach ($getresult as $data) {
           
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['itemcode'].'</td>
                  <td>'.$data['itemname'].'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.$data['rate'].'</td>
                  <td>'.number_format((float)$data['total_amount'] ,2,'.', '').'</td>
                  <td>'.$data['batchno'].'</td>
                  <td>'.$data['expirydate'].'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$data['total_amount'];
                    $sumqty+=$data['quantity'];
        }
              $html.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th>'.$sumqty.'</th>
                    
                    <th></th>
                    <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
                    <th></th>
                    <th></th>
                  
                  </tr>
                  </tbody>
                  </table>';
        

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $html
                ));
                  exit;
          }
          else
          {
              $this->msg='';
              $this->error='No Data Found';
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


   public function getmonthly()
    {
      $this->form_validation->set_rules('mon_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('mon_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('mon_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
     
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('mon_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('mon_todate')))));
        $det_item=trim(htmlentities($this->input->post('mon_item')));
     $getresult=$this->Creditbill_m->getmondetailedreportmodel($det_fromdate,$det_todate,$det_item,$this->session->userdata('office_id'));
      if($getresult)
      {
        if(!$det_item)
        {
          $det_item=0;
        }
        $url='Sales_report/print_mon/'.$det_fromdate.'/'.$det_todate.'/'.$det_item;

        $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div><table class="table table-striped table-bordered dataex-html5-selectors" id="example_mon">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Item Code</th>
                         <th>Item Name</th>
                         <th>Quantity</th>
                         <th>Rate</th>
                         <th>Total</th>
                         <th>Batch No</th>
                         <th>Expiry Date</th>
                       
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        $sumqty='0.00';
        $rat=0;
        foreach ($getresult as $data) {
           $rat=$data['quantity']*$data['rate'];
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['itemcode'].'</td>
                  <td>'.$data['itemname'].'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.number_format((float)$data['rate'] ,2,'.', '').'</td>
                  <td>'.number_format((float)$rat ,2,'.', '').'</td>
                  <td>'.$data['batchno'].'</td>
                  <td>'.$data['expirydate'].'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$rat;
                $sumqty+=$data['quantity'];
        }
              $html.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th>Total</th>
                    <th>'.$sumqty.'</th>
                    <th></th>
                    <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </tbody>
                  </table>';
        

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $html
                ));
                  exit;
          }
          else
          {
              $this->msg='';
              $this->error='No Data Found';
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

  public function print_mon($sum_fromdate,$sum_todate,$det_item)
  {
error_reporting(0);
    $office_id=$this->session->userdata('office_id');
    $sum_modeofpay='';
    $staff='';
    $status='';
    $sum_customer='';
    $supplier_id='';
   $getresult=$this->Creditbill_m->getmondetailedreportmodel($sum_fromdate,$sum_todate,$det_item,$this->session->userdata('office_id'));
  
    $data['logo'] = "";
    
    $office=$this->db->get_where('office',"office_id=$office_id")->row();
    $data['logo']=($office->logo=='')?'':"<img style='width:10%;max-height:100px' src='". base_url('images/profile/')."$office->logo'>";
    
    $data['company_name']=$office->printable_company_name;
    $data['company_address']=$office->printable_company_address;
    $data['company_mobile']=$office->printable_company_mobile;
    $data['company_land_phone']=$office->printable_company_phone;
    $data['company_email']=$office->printable_emailid;
    $data['company_gst']=$office->license_no;
    $data['print_declaration']=$office->declaration;
    $data['gstin_no']=$office->gstin_no;
    $data['fdate']=trim(htmlentities(date('d/m/Y',strtotime($sum_fromdate))));
    $data['tdate']=trim(htmlentities(date('d/m/Y',strtotime($sum_todate))));
   
    

    if($getresult)
      {
       
      
       $conn='';
     

        $htmld='  <table style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Item Code</th>
                         <th>Item Name</th>
                         <th>Quantity</th>
                         <th>Rate</th>
                         <th>Total</th>
                         <th>Batch No</th>
                         <th>Expiry Date</th>
                     </tr>
                     </thead>
                   <tbody>';
            $sl=1;
            $sumnetamount='0.00';
            $sumqty='0.00';
            $rat=0;
        foreach ($getresult as $dataf) {
           $rat=$dataf['quantity']*$dataf['rate'];
            $htmld.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$dataf['itemcode'].'</td>
                  <td>'.$dataf['itemname'].'</td>
                  <td>'.$dataf['quantity'].'</td>
                  <td>'.number_format((float)$dataf['rate'] ,2,'.', '').'</td>
                  <td>'.number_format((float)$rat ,2,'.', '').'</td>
                  <td>'.$dataf['batchno'].'</td>
                  <td>'.$dataf['expirydate'].'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$rat;
                $sumqty+=$dataf['quantity'];
        }
              $htmld.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th>Total</th>
                    <th>'.$sumqty.'</th>
                    <th></th>
                    <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </tbody>
                  </table>';
        
          
           
          }
          $data['htmldata']=$htmld;
        //  print_r($data);exit;


     $html=$this->load->view("reports/salesreportprint",$data, true); 
                   $print_config=[
                                    'format' => 'A4',
                                    'margin_left' => 10,
                                    'margin_right' => 10,
                                    'margin_top' => 10,
                                    'margin_bottom' => 10,
                                    'margin_header' => 0,
                                    'margin_footer' => 0,
                                ];

            $mpdf = new \Mpdf\Mpdf($print_config);
            $pdfFilePath ="print-".time().".pdf"; 
            $labName=$company_name;
            $mpdf->SetWatermarkText($labName,0.03);
            $mpdf->showWatermarkText = true;
            $mpdf -> SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
  }



  public function getcollection()
    {
      $this->form_validation->set_rules('col_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('col_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('col_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('col_todate')))));
        $getresult=$this->Creditbill_m->getcollectionreportmodel($det_fromdate,$det_todate,$this->session->userdata('office_id'));
      if($getresult)
      {
        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_col">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Bill Date</th>
                         <th>Bill No Range</th>
                         <th>CASH</th>
                         <th>CARD</th>
                         <th>CREDIT</th>
                         <th>PHONE PAY</th>
                         <th>GOOGLE PAY</th>
                         <th>Total</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        
        $sumcash='0.00';
        $sumcard='0.00';
        $sumcredit='0.00';
        $sumphonepae='0.00';
        $sumgooglepae='0.00';
        foreach ($getresult as $data) 
        {
          $cashamt='0.00';
        $cardamt='0.00';
        $credtamt='0.00';
        $phonepaeamt='0.00';
        $googlepae='0.00';
         $modeofpay_id = $this -> db
       -> select('modeofpay_id')
       -> where('name', 'CASH')
       -> limit(1)
       -> get('modeofpay')
       -> row()
       ->modeofpay_id;
         $getcash=$this->Creditbill_m->getmodeamount($modeofpay_id,$data['sdate']);
         if($getcash[0]['modeamount'])
         {
          $cashamt=$getcash[0]['modeamount'];
         }
         $modeofpay_id = $this -> db
       -> select('modeofpay_id')
       -> where('name', 'CARD')
       -> limit(1)
       -> get('modeofpay')
       -> row()
       ->modeofpay_id;
         $getcard=$this->Creditbill_m->getmodeamount($modeofpay_id,$data['sdate']);
         if($getcard[0]['modeamount'])
         {
          $cardamt=$getcard[0]['modeamount'];
         }
                $modeofpay_id = $this -> db
       -> select('modeofpay_id')
       -> where('name', 'CREDIT')
       -> limit(1)
       -> get('modeofpay')
       -> row()
       ->modeofpay_id;
         $getcredit=$this->Creditbill_m->getmodeamount($modeofpay_id,$data['sdate']);
         if($getcredit[0]['modeamount'])
         {
          $credtamt=$getcredit[0]['modeamount'];
         }
          $modeofpay_id = $this -> db
       -> select('modeofpay_id')
       -> where('name', 'PHONE PAY')
       -> limit(1)
       -> get('modeofpay')
       -> row()
       ->modeofpay_id;
         $getphonepae=$this->Creditbill_m->getmodeamount($modeofpay_id,$data['sdate']);
         if($getphonepae[0]['modeamount'])
         {
          $phonepaeamt=$getphonepae[0]['modeamount'];
         }
          $modeofpay_id = $this -> db
       -> select('modeofpay_id')
       -> where('name', 'GOOGLE PAY')
       -> limit(1)
       -> get('modeofpay')
       -> row()
       ->modeofpay_id;
         $getgooglepae=$this->Creditbill_m->getmodeamount($modeofpay_id,$data['sdate']);
         if($getgooglepae[0]['modeamount'])
         {
          $googlepae=$getgooglepae[0]['modeamount'];
         }
           
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>ABY-'.$data['from_invoice_no'].' to  ABY-'.$data['to_invoice_no'].'</td>
                  <td>'.number_format($cashamt,2).'</td>
                  <td>'.number_format($cardamt,2).'</td>
                  <td>'.number_format($credtamt,2).'</td>
                  <td>'.number_format($phonepaeamt,2).'</td>
                  <td>'.number_format($googlepae,2).'</td>
                  <td>'.number_format((float)$data['total'] ,2,'.', '').'</td>
                  </tr>';
                $sl++;
                $sumnetamount+=$data['total'];
                $sumcash+=$cashamt;
                $sumcard+=$cardamt;
                $sumcredit+=$credtamt;
                $sumphonepae+=$phonepaeamt;
                $sumgooglepae+=$googlepae;

        }
              $html.='<tr style="font-weight:bold;">
                        <td>'.$sl.'</td>
                        <td><b>Total</b></td>
                        <td></td>
                        <td>'.number_format($sumcash,2).'</td>
                        <td>'.number_format($sumcard,2).'</td>
                        <td>'.number_format($sumcredit,2).'</td>
                        <td>'.number_format($sumphonepae,2).'</td>
                        <td>'.number_format($sumgooglepae,2).'</td>
                        <td>'.number_format($sumnetamount,2).'</td>
                      </tr>
                  </tbody>
                  </table>';
        

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $html
                ));
                  exit;
          }
          else
          {
              $this->msg='';
              $this->error='No Data Found';
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


  public function producthistory()
  {
    $this->form_validation->set_rules('pro_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
    $this->form_validation->set_rules('pro_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
    if($this->form_validation->run() == TRUE)
    {
      $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('pro_fromdate')))));
      $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('pro_todate')))));
      $pro_item=trim(htmlentities($this->input->post('pro_item')));
      $getresult=$this->Purchase_report_model->getdetailedreportmodel($sum_fromdate,$sum_todate,$det_supplier='',$det_modeofpay='',$this->session->userdata('office_id'),$pro_item);
      $getresultsales=$this->Creditbill_m->getdetailedreportmodel($sum_fromdate,$sum_todate,$det_customer='',$det_modeofpay='',$this->session->userdata('office_id'),$pro_item,$det_lens='');
		  if($getresult!='' || $getresultsales!='')
		  {
		  	$html='<h2>Purchase</h2><table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
		  			<thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Supplier Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Item Code</th>
                         <th>Item Name</th>
                         <th>Quantity</th>
                         <th>Free Qty</th>
                         <th>CP</th>
                         <th>MRP</th>
                         <th>Total</th>
                         <th>Batch No</th>
                         <th>Expiry Date</th>
                        
                     </tr>
                     </thead>
                   <tbody>';
		  	$sl=1;
		  	$sumnetamount='0.00';
		  	foreach ($getresult as $data) {

		  		
		  		
		  			$html.='<tr>
			  					<td>'.$sl.'</td>
			  					<td>'.$data['supname'].'</td>
			  					<td>'.$data['purchase_date'].'</td>
			  					<td>'.$data['invoice_no'].'</td>
			  					<td>'.$data['itemcode'].'</td>
			  					<td>'.$data['itemname'].'</td>
			  					<td>'.$data['quantity'].'</td>
			  					<td>'.$data['free'].'</td>
			  					<td>'.number_format((float)$data['cost_price'] ,2,'.', '').'</td>
			  					<td>'.number_format((float)$data['mrp'] ,2,'.', '').'</td>
			  					<td>'.$data['tot_amount'].'</td>
			  					<td>'.$data['batchno'].'</td>
			  					<td>'.$data['expirydate'].'</td>
		  					</tr>';
		  					$sl++;
		  					$sumnetamount+=$data['tot_amount'];
		  	}
		  				$html.='
		  						
		  						<tr>
				  					<th>'.$sl.'</th>
				  					<th></th>
				  					<th></th>
				  					<th></th>
				  					<th></th>
				  					<th></th>
				  					<th></th>
			  						<th></th>
			  						<th></th>
			  						<th>Total</th>
			  						<th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
			  						<th></th>
			  						<th></th>
			  					
		  						</tr>
		  						</tbody>
		  						</table>';

                  $html.=' <h2>Sales</h2><hr/><table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Item Code</th>
                         <th>Item Name</th>
                         <th>Quantity</th>
                         <th>Rate</th>
                         <th>Total</th>
                         <th>Batch No</th>
                         <th>Expiry Date</th>
                       
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        $sumqty='0.00';
        foreach ($getresultsales as $data) {
           
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['itemcode'].'</td>
                  <td>'.$data['itemname'].'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.$data['rate'].'</td>
                  <td>'.number_format((float)$data['total_amount'] ,2,'.', '').'</td>
                  <td>'.$data['batchno'].'</td>
                  <td>'.$data['expirydate'].'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$data['total_amount'];
                    $sumqty+=$data['quantity'];
        }
              $html.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th>'.$sumqty.'</th>
                    
                    <th></th>
                    <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
                    <th></th>
                    <th></th>
                  
                  </tr>
                  </tbody>
                  </table>';
		  	

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $html
                ));
                  exit;
          }
        else
        {
            $this->msg='';
            $this->error='No Data Found';
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
