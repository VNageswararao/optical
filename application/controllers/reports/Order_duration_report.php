<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_duration_report extends CI_Controller {
	private $msg;
	private $error;
	private $error_message;
	private $randval;
	public function __construct() {
    error_reporting(0);
        parent::__construct();
        if (!isset($this->session->optical_login))
         {
		    	redirect('login');
         }
         $this->load->model('Item_model');
         $this->load->model('Common_model');
        
        
    }
	public function index()
	{
		$data['title']='Optical::Order Duration Report';
		$data['activecls']='Order_duration_report';
		$office_id=$this->session->office_id;
		$var_array=array($office_id);
       $content=$this->load->view('reports/order_duration_report',$data,true);
		$this->load->view('includes/layout',['content'=>$content]);
	}

	public function fore_month_data()   // summary 
     {
     $today_date = new DateTime('now');
	$today = $today_date->format('Y-m-d');
	$today_date->modify('-4 month'); // or you can use '-90 day' for deduct
	$befoure_month = $today_date->format('Y-m-d');
    $sql = "SELECT sales_id,sales_master.status,customer.name,customer.mobile,customer.address,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount FROM sales_master inner join customer on sales_master.customer_id=customer.customer_id WHERE sales_date >= DATE_SUB('$today', INTERVAL 4 MONTH) AND sales_date < DATE_SUB('$today', INTERVAL 3 MONTH)";
    
        $result=$this->db->query($sql)->result();
//print_r($result);exit;
       //  $url='Order_duration_report/print/'.$frmdate.'/'.$todate.'/'.$taxy.'/'.$mode;
    
      // $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div><table class="table table-striped" id="example_sum"><thead>

	 $html='<table class="table table-striped table-bordered " id="example_sum"><thead>
       			<tr>
       				<th>Sl No</th>
					<th>Order Number</th>
					<th>Patient Name</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>Amount</th>
					<th>Order Date</th>
				</tr></thead><tbody>';
       				
        $i=1;
        foreach($result as $row)
        {
        	$html.='<tr>
        				<td>'.$i.'</td>
        				<td>'.$row->invoice_number.'</td>
        				<td>'.$row->name.'</td>
        				<td>'.$row->mobile.'</td>
        				<td>'.$row->address.'</td>
        				<td>'.$row->netamount.'</td>
        				<td>'.$row->sales_date.'</td>
			</tr>';
          $i++;
        }
       $html.='
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
	public function eight_month_data()   // summary 
     {
   $today_date = new DateTime('now');
	$today = $today_date->format('Y-m-d');
	$today_date->modify('-8 month'); // or you can use '-90 day' for deduct
	$befoure_month = $today_date->format('Y-m-d');
     $sql = "SELECT sales_id,sales_master.status,customer.name,customer.mobile,customer.address,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount FROM sales_master inner join customer on sales_master.customer_id=customer.customer_id WHERE sales_date >= DATE_SUB('$today', INTERVAL 8 MONTH) AND sales_date < DATE_SUB('$today', INTERVAL 7 MONTH)";
    
        $result=$this->db->query($sql)->result();
//print_r($result);exit;
       //  $url='Order_duration_report/print/'.$frmdate.'/'.$todate.'/'.$taxy.'/'.$mode;
    
      // $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div><table class="table table-striped" id="example_sum"><thead>

	 $html='<table class="table table-striped table-bordered " id="example_sum2"><thead>
       			<tr>
       				<th>Sl No</th>
					<th>Order Number</th>
					<th>Patient Name</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>Amount</th>
					<th>Order Date</th>
				</tr></thead><tbody>';
       				
        $i=1;
        foreach($result as $row)
        {
        	$html.='<tr>
        				<td>'.$i.'</td>
        				<td>'.$row->invoice_number.'</td>
        				<td>'.$row->name.'</td>
        				<td>'.$row->mobile.'</td>
        				<td>'.$row->address.'</td>
        				<td>'.$row->netamount.'</td>
        				<td>'.$row->sales_date.'</td>
			</tr>';
          $i++;
        }
       $html.='
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

public function twelve_months_data()   // summary 
     {
   $today_date = new DateTime('now');
	$today = $today_date->format('Y-m-d');
	$today_date->modify('-12 month'); // or you can use '-90 day' for deduct
	$befoure_month = $today_date->format('Y-m-d');
	 $sql = "SELECT sales_id,sales_master.status,customer.name,customer.mobile,customer.address,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount FROM sales_master inner join customer on sales_master.customer_id=customer.customer_id WHERE sales_date >= DATE_SUB('$today', INTERVAL 12 MONTH) AND sales_date < DATE_SUB('$today', INTERVAL 11 MONTH)";
    
        $result=$this->db->query($sql)->result();
//print_r($result);exit;
       //  $url='Order_duration_report/print/'.$frmdate.'/'.$todate.'/'.$taxy.'/'.$mode;
    
      // $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div><table class="table table-striped" id="example_sum"><thead>

	 $html='<table class="table table-striped table-bordered " id="example_sum3"><thead>
       			<tr>
       				<th>Sl No</th>
					<th>Order Number</th>
					<th>Patient Name</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>Amount</th>
					<th>Order Date</th>
				</tr></thead><tbody>';
       				
        $i=1;
        foreach($result as $row)
        {
        	$html.='<tr>
        				<td>'.$i.'</td>
        				<td>'.$row->invoice_number.'</td>
        				<td>'.$row->name.'</td>
        				<td>'.$row->mobile.'</td>
        				<td>'.$row->address.'</td>
        				<td>'.$row->netamount.'</td>
        				<td>'.$row->sales_date.'</td>
			</tr>';
          $i++;
        }
       $html.='
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
}