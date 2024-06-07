<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_entry_report extends CI_Controller {
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
        
        $this->load->model('Purchase_report_model');
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
    }
	public function index()
	{
		$data['title']='Optical::Purchase Entry Report';
		$data['activecls']='Purchase_entry_report';
		$office_id=$this->session->office_id;
		$var_array=array($office_id);
		$data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
		$data['getitem']=$this->Common_model->getitemdata($var_array);
		$data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
		$content=$this->load->view('reports/purchase_entry_report',$data,true);
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
	 	 $getresult=$this->Purchase_report_model->getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_supplier,$sum_modeofpay,$this->session->userdata('office_id'));
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
	 	 $getresult=$this->Purchase_report_model->getdetailedreportmodel($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$this->session->userdata('office_id'),$det_item);
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
                         <th>MRP</th>
                         <th>Total</th>
                         <th>Frame</th>
                         <th>Frame Type</th>
                         <th>Frame Color</th>
                         <th>Frame Model</th>
                         <th>Frame Size</th>
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
			  					<td>'.$frametype.'</td>
			  					<td>'.$framecolor.'</td>
			  					<td>'.$data['framemodel'].'</td>
			  					<td>'.$framesize.'</td>
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
    public function getdetailed1()
    {
    	error_reporting(0);
      $this->form_validation->set_rules('det_fromdate1', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_todate1', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('det_item1', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_fromdate1')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('det_todate1')))));
        $det_supplier='';
        $det_modeofpay=trim(htmlentities($this->input->post('det_modeofpay1')));
        $det_item=trim(htmlentities($this->input->post('det_item1')));
     $getresult=$this->Purchase_report_model->getdetailedreportmodel1($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$this->session->userdata('office_id'),$det_item);
    // print_R($getresult);exit;
      if($getresult)
      {
       	$html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_det1">
		  			<thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Days Count</th>
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
                         <th>Frame Type</th>
                         <th>Frame Color</th>
                         <th>Frame Model</th>
                         <th>Frame Size</th>
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

		  		$purdetaid=$data['purchase_details_id'];
        $getdataval=$this->Purchase_report_model->getCountPayment($purdetaid,10);
          if($getdataval)
          {
              $clr='';
             // $countday=$getdataval[0]['days'];
              $edate=$getdataval[0]['SubscriptionDueDate'];
              // $payment_date=date_create($edate);
              // $payment_date=date_format($payment_date,"d/m/Y");
              //$getres=$this->CheckNumber($countday);
               //$getresd=$this->CheckNumberf($countday);
              
          }
		  		
		  			$html.='<tr>
			  					<td>'.$sl.'</td>
			  					<td>'.$edate.' Days</td>
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
			  					<td>'.$frametype.'</td>
			  					<td>'.$framecolor.'</td>
			  					<td>'.$data['framemodel'].'</td>
			  					<td>'.$framesize.'</td>
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
   public function CheckNumber($x) {
    if ($x > 0)
      {$message = $x .'  Days More';}
    elseif ($x == 0)
      {$message = $x;}
    else
      {$message = $x .' Days expired';}
    return $message."\n";
  }

  public function CheckNumberf($x) {
    if ($x > 0)
      {$message = '';}
    elseif ($x == 0)
      {$message = '';}
    else
      {$message = 'style="background:red;color: #fff;"';}
    return $message."\n";
  }
}
