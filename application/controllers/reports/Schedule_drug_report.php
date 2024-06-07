<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_drug_report extends CI_Controller {
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
        
        $this->load->model('Schedule_drug_report_model');
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
    }
  public function index()
  {
    $data['title']='Pharmacy::Schedule Drug Report';
    $data['activecls']='Schedule_drug_report';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
    $data['getcustomer']=$this->Common_model->getcustomerdata($var_array);
    $data['getitem']=$this->Common_model->getitemdata($var_array);
    $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
    $data['getcategory']=$this->Common_model->getcategory($var_array);
    $data['getschedule']=$this->Common_model->getscheduledrug($var_array);
    $data['getstaff']=$this->Common_model->GetStaffData($var_array);
    $data['getsupp']=$this->Common_model->getsupplierdataval($var_array);
    $content=$this->load->view('reports/schedule_drug_report',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }

   

   public function getdetailed()
    {
      $this->form_validation->set_rules('sum_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sum_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdate')))));
        $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todate')))));
        $det_item=trim(htmlentities($this->input->post('det_item')));
        $schedule_drug=trim(htmlentities($this->input->post('schedule_drug')));
        $url='Schedule_drug_report/print/'.$sum_fromdate.'/'.$sum_todate.'/'.$schedule_drug;
     $getresult=$this->Schedule_drug_report_model->getdetailedreportmodel($sum_fromdate,$sum_todate,$det_item,$schedule_drug,$this->session->userdata('office_id'));
      if($getresult)
      {
        $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div><table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Manufacture  Name</th>
                         <th>Customer Name</th>
                          <th>Doctor Name</th>
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
        foreach ($getresult as $data) {

          $getresultgg=$this->Schedule_drug_report_model->getsuppliernameinitem($data['batchno'],$data['expirydaterr'],$data['item_id'],$this->session->userdata('office_id'));

            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$getresultgg[0]['supname'].'</td>
                  <td>'.$data['cusname'].'</td>
                   <td>'.$data['docname'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['itemcode'].'</td>
                  <td>'.$data['itemname'].'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.number_format($data['rate'],2).'</td>
                  <td>'.number_format((float)$data['total_amount'] ,2,'.', '').'</td>
                  <td>'.$data['batchno'].'</td>
                  <td>'.$data['expirydate'].'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$data['total_amount'];
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

public function print($sum_fromdate,$sum_todate,$schedule_drug)
  {
    error_reporting(0);
    $office_id=$this->session->userdata('office_id');
    $sum_modeofpay='';
    $det_item='';
    $sum_customer='';
    $supplier_id='';
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

   
     $getresult=$this->Schedule_drug_report_model->getdetailedreportmodel($sum_fromdate,$sum_todate,$det_item,$schedule_drug,$this->session->userdata('office_id'));
     
        $htmld='<table style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                          <th>Doctor Name</th>
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
        foreach ($getresult as $datat) {
           
            $htmld.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$datat['cusname'].'</td>
                   <td>'.$datat['docname'].'</td>
                  <td>'.$datat['sales_date'].'</td>
                  <td>'.$datat['invoice_number'].'</td>
                  <td>'.$datat['itemcode'].'</td>
                  <td>'.$datat['itemname'].'</td>
                  <td>'.$datat['quantity'].'</td>
                  <td>'.number_format($datat['rate'],2).'</td>
                  <td>'.number_format((float)$datat['total_amount'] ,2,'.', '').'</td>
                  <td>'.$datat['batchno'].'</td>
                  <td>'.$datat['expirydate'].'</td>
                
                </tr>';
                $sl++;
                $sumnetamount+=$datat['total_amount'];
        }
              $htmld.='
                  
                  <tr>
                    <th>'.$sl.'</th>
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

    
        
          
           
    
          $data['htmldata']=$htmld;

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
        $getresult=$this->Sales_report_model->getcollectionreportmodel($det_fromdate,$det_todate,$this->session->userdata('office_id'));
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
         $getcash=$this->Sales_report_model->getmodeamount($modeofpay_id,$data['sdate']);
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
         $getcard=$this->Sales_report_model->getmodeamount($modeofpay_id,$data['sdate']);
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
         $getcredit=$this->Sales_report_model->getmodeamount($modeofpay_id,$data['sdate']);
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
         $getphonepae=$this->Sales_report_model->getmodeamount($modeofpay_id,$data['sdate']);
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
         $getgooglepae=$this->Sales_report_model->getmodeamount($modeofpay_id,$data['sdate']);
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
}
