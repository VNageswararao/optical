<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Counter_sales extends CI_Controller {
  private $msg;
  private $error;
  private $error_message;
  private $randval;
  public function __construct() {
        parent::__construct();
        error_reporting(0);
        if (!isset($this->session->optical_login))

         {
      redirect('login');
         }
        
        $this->load->model('Counter_sales_model');
       $this->load->model('Common_model');
       $this->load->model('Profile_model');
    }
  public function index()
  {
          $data['title']='Optical::Counter_sales';
          $data['activecls']='Counter_sales';
          $office_id=$this->session->office_id;
          $var_array=array($office_id);
          $data['category']=$this->Common_model->getcategory($var_array);
          $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
          $data['getcustomer']=$this->Common_model->getcustomerdata($var_array);
          $data['getcustomerCounter_sales']=$this->Counter_sales_model->getcustomerCounter_salesdata($var_array);
          $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
          $data['getstaff']=$this->Common_model->GetStaffData($var_array);
          $content=$this->load->view('transaction/counter/insert',$data,true);
        $this->load->view('includes/layout',['content'=>$content]);
  }
   public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Counter_sales_model->ajax_call($param);
           echo json_encode($response);
    }
    public function smsgateway($mobileno,$temp_id,$msg)
  {
    $mobileno = str_replace('-', '', $mobileno);
		$url='https://fastsms.expressad.in/api/v1/send-sms?api-key=BJpscIwYy17oWb0xZT4jcl2PZb3YoB7Z2ITdb3EZ&sender-id=DEYEHP&sms-type=1&mobile='.$mobileno.'&te_id='.$temp_id.'&message='.$msg.'';
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL =>$url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    if ($err) {
    //echo "cURL Error #:" . $err;
    } else {
    //echo $response;
    }
    //exit;
  }
      public function getlastidcustomercountno()
  {
        $office_id=$this->session->office_id;
        $var_array=array($office_id);
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
          if($code)
          {

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $code
                ));
                  exit;
          }
          else
          {
              $this->msg='';
              $this->error='Network Issue';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message
                ));
                  exit;
          }
        
   
  }
    public function getlastidcustomer()
  {
        $office_id=$this->session->office_id;
        $var_array=array($office_id);
        $getresult=$this->Counter_sales_model->Getlastidcustomer($var_array);
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
              $this->error='No Customers Found';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message
                ));
                  exit;
          }
        
   
  }
   public function Showcustomername()
  {
        $office_id=$this->session->office_id;
        $var_array=array($office_id);
        $getresult=$this->Common_model->getcustomerdata($var_array);
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
              $this->error='No Customers Found';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message
                ));
                  exit;
          }
        
   
  }
  public function print_Counter_sales() 
  {
      $this->Counter_sales_model->print_bill($this->input->post('data_generatebill'),$this->session->userdata('office_id'));
  }
  public function getstatuscon()
  {
      $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[10]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $status=trim(htmlentities($this->input->post('status')));
        $var_array=array($status,$this->session->userdata('office_id'));
        
          $getresult=$this->Counter_sales_model->Getstatusdata($status,$this->session->userdata('office_id'));
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

  public function getcustomer()
  {
      $this->form_validation->set_rules('customer_id', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $customer_id=trim(htmlentities($this->input->post('customer_id')));
        $var_array=array($customer_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Common_model->checkcustomer($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Common_model->Getcustomerdataind($var_array);
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

  public function getcustomerdata()
  {
      $this->form_validation->set_rules('getid', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $Counter_sales_id=trim(htmlentities($this->input->post('getid')));
        $var_array=array($Counter_sales_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Counter_sales_model->deletecheckCounter_salesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $var_arrayy=array($this->session->userdata('office_id'));
          $getofficedata=$this->Profile_model->getprofile($var_arrayy);
          $getresult=$this->Counter_sales_model->GetcustomerdataindCounter_sales($var_array);
          $getpaidamount=$this->Counter_sales_model->getpaidamount($var_array);
          $getstatus=$this->Counter_sales_model->Getmastertable($var_array);
          if($getresult)
          {
             if($getofficedata)
             {
              $img=$getofficedata[0]['logo'];
             }
             else
             {
              $img='';
             }
             $date=date_create($getresult[0]['Counter_sales_date']);
             $Counter_sales_date=date_format($date,"d/m/Y");
             $expected_del_date=date_create($getresult[0]['expected_del_date']);
             $expected_del_date=date_format($expected_del_date,"d/m/Y");
              $headersection='';
            $office_id=$this->session->office_id;
            $var_array=array($office_id);
            $modeofpay=$this->Common_model->GetModeofpayData($var_array);
            if($modeofpay)
            {
              $sv='<select class="form-control" name="pay_mode" id="pay_mode">';
              foreach ($modeofpay as $data) {
                $sv.='<option value="'.$data['modeofpay_id'].'">'.$data['name'].'</option>';
              }
              $sv.='</select>';
            }
             $print='<button onclick="printsale('.$getresult[0]['Counter_sales_id'].')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';
              $bal_due=$getresult[0]['netamount']-$getpaidamount[0]['advanced_amount'];
              $headersection.='<div class="row"><div class="col-md-11"></div><div class="col-md-1">'.$print.'</div></div><div id="invoice-company-details" class="row">
                                <input type="hidden" id="st_customer" value="'.$getresult[0]['customer_id'].'">
                                  <div class="col-sm-6 col-12 text-center text-sm-left">
                                    <div class="media row">
                                      <div class="col-12 col-sm-3 col-xl-2">';
                                      if($img){
                                        $headersection.='<img style="width:100%;" src="'.base_url("images/profile/$img").'">';
                                      }
                                      $headersection.='</div>
                                      <div class="col-12 col-sm-9 col-xl-10">
                                        <div class="media-body">
                                          <ul class="ml-2 px-0 list-unstyled">
                                            <li class="text-bold-800">'.$getofficedata[0]['printable_company_name'].'</li>
                                            <li>'.$getofficedata[0]['printable_company_address'].'</li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6 col-12 text-center text-sm-right">
                                    <h2>INVOICE</h2>
                                    <p class="pb-sm-3"># '.$getresult[0]['invoice_number'].'</p>
                                    <ul class="px-0 list-unstyled">
                                      <li>Balance Due</li>
                                      <li class="lead text-bold-800"><i class="la la-inr"></i>'.$bal_due.'</li>
                                    </ul>
                                  </div>
                                </div>
                                  <div id="invoice-customer-details" class="row pt-2">
                                          <div class="col-12 text-center text-sm-left">
                                            <p class="text-muted">Bill To</p>
                                          </div>
                                          <div class="col-sm-6 col-12 text-center text-sm-left">
                                            <ul class="px-0 list-unstyled">
                                              <li class="text-bold-800">Mr. '.$getresult[0]['name'].'</li>
                                              <li>'.$getresult[0]['mobile'].'</li>
                                              <li>'.$getresult[0]['address'].'</li>
                                            </ul>
                                          </div>
                                          <div class="col-sm-6 col-12 text-center text-sm-right">
                                            <p><span class="text-muted">Invoice Date :</span> '.$Counter_sales_date.'</p>
                                            <p><span class="text-muted">Terms :</span> Due on Receipt</p>
                                            <p><span class="text-muted">Due Date :</span> '.$expected_del_date.'</p>
                                          </div>
                                        </div>

                                        <div id="invoice-items-details" class="pt-2">
      <div class="row">
        <div class="table-responsive col-12">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Item Name</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Amount</th>
              </tr>
            </thead>
            <tbody>';

          $var_array_child=array($getresult[0]['Counter_sales_id']);
          $getallclassfication=$this->Counter_sales_model->getallclassfication($var_array_child);
          $sl=1;
          $ggg='<tr class="bg-grey bg-lighten-4">
                  <td class="text-bold-800" style="width:100%;">Dis Amt</td>
                  <td class="text-bold-800 text-right">
                    <input type="hidden" name="olddisper" id="olddisper"  class="form-control grid_table" value"'.$getresult[0]['discount_percentage'].'">
                    <input type="hidden" name="olddisamt" id="olddisamt"  class="form-control grid_table" value"'.$getresult[0]['discount_amount'].'">
                    <input type="hidden" name="disper" id="disper"  class="form-control grid_table" onkeyup="ffind_discount_percentage();stcalcnet();">
                    <input type="text" name="disamt" id="disamt"  class="form-control grid_table" onkeyup="ffind_discount_percentage();stcalcnet();">
                    </td>
                </tr>';
          // $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
          //   $ggg='';
          //   if($host_tvm=='opticaltesting')
          //   {
              
          //   }
          if($getallclassfication)
          {
            
            foreach ($getallclassfication as $data) {
              
                 $headersection.='<tr>
                    <th scope="row">'.$sl.'</th>
                    <td>
                      <p>'.$data['name'].'</p>
                    </td>
                    <td class="text-right">'.number_format((float)$data['rate']
            ,2,'.', '').'</td>
                    <td class="text-right">'.$data['quantity'].'</td>
                    <td class="text-right">'.number_format((float)$data['total_amount']
            ,2,'.', '').'</td>
                  </tr>';
                  $sl++;
            }
          }
          
          $getlensmasterdata=$this->Counter_sales_model->Getlenstable($var_array_child);
          if($getlensmasterdata)
          {
            foreach ($getlensmasterdata as $data) {
                 $headersection.='<tr>
                    <th scope="row">'.$sl.'</th>
                    <td>
                      <p>'.$data['name'].'</p>
                    </td>
                    <td class="text-right">'.number_format((float)$data['rate']
            ,2,'.', '').'</td>
                    <td class="text-right">'.$data['quantity'].'</td>
                    <td class="text-right">'.number_format((float)$data['total_amount']
            ,2,'.', '').'</td>
                  </tr>';
                  $sl++;
            }
          }
          
             if($getstatus[0]['status']==1)
             {
              $status="<p style='color:red;font-weight:bold;font-size: 35px;'>Inprogress</p><br/><br/><i class='la la-tick'></i>";
             }
             elseif ($getstatus[0]['status']==3) {
               $status="<p style='color:yellow;font-weight:bold;font-size: 35px;'>Ready To Delivery</p><br/><br/><i class='la la-tick'></i>";
             }
             else
             {
               $status="<p style='color:green;font-weight:bold;font-size: 35px;'>Delivered</p>";
             }
              $headersection.='</tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-7 col-12 text-center text-sm-left">
          <p class="lead">Status:'.$status.'</p>
          <div class="row">
            <div class="col-sm-8">
             
            </div>
          </div>
        </div>
        <div class="col-sm-5 col-12">
          <p class="lead">Total due</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td class="text-bold-800">Grand Total</td>
                  <td class="text-bold-800 text-right"><i class="la la-inr"></i> '.number_format((float)$getresult[0]['netamount']
            ,2,'.', '').'</td>
                </tr>
                <tr>
                  <td>Payment Made</td>
                  <td class="pink text-right">(-) <i class="la la-inr"></i>'.number_format((float)$getpaidamount[0]['advanced_amount']
            ,2,'.', '').'</td>
                </tr>
                <tr class="bg-grey bg-lighten-4">
                  <td class="text-bold-800">Balance Due</td>
                  <td class="text-bold-800 text-right"><i class="la la-inr"></i>'.number_format((float)$bal_due
            ,2,'.', '').'</td>
                </tr>
               ';
                if($getstatus[0]['status']==1 || $getstatus[0]['status']==3)
                {
                 $headersection.=' <tr class="bg-grey bg-lighten-4">
                  <td class="text-bold-800">Status</td>
                  <td class="text-bold-800 text-right"><select class="form-control" name="status_cus" id="status_cus"><option value="1">Inprogress</option><option value="2">Delivered</option></select></td>
                  '.$ggg.'
                </tr><tr class="bg-grey bg-lighten-4">
                  <td class="text-bold-800" style="width:100%;">Pay Due</td>
                  <td class="text-bold-800 text-right"><input type="hidden" name="payhide" id="payhide" value="'.number_format((float)$bal_due
            ,2,'.', '').'" class="form-control grid_table"><input type="text" name="pay" id="pay" value="'.number_format((float)$bal_due
            ,2,'.', '').'" class="form-control grid_table"></td>

                 
                </tr>

              <tr class="bg-grey bg-lighten-4">
                  <td class="text-bold-800" style="width:100%;">Modeofpay</td>
                  <td class="text-bold-800 text-right">'.$sv.'</td>
                  
                 
                </tr>
                ';
              }
                 
              $headersection.='</tbody>
            </table>
            <input type="hidden" id="Counter_sales_idcus" value="'.$getresult[0]['Counter_sales_id'].'">
            <input type="hidden" id="customer_idcus"  value="'.$getresult[0]['customer_id'].'">
            <input type="hidden" id="netamount_idcus"  value="'.$getresult[0]['netamount'].'">';
             if($getstatus[0]['status']==1 || $getstatus[0]['status']==3)
                {
                  $headersection.='<button class="btn mr-1 mb-1 btn-danger" style="float: right;" onclick="payamount()">Pay Amount</button>';
                }
          $headersection.='</div>
        
        </div>
      </div>
    </div>';

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
  public function Counter_sales_search_stock_by_barcode()
  {
      $this->form_validation->set_rules('barcode', 'barcode', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('barcode')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Counter_sales_model->getbarcode($product,$this->session->userdata('office_id'));
       // print_r($getresult);exit;
          if($getresult)
          {

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $getresult[0]['name']
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

  public function Counter_sales_search_stock_by_framemodel()
  {
      $this->form_validation->set_rules('framemodel', 'framemodel', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('framemodel')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Counter_sales_model->getframemodel($product,$this->session->userdata('office_id'));
       // print_r($getresult);exit;
          if($getresult)
          {

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $getresult[0]['name']
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

  public function Counter_sales_search_stock()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Counter_sales_model->getCounter_salesSearchStock($product,$this->session->userdata('office_id'));
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
  public function Counter_sales_search_stock_framemodel()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $framemodel=trim(htmlentities($this->input->post('framemodel')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Counter_sales_model->getCounter_salesSearchStock_framemodel($product,$framemodel,$this->session->userdata('office_id'));
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
  public function Counter_sales_search_stock_barcode()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $barcode=trim(htmlentities($this->input->post('barcode')));
        $var_array=array($product,$barcode,$this->session->userdata('office_id'));
        $getresult=$this->Counter_sales_model->getCounter_salesSearchStock_barcode($product,$barcode,$this->session->userdata('office_id'));
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

  public function Counter_sales_search_lens()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $supplier_id=trim(htmlentities($this->input->post('supplier_id')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Counter_sales_model->getCounter_salesSearchLens($product,$supplier_id,$this->session->userdata('office_id'));
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
              $this->error='No Product Found';
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
      public function fetch_data() 
       {
           
           $office_id=$this->session->office_id;
           $return=array(
               "Counter_sales"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "sales_date"=>date('Y-m-d',strtotime($this->input->post('Counter_sales_date'))),
                   "sales_time"=>($this->input->post('pe_time'))?$this->input->post('Counter_sales_time'):date('H:i:s'),
                   "customer_id"=>$this->input->post('customer_id'),
                   'total_qty'=>$this->input->post('total_qty'),
                   'total_cgst'=>$this->input->post('total_cgst'),
                   'total_sgst'=>$this->input->post('total_sgst'),
                   'supplier_id'=>$this->input->post('supplier_id'),
                   'total_amount'=>$this->input->post('total_amount'),
                   'discount_amount'=>$this->input->post('total_discount_amount'),
                   'discount_percentage'=>$this->input->post('total_discount_percentage'),
                   'other_charge'=>$this->input->post('other_charge'),
                   'advanced_amount'=>$this->input->post('paying_amount'),
                   'balance_amount'=>$this->input->post('balance_amount'),
                   'roundoff'=>$this->input->post('roundoff'),
                   'netamount'=>$this->input->post('invoice_amount'),
                   'modeofpay_id'=>$this->input->post('modeofpay_id'),
                   'staff_id'=>$this->input->post('staff_id'),
                   'description'=>$this->input->post('sdescription'),
                   'cash'=>$this->input->post('cash_billing'),

                   'card'=>$this->input->post('card_billing'),

                   'paytm'=>$this->input->post('paytm_billing'),

                   'others'=>$this->input->post('others_billing'),
                   'expected_del_date'=>date('Y-m-d',strtotime($this->input->post('edate'))),
                   'status'=>$this->input->post('bill_status'),
                   'office_id'=> $office_id
               ),
             "Counter_sales_detail"=>array(
                 "product_type"=>$this->input->post('product_type'),
                 "item_id"=>$this->input->post('product_id'),
                 "rate"=>$this->input->post('selling_price'),
                 "orginal_rate"=>$this->input->post('original_selling_price'),
                 "quantity"=>$this->input->post('quantity'),
                 "discount_type"=>$this->input->post('discount_type'),
                 "discount_input"=>$this->input->post('discount_input'),
                 "discount_amount"=>$this->input->post('discount_value'),
                 "total_amount"=>$this->input->post('amount'),
                 "tax_type"=>$this->input->post('tax_type'),
                 "tax"=>$this->input->post('gst'),
                 "cgst"=>$this->input->post('cgst'),
                 "sgst"=>$this->input->post('sgst'),
                 "stock_id"=>$this->input->post('stock_id'),
                 "tax_amount"=>$this->input->post('tax_amount')
             )
             
           
           );
            return $return;
       }
       public function getopticaladvice()
       {
             $opaddate=$this->input->post('opticaladvice_date1');
             $opaddate2=$this->input->post('opticaladvice_date2');
             if($opaddate)
             {
                $opening_date = $opaddate;
                $current_date = '2022-09-21';

                if ($opening_date > $current_date) {
                   $opdate=$opening_date;
                }
                else {
                  $opdate='';
                }
               
            
                $getresult=$this->Counter_sales_model->getopticaladvicedata($opdate,$opaddate2);
                if($getresult)
                {
                  $html='<table id="opadv" class="table table-bordered table-hover"><thead><tr><th>SL NO</th><th>Patient Name</th><th>MRD NO</th><th>Mobile No</th><th>Address</th><th>Optical Advice Date</th><th>Print</th></tr></thead><tbody>';
                  $sl=1;
                  $exid='';
                  foreach ($getresult as $datr) {
                    $getresultdata=$this->Counter_sales_model->getlastemrexaminationid($datr['patient_registration_id']);
                    if($getresultdata)
                    {
                      $exid=$getresultdata[0]['examination_id'];
                    }
                    $print='<button onclick="examinationprint('.$exid.')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';
                    $html.='<tr><td>'.$sl.'</td><td>'.$datr['fname'].' '.$datr['lname'].'</td><td>'.$datr['mrdno'].'</td><td>'.$datr['mobileno'].'</td><td>'.$datr['address'].'</td><td>'.$datr['opticaladvice_date'].'</td><td>'.$print.'</td></tr>';
                    $sl++;
                  }
                  echo json_encode(array('msg'=>$html,'error'=>'','error_message' =>''));
                }
                else {
                  echo json_encode(array('msg'=>'No Data Found','error'=>'No data found','error_message' =>''));
                }
             }
             else {
                echo json_encode(array('msg'=>'failed','error'=>'Please select Date','error_message' =>''));
             }
             
       }
       public function examinationprint()
    {
       
        $this->Counter_sales_model->examination_print_bill($this->input->post('examinationid'),$this->input->post('chkcomplaintsout'),$this->input->post('chkopthalmicsout'),$this->input->post('chkmedicalout'),$this->input->post('chkeyepartout'),$this->input->post('addmedicinessout'),$this->input->post('investigationchkout'),$this->input->post('preliminary_exout'),$this->input->post('vsisonreadingsout'),$this->input->post('curspecout'),$this->input->post('objectchkout'),$this->input->post('arkkchkout'),$this->input->post('manchkout'),$this->input->post('specchkout'),$this->input->post('conlchkout'),$this->input->post('pmtchkout'),$this->session->userdata('office_id'));
    }

   public function saveCounter_salesentry()
  {
    $this->form_validation->set_rules('customer_id', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total qty', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('bill_status', 'Bill Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'trim|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('quantity[]', 'quantity', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('selling_price[]', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    
      
      if($this->form_validation->run() == TRUE)
      {
          $data=$this->fetch_data();
          $getresult=$this->Counter_sales_model->savedata($data);
          if($getresult)
          {
           $counter_sales_id=$this->db->select('max(counter_sales_id) as counter_sales_id')
                         ->from('counter_sales_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->counter_sales_id;
                if($counter_sales_id>0)
                {
                    $counter_sales_id=$counter_sales_id;
                } else {
                    $counter_sales_id= $counter_sales_id;
                }
               // echo $counter_sales_id;exit;
              $this->msg='Saved Successfully';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'Counter_sales_id'=>$counter_sales_id,
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
        $frame_array=array($this->session->userdata('office_id'));
        $var_framearray=array($getid);
        $chk_duplication=$this->Counter_sales_model->deletecheckCounter_salesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $html='';
          $var_array_child=array($getid);
          $getmasterdata=$this->Counter_sales_model->Getmastertable($var_array);
          $getallclassfication=$this->Counter_sales_model->getallclassfication($var_array_child);
          $sl=1;
          if($getallclassfication)
          {
              foreach ($getallclassfication as $data) {
                  
                  $bg='style="background:#a4ffde;"';
                  $stockin='<td><input type="text" name="stock[]" id="stock_'.$sl.'" readonly="" class="form-control grid_table"  value="'.$data['stock'].'"></td>';
                  $itemclassfn='<td>'.$data['frametype'].'</td>
                                <td>'.$data['framecolor'].'</td>
                                <td>'.$data['framesize'].'</td>
                                <td>'.$data['framemodel'].'</td><td></td><td></td>
                                ';
                  $name=$data['name'];
                  $code=$data['code'];
                  $tseln='';
                  $tseli='';
                  $tselnon='';
                  if($data['tax_type']==0)
                  {
                    $tseln='selected';
                  }
                  if($data['tax_type']==1)
                  {
                    $tseli='selected';
                  }
                  if($data['tax_type']==2)
                  {
                    $tselnon='selected';
                  }
                  $taxsec='<td class="mbl_view" style="display: none;">
                     <select name="tax_type[]" id="tax_type_'.$sl.'" style="font-size:12px" class="form-control grid_table disabled_select"><option value="0"  '.$tseln.'>Non Tax</option><option value="1" '.$tseli.'>Inclusive</option><option value="2"  '.$tselnon.'>Exclusive</option>
                     </select></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'.$sl.'" readonly="" value="'.$data['tax'].'"></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="cgst[]" id="cgst_'.$sl.'" readonly="" value="'.$data['cgst'].'"></td>
                   <td style="display: none;" class="vat mbl_view"><input type="text" class="form-control grid_table" name="sgst[]" id="sgst_'.$sl.'" readonly="" value="'.$data['sgst'].'" ></td>';
               
               
                $html.='<tr '.$bg.'>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td>'.$code.'</td>
                         <td><b>'.$name.'</b><input type="hidden" value="'.$name.'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$sl.'" value="'.$data['orginal_rate'].'"></td>
                         '.$stockin.'
                         <td><input type="text" name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))" ></td>
                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)"  required  autocomplete="off"></td>
                          '.$itemclassfn.'
                          <td class="mbl_view">
                         <select name="discount_type[]" id="discount_type_'.$sl.'" class="form-control grid_table" onchange="calcrow('.$sl.')">
                           <option value="0">Amount</option>
                           <option value="1">Percentage</option>
                           </select>
                          </td>
                           <td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onKeyUp="calcrow('.$sl.')" id="discount_input_'.$sl.'" value="'.$data['discount_input'].'" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))">
                      <input type="hidden" name="discount_amount[]" value="'.$data['discount_value'].'" id="discount_amount_'.$sl.'"></td>
                      <td>
                        <input name="amount[]" id="amount_'.$sl.'" class="form-control grid_table" value="'.$data['total_amount'].'" readonly="">
                     </td>
                     '.$taxsec.'
                         <td style="display:none">
                         <input type="hidden" name="stock_id[]" id="stock_id_'.$sl.'" value="'.$data['stock_id'].'">
                         <input type="hidden" name="product_id[]" id="product_id_'.$sl.'" value="'.$data['item_id'].'">
                         <input type="hidden" name="tax_amount[]" id="tax_amount_'.$sl.'" value="'.$data['tax_amount'].'">
                         <input type="hidden" name="product_type[]" id="product_type_'.$sl.'" value="'.$data['product_type'].'">
                       </td>
                         </tr>';
                         $sl++;
              }
            }
              //print_r($getlensmasterdata);exit;
              $getlensmasterdata=$this->Counter_sales_model->Getlenstable($var_array_child);
              if($getlensmasterdata)
              {
                foreach ($getlensmasterdata as $data) {
                    
                  
                  $bg='style="background:#ffedb8;"';
                  $stockin='<td><input type="hidden" name="stock[]" id="stock_'.$sl.'" readonly="" class="form-control grid_table" ></td>';
                  $itemclassfn='<td></td>
                                <td></td>
                                <td></td>
                                <td></td><td>'.$getlensmasterdata[0]['lens_type'].'</td><td>'.$getlensmasterdata[0]['lens_coating'].'</td>';
                  $name=$data['name'];
                  $code=$data['code'];

                   $tseln='';
                  $tseli='';
                  $tselnon='';
                  if($data['tax_type']==0)
                  {
                    $tseln='selected';
                  }
                  if($data['tax_type']==1)
                  {
                    $tseli='selected';
                  }
                  if($data['tax_type']==2)
                  {
                    $tselnon='selected';
                  }
                  $taxsec='<td class="mbl_view" style="display: none;">
                     <select name="tax_type[]" id="tax_type_'.$sl.'" style="font-size:12px" class="form-control grid_table disabled_select"><option value="0"  '.$tseln.'>Non Tax</option><option value="1" '.$tseli.'>Inclusive</option><option value="2"  '.$tselnon.'>Exclusive</option>
                     </select></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'.$sl.'" readonly="" value="'.$data['tax'].'"></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="cgst[]" id="cgst_'.$sl.'" readonly="" value="'.$data['cgst'].'"></td>
                   <td style="display: none;" class="vat mbl_view"><input type="text" class="form-control grid_table" name="sgst[]" id="sgst_'.$sl.'" readonly="" value="'.$data['sgst'].'" ></td>';

                    $html.='<tr '.$bg.'>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td>'.$code.'</td>
                         <td><b>'.$name.'</b><input type="hidden" value="'.$name.'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$sl.'" value="'.$data['orginal_rate'].'"></td>
                         '.$stockin.'
                         <td><input type="text" name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))" ></td>
                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)"  required  autocomplete="off"></td>
                          '.$itemclassfn.'
                          <td class="mbl_view">
                         <select name="discount_type[]" id="discount_type_'.$sl.'" class="form-control grid_table" onchange="calcrow('.$sl.')">
                           <option value="0">Amount</option>
                           <option value="1">Percentage</option>
                           </select>
                          </td>
                           <td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onKeyUp="calcrow('.$sl.')" id="discount_input_'.$sl.'" value="'.$data['discount_input'].'" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))">
                      <input type="hidden" name="discount_amount[]" value="'.$data['discount_value'].'" id="discount_amount_'.$sl.'"></td>
                      <td>
                        <input name="amount[]" id="amount_'.$sl.'" class="form-control grid_table" value="'.$data['total_amount'].'" readonly="">
                     </td>
                     '.$taxsec.'
                         <td style="display:none">
                         <input type="hidden" name="stock_id[]" id="stock_id_'.$sl.'" value="'.$data['stock_id'].'">
                         <input type="hidden" name="product_id[]" id="product_id_'.$sl.'" value="'.$data['item_id'].'">
                         <input type="hidden" name="tax_amount[]" id="tax_amount_'.$sl.'" value="'.$data['tax_amount'].'">
                         <input type="hidden" name="product_type[]" id="product_type_'.$sl.'" value="'.$data['product_type'].'">
                       </td>
                         </tr>';
                         $sl++;

                }
              }

          
            
          
          if($getmasterdata)
          {
              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getmasterdata' => $getmasterdata,
                  'numrows' => $sl,
                  'getchilddata' => $html
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
 public function deleteCounter_salesentry()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_Counter_salesid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_Counter_salesid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Counter_sales_model->deletecheckCounter_salesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Counter_sales_model->deletedata($delete_Counter_salesid);
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
  public function readytodelivery()
  {
    $this->form_validation->set_rules('id', 'Ready To Delivery ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_Counter_salesid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_Counter_salesid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Counter_sales_model->deletecheckCounter_salesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Counter_sales_model->updatereadutodelivery($delete_Counter_salesid);
          if($getresult)
          {
            $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
            if($host_tvm=='dehoptical')
            {
           
              $tempid='1407165771314881328';

               $customer_id=$this->db->select('customer_id')
                         ->from('Counter_sales_master')
                         ->where(array('Counter_sales_id'=>$delete_Counter_salesid))
                         ->get()->row()->customer_id;

                         $invoice_number=$this->db->select('invoice_number')
                         ->from('Counter_sales_master')
                         ->where(array('Counter_sales_id'=>$delete_Counter_salesid))
                         ->get()->row()->invoice_number;

              $mobileno=$this->db->select('mobile')
                         ->from('customer')
                         ->where(array('customer_id'=>$customer_id))
                         ->get()->row()->mobile;

                 $name=$this->db->select('name')
                         ->from('customer')
                         ->where(array('customer_id'=>$customer_id))
                         ->get()->row()->name;

               $msg=urlencode('Dear Sir / Madam Name '.$name.' Order No '.$invoice_number.' Your Spectacles are ready Please come and collect. DEYEHP');
            
             
               if($mobileno)
               {
                 $this->smsgateway($mobileno,$tempid,$msg);
               }
               
            }

              $this->msg='Ready To Delivery Successfully';
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
              $this->error='Failed  Ready To Delivery';
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
            $this->error='Ready To Delivery ID Not Found';
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
  public function editCounter_salesentry()
  {
    $this->form_validation->set_rules('edit_Counter_sales_id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
   $this->form_validation->set_rules('customer_id', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric');
  
   $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total qty', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay ID', 'trim|required|min_length[1]|max_length[100]|numeric');
  
    $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('quantity[]', 'quantity', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('selling_price[]', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
   
      if($this->form_validation->run() == TRUE)
      {
        $edit_Counter_sales_id=trim(htmlentities($this->input->post('edit_Counter_sales_id')));
        $var_array=array($edit_Counter_sales_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Counter_sales_model->deletecheckCounter_salesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $data=$this->fetch_data();
          $getresult=$this->Counter_sales_model->updatedata($data,$edit_Counter_sales_id);
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

  public function payamount()
  {
      error_reporting(0);
    $this->form_validation->set_rules('Counter_sales_id', 'Counter_sales ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('payamount', 'Payment Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('customer_id', 'Customer', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('netamount', 'Net Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('pay_mode', 'Modeofpay', 'trim|required|min_length[1]|max_length[100]|numeric');
    if($this->form_validation->run() == TRUE)
      {
        $Counter_sales_id=trim(htmlentities($this->input->post('Counter_sales_id')));
        $payamount=trim(htmlentities($this->input->post('payamount')));
        $status=trim(htmlentities($this->input->post('status')));
        $netamount=trim(htmlentities($this->input->post('netamount')));
        $customer_id=trim(htmlentities($this->input->post('customer_id')));
        $mode_id=trim(htmlentities($this->input->post('pay_mode')));
        $var_array=array($Counter_sales_id,$this->session->userdata('office_id'));
        $var_arrayy=array($Counter_sales_id);

        $getresultdis=$this->Counter_sales_model->GetcustomerdataindCounter_saless($var_arrayy);
        //print_r($getresultdis);exit;
        if($getresultdis[0]['discount_amount'])
        {
          $disamtt=$getresultdis[0]['discount_amount'];
        }
        else
        {
          $disamtt=0;
        }
        if($getresultdis[0]['discount_percentage'])
        {
          $disperr=$getresultdis[0]['discount_percentage'];
        }
        else
        {
          $disperr=0;
        }
        $olddisamt=$disamtt;
        $olddisper=$disperr;
        if(trim(htmlentities($this->input->post('disamt')))>0)
        {
          $didd=trim(htmlentities($this->input->post('disamt')));
        }
        else
        {
          $didd=0;
        }
        $disamt=$didd+$olddisamt;
        if($this->input->post('disper'))
        {
          $diss=$this->input->post('disper');
        }
        else
        {
          $diss=0;
        }
        $disper=$diss+$olddisper;
        $chk_duplication=$this->Counter_sales_model->deletecheckCounter_salesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $getresult=$this->Counter_sales_model->updatepaymentdata($Counter_sales_id,$payamount,$status,$customer_id,$netamount,$mode_id,$disamt,$disper);
          if($getresult)
          {
              $this->msg='Payment Updated Successfully';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'Counter_sales_id'      => $Counter_sales_id,
                  'error'         => $this->error,
                  'error_message' => $this->error_message
                ));

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


}
