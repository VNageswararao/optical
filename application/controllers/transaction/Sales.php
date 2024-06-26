<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
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
        
        $this->load->model('Sales_models');
       $this->load->model('Common_model');
       $this->load->model('Profile_model');
	   $this->load->model('Sales_report_model');
    }
  public function index()
  {
          $data['title']='Optical::Sales';
          $data['activecls']='Sales';
          $office_id=$this->session->office_id;
          $var_array=array($office_id);
          $data['category']=$this->Common_model->getcategory($var_array);
          $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
        //  $data['getcustomer']=$this->Common_model->getcustomerdatalimit($var_array);
          $data['getcustomersales']=$this->Sales_models->getcustomersalesdata($var_array);
          $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
          $data['getstaff']=$this->Common_model->GetStaffData($var_array);
          $content=$this->load->view('transaction/sales/insert',$data,true);
        $this->load->view('includes/layout',['content'=>$content]);
  }
   public function serchcustomer(){
	   $office_id=$this->session->office_id;
	  
	   if(!isset($_POST['searchTerm'])){
		  // $fetchData = mysqli_query($con,"select * from customer where status=1 and office_id= '$office_id' order by customer_id limit 5");
			   $sql = "select * from customer where status=1 and office_id= '$office_id' order by customer_id limit 10";
			  $result_row=$this->db->query($sql, $var_array); 
			  $fetchData= $result_row->result();
		   
		}else{
			$search = $_POST['searchTerm'];
			//$fetchData = mysqli_query($con,"select * from customer where status=1 and office_id= '$office_id' and name like '%".$search."%' limit 5");
			  $sql = "select * from customer where status=1 and office_id= '$office_id' and (name like '%".$search."%' || mrd like '%".$search."%' || mobile like '%".$search."%') limit 10";
			  $result_row=$this->db->query($sql, $var_array); 
			  $fetchData= $result_row->result();
		}
		
		$data11 = array();
		$fetchData = json_decode(json_encode($fetchData), true);
		
		//foreach ($row as $fetchData) {
		foreach ($fetchData as $row) {
			$data11[] = array("id"=>$row['customer_id'], "text"=>$row['name']." ".$row['mobile']." ".$row['mrd']);
		}
		//print_r($data11);exit;
		echo json_encode($data11);
    } 
	public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Sales_models->ajax_call($param);
           echo json_encode($response);
    }
    public function printcustomer_orderform() 
  {
      $this->Sales_models->cusprint_bill_orderform($this->input->post('data_generatebill'),$this->session->userdata('office_id'));
  }

	public function emorder(){
           $param=$_REQUEST;
           $response=$this->Sales_models->emorder($param);
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
        $getresult=$this->Sales_models->Getlastidcustomer($var_array);
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
  public function print_sales() 
  {
      $this->Sales_models->print_bill($this->input->post('data_generatebill'),$this->session->userdata('office_id'));
  }
  
   public function salesWithCategory(){
	 $this->load->view('transaction/sales/withcat',['content'=>$content]);
  }
  
  public function getstatuscon()
  {
      $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[10]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $status=trim(htmlentities($this->input->post('status')));
        $var_array=array($status,$this->session->userdata('office_id'));
        
          $getresult=$this->Sales_models->Getstatusdata($status,$this->session->userdata('office_id'));
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
      $sc='';
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
            $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
            if($host_tvm=='dehoptical' || $host_tvm=='dehaoptical' || $host_tvm=='dehtoptical' || $host_tvm=='pefoptical')
            {
              if($getresult[0]['mrd'])
              {
                $getmaster_so=$this->Common_model->Get_Pat_Source($getresult[0]['mrd']);
                if($getmaster_so)
                {
                  $socurce=$getmaster_so[0]['source'];
                  $sc="<y style='color:blue;font-weight:bold'>Source:$socurce</y>";
                }
              }
                
            }

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'source' => $sc,
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
        $sales_id=trim(htmlentities($this->input->post('getid')));
        $var_array=array($sales_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $var_arrayy=array($this->session->userdata('office_id'));
          $getofficedata=$this->Profile_model->getprofile($var_arrayy);
          $getresult=$this->Sales_models->Getcustomerdataindsales($var_array);
          $getpaidamount=$this->Sales_models->getpaidamount($var_array);
          $getstatus=$this->Sales_models->Getmastertable($var_array);
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
             $date=date_create($getresult[0]['sales_date']);
             $sales_date=date_format($date,"d/m/Y");
             $expected_del_date=date_create($getresult[0]['expected_del_date']);
             $expected_del_date=date_format($expected_del_date,"d/m/Y");
              $headersection='';
            $office_id=$this->session->office_id;
            $var_array=array($office_id);
            $modeofpay=$this->Common_model->GetModeofpayData($var_array);
            if($modeofpay)
            {
              $sv='<select class="form-control"  onchange="changeeditVat($(this).val())" name="pay_mode" id="pay_mode">';
              foreach ($modeofpay as $data) {
                $sv.='<option value="'.$data['modeofpay_id'].'">'.$data['name'].'</option>';
              }
              $sv.='</select>';
            }
             $print='<button onclick="printsale('.$getresult[0]['sales_id'].')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';
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
                                            <p><span class="text-muted">Invoice Date :</span> '.$sales_date.'</p>
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

          $var_array_child=array($getresult[0]['sales_id']);
          $getallclassfication=$this->Sales_models->getallclassfication($var_array_child);
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
          
          $getlensmasterdata=$this->Sales_models->Getlenstable($var_array_child);
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
			 elseif ($getstatus[0]['status']==4) {
               $status="<p style='color:blue;font-weight:bold;font-size: 35px;'>Send To Fitting</p><br/><br/><i class='la la-tick'></i>";
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
                if($getstatus[0]['status']==1 || $getstatus[0]['status']==3 || $getstatus[0]['status']==4)
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
				<tr class="bg-grey bg-lighten-4" id="mpayment">
                   <td class="text-bold-800 text-right"><input type="text" name="cash_bill" id="cash_bill" class="form-control" placeholder="Cash Bill" style="width: 100px"></td>
                   <td class="text-bold-800 text-right"><input type="text" name="card_bill" id="card_bill" class="form-control" placeholder="Card Bill" style="width: 100px"></td>
                   <td class="text-bold-800 text-right"><input type="text" name="paytm_bill" id="paytm_bill" class="form-control" placeholder="Patim Bill" style="width: 100px"></td>
				  </tr>
				
                ';
				
              }
                 
              $headersection.='</tbody>
            </table>
            <input type="hidden" id="sales_idcus" value="'.$getresult[0]['sales_id'].'">
            <input type="hidden" id="customer_idcus"  value="'.$getresult[0]['customer_id'].'">
            <input type="hidden" id="netamount_idcus"  value="'.$getresult[0]['netamount'].'">';
             if($getstatus[0]['status']==1 || $getstatus[0]['status']==3)
                {
                  $headersection.='<button class="btn mr-1 mb-1 btn-danger" style="float: right;" onclick="payamount()">Pay Amount</button>';
                }
          $headersection.='</div>
        
        </div>
      </div>
    </div>
    
    ';

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
  public function getcustomerdata_sec_ad()
  {
      $this->form_validation->set_rules('getid', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $sales_id=trim(htmlentities($this->input->post('getid')));
        $var_array=array($sales_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $var_arrayy=array($this->session->userdata('office_id'));
          $getofficedata=$this->Profile_model->getprofile($var_arrayy);
          $getresult=$this->Sales_models->Getcustomerdataindsales($var_array);
		  $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details where sales_id=$sales_id  ")->row();
		  //print_r($advancecreditamount);exit;
          if($getresult)
          {
              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'customerdata' => $getresult,
                   'paid_pay1' => $advancecreditamount,
                   'paid_pay' => $advancecreditamount
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
  public function sales_search_stock_by_barcode()
  {
      $this->form_validation->set_rules('barcode', 'barcode', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('barcode')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Sales_models->getbarcode($product,$this->session->userdata('office_id'));
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

  public function sales_search_stock_by_framemodel()
  {
      $this->form_validation->set_rules('framemodel', 'framemodel', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('framemodel')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Sales_models->getframemodel($product,$this->session->userdata('office_id'));
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
  public function send_to_fitt_update()
  {
      error_reporting(0);
      $this->form_validation->set_rules('stt_supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[100]|numeric');
    if($this->form_validation->run() == TRUE)
      {

        $sales_id=trim(htmlentities($this->input->post('stt_sales_id')));
        $stt_date=trim(htmlentities($this->input->post('stt_date')));
        $remarks=trim(htmlentities($this->input->post('stt_remarks')));
        $stt_supplier_id=trim(htmlentities($this->input->post('stt_supplier_id')));
		$status="4";
      
          $getresult=$this->Sales_models->send_to_fitt_update($sales_id,$stt_date,$status,$remarks,$stt_supplier_id);
		 // 
          if($getresult)
          {
              $this->msg='Send To Fitting Successfully';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'sales_id'      => $sales_id,
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
  public function sales_search_stock()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Sales_models->getSalesSearchStock($product,$this->session->userdata('office_id'));
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
  public function sales_search_stock_framemodel()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $framemodel=trim(htmlentities($this->input->post('framemodel')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Sales_models->getSalesSearchStock_framemodel($product,$framemodel,$this->session->userdata('office_id'));
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
  public function sales_search_stock_barcode()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $barcode=trim(htmlentities($this->input->post('barcode')));
        $var_array=array($product,$barcode,$this->session->userdata('office_id'));
        $getresult=$this->Sales_models->getSalesSearchStock_barcode($product,$barcode,$this->session->userdata('office_id'));
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

  public function sales_search_lens()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $supplier_id=trim(htmlentities($this->input->post('supplier_id')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->Sales_models->getSalesSearchLens($product,$supplier_id,$this->session->userdata('office_id'));
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
               "sales"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "sales_date"=>date('Y-m-d',strtotime($this->input->post('sales_date'))),
                   "sales_time"=>($this->input->post('pe_time'))?$this->input->post('sales_time'):date('H:i:s'),
                   "customer_id"=>$this->input->post('customer_id'),
                   'total_qty'=>$this->input->post('total_qty'),
                   'total_cgst'=>$this->input->post('total_cgst'),
                   'total_sgst'=>$this->input->post('total_sgst'),
                   'supplier_id'=>$this->input->post('supplier_id'),
                   'emergency_order'=>$this->input->post('emergency_order'),
                   'credit_name'=>$this->input->post('credit_name'),
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
                   'office_id'=> $office_id,
                   'stf_supplier_id'=> "",
                   'stf_date'=> "",
                   'stf_remarks'=> ""
               ),
             "sales_detail"=>array(
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
             ),
              "payment_details"=>array(
                "payment_date"=>date('Y-m-d',strtotime($this->input->post('sales_date'))),
                "advanced_amount"=>$this->input->post('paying_amount'),
                "balanced_amount"=>$this->input->post('balanced_amount'),
                "net_amount"=>$this->input->post('invoice_amount'),
                "payment_time"=>date('H:i:s'),
                "login_id"=>$this->session->userdata('login_id'),
                'office_id'=> $office_id
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
               
            
                $getresult=$this->Sales_models->getopticaladvicedata($opdate,$opaddate2);
                if($getresult)
                {
                  $html='<table id="opadv" class="table table-bordered table-hover"><thead><tr><th>SL NO</th><th>Patient Name</th><th>MRD NO</th><th>Mobile No</th><th>Address</th><th>Optical Advice Date</th><th>Print</th></tr></thead><tbody>';
                  $sl=1;
                  $exid='';
                  foreach ($getresult as $datr) {
                    $getresultdata=$this->Sales_models->getlastemrexaminationid($datr['patient_registration_id']);
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
       
        $this->Sales_models->examination_print_bill($this->input->post('examinationid'),$this->input->post('chkcomplaintsout'),$this->input->post('chkopthalmicsout'),$this->input->post('chkmedicalout'),$this->input->post('chkeyepartout'),$this->input->post('addmedicinessout'),$this->input->post('investigationchkout'),$this->input->post('preliminary_exout'),$this->input->post('vsisonreadingsout'),$this->input->post('curspecout'),$this->input->post('objectchkout'),$this->input->post('arkkchkout'),$this->input->post('manchkout'),$this->input->post('specchkout'),$this->input->post('conlchkout'),$this->input->post('pmtchkout'),$this->session->userdata('office_id'));
    }

   public function savesalesentry()
  {
    $this->form_validation->set_rules('customer_id', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    if($host_tvm=='aby')
      {
          $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[100]|numeric');
      }
    $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total qty', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('bill_status', 'Bill Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'trim|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('quantity[]', 'quantity', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('selling_price[]', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    if($this->input->post('modeofpay_id')!=9){
    $this->form_validation->set_rules('paying_amount', 'advanced amount', 'trim|required|min_length[1]|max_length[100]|numeric|required');
     }
      
      if($this->form_validation->run() == TRUE)
      { 
		  
       if($this->input->post('bill_status') == "1"  || ($this->input->post('bill_status') == "2" && $this->input->post('balance_amount') == "0")){
			// print_r("yes");exit;
			 $data=$this->fetch_data();
          $getresult=$this->Sales_models->savedata($data);
          if($getresult)
          {
            $supplier_id=$this->input->post('supplier_id');
            if($supplier_id>0){
           $qry=$this->db->get_where("supplier","supplier_id='$supplier_id'");
           $row=$qry->row();
           $supemail_id=$row->email_id; 
           if($supemail_id){
                $this->db->select("sales_id");
                $this->db->from("sales_master");
                $this->db->limit(1);
                $this->db->order_by('sales_id',"DESC");
                $query = $this->db->get();
                $result = $query->row();
                $result->sales_id;
              $this->Sales_models->print_bill($result->sales_id,$this->session->userdata('office_id'),$this->input->post('supplier_id'));
            }
           }
           
           $sales_id=$this->db->select('max(sales_id) as sales_id')
                         ->from('sales_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->sales_id;
                if($sales_id>0)
                {
                    $sales_id=$sales_id;
                } else {
                    $sales_id= $sales_id;
                   
                }
              $this->msg='Saved Successfully';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'sales_id'=>$sales_id,
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
		else{
			// print_r("No");exit;
			$this->msg='';
              $this->error='Payment Due Not Delivered';
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
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $html='';
		  $status='0';
          $var_array_child=array($getid);
          $getmasterdata=$this->Sales_models->Getmastertable($var_array);
		  $cus_id=$getmasterdata[0]['customer_id'];
		  $var_arr=array($cus_id,$this->session->userdata('office_id'));
          $getresult=$this->Common_model->Getcustomerdataind($var_arr); 
		   
		  $getallclassfication=$this->Sales_models->getallclassfication($var_array_child);
		  
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
                         <td><input type="text" name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" ></td>
                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)"  required  autocomplete="off"></td>
                          '.$itemclassfn.'
                          <td class="mbl_view">
                         <select name="discount_type[]" id="discount_type_'.$sl.'" class="form-control grid_table" onchange="calcrow('.$sl.')">
                           <option value="0">Amount</option>
                           <option value="1">Percentage</option>
                           </select>
                          </td>
                           <td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onKeyUp="calcrow('.$sl.')" id="discount_input_'.$sl.'" value="'.$data['discount_input'].'"  onkeydown="changefocus(event,$(this))">
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
              $getlensmasterdata=$this->Sales_models->Getlenstable($var_array_child);
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
                         <td><input type="text" name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" ></td>
                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)"  required  autocomplete="off"></td>
                          '.$itemclassfn.'
                          <td class="mbl_view">
                         <select name="discount_type[]" id="discount_type_'.$sl.'" class="form-control grid_table" onchange="calcrow('.$sl.')">
                           <option value="0">Amount</option>
                           <option value="1">Percentage</option>
                           </select>
                          </td>
                           <td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onKeyUp="calcrow('.$sl.')" id="discount_input_'.$sl.'" value="'.$data['discount_input'].'"  onkeydown="changefocus(event,$(this))">
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
                  'getresult' => $getresult,
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
 public function deletesalesentry()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_salesid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_salesid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
			
          
          $getresult=$this->Sales_models->deletedata($delete_salesid);
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
        $delete_salesid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_salesid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Sales_models->updatereadutodelivery($delete_salesid);
          if($getresult)
          {
            $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
            if($host_tvm=='dehoptical')
            {
           
              $tempid='1407165771314881328';

               $customer_id=$this->db->select('customer_id')
                         ->from('sales_master')
                         ->where(array('sales_id'=>$delete_salesid))
                         ->get()->row()->customer_id;

                         $invoice_number=$this->db->select('invoice_number')
                         ->from('sales_master')
                         ->where(array('sales_id'=>$delete_salesid))
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
  public function editsalesentry()
  {
	 
    $this->form_validation->set_rules('edit_sales_id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
   $this->form_validation->set_rules('customer_id', 'Customer_id ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
   if($host_tvm=='aby')
      {
        $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[100]|numeric');
      }
   $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total qty', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('bill_status', 'Bill Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('quantity[]', 'quantity', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('selling_price[]', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    $this->form_validation->set_rules('paying_amount', 'advanced amount', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
      if($this->form_validation->run() == TRUE)
      {
		
			$edit_sales_id=trim(htmlentities($this->input->post('edit_sales_id')));
			$var_array=array($edit_sales_id,$this->session->userdata('office_id'));
			$chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
			if($chk_duplication[0]['cnt']==1)
			{
				$data=$this->fetch_data(); 
				 $getcntval=$this->Sales_report_model->getcountofpayment($edit_sales_id);
				
                if($getcntval[0]['CNT']==1)
                {
					
					$getresult=$this->Sales_models->updatedata($data,$edit_sales_id);
				}
				else
                {
					if($data[sales]['status']==1)
					{
						$getresult=$this->Sales_models->updatedata($data,$edit_sales_id);
					}else{
						$getresult=$this->Sales_models->secoundupdatedata($data,$edit_sales_id);
					}
					
                 } 
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
    $this->form_validation->set_rules('sales_id', 'Sales ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('payamount', 'Payment Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('customer_id', 'Customer', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('netamount', 'Net Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('pay_mode', 'Modeofpay', 'trim|required|min_length[1]|max_length[100]|numeric');
    if($this->form_validation->run() == TRUE)
      {
		
        $sales_id=trim(htmlentities($this->input->post('sales_id')));
        $payamount=trim(htmlentities($this->input->post('payamount')));
        $status=trim(htmlentities($this->input->post('status')));
        $netamount=trim(htmlentities($this->input->post('netamount')));
        $customer_id=trim(htmlentities($this->input->post('customer_id')));
        $mode_id=trim(htmlentities($this->input->post('pay_mode')));
        $cash_bill=trim(htmlentities($this->input->post('cash_bill')));
        $card_bill=trim(htmlentities($this->input->post('card_bill')));
        $paytm_bill=trim(htmlentities($this->input->post('paytm_bill')));
        $var_array=array($sales_id,$this->session->userdata('office_id'));
        $var_arrayy=array($sales_id);

        $getresultdis=$this->Sales_models->Getcustomerdataindsaless($var_arrayy);
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
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $getresult=$this->Sales_models->updatepaymentdata($sales_id,$payamount,$status,$customer_id,$netamount,$mode_id,$cash_bill,$card_bill,$paytm_bill,$disamt,$disper);
          if($getresult)
          {
              $this->msg='Payment Updated Successfully';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'sales_id'      => $sales_id,
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
  
  
 
  

public function sec_ad_payamount()
  {
      error_reporting(0);
  //print_r($this->input->post());exit();
    $this->form_validation->set_rules('payamount', '2 nd Advaance Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('pay_mode', 'Modeofpay', 'trim|required|min_length[1]|max_length[100]|numeric');
    if($this->form_validation->run() == TRUE)
      {
        $sales_id=trim(htmlentities($this->input->post('sales_id')));
        $payamount=trim(htmlentities($this->input->post('payamount')));
        $status=trim(htmlentities($this->input->post('status')));
        $netamount=trim(htmlentities($this->input->post('netamount')));
        $customer_id=trim(htmlentities($this->input->post('customer_id')));
        $mode_id=trim(htmlentities($this->input->post('pay_mode')));
        $cash_bill=trim(htmlentities($this->input->post('cash_bill')));
        $card_bill=trim(htmlentities($this->input->post('card_bill')));
        $paytm_bill=trim(htmlentities($this->input->post('paytm_bill')));
        $var_array=array($sales_id,$this->session->userdata('office_id'));
        $var_arrayy=array($sales_id);

        $getresultdis=$this->Sales_models->Getcustomerdataindsaless($var_arrayy);
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
        $chk_duplication=$this->Sales_models->deletechecksalesentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $getresult=$this->Sales_models->sec_ad_updatepaymentdata($sales_id,$payamount,$status,$customer_id,$netamount,$mode_id,$cash_bill,$card_bill,$paytm_bill,$disamt,$disper);
          if($getresult)
          {
              $this->msg='Payment Updated Successfully';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'sales_id'      => $sales_id,
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
  
public function catTypeload(){
		  $office_id=$this->session->office_id;
          $var_array=array($office_id);
		  $catType=$_REQUEST['cattype'];
          $data['category']=$this->Common_model->getcategory($var_array);
          $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
        //  $data['getcustomer']=$this->Common_model->getcustomerdatalimit($var_array);
          $data['getcustomersales']=$this->Sales_models->getcustomersalesdata($var_array);
          $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
          $data['getstaff']=$this->Common_model->GetStaffData($var_array);
          $content=$this->load->view("transaction/sales/$catType",$data,true);
		  echo $content;
        //$this->load->view('includes/layout',['content'=>$content]);
}

public function addMasterDataRow(){
	
	$trlength=$_REQUEST['trlength'];
	$itemType=$_REQUEST['itemType'];
	$tr_html='<tr style="background:#ffedb8;">';
	$tr_html.='<td>
                        <a href="#" onclick="$(this).parent().parent().remove()"; class="input_column">
                        <button class="btn btn-danger btnDelete btn-sm">
                           <i class="la la-trash"></i>
                        </button>
                        </a>
                   </td>';
	$tr_html.='<td><input type="text" name="itemtype_'.$trlength.'" id="itemtype_'.$trlength.'" class="form-control grid_table" value="'.$itemType.'" readonly=""></td>';
	$tr_html.='<td><input type="text" name="itemname_'.$trlength.'" id="itemname_'.$trlength.'" class="form-control grid_table" value=""></td>';
    $tr_html.='<td><input type="text" name="itemcode_'.$trlength.'" id="itemcode_'.$trlength.'" class="form-control grid_table" value=""></td>';
	$tr_html.='<td><input type="text" name="desc_'.$trlength.'" id="desc_'.$trlength.'" class="form-control grid_table" value=""></td>';
    $tr_html.='<td><input type="text" name="rate_'.$trlength.'" id="rate_'.$trlength.'" class="form-control grid_table" value=""></td>';
	$tr_html.='<td><input type="text" name="quantity_'.$trlength.'" id="quantity_'.$trlength.'" class="form-control grid_table" value="" onchange="calcTotalAmount('.$trlength.')"></td>';
    //$tr_html.='<td><input type="number" step="any" name="quantity_'.$trlength.'" id="quantity_'.$trlength.'" class="form-control grid_table" value="0" required="" onchange="calcTotalAmount('.$trlength.')"></td>';
    $tr_html.='<td class="mbl_view">
                       <select name="gst_'.$trlength.'[]" id="gst_'.$trlength.'" class="form-control grid_table" onchange="gstCalc('.$trlength.')">
						<option value="0">No</option>
                        <option value="1">Yes</option>
                       </select>
                   </td>';
	 $tr_html.='<td><input name="discount_'.$trlength.'" id="discount_'.$trlength.'"  class="form-control grid_table" onchange="disCalc('.$trlength.')"></td>';
	$tr_html.='<td><input type="text" name="advance_'.$trlength.'" id="advance_'.$trlength.'" class="form-control grid_table" value=""></td>';
    $tr_html.='<td><input type="text" name="modeofpay_'.$trlength.'" id="modeofpay_'.$trlength.'" class="form-control grid_table" value=""></td>';
    $tr_html.='<td><input type="date" name="expdate_'.$trlength.'" id="expdate_'.$trlength.'" class="form-control grid_table" value=""></td>';
	$tr_html.='<td><input type="text" name="total_'.$trlength.'" id="total_'.$trlength.'" class="form-control grid_table" value=""></td>';
    $tr_html.='<td><input type="text" name="netamount_'.$trlength.'" id="netamount_'.$trlength.'" class="form-control grid_table" value=""></td>';
	$tr_html.='<td><input type="text" name="balance_'.$trlength.'" id="balance_'.$trlength.'" class="form-control grid_table" value=""></td>';
 /*	$tr_html.='<td><input type="number" step="any" name="mrp_'.$trlength.'" id="mrp_'.$trlength.'" class="form-control grid_table" value="0" required="" autocomplete="off"></td>';
	$tr_html.='<td><input type="text" step="any" name="totalamount_'.$trlength.'" id="totalamount_'.$trlength.'" class="form-control grid_table" value="0" required="" autocomplete="off"></td>';
	$tr_html.='<td><input type="number" step="any" name="purchaseamount_'.$trlength.'" id="purchaseamount_'.$trlength.'" class="form-control grid_table" value="0" required="" autocomplete="off"></td>';*/
	
                /*   <td>
                      <input name="totalamount_'.$trlength.'" id="totalamount_'.$trlength.'" class="form-control grid_table" value="0" readonly="">
                   </td>'*/
                   $tr_html.='</tr>';
		echo $tr_html;		
}


public function saveWithOutMasterData(){
	$rows=$_GET['row'];
	$data=$_REQUEST;
	for($i=0;$i<$rows;$i++){
		$record['itemtype']=$data["itemtype_".$i];
		$record['itemname']=$data["itemname_$i"];
		$record['itemcode']=$data["itemcode_$i"];
		$record['description']=$data["desc_$i"];
		$record['rate']=$data["rate_$i"];
		$record['quantity']=$data["quantity_$i"];
		$record['gst']=$data["gst_$i"][0];
		$record['discount']=$data["discount_$i"];
		$record['advance']=$data["advance_$i"];
		$record['modeofpay']=$data["modeofpay_$i"];
		$record['expdate']=$data["expdate_$i"];
		$record['total']=$data["total_$i"];
		$record['netamount']=$data["netamount_$i"];
		$record['balance']=$data["balance_$i"];
		$getresult=$this->Sales_models->saveWithOutMasterData($record);

	}
	

}

public function addWithoutTableRow(){
	$index=$_REQUEST['index'];
	 $itemtype=$_REQUEST['itemtype'];
	 if($itemtype=='LENS'){
		 $color='#ffedb8;';
	 }else if($itemtype=='FRAME'){
		$color='#a4ffde;'; 
	 }else if($itemtype=='READING GLASS'){
		$color='#ffedb8;'; 
	 }else if($itemtype=='CONTACTLENS'){
		$color='#ffedb8;'; 
	 }else if($itemtype=='SUNGLASS'){
		$color='#ffedb8;'; 
	 }else if($itemtype=='SERVICE'){
		$color='#ffedb8;'; 
	 }else if($itemtype=='ACLUDAR'){
		$color='#ffedb8;'; 
	 }else{
		$color='#a4ffde;'; 
	 }
	/*$html.='<tr style="background:'.$color.';">
                  <td>
                        <a href="#" onclick="$(this).parent().parent().remove();calcnet();checkgridcount();" class="input_column">
                        <button class="btn btn-danger btnDelete btn-sm">
                           <i class="la la-trash"></i>
                        </button>
                        </a>
                   </td>
                   <td><input type="text" name="itemtype_'.$index.'" id="itemtype_'.$index.'" class="form-control grid_table" value="'.$itemtype.'" onkeyup="calcrow('.$index.')"  onkeydown="changefocus(event,$(this))"></td>
                   <td><input type="text" name="product[]" id="selling_price_'.$index.'" class="form-control grid_table" value="" onkeyup="calcrow('.$index.')"  onkeydown="changefocus(event,$(this))"></td>
                   <td></td>
                   <td><input type="text" name="selling_price[]" id="selling_price_'.$index.'" class="form-control grid_table" value="200" onkeyup="calcrow('.$index.')"  onkeydown="changefocus(event,$(this))"></td>
                   <td><input type="number" step="any" name="quantity[]" id="quantity_'.$index.'" class="form-control grid_table" value="0" onkeyup="calcrow('.$index.')" onkeydown="changefocus(event,$(this))" required="" autocomplete="off"></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td>NONE</td>
                   <td>NONE1</td>
                   <td class="mbl_view">
                       <select name="discount_type[]" id="discount_type_'.$index.'" class="form-control grid_table" onchange="calcrow('.$index.')">
                         <option value="0">Amount</option>
                         <option value="1">Percentage</option>
                       </select>
                   </td>
                   <td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onkeyup="calcrow('.$index.')" id="discount_input_'.$index.'"  onkeydown="changefocus(event,$(this))">
                      <input type="hidden" name="discount_amount[]" value="0" id="discount_amount_'.$index.'"></td>
                   
                   <td>
                      <input name="amount[]" id="amount_'.$index.'" class="form-control grid_table" value="0" readonly="">
                   </td>
                   <td style="display: none;" class="mbl_view">
                     <select name="tax_type[]" id="tax_type_'.$index.'" style="font-size:12px" class="form-control grid_table disabled_select">
                       <option value="0">Non Tax</option>
                       <option value="1">Inclusive</option>
                       <option value="2">Exclusive</option>
                     </select>
                   </td>
                   <td style="display: none;" class="mbl_view"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'.$index.'" readonly="" value=""></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="cgst[]" id="cgst_'.$index.'" readonly="" value="6"></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="sgst[]" id="sgst_'.$index.'" readonly="" value="6"></td>
                   <td style="display:none" class="mbl_view">
                     <input type="hidden" name="stock_id[]" id="stock_id_'.$index.'" value="100">
                     <input type="hidden" name="product_id[]" id="product_id_'.$index.'" value="0.0">
                     <input type="hidden" name="tax_amount[]" id="tax_amount_'.$index.'" value="0.0">
                     <input type="hidden" name="product_type[]" id="product_type_'.$index.'" value="0.0">
                   </td>
                </tr>';*/
				$html.='<tr style="background:'.$color.';">';
                  $html.='<td>
                        <a href="#" onclick="$(this).parent().parent().remove();calcnet();checkgridcount();" class="input_column">
                        <button class="btn btn-danger btnDelete btn-sm">
                           <i class="la la-trash"></i>
                        </button>
                        </a>
                   </td>';
    $html.='<td>10</td>';
    $html.='<td>
	<input type="text" class="form-control grid_table" value="" name="product[]">
	<input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$index.'" value="0">
	</td>
    $html.=<td></td>';
    $html.='<td><input type="text" name="selling_price[]" id="selling_price_'.$index.'" class="form-control grid_table" value="0" onkeyup="calcrow('.$index.')" onkeydown="changefocus(event,$(this))"></td>';
    $html.='<td><input type="number" step="any" name="quantity[]" id="quantity_'.$index.'" class="form-control grid_table" value="0" onkeyup="calcrow('.$index.')" onkeydown="changefocus(event,$(this))"  required="" autocomplete="off"></td>';
    $html.='<td></td>';
    $html.='<td></td>';
    $html.='<td></td>';
    $html.='<td></td>';
    $html.='<td>NONE</td>';
    $html.='<td>NONE1</td>';
    $html.='<td class="mbl_view">
                       <select name="discount_type[]" id="discount_type_'.$index.'" class="form-control grid_table" onchange="calcrow('.$index.')">
                         <option value="0">Amount</option>
                         <option value="1">Percentage</option>
                       </select>
                   </td>';
    $html.='<td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onkeyup="calcrow('.$index.')" id="discount_input_'.$index.'"  onkeydown="changefocus(event,$(this))">
                      <input type="hidden" name="discount_amount[]" value="0" id="discount_amount_'.$index.'"></td>';
                   
    $html.='<td>
                      <input name="amount[]" id="amount_'.$index.'" class="form-control grid_table" value="0" readonly="">
                   </td>';
    $html.='<td style="display: none;" class="mbl_view">
                     <select name="tax_type[]" id="tax_type_'.$index.'" style="font-size:12px" class="form-control grid_table disabled_select">
                       <option value="0">Non Tax</option>
                       <option value="1">Inclusive</option>
                       <option value="2">Exclusive</option>
                     </select>
                   </td>';
    $html.='<td style="display: none;" class="mbl_view"><input type="text" class="form-control grid_table" name="gst" id="gst_'.$index.'" readonly="" value="12"></td>';
    $html.='<td style="display: none;"><input type="hidden" class="form-control grid_table" name="cgst" id="cgst_'.$index.'" readonly="" value="0.00"></td>';
    $html.='<td style="display: none;"><input type="hidden" class="form-control grid_table" name="sgst" id="sgst_'.$index.'" readonly="" value="0.00"></td>';
    $html.='<td style="display:none" class="mbl_view">
                     <input type="hidden" name="stock_id" id="stock_id_'.$index.'" value="14">
                     <input type="hidden" name="product_id" id="product_id_'.$index.'" value="14">
                     <input type="hidden" name="tax_amount" id="tax_amount_'.$index.'" value="0">
                     <input type="hidden" name="product_type" id="product_type_'.$index.'" value="1">
                   </td>';
    $html.='</tr>';
				echo $html;
	
}
public function loadPendingSalesList(){
	$getresult=$this->Sales_models->loadPendingSalesList();
	//echo"<pre>";print_r($getresult);die;
	$html='';
	$html.="<table class='table table-striped table-bordered opticaltable-list' style='width: 100%;'>
                                                       <thead>
														  <tr>	
														<th>Item Type</th>
														<th>Item Name</th>
														<th>Item Code</th>
														<th> Description </th>
														<th>Rate</th>
														<th>Qty</th>
														<th>GST</th>
														<th>Discount</th>
														<th>ADV</th>
														<th>Mode of pay</th>
														<th>Exp Delivery</th> 
														<th>Total Amount</th>
														<th>Net Amount</th>
														<th>Balance</th>
														<th>Status</th>
														<th>Print</th>
														<th>Edit</th>
														<th>Delete</th>
														  </tr>
														</thead>";
														foreach($getresult as $k=>$v){
															//echo"<pre>";print_r($v);die;
														
						$html.="<tr>
							<td>".$v['itemtype']."</td> 	<td>".$v['itemname']."</td> 	<td>".$v['itemcode']."</td> 	<td>".$v['description']."</td> 	<td>".$v['rate']."</td> 	<td>".$v['quantity']."</td> 	<td>".$v['gst']."</td> 	<td>".$v['discount']."</td> 	<td>".$v['advance']."</td> 	<td>".$v['modeofpay']."</td> 	<td>".$v['expdate']."</td> 	<td>".$v['total']."</td> 	<td>".$v['netamount']."</td> <td></td>	<td>".$v['balance']."</td> <td><button type='button' class='btn btn-info btn-info mr-1 mb-1'><i class='la la-print'></i></button></td>  <td><button type='button' class='btn btn-icon btn-warning mr-1 mb-1'onclick='progressedit()'><i class='la la-edit'></i></button></td> <td><button type='button' class='btn btn-icon btn-danger mr-1 mb-1'><i class='la la-trash'></i></button></td>
							</tr>";
														}
						
						
						$html.="<tfoot>
															<tr>
															
														<th>Item Type</th>
														<th>Item Name</th>
														<th>Item Code</th>
														<th> Description </th>
														<th>Rate</th>
														<th>Qty</th>
														<th>GST</th>
														<th>Discount</th>
														<th>ADV</th>
														<th>Mode of pay</th>
														<th>Exp Delivery</th> 
														<th>Total Amount</th>
														<th>Net Amount</th>
														<th>Balance</th>
														<th>Status</th>
														<th>Print</th>
														<th>Edit</th>
														<th>Delete</th>
															</tr>
														</tfoot>
													</table>";
				
echo $html;				
}  

public function editPendingSaleslist(){
	
		$html.='<form id="edit_data_form" action="#" method="post"> 
							 <div id="div_edit_data" class="modal fade show" role="dialog" aria-modal="true" style="display: block;">
							        <div class="modal-dialog modal-xl">
							        <!-- Modal content-->
							            <div class="modal-content">
							                <div class="modal-header">
							                    <h4 class="modal-title">Edit Data</h4>
							                    <button type="button" class="close" data-dismiss="modal">×</button>
							                </div>
							                <div class="modal-body">
										
										 <div class="col-lg-12 col-md-12" >
							                         
							                                 
							       <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Code: </label>
                                            <input type="text" class="form-control" name="code" placeholder="Code" id="code" required >
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Item Type: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="item_type_id" id="item_type_id">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Coating: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="lens_coating_id" id="lens_coating_id">
                                               
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Item Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Item Name" id="itemname" name="itemname" required>
                                        </div>
                                    </div>
                                
                               
   
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Purchase Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Purchase Date" id="purchase_date" name="purchase_date" pattern="\d{4}-\d{2}-\d{2}" >
                                        </div>
									</div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Delivery Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Delivery Date" id="delivery_date" name="delivery_date" pattern="\d{4}-\d{2}-\d{2}" >
                                        </div>
                                    </div>
								</div>
								<div class="row">
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Rate: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Rate" id="rate" name="rate" required>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                       <div class="form-group">
                                            <label for="quantity"> Qty: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Quantity" id="quantity" name="quantity" required>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                       <div class="form-group">
                                            <label for="discount"> Discount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="discount" id="discount" name="discount" required>
                                        </div>
                                    </div>
                                      <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Gst: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="gst_type" id="gst_type" onchange="changeVat($(this).val())">
                                               <option value="0">NonTax</option>
                                               <option value="1">Inclusive</option>
                                               <option value="2">Exclusive</option>
                                           </select>
                                        </div>
                                    </div>

                                    <div class="row col-md-6" id="tax_gstt" style="display: none;">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Tax: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="tax" id="taxt" onchange="changeTaxvall($(this).val())">
                                            <option value="">Select Tax</option>
                                              '.$taxx.'
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">CGST%: </label>
                                           <input type="text" readonly name="cgst" id="cgstt" class="form-control" placeholder="CGST">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">SGST%: </label>
                                           <input type="text" readonly name="sgst" id="sgstt" class="form-control" placeholder="SGST">
                                        </div>
                                    </div>
                                </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control select2" name="supplier_name" id="supplier_name">
										</div>
                                    </div>
									<div class="col-md-2">
                                       <div class="form-group">
                                            <label for="lastname">Purchase Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Purchase Amount" id="purchaseamount" name="purchaseamount" required>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                       <div class="form-group">
                                            <label for="total_amount">Total Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Total Amount" id="total_amount" name="total_amount" required>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                       <div class="form-group">
                                            <label for="net_amount">Net Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Net Amount" id="net_amount" name="net_amount" required>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                       <div class="form-group">
                                            <label for="invoice_no">Invoice No: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Invoice No" id="invoice_no" name="invoice_no" required>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="description" name="description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
								
											</div>
							                <div class="modal-footer">
		<button id="save" class="btn btn-primary btn-sm" type="button" onclick="ProgressSaveEntryData();"><i class="fas fa-plus-square"></i>Save</button>
			<button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							                </div>
							            </div>
							        </div>
							    </div>
							</form>';
							
						echo $html; 
	
}


public function progressSaveEntryData(){

	$data=$_REQUEST;
		$record['code']=$data["code"];
		$record['itemtype']=$data["item_type_id"];
		$record['coating']=$data["lens_coating_id"];
		$record['itemname']=$data["itemname"];
		$record['purchasedate']=$data["purchase_date"];
		$record['deliverydate']=$data["delivery_date"];
		$record['rate']=$data["rate"];
		$record['quantity']=$data["quantity"];
		$record['discount']=$data["discount"];
		$record['gst']=$data["gst_type"][0];
		$record['suppliername']=$data["supplier_name"];
		$record['purchaseamount']=$data["purchaseamount"];
		$record['totalamount']=$data["total_amount"];
		$record['netamount']=$data["net_amount"];
		$record['invoiceno']=$data["invoice_no"];
		$record['description']=$data["description"];
		$getresult=$this->Sales_models->saveProgressData($record);
	

}

}
