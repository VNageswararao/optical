<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_order_report extends CI_Controller {
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
        
        $this->load->model('Bill_order_report_model');
        $this->load->model('Sales_report_model');
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
        $this->load->model('Purchase_report_model');
       
    }
  public function index()
  {
    $data['title']='Optical::Bill Order Due Entry Report';
    $data['activecls']='Bill_order_report';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
    $data['getcustomer']=$this->Common_model->getcustomerdata($var_array);
    $data['getitem']=$this->Common_model->getitemdata($var_array);
    $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
    $data['getcategory']=$this->Common_model->getcategory($var_array);
    $data['getlens']=$this->Common_model->getlensmaster($var_array);
    $data['getstaff']=$this->Common_model->GetStaffData($var_array);
    $data['getsupp']=$this->Common_model->getsupplierdataval($var_array);
    $content=$this->load->view('reports/bill_order_report',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }

    public function getsummary()
    {
      error_reporting(0);
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
        $emergency_order=trim(htmlentities($this->input->post('emergency_order')));
        

        $getresult=$this->Bill_order_report_model->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$this->session->userdata('office_id'),$staff,$status,$supplier_id,$emergency_order);
      if($getresult)
      {

       $html.='</div><table class="table table-striped table-bordered dataex-html5-selectors" id="example_sum">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Staff</th>
                         <th>Customer Name</th>
                        
                         <th>Date</th>
                         <th>Invoice No</th>
                        
                         <th>Modeofpay</th>
                        
                         <th>Total Qty</th>
                         <th>Discount Amount</th>
                         <th>Advanced Amount</th>
                         <th>Delivery Amount</th>
                         <th>Balanced Amount</th>
                         <th>Net Amount</th>
                         <th>Status</th>
                         
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        $sumadamount='0.00';
        $sumbalamount='0.00';
        $sumdelamt='0.00';
        foreach ($getresult as $data) {
            $sales_id= $data['sales_id'];
            $advanced_amount=0;
            $delamt=0;
            $bal=0;
            if($data['status']=='Inprogress')
            {
                $getcntval=$this->Sales_report_model->getcountofpayment($data['sales_id']);
                if($getcntval[0]['CNT']==1)
                {
                    if($data['advanced_amount'])
                    {
                        $bal=$data['netamount']-$data['advanced_amount'];
                        $advanced_amount=$data['advanced_amount'];
                        $delamt=0;
                    }
                    else
                    {
                        $bal=$data['netamount'];
                    }
                    
                }
                else
                {
                    $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id   where sales_date >= '$sum_fromdate' AND sales_date <= '$sum_todate' and payment_details.sales_id=$sales_id   $cus ")->row();



                    if($advancecreditamount->advanced_amount)
                    {
                        $bal=0;
                        $advanced_amount=$data['advanced_amount'];
                        $delamt=$advancecreditamount->advanced_amount-$data['advanced_amount'];
                    }
                    else
                    {
                        $bal=0;
                        $advanced_amount=0;
                        $delamt=$data['netamount'];
                    }
                }
            }
            else
            {
                $getcntval=$this->Sales_report_model->getcountofpayment($data['sales_id']);
                if($getcntval[0]['CNT']==1)
                {
                    if($data['advanced_amount'])
                    {
                        $bal=0;
                        $advanced_amount=$data['advanced_amount'];
                        $delamt=0;
                    }
                    else
                    {
                        $bal=$data['netamount'];
                    }
                    
                }
                else
                {
                    $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id   where payment_details.sales_id=$sales_id   $cus ")->row();
                   

                    if($advancecreditamount->advanced_amount)
                    {
                        $bal=0;
                        $advanced_amount=$advancecreditamount->advanced_amount;
                        $delamt=$advancecreditamount->advanced_amount-$advanced_amount;
                    }
                    else
                    {
                        $bal=0;
                        $advanced_amount=0;
                        $delamt=$data['netamount'];
                    }
                }
                
            }

             $getresultmode=$this->Sales_report_model->getmodedata($sum_fromdate,$sum_todate,$sales_id);
            $modeam='';
         foreach($getresultmode as $datamode)
         {
            if($datamode['advanced_amount'])
            {
                $adamt=$datamode['advanced_amount'];
            }
            else
            {
                $adamt=$data['netamount'];
            }
          
            $modeam.=$datamode['name'].'='.$adamt;
         }

            if($data['sts']==1)
            {
                $st1='Inprogress';
            }
            elseif($data['sts']==3)
            {
                $st1='Ready';
            }
            else
            {
                $st1='Delivered';
            }
       

         
            $html.='<tr '.$clr.'>
                  <td>'.$sl.'</td>
                  <td>'.$data['staffname'].'</td>
                  <td>'.$data['cusname'].'</td>
                
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                
                  <td>'.$modeam.'</td>
                
                  <td>'.$data['total_qty'].'</td>
                  <td>'.number_format((float)$data['discount_amount']
            ,2,'.', '').'</td>
                  <td>'.abs(number_format((float)$advanced_amount
            ,2,'.', '')).'</td>
                   <td>'.number_format((float)$delamt
            ,2,'.', '').'</td>
                  <td>'.number_format((float)$bal
            ,2,'.', '').'</td>
                  <td>'.number_format((float)$data['netamount']
            ,2,'.', '').'</td>
                  <td>'.$st1.'</td>
                 
                </tr>';
                $sl++;
                $sumnetamount+=$data['netamount'];
                $sumadamount+=$advanced_amount;
                $sumdelamt+=$delamt;
                $sumbalamount+=$bal;
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
                    <th>Total</th>
                    <th>'.number_format((float)$sumadamount
            ,2,'.', '').'</th>
                    <th>'.number_format((float)$sumdelamt
            ,2,'.', '').'</th>
                    <th>'.number_format((float)$sumbalamount
            ,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamount
            ,2,'.', '').'</th>
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


  public function getsummaryr()
    {
      error_reporting(0);
      $this->form_validation->set_rules('sum_fromdater', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sum_todater', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('percentage', 'Percentage', 'trim|required|min_length[1]|max_length[4]');
      if($this->form_validation->run() == TRUE)
      {
        $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdater')))));
        $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todater')))));
        $sum_customer='';
        $sum_modeofpay='';
        $staff='';
        $status=2;
        $supplier_id='';
        $percentage=$this->input->post('percentage');
        

        $getresult=$this->Sales_report_model->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$this->session->userdata('office_id'),$staff,$status,$supplier_id);
      if($getresult)
      {

       $html.='</div><table class="table table-striped table-bordered dataex-html5-selectors" id="example_sumr">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Staff</th>
                         <th>Customer Name</th>
                         <th>Supplier Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>User Name</th>
                         <th>Modeofpay</th>
                         <th>Total Qty</th>
                         <th>Net Amount</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        $sumadamount='0.00';
        $sumbalamount='0.00';
        $sumdelamt='0.00';
        foreach ($getresult as $data) {
           $sales_id= $data['sales_id'];
           $advanced_amount=0.00;
           if($data['advanced_amount']>0){
           $advanced_amount= $data['advanced_amount'];
           }

           $getcntval=$this->Sales_report_model->getcountofpayment($data['sales_id']);
           $delamt='0.00';
           if($getcntval[0]['CNT']>1)
           {
              $getdelamt=$this->Sales_report_model->getdelpayment($data['sales_id']);
              $delamt=$getdelamt[0]['advanced_amount'];
           }
           $netamt=$data['netamount'];
           $perval=($netamt*$percentage)/100;
           $outp=$netamt-$perval;


            
$bal=0.00;
         if($data['status']=='Inprogress'){
          $bal=($data['netamount']-$advanced_amount)-$delamt;
          }
         
          $clr='';
         
        // print_r($getresultmode);
           $getresultmode=$this->Sales_report_model->getmodedata($sum_fromdate,$sum_todate,$sales_id);
            $modeam='';
         foreach($getresultmode as $datamode)
         {
            if($datamode['advanced_amount'])
            {
                $adamt=$datamode['advanced_amount'];
            }
            else
            {
                $adamt=$data['netamount'];
            }
          
            $modeam.=$datamode['name'];
         }


         
            $html.='<tr '.$clr.'>
                  <td>'.$sl.'</td>
                  <td>'.$data['staffname'].'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['supname'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['username'].'</td>
                  <td>'.$modeam.'</td>
                  <td>'.$data['total_qty'].'</td>
                  <td>'.number_format((float)$outp
            ,2,'.', '').'</td>
                </tr>';
                $sl++;
                $sumnetamount+=$outp;
              
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

  public function getsummaryi()
    {
        $cnamt=0;
      error_reporting(0);
      $this->form_validation->set_rules('sum_fromdatei', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sum_todatei', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdatei')))));
        $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todatei')))));

    $sql = "select sum(netamount) as cntamt from counter_sales_master where sales_date>= '$sum_fromdate' AND sales_date <='$sum_todate'";
    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    if($res)
    {
        $cnamt=$res[0]['cntamt'];
    }
    


        $getresult=$this->Sales_report_model->getincomemdl($sum_fromdate,$sum_todate,$this->session->userdata('office_id'));
      if($getresult)
      {

        $modedata=$this->Sales_report_model->getmodemodel($this->session->userdata('office_id'));
        $html.='<div class="row">';
       $u=1;
       $cli='';
       $sumnetamountada='0.00';
       foreach($modedata as $datva)
       {
           $moden=$datva['name'];
           $advancecashamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount from sales_master inner join payment_details on sales_master.sales_id=payment_details.sales_id  inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id
        left join staff on sales_master.staff_id=staff.staff_id  where payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate' and  modeofpay.name='$moden' $staffcond  $stacond  $cus")->row();
           if($u==1)
           {
              $cli='success';
           }
           elseif ($u==2) {
              $cli='danger';
           }
           elseif ($u==3) {
              $cli='info';
           }
           elseif ($u==4) {
              $cli='primary';
           }
           elseif ($u==5) {
              $cli='warning';
           }
           elseif ($u==6) {
              $cli='secondary';
           }
           elseif ($u==7) {
              $cli='light';
           }
           else
           {
            $cli='success';
           }

             $html.='
                  <div class="col-md-4">
                      <div class="alert alert-'.$cli.' mb-2" role="alert">
                       <h4 style="text-align:center;font-weight:bold;">'.$moden.':'.number_format((float)$advancecashamount->advanced_amount
            ,2,'.', '').'</h4>
                       </div>
                  </div>
                  ';
                  $u++;

       }

       $html.='</div>';
       $url='Sales_report/printincome/'.$sum_fromdate.'/'.$sum_todate;
       $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div>
       <table class="table table-striped table-bordered dataex-html5-selectors" id="example_sumi">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Modeofpay</th>
                         <th style="display:none;">Todays collected Amount</th>
                         <th>Delivery Amount</th>
                         <th>Advanced collected amount</th>
                         <th style="display:none;">Collected Amount</th>
                         <th>Balanced Amount</th>
                         <th>Net Amount</th>
                         <th>Status</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamountad=$net='0.00';
        $sumnetamountnet='0.00';
        $sumnetamountadr='0.00';
        $sumnetamountnetdel=0;
        $sumnetamountadrad=0;
        foreach ($getresult as $data) {
            $getpaidamt=$this->Sales_report_model->getpaidamt($data['sales_id'],$sum_fromdate,$sum_todate);
            $getresultvalad=$this->Sales_report_model->getadamt($data['sales_id']);
        $getresultval=$this->Sales_report_model->getsalesdetails($data['sales_id']);
        $bal='0.00';
        if($getresultval[0]['status']==1)
        {
            $bal=$data['net_amount']-$getresultvalad[0]['adamount'];
            $del=0;
            $pen=$getpaidamt[0]['paidamount'];
            $net=$data['net_amount'];
            $st='<span class="text-danger"><b>Pending</b></span>';

        }
        elseif($getresultval[0]['status']==3)
        {
            $bal=$data['net_amount']-$getresultvalad[0]['adamount'];
            $del=0;
            $pen=$getpaidamt[0]['paidamount'];
            $net=$data['net_amount'];
            $st='<span class="text-warning"><b>Ready</b></span>';
        }
        else
        {
            $net=0;
            $del=$getpaidamt[0]['paidamount'];
            $pen=0;
            $st='<span class="text-success"><b>Delivered</b></span>';
        }
         
            $html.='<tr '.$clr.'>
                  <td>'.$sl.'</td>
                  <td>'.$getresultval[0]['cusname'].'</td>
                  <td>'.$data['payment_date'].'</td>
                  <td>'.$getresultval[0]['invoice_number'].'</td>
                  <td>'.$data['mode'].'</td>
                  <td style="display:none;">'.number_format((float)$getpaidamt[0]['paidamount'],2,'.', '').'</td>
                  <td>'.$del.'</td>
                  <td>'.$pen.'</td>
                  <td style="display:none;">'.number_format((float)$getresultvalad[0]['adamount'],2,'.', '').'</td>
                  <td>'.number_format((float)$bal,2,'.', '').'</td>
                  <td>'.number_format((float)$net,2,'.', '').'</td>
                  <td>'.$st.'</td>
                </tr>';
                $sl++;
                $sumnetamountada+=$getpaidamt[0]['paidamount'];
                $sumnetamountad+=$getresultvalad[0]['adamount'];
                $sumnetamountnet+=$net;
                $sumnetamountadr+=$bal;

                $sumnetamountnetdel+=$del;
                $sumnetamountadrad+=$pen;
              
        }

         $html.='
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Counter Sales Amount</th>
                    <th style="display:none;"></th>
                    <th></th>
                    <th></th>
                    <th style="display:none;"></th>
                    <th></th>
                    <th>'.number_format((float)$cnamt,2,'.', '').'</th>
                    <th></th>
                  </tr>';
$sll=$sl+1;
              $html.='
                  <tr>
                    <th>'.$sll.'</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th style="display:none;">'.number_format((float)$sumnetamountada,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamountnetdel,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamountadrad,2,'.', '').'</th>
                    <th style="display:none;">'.number_format((float)$sumnetamountad,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamountadr,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamountnet+$cnamt,2,'.', '').'</th>
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
  public function producthistory()
    {
      error_reporting(0);
      $this->form_validation->set_rules('sum_fromdateproduct', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sum_todateproduct', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdateproduct')))));
        $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todateproduct')))));
        $det_item=trim(htmlentities($this->input->post('det_itemp')));
        $getresult=$this->Purchase_report_model->getdetailedreportmodel($sum_fromdate,$sum_todate,$det_supplier='',$det_modeofpay='',$this->session->userdata('office_id'),$det_item);
        $det_lens=trim(htmlentities($this->input->post('det_lensp')));
        $getresult1=$this->Sales_report_model->getdetailedreportmodel($sum_fromdate,$sum_todate,$det_customer='',$det_modeofpay='',$this->session->userdata('office_id'),$det_item,$det_lens);
        if($getresult!='' ||  $getresult1!='')
        {
          $html='<h1>PURCHASE</h1><table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
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
                           <th>Frame</th>
                       </tr>
                       </thead>
                     <tbody>';
          $sl=1;
          $sumnetamount='0.00';
          foreach ($getresult as $data) {
  
            if($data['mul_type']==1)
            {
              $frameclas='Individual';
              $frametype_array=array($data['frametype'],$this->session->userdata('office_id'));
            $frame_type=$this->Common_model->GetframeclassficationData($frametype_array);
            $frametype=$frame_type[0]['name'];
            $framecolor_array=array($data['framecolor'],$this->session->userdata('office_id'));
            $frame_color=$this->Common_model->GetframeclassficationData($framecolor_array);
            $framecolor=$frame_color[0]['name'];
            $framesize_array=array($data['framesize'],$this->session->userdata('office_id'));
            $frame_size=$this->Common_model->GetframeclassficationData($framesize_array);
            $framesize=$frame_size[0]['name'];
            // $frame_color=$this->Common_model->GetframecolorData($frame_array);
            // $frame_model=$this->Common_model->GetframemodelData($frame_array);
            // $frame_size=$this->Common_model->GetframesizeData($frame_array);
            }
            else
            {
              $frameclas='Multiple';
              $mulframetype=explode(',',$data['frametype']);
                $mulframecolor=explode(',',$data['framecolor']);
              $mulframesize=explode(',',$data['framesize']);
              
              $x = 1;
                      $b=0;
                      $frametype='';
              while($x <= $data['quantity']) 
                      {
                        if($mulframetype[$b]>0)
                          {
                            $frametype_array=array($mulframetype[$b],$this->session->userdata('office_id'));
                            $mulframe_type=$this->Common_model->GetframeclassficationData($frametype_array);
                            foreach ($mulframe_type as $mulframetypedata) {
                              $frametype.=$mulframetypedata['name'].',<br/>';
                            }
                          }
                          $x++;
                          $b++;
                      }
  
                      $y = 1;
                      $c=0;
                      $framecolor='';
               while($y <= $data['quantity']) 
                       {	
                        
                         if($mulframecolor[$c])
                           {
                          $framecolor.='';
                            $framecolor_array=array($mulframecolor[$c],$this->session->userdata('office_id'));
                            $mulframecolorr=$this->Common_model->GetframeclassficationData($framecolor_array);
                            foreach ($mulframecolorr as $mulframecolordata) {
                               $framecolor.=$mulframecolordata['name'].',<br/>';
                            }
                         }
                          
                          
                             $y++;
                            $c++;
                       }
                     
                      $x = 1;
                      $b=0;
                      $framesize='';
              while($x <= $data['quantity']) 
                      {
                        if($mulframesize[$b]>0)
                          {
                            $framesize_array=array($mulframesize[$b],$this->session->userdata('office_id'));
                            $mulframe_size=$this->Common_model->GetframeclassficationData($framesize_array);
                            foreach ($mulframe_size as $mulframesizedata) {
                              $framesize.=$mulframesizedata['name'].',<br/>';
                            }
                          }
                          $x++;
                          $b++;
                      }
            }
            
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
                    <td>'.$frameclas.'</td>
                  
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
                    
                    </tr>
                    </tbody>
                    </table>';

          
           
                    $html.=' <hr/><h1>SALES</h1><table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
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
                                 <th>Item Type</th>
                                 
                             </tr>
                             </thead>
                           <tbody>';
                $sl=1;
                $sumnetamount='0.00';
                foreach ($getresult1 as $data) {
                    if($data['product_type']==0)
                    {
                      $protype="Frame";
                      $frametype_array=array($data['frame_type'],$this->session->userdata('office_id'));
                      $frame_type=$this->Common_model->GetframeclassficationData($frametype_array);
                      $frame_type=$frame_type[0]['name'];
                      $framecolor_array=array($data['frame_color'],$this->session->userdata('office_id'));
                      $frame_color=$this->Common_model->GetframeclassficationData($framecolor_array);
                      $frame_color=$frame_color[0]['name'];
                      $framesize_array=array($data['frame_size'],$this->session->userdata('office_id'));
                      $frame_size=$this->Common_model->GetframeclassficationData($framesize_array);
                      $frame_size=$frame_size[0]['name'];
                      $getresultlenscoating='';
                      $getresultlenstype='';
                      $itemcode=$data['itemcode'];
                      $itemname=$data['itemname'];
                      $framemodel=$data['frame_model'];
                    }
                    else if($data['product_type']==1)
                    {
                      $frame_type='';
                      $frame_color='';
                      $frame_size='';
                      $framemodel='';
                      $protype="Lens";
                      $lens_array=array($data['stock_id'],$this->session->userdata('office_id'));
                      $getresultlenstype=$this->Common_model->GetLenstypeData($lens_array);
                      $getresultlenstype=$getresultlenstype[0]['lenstype'];
                      $getresultlenscoating=$this->Common_model->GetLenscoatingData($lens_array);
                      $getresultlenscoating=$getresultlenscoating[0]['lenscoating'];
                      $getresultlens=$this->Common_model->GetLensData($lens_array);
                      $itemcode=$getresultlens[0]['code'];
                      $itemname=$getresultlens[0]['name'];
                    }
                    else
                    {
                     $protype="Other"; 
                    }
                  
                    $html.='<tr>
                          <td>'.$sl.'</td>
                          <td>'.$data['cusname'].'</td>
                          <td>'.$data['sales_date'].'</td>
                          <td>'.$data['invoice_number'].'</td>
                          <td>'.$itemcode.'</td>
                          <td>'.$itemname.'</td>
                          <td>'.$data['quantity'].'</td>
                          <td>'.$data['rate'].'</td>
                          <td>'.number_format((float)$data['total_amount'] ,2,'.', '').'</td>
                          <td>'.$protype.'</td>
                         
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
                            
                            <th>Total</th>
                            <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
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

  public function printincome($sum_fromdate,$sum_todate)
  {
    error_reporting(0);
    $office_id=$this->session->userdata('office_id');
    $sum_modeofpay='';
    $staff='';
    $status='';
    $sum_customer='';
    $supplier_id='';
    $getresult=$this->Sales_report_model->getincomemdl($sum_fromdate,$sum_todate,$this->session->userdata('office_id'));
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
        $htmld='<table style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Modeofpay</th>
                         
                         <th>Delivery Amount</th>
                         <th>Advanced collected amount</th>
                         
                         <th>Balanced Amount</th>
                         <th>Net Amount</th>
                         <th>Status</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamountad=$net='0.00';
        $sumnetamountnet='0.00';
        $sumnetamountadr='0.00';
        $sumnetamountada='0.00';
        foreach ($getresult as $datat) {
        $getresultval=$this->Sales_report_model->getsalesdetails($datat['sales_id']);
        $getpaidamt=$this->Sales_report_model->getpaidamt($datat['sales_id'],$sum_fromdate,$sum_todate);
         $getresultvalad=$this->Sales_report_model->getadamt($datat['sales_id']);
        $bal='0.00';
        if($getresultval[0]['status']==1)
        {
            $bal=$datat['net_amount']-$getresultvalad[0]['adamount'];
            $del=0;
            $pen=$getpaidamt[0]['paidamount'];
            $net=$datat['net_amount'];
            $st='<span class="text-danger"><b>Pending</b></span>';

        }
        else if($getresultval[0]['status']==3)
        {
            $bal=$datat['net_amount']-$getresultvalad[0]['adamount'];
            $del=0;
            $pen=$getpaidamt[0]['paidamount'];
            $net=$datat['net_amount'];
            $st='<span class="text-warning"><b>Ready</b></span>';

        }
        else
        {
            $net=0;
            $del=$getpaidamt[0]['paidamount'];
            $pen=0;
            $st='<span class="text-success"><b>Delivered</b></span>';
        }




           


            $htmld.='<tr '.$clr.'>
                 <td>'.$sl.'</td>
                  <td>'.$getresultval[0]['cusname'].'</td>
                  <td>'.$datat['payment_date'].'</td>
                  <td>'.$getresultval[0]['invoice_number'].'</td>
                  <td>'.$datat['mode'].'</td>
                  
                  <td>'.$del.'</td>
                  <td>'.$pen.'</td>
                  
                  <td>'.number_format((float)$bal,2,'.', '').'</td>
                  <td>'.number_format((float)$net,2,'.', '').'</td>
                  <td>'.$st.'</td>
                </tr>';
                $sl++;
                $sumnetamountada+=$getpaidamt[0]['paidamount'];
                $sumnetamountad+=$getresultvalad[0]['adamount'];
                $sumnetamountnet+=$net;
                $sumnetamountadr+=$bal;

                $sumnetamountnetdel+=$del;
                $sumnetamountadrad+=$pen;
               
        }
              $htmld.='
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    
                    <th>'.number_format((float)$sumnetamountnetdel,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamountadrad,2,'.', '').'</th>
                    
                    <th>'.number_format((float)$sumnetamountadr,2,'.', '').'</th>
                    <th>'.number_format((float)$sumnetamountnet,2,'.', '').'</th>
                    <th></th>
                  </tr>
                  </tbody>
                  </table>';
        
          
           
          }
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
  public function print($sum_fromdate,$sum_todate)
  {
error_reporting(0);
    $office_id=$this->session->userdata('office_id');
    $sum_modeofpay='';
    $staff='';
    $status='';
    $sum_customer='';
    $supplier_id='';
    $getresult=$this->Sales_report_model->getsummaryreportmodell($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$office_id,$staff,$status,$supplier_id);
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
      $stacond='';
       if($status)
      {
        $stacond= ' and sales_master.status='.$status;
      }
       $dte=" and sales_date >= '$sum_fromdate' AND sales_date <= '$sum_todate'";
      if($status==2)
      {
        $dte= " and payment_details.payment_date>= '$sum_fromdate' AND payment_details.payment_date <='$sum_todate'";
      }
       $advancecashamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount from sales_master inner join payment_details on sales_master.sales_id=payment_details.sales_id  inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id
        left join staff on sales_master.staff_id=staff.staff_id  where payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate' and  modeofpay.name='CASH' $staffcond  $stacond  $cus")->row();



       $advancecardamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id left join staff on sales_master.staff_id=staff.staff_id  where 1=1  and   modeofpay.name='CARD' $staffcond  $stacond  $dte  $cus")->row();

       $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id left join staff on sales_master.staff_id=staff.staff_id  where payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate' and   modeofpay.name='CREDIT' $staffcond  $stacond  $cus")->row();
       $conn='';
      $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0]; 
      if($host_tvm=='nvc')
      {
        $conn='<style="display:none;"';
      }

        $htmld='
        </div> <table style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Modeofpay</th>
                         <th>Advanced Amount</th>
                         <th>Delivery Amount</th>
                         <th>Net Amount</th>
                         <th>Status</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
    
        $sumnetamount='0.00';
        $sumadamount='0.00';
        $netamt='0.00';
        $sumdelamt='0.00';
        foreach ($getresult as $datav) {
           $sales_id= $datav['sales_id'];
           $advanced_amount=0.00;
           if($datav['advanced_amount']>0){
           $advanced_amount= $datav['advanced_amount'];
           }

           $delamt='0.00';
           
           $getdelamt=$this->Sales_report_model->getdelpaymentt($datav['sales_id'],$datav['payment_date']);
           if($getdelamt)
           {
            $delamt=$getdelamt[0]['advanced_amount'];
           }


         
         


           if($datav['sts']==1)
           {
              $adamt=$datav['advanced_amount'];
              $netamt=$datav['netamount'];
              $delamt=0.00;
           }
           elseif($datav['sts']==3)
           {
              $adamt=$datav['advanced_amount'];
              $netamt=$datav['netamount'];
              $delamt=0.00;
           }
           else
           {
              $adamt=0.00;
              $netamt=0.00;
              $delamt=$delamt;

               $getcntval=$this->Sales_report_model->getcountofpayment($datav['sales_id']);
              if($getcntval[0]['CNT']==1)
              {
                 $adamt=$delamt;
                 $netamt=$datav['netamount'];
                 $delamt=0.00;
              }
              
           }

            $getmodedata=$this->Sales_report_model->getcountofpaymentt($datav['sales_id']);

           

            if($datav['sdate']==date('Y-m-d'))
            {
                 $netamt=$datav['netamount'];
                 $adamt=$datav['advanced_amount'];
            }

            if($datav['sts']==1)
            {
                $st1='Inprogress';
            }
            elseif($datav['sts']==3)
            {
                $st1='Ready';
            }
            else
            {
                $st1='Delivered';
            }
         
               


            $htmld.='<tr '.$clr.'>
                  <td>'.$sl.'</td>
                
                  <td>'.$datav['cusname'].'</td>
                 
                  <td>'.$datav['sales_date'].'</td>
                  <td>'.$datav['invoice_number'].'</td>
                
                  <td>'.$getmodedata[0]['name'].'</td>
               
                 
                 <td>'.number_format((float)$adamt
            ,2,'.', '').'</td>
                   <td>'.number_format((float)$delamt
            ,2,'.', '').'</td>
                 
                  <td>'.number_format((float)$netamt
            ,2,'.', '').'</td>
                  <td>'.$st1.'</td>
                </tr>';
                $sl++;
               if($adamt>0)
               {
                $adamt=$adamt;
               }
               else
               {
                $adamt=0;
               }

                $sumnetamount+=$netamt;
                $sumadamount+=$adamt;
                $sumdelamt+=$delamt;
                
        }
              $htmld.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                   
                   <th></th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th>'.number_format((float)$sumadamount
            ,2,'.', '').'</th>
                     <th>'.number_format((float)$sumdelamt
            ,2,'.', '').'</th>
                    
                    <th>'.number_format((float)$sumnetamount
            ,2,'.', '').'</th>
                    <th></th>
                  </tr>
                    <tr>
                        <td  colspan="9" align="right">Total Income:'.number_format((float)$sumadamount+$sumdelamt ,2,'.', '').'</td>
                    </tr>
                    <tr>
                        <td  colspan="9" align="right">Total Sale:'.number_format((float)$sumnetamount ,2,'.', '').'</td>
                    </tr>
                  ';

       $modedata=$this->Sales_report_model->getmodemodel($this->session->userdata('office_id'));
       foreach($modedata as $datva)
       {
           $moden=$datva['name'];
           $advancecashamountt=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount from sales_master inner join payment_details on sales_master.sales_id=payment_details.sales_id  inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id
        left join staff on sales_master.staff_id=staff.staff_id  where payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate' and  modeofpay.name='$moden'")->row();
          
             $htmld.='<tr>
                        <td colspan="9" align="right">'.$moden.':'.number_format((float)$advancecashamountt->advanced_amount ,2,'.', '').'</td>
                    </tr>';
                 

       }

                  $htmld.='</tbody>
                  </table>';
        
          
           
          }
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

 
   public function getdetailed()
    {
      error_reporting(0);
      $this->form_validation->set_rules('det_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
     
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_todate')))));
       
        $html='<table class="table table-bordered table-hover" style="width:100%;" id="example_det">
                    <thead>
                       <tr>
                       <th   style="text-align:center;background:#abffab;color:#abffab;">1</th>
                          <th   style="text-align:center;background:#abffab;"></th>
                          <th   style="text-align:center;background:#abffab;"></th>
                          <th   style="text-align:center;background:#abffab;">New Order</th>
                          <th   style="text-align:center;background:#abffab;"></th>
                          <th   style="text-align:center;background:#abffab;"></th>
                          <th   style="text-align:center;background:#abffab;"></th>
                          <th   style="text-align:center;background:#abffab;"></th>
                       </tr>
                       <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Order Date</th>
                         <th>Invoice Number</th>
                         <th>Expected Delivery Date</th>
                         <th>Total Amount</th>
                         <th>Discount Amount</th>
                         <th>Net Amount</th>
                       </tr>
                    </thead>
                    <tbody>';
                    $tot1=0;
                    $getresult=$this->Bill_order_report_model->getdetailedreportmodel($det_fromdate,$det_todate);
                    if($getresult)
                    {
                      $sl=1;
                      foreach($getresult as $datav)
                      {
                        $html.='<tr><td>'.$sl.'</td><td>'.$datav['cusname'].'</td><td>'.$datav['sales_date'].'</td><td>'.$datav['invoice_number'].'</td><td>'.$datav['expected_del_date'].'</td><td>'.$datav['total_amount'].'</td><td>'.number_format($datav['discount_amount'],2).'</td><td>'.$datav['netamount'].'</td></tr>';
                        $sl++;
                        $tot1+=$datav['netamount'];
                      }
                    }

                    $slll=$sl;
                  
                    $html.='<tr>
                    <th   style="text-align:center;color:#fff;">'.$slll.'</th>
                       <th   ></th>
                       <th  ></th>
                       <th  ></th>
                       <th  ></th>
                       <th  ></th>
                       <th   style="color:red;font:size:35px;"><b>Total:</b></th>
                       <th   style="color:red;font:size:35px;">'.number_format($tot1,2).'</th>
                    </tr>';
$slll=$slll+1;
$sllld=$slll+1;
                    $html.='
                       <tr>
                        <th   style="text-align:center;background:#ffff7f;color:#ffff7f;">'.$slll.'</th>
                        <th   style="text-align:center;background:#ffff7f;"></th>
                        <th   style="text-align:center;background:#ffff7f;"></th>
                        <th   style="text-align:center;background:#ffff7f;">Delivery Order</th>
                        <th   style="text-align:center;background:#ffff7f;"></th>
                        <th   style="text-align:center;background:#ffff7f;"></th>
                        <th   style="text-align:center;background:#ffff7f;"></th>
                        <th   style="text-align:center;background:#ffff7f;"></th>
                       </tr>
                       <tr>
                         <th style="color:#fff;">'.$sllld.'</th>
                         <th>Customer Name</th>
                         <th>Order Date</th>
                         <th>Invoice Number</th>
                         <th>Delivery Date</th>
                         <th></th>
                         <th>Delivery Amount</th>
                         <th>Net Amount</th>
                       </tr>
                    ';
                 $sllld=$sllld+1;
                 $tot2=0;
                    $getresult=$this->Bill_order_report_model->getdetailedreportmodel_deli($det_fromdate,$det_todate);
                    if($getresult)
                    {
                     
                      foreach($getresult as $datav)
                      {
                        $sales_id=$datav['sales_id'];
                        $getresults=$this->Bill_order_report_model->getdelpaymentt_dee($sales_id);
                        if($getresults)
                        {
                          $paydate=$getresults[0]['payment_date'];
                          $advanced_amount=$getresults[0]['advanced_amount'];
                        }
                        $html.='<tr><td>'.$sllld.'</td><td>'.$datav['cusname'].'</td><td>'.$datav['sales_date'].'</td><td>'.$datav['invoice_number'].'</td><td>'.$paydate.'</td><td></td><td>'.$advanced_amount.'</td><td>'.$datav['netamount'].'</td></tr>';
                        $sllld++;
                        $tot2+=$datav['netamount'];
                      }
                    }

                    $html.='<tr>
                    <th   style="text-align:center;color:#fff;">'.$sllld.'</th>
                       <th   ></th>
                       <th  ></th>
                       <th  ></th>
                       <th  ></th>
                       <th  ></th>
                       <th   style="color:red;font:size:35px;"><b>Total:</b></th>
                       <th   style="color:red;font:size:35px;">'.number_format($tot2,2).'</th>
                    </tr>';
                    $html.=' </tbody></table>';
        

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


   public function getlensreport()
    {
      error_reporting(0);
      $this->form_validation->set_rules('len_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('len_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('len_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
      $this->form_validation->set_rules('len_lens', 'Lens', 'trim|min_length[1]|max_length[20]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $len_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('len_fromdate')))));
        $len_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('len_todate')))));
        $len_customer=trim(htmlentities($this->input->post('len_customer')));
        $len_modeofpay=trim(htmlentities($this->input->post('len_modeofpay')));
        $len_item=trim(htmlentities($this->input->post('len_item')));
        $len_lens=trim(htmlentities($this->input->post('len_lens')));
     $getresult=$this->Sales_report_model->getlensreportmodel($len_fromdate,$len_todate,$len_customer,$len_modeofpay,$this->session->userdata('office_id'),$len_item,$len_lens);
      if($getresult)
      {
        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_len">
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
                         <th>Item Type</th>
                         <th>Lens Type</th>
                         <th>Lens Coating</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        foreach ($getresult as $data) {

              $protype="Lens";
              $lens_array=array($data['stock_id'],$this->session->userdata('office_id'));
              $getresultlenstype=$this->Common_model->GetLenstypeData($lens_array);
              $getresultlenstype=$getresultlenstype[0]['lenstype'];
              $getresultlenscoating=$this->Common_model->GetLenscoatingData($lens_array);
              $getresultlenscoating=$getresultlenscoating[0]['lenscoating'];
              $getresultlens=$this->Common_model->GetLensData($lens_array);
              $itemcode=$getresultlens[0]['code'];
              $itemname=$getresultlens[0]['name'];
           
            
          
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$itemcode.'</td>
                  <td>'.$itemname.'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.$data['rate'].'</td>
                  <td>'.number_format((float)$data['total_amount'] ,2,'.', '').'</td>
                  <td>'.$protype.'</td>
                  <td>'.$getresultlenstype.'</td>
                  <td>'.$getresultlenscoating.'</td>
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
                    <th>Total</th>
                    <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
                    <th></th>
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

   public function getprofit()
    {
      error_reporting(0);
      $this->form_validation->set_rules('profit_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('profit_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
      $this->form_validation->set_rules('det_lens', 'Lens', 'trim|min_length[1]|max_length[20]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('profit_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('profit_todate')))));
        $det_customer=trim(htmlentities($this->input->post('det_customer')));
        $det_modeofpay=trim(htmlentities($this->input->post('det_modeofpay')));
        $det_item=trim(htmlentities($this->input->post('det_item')));
        $det_lens=trim(htmlentities($this->input->post('det_lens')));
        $det_category=trim(htmlentities($this->input->post('det_category')));
     $getresult=$this->Sales_report_model->getdetailedreportmodel($det_fromdate,$det_todate,$det_customer,$det_modeofpay,$this->session->userdata('office_id'),$det_item,$det_lens,$det_category);
      if($getresult)
      {
        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_profit">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Item Code</th>
                         <th>Item Name</th>
                         <th>Quantity</th>
                         <th>Cost price</th>
                          <th>MRP</th>
                         <th style="background: antiquewhite;">CP-MRP=PROFIT</th>
                         <th>Selling Price</th>
                         
                        
                         <th>Total</th>
                         <th>Item Type</th>
                         <th>Frame Type</th>
                         <th>Frame Color</th>
                         <th>Frame Size</th>
                         <th>Frame Model</th>
                       
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        foreach ($getresult as $data) {
            if($data['product_type']==0)
            {
              $protype="Frame";
              $frametype_array=array($data['frame_type'],$this->session->userdata('office_id'));
              $frame_type=$this->Common_model->GetframeclassficationData($frametype_array);
              $frame_type=$frame_type[0]['name'];
              $framecolor_array=array($data['frame_color'],$this->session->userdata('office_id'));
              $frame_color=$this->Common_model->GetframeclassficationData($framecolor_array);
              $frame_color=$frame_color[0]['name'];
              $framesize_array=array($data['frame_size'],$this->session->userdata('office_id'));
              $frame_size=$this->Common_model->GetframeclassficationData($framesize_array);
              $frame_size=$frame_size[0]['name'];
              $getresultlenscoating='';
              $getresultlenstype='';
              $itemcode=$data['itemcode'];
              $itemname=$data['itemname'];
              $framemodel=$data['frame_model'];
              $item_id=$data['item_id'];
              $cp='';
              $get_dett_AMt=$this->Sales_report_model->Get_Purchasedetails_price_Details($item_id,$data['selling_price'],$data['mrp'],$framemodel);
              if($get_dett_AMt)
              {
                $cp=$get_dett_AMt[0]['cost_price'];
              }
           $totpro=$data['mrp']-$cp;
          
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$itemcode.'</td>
                  <td>'.$itemname.'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.$cp.'</td>
                   <td>'.$data['mrp'].'</td>
                  <td style="background: antiquewhite;">'.$totpro.'</td>
                  <td>'.$data['selling_price'].'</td>
                 
                  <td>'.number_format((float)$data['total_amount'] ,2,'.', '').'</td>
                  <td>'.$protype.'</td>
                  <td>'.$frame_type.'</td>
                  <td>'.$frame_color.'</td>
                  <td>'.$frame_size.'</td>
                  <td>'.$framemodel.'</td>
                 
                </tr>';
                $sl++;
                $sumnetamount+=$data['total_amount'];
            }
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
                    <th>Total</th>
                    <th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
                    <th></th>
                    <th></th>
                    <th></th>
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
