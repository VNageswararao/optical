<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_return_report extends CI_Controller {
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
        
        $this->load->model('Purchase_return_report_model');
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
    }
	public function index()
	{
		$data['title']='Pharmacy::Purchase Entry Report';
		$data['activecls']='Purchase_return_report';
		$office_id=$this->session->office_id;
		$var_array=array($office_id);
		$data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
		$data['getitem']=$this->Common_model->getitemdata($var_array);
		$data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
		$content=$this->load->view('reports/purchase_return_report',$data,true);
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
        $sum_supplier=trim(htmlentities($this->input->post('sum_supplier')));
        $sum_modeofpay=trim(htmlentities($this->input->post('sum_modeofpay')));
        $var_array=array($sum_fromdate,$sum_todate,$sum_supplier,$sum_modeofpay,$this->session->userdata('office_id'));
	 	 $getresult=$this->Purchase_return_report_model->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_supplier,$sum_modeofpay,$this->session->userdata('office_id'));
		if($getresult)
		  {
		  	$html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_sum">
		  			<thead>
                    <tr>
                         <th>SL NO</th>
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
		  	foreach ($getresult as $data) {
		  		
		  			$html.='<tr>
			  					<td>'.$sl.'</td>
			  					<td>'.$data['supname'].'</td>
			  					<td>'.$data['purchase_return_date'].'</td>
			  					<td>'.$data['invoice_no'].'</td>
			  					<td>'.$data['username'].'</td>
			  					<td>'.$data['mode'].'</td>
			  					<td>'.$data['total_qty'].'</td>
			  					<td>'.$data['total_amount'].'</td>
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

   public function getsummaryr()
    {
      $this->form_validation->set_rules('sum_fromdater', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sum_todater', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $sum_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdater')))));
        $sum_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todater')))));
        $sum_supplier=trim(htmlentities($this->input->post('sum_supplierr')));
        $sum_modeofpay=trim(htmlentities($this->input->post('sum_modeofpayr')));
        $var_array=array($sum_fromdate,$sum_todate,$sum_supplier,$sum_modeofpay,$this->session->userdata('office_id'));
	 	 $getresult=$this->Purchase_return_report_model->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_supplier,$sum_modeofpay,$this->session->userdata('office_id'));
		  if($getresult)
		  {
		  	$html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_sumr">
		  			<thead>
                    <tr>
                         <th>SL NO</th>
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
		  	foreach ($getresult as $data) {
		  		
		  			$html.='<tr>
			  					<td>'.$sl.'</td>
			  					<td>'.$data['supname'].'</td>
			  					<td>'.$data['purchase_date'].'</td>
			  					<td>'.$data['invoice_no'].'</td>
			  					<td>'.$data['username'].'</td>
			  					<td>'.$data['mode'].'</td>
			  					<td>'.$data['total_qty'].'</td>
			  					<td>'.$data['total_amount'].'</td>
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

   public function getdetailed()
    {
      $this->form_validation->set_rules('det_fromdate', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_todate', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_fromdate')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_todate')))));
        $det_supplier=trim(htmlentities($this->input->post('det_supplier')));
        $det_modeofpay=trim(htmlentities($this->input->post('det_modeofpay')));
        $det_item=trim(htmlentities($this->input->post('det_item')));
	 	 $getresult=$this->Purchase_return_report_model->getdetailedreportmodel($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$this->session->userdata('office_id'),$det_item);
		  if($getresult)
		  {
		  	$html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
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
                         <th>Tax</th>
                         <th>CGST</th>
                         <th>SGST</th>
                         <th>MRP</th>
                         <th>Total</th>
                         
                        
                     </tr>
                     </thead>
                   <tbody>';
		  	$sl=1;
		  	$sumnetamount='0.00';
		  	foreach ($getresult as $data) {
         $am1= $data['cost_price']*$data['ret_quantity'];
         $am2=($am1*$data['tax_val'])/100;
		  		
		  			$html.='<tr>
			  					<td>'.$sl.'</td>
			  					<td>'.$data['supname'].'</td>
			  					<td>'.$data['purchase_return_date'].'</td>
			  					<td>'.$data['invoice_no'].'</td>
			  					<td>'.$data['itemcode'].'</td>
			  					<td>'.$data['itemname'].'</td>
			  					<td>'.$data['ret_quantity'].'</td>
			  					<td>'.$data['free'].'</td>
			  					<td>'.number_format((float)$data['cost_price'] ,2,'.', '').'</td>
                  <td>'.$data['tax_val'].'</td>
                  <td>'.number_format((float)$am2/2 ,2,'.', '').'</td>
                  <td>'.number_format((float)$am2/2 ,2,'.', '').'</td>
			  					<td>'.number_format((float)$data['mrp'] ,2,'.', '').'</td>
			  					<td>'.$data['tot_amount'].'</td>
			  					
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
                    <th></th>
                    <th></th>
			  						<th></th>
			  						<th>Total</th>
			  						<th>'.number_format((float)$sumnetamount ,2,'.', '').'</th>
			  				
			  					
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
