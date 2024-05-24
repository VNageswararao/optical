<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_history_report extends CI_Controller {
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
        
        $this->load->model('Sales_report_model');
        $this->load->model('Product_history_report_model');
        $this->load->model('Common_model');
    }
  public function index()
  {
    $data['title']='Pharmacy::Product History Report';
    $data['activecls']='Product_history_report';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
    $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
    $data['getcustomer']=$this->Common_model->getcustomerdata($var_array);
    $data['getitem']=$this->Common_model->getitemdata($var_array);
    $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
    $data['getcategory']=$this->Common_model->getcategory($var_array);
    $data['getlens']=$this->Common_model->getlensmaster($var_array);
    $data['getstaff']=$this->Common_model->GetStaffData($var_array);
    $data['getsupp']=$this->Common_model->getsupplierdataval($var_array);
    $content=$this->load->view('reports/product_history_report',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }

    

   public function getdetailed()
    {
      $this->form_validation->set_rules('det_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric|required');
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_todate')))));
        $det_item=trim(htmlentities($this->input->post('det_item')));
        $getsupplierdetails=$this->Product_history_report_model->getalldetailsreport($det_fromdate,$det_todate,$det_item,$this->session->userdata('office_id'));
      if($getsupplierdetails)
      {
        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
                   <thead>
                     <tr>
                        <th>SL No</th>
                        <th>Item Name</th>
                        <th>Batch No</th>
                        <th>Expiry Date</th>
                        <th>MRP</th>
                        <th>Selling Price</th>
                        <th>Purchase Qty</th>
                        <th>Stock adj +</th>
                        <th>Stock adj -</th>
                        <th>Sales Qty</th>
                        <th>Sales Return Qty</th>
                     
                     </tr>
                     </thead>
                   <tbody>';
                       $lt=1;
                        foreach($getsupplierdetails as $dataval)
                        {
                           $salesqtysum=$this->Product_history_report_model->salesdetails($dataval['item_id'],$dataval['batchno'],$dataval['expdate'],$dataval['mrp'],$dataval['selling_price'],$this->session->userdata('office_id'));
                           if($salesqtysum)
                           {
                             $salesqty=$salesqtysum[0]['salesqty'];
                           }
                           else
                           {
                            $salesqty=0;
                           }

                           $stkadjqtysum=$this->Product_history_report_model->stockadj($dataval['item_id'],$dataval['batchno'],$dataval['expdate'],$dataval['mrp'],$dataval['selling_price'],1,$this->session->userdata('office_id'));
                           if($stkadjqtysum)
                           {
                             $stkplus=$stkadjqtysum[0]['stkadjqty'];
                           }
                           else
                           {
                            $stkplus=0;
                           }

                           $stkadjqtymin=$this->Product_history_report_model->stockadj($dataval['item_id'],$dataval['batchno'],$dataval['expdate'],$dataval['mrp'],$dataval['selling_price'],2,$this->session->userdata('office_id'));
                           if($stkadjqtymin)
                           {
                             $stkmin=$stkadjqtymin[0]['stkadjqty'];
                           }
                           else
                           {
                            $stkmin=0;
                           }

                            $salesretsum=$this->Product_history_report_model->salesretdetails($dataval['item_id'],$dataval['batchno'],$dataval['expdate'],$dataval['mrp'],$dataval['selling_price'],$this->session->userdata('office_id'));
                           if($salesretsum)
                           {
                             $saret=$salesretsum[0]['salesretqty'];
                           }
                           else
                           {
                            $saret=0;
                           }
                         

                              $html.='<tr>
                                      <td>'.$lt.'</td>
                                      <td>'.$dataval['itemname'].'</td>
                                      <td>'.$dataval['batchno'].'</td>
                                      <td>'.$dataval['expirydate'].'</td>
                                      <td>'.$dataval['mrp'].'</td>
                                      <td>'.$dataval['selling_price'].'</td>
                                      <td>'.$dataval['quantity'].'</td>
                                      <td>'.$stkplus.'</td>
                                      <td>'.$stkmin.'</td>
                                      <td>'.$salesqty.'</td>
                                      <td>'.$saret.'</td>
                                      
                                   </tr>';
                                   $lt++;
                                  
                        }
                        
                   
          $html.='</tbody>
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
     $getresult=$this->Sales_report_model->getmondetailedreportmodel($det_fromdate,$det_todate,$det_item,$this->session->userdata('office_id'));
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
   $getresult=$this->Sales_report_model->getmondetailedreportmodel($sum_fromdate,$sum_todate,$det_item,$this->session->userdata('office_id'));
  
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
