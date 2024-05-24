<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_report extends CI_Controller {
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
        
        $this->load->model('Stock_report_model');
        $this->load->model('Common_model');
    }
	public function index()
	{
		$data['title']='Optical::Stock Report';
		$data['activecls']='Stock_report';
		$office_id=$this->session->office_id;
		$var_array=array($office_id);
		$data['getitem']=$this->Common_model->getitemdata($var_array);
    $data['getcategory']=$this->Common_model->getcategory($var_array);
    $data['getlens']=$this->Common_model->getlensmaster($var_array);
		$content=$this->load->view('reports/Stock_report',$data,true);
		$this->load->view('includes/layout',['content'=>$content]);
	}

    public function getsummary()
    {
      $this->form_validation->set_rules('sum_productname', 'Item Name', 'trim|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        
        $itemname=trim(htmlentities($this->input->post('sum_productname')));
        $category_id=trim(htmlentities($this->input->post('category_id')));
	 	 $getresult=$this->Stock_report_model->getsummaryreportmodel($itemname,$category_id,$this->session->userdata('office_id'));
		  if($getresult)
		  {

        $stockqty=$this->db->query("select sum(quantity) as qtys  from stock where quantity>0")->row();

		  	$html='<div class="row">
                  <div class="col-md-12">
                      <div class="alert alert-success mb-2" role="alert">
                       <h4 style="text-align:center;font-weight:bold;">TOTAL STOCK:'.number_format((float)$stockqty->qtys
            ,2,'.', '').'</h4>
                       </div>
                  </div>
                  </div>
                  <table class="table table-striped table-bordered dataex-html5-selectors" id="example_sum">
		  			<thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Item Name</th>
                         <th>Cost Price</th>
                         <th>MRP</th>
                         <th>Stock</th>
                         <th>Stock Value</th>
                     </tr>
                     </thead>
                   <tbody>';
		  	$sl=1;
		  	$sumnetamount='0.00';
        
		  	foreach ($getresult as $data) {
          $stock=0;
		  		if($data['stock'])
          {
            $stock=$data['stock'];
          }
          $getpurchaseval=$this->Stock_report_model->getcolrepmdl($data['item_id'],$data['mrp']);
          if($getpurchaseval)
          {
            $cp=$getpurchaseval[0]['cost_price'];
          }
          else
          {
            $cp=0;
          }
          if($data['stock']>0)
          {
            
		  			$html.='<tr>
			  					<td>'.$sl.'</td>
			  					<td>'.$data['name'].'</td>
                  <td>'.$cp.'</td>
                  <td>'.$data['mrp'].'</td>
			  					<td>'.$stock.'</td>
                  <td>'.$cp*$stock.'</td>
		  					</tr>';
		  					$sl++;
		  					$sumnetamount+=$data['stock'];
          }
          
		  	}
		  				$html.='
		  						
		  						<tr>
				  					<th>'.$sl.'</th>
                    <th></th>
                    <th></th>
				  					<th>Total</th>
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
  public function getlens_adjstment()
    {
     
        
        $le_from_date=trim(htmlentities($this->input->post('le_from_date')));
        $le_to_date=trim(htmlentities($this->input->post('le_to_date')));
        $lens_stock_type=trim(htmlentities($this->input->post('lens_stock_type')));
        if($lens_stock_type==1)
        {
       $getresult=$this->Stock_report_model->Get_stockdetails($le_from_date,$le_to_date);
     //  print_r($getresult);exit;
      if($getresult)
      {

       

        $html='
                  <table class="table table-striped table-bordered dataex-html5-selectors" id="example_sums">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Supplier Name</th>
                         <th>Sales Bill No</th>
                         <th>Adjsutment Date</th>
                         <th>Adjustment Number</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
     
        
        foreach ($getresult as $data) {
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['supname'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['adjustment_date'].'</td>
                  <td>'.$data['number'].'</td>
                 
                </tr>';
                $sl++;
          
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
            $getresult=$this->Stock_report_model->Get_stockdetails1($le_from_date,$le_to_date);
     //  print_r($getresult);exit;
      if($getresult)
      {

       

        $html='
                  <table class="table table-striped table-bordered dataex-html5-selectors" id="example_sums">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Customer Name</th>
                         <th>Supplier Name</th>
                         <th>Sales Bill No</th>
                         <th>Adjsutment Date</th>
                         <th>Adjustment Number</th>
                         <th>Item Name</th>
                         <th>Adjustment Quantity</th>
                         <th>Action</th>
                         <th>Rate</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
     
        
        foreach ($getresult as $data) {
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['cusname'].'</td>
                  <td>'.$data['supname'].'</td>
                  <td>'.$data['invoice_number'].'</td>
                  <td>'.$data['adjustment_date'].'</td>
                  <td>'.$data['number'].'</td>
                  <td>'.$data['lensname'].'</td>
                  <td>'.$data['quantity'].'</td>
                  <td>'.$data['action'].'</td>
                  <td>'.$data['rate'].'</td>
                 
                </tr>';
                $sl++;
          
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
     
        
      
  }
   public function getsummary_lens()
    {
      $this->form_validation->set_rules('lens_item', 'Item Name', 'trim|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        
         $itemname=trim(htmlentities($this->input->post('lens_item')));
                 $category_id='';
     $getresult=$this->Stock_report_model->getsummaryreportmodel_lens($itemname,$category_id,$this->session->userdata('office_id'));
      if($getresult)
      {

        $stockqty=$this->db->query("select sum(quantity) as qtys  from lens_stock ")->row();

        $html='<div class="row">
                  <div class="col-md-12">
                      <div class="alert alert-success mb-2" role="alert">
                       <h4 style="text-align:center;font-weight:bold;">TOTAL STOCK:'.number_format((float)$stockqty->qtys
            ,2,'.', '').'</h4>
                       </div>
                  </div>
                  </div>
                  <table class="table table-striped table-bordered dataex-html5-selectors" id="example_lens">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Item Name</th>
                         <th>Cost Price</th>
                         <th>MRP</th>
                         <th>Stock</th>
                         <th>Stock Value</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        
        foreach ($getresult as $data) {
          $stock=0;
          if($data['stock'])
          {
            $stock=$data['stock'];
          }
          $cp=$data['cp'];
          if($data['stock']>0)
          {
            
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['name'].'</td>
                  <td>'.$cp.'</td>
                  <td>'.$data['mrp'].'</td>
                  <td>'.$stock.'</td>
                  <td>'.$cp*$stock.'</td>
                </tr>';
                $sl++;
                $sumnetamount+=$data['stock'];
          }
          
        }
              $html.='
                  
                  <tr>
                    <th>'.$sl.'</th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
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
	 	 $getresult=$this->Sales_report_model->getdetailedreportmodel($det_fromdate,$det_todate,$det_customer,$det_modeofpay,$this->session->userdata('office_id'),$det_item,$det_lens);
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
                         <th>Item Type</th>
                         <th>Frame Type</th>
                         <th>Frame Color</th>
                         <th>Frame Size</th>
                         <th>Frame Model</th>
                         <th>Lens Type</th>
                         <th>Lens Coating</th>
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
			  					<td>'.$frame_type.'</td>
			  					<td>'.$frame_color.'</td>
			  					<td>'.$frame_size.'</td>
			  					<td>'.$framemodel.'</td>
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
  public function getstockRegister ()
  {
      // echo ($this->input->post('from_date'));exit;
    $this->form_validation->set_rules('from_date', 'From Date', 'trim|required|min_length[1]|max_length[20]');
    $this->form_validation->set_rules('to_date', 'To Date', 'trim|required|min_length[1]|max_length[20]');
    $this->form_validation->set_rules('det_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
    $this->form_validation->set_rules('det_lens', 'Lens', 'trim|min_length[1]|max_length[20]|numeric');
    if($this->form_validation->run() == TRUE)
    {
      $det_fromdate=$from_date=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('from_date')))));
      $det_todate=$to_date=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('to_date')))));
      $det_item=trim(htmlentities($this->input->post('det_item')));
    $getresult=$this->Stock_report_model->getstockregistermodel($det_fromdate,$det_todate,$this->session->userdata('office_id'),$det_item);
    if($getresult)
    {
      $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_det">
          <thead>
                  <tr>
                       <th>SL NO</th>
                       <th>Product Id</th>
                       <th>Product Name</th>
                       <th>CP</th>
                       <th>MRP</th>
                       <th>Stock Value</th>
                       <th>Opening Stock</th>
                       <th>Purchase Stock</th>
                       <th>Purchase Return</th>
                       <th>Sales</th>
                       <th>Sales Return</th>
                       <th>Stock Adjustment</th>
                       <th>Closing Stock</th>
                   </tr>
                   </thead>
                 <tbody>';
      $sl=1;
      $sumnetamount='0.00';
      foreach ($getresult as $data) {
          
          $opening_stock = $data['total_stock'];

          $getpurchaseval = $this->Stock_report_model->getcolrepmdl_dd($data['item_id'], $data['mrp']);
           $mrp = $data['mrp'];
          if ($getpurchaseval) {
            $cp = $getpurchaseval[0]['cost_price'];
             $mrp = $getpurchaseval[0]['mrp'];
            
          } else {
            $cp = 0;
          }

         
      //     $purchase_qty=$this->db->query("select sum(purchase_details.quantity) as purchase_qty
      //                          from purchase_details
      //                          inner join purchase on purchase_details.purchase_id=purchase.purchase_id
      //                          where purchase_date>='$from_date' and item_id=".$data['item_id'] )->row()->purchase_qty;
      //    $opening_stock-=$purchase_qty;
         
      //    //start purchase stock//
      //    $purchase_stock=$this->db->query("select sum(purchase_details.quantity) as purchase_qty
      //                          from purchase_details
      //                          inner join purchase on purchase_details.purchase_id=purchase.purchase_id
      //                          where purchase_date>='$from_date' and purchase_date<='$to_date' and item_id=".$data['item_id'])->row()->purchase_qty;
      //    //end purchase stock//
          
      //    $purchase_return_qty=$this->db->query("select sum(quantity) as purchase_return_qty
      //                          from purchase_return_details
      //                          inner join purchase_return on purchase_return_details.purchase_return_id=purchase_return.purchase_return_id
      //                          where purchase_return_date>='$from_date' and item_id=".$data['item_id'])->row()->purchase_return_qty;
         
      //    $opening_stock+=$purchase_return_qty;
         
      //     //start purchase return//
      //    $purchase_return_stock=$this->db->query("select sum(quantity) as purchase_return_qty
      //                          from purchase_return_details
      //                          inner join purchase_return on purchase_return_details.purchase_return_id=purchase_return.purchase_return_id
      //                          where purchase_return_date>='$from_date' and purchase_return_date<='$to_date' and item_id=".$data['item_id'])->row()->purchase_return_qty;
      //    //end purchase return//
         
      //    $sales_qty= $this->db->query("select sum(quantity) as qty
      //                                  from sales_details
      //                                  inner join sales_master on sales_details.sales_id=sales_master.sales_id
      //                                  where product_type=1 and  sales_date>='$from_date' and item_id=".$data['item_id'])->row()->qty;
      //    $opening_stock+=$sales_qty;
         
      //    //start sales stock//
      //    $sales_stock= $this->db->query("select sum(quantity) as qty
      //                                  from sales_details
      //                                  inner join sales_master on sales_details.sales_id=sales_master.sales_id
      //                                  where  product_type=0 and sales_date>='$from_date' and sales_date<='$to_date' and item_id=".$data['item_id'])->row()->qty;
      //   // echo $this->db->last_query();exit;
      //    //end sales stock//
         
        
         
      //    $sales_return_qty= $this->db->query("select sum(quantity) as qty
      //                                  from sales_return_details
      //                                  inner join sales_return on sales_return_details.sales_return_id=sales_return.sales_return_id
      //                                  where sales_return_date>='$from_date' and item_id=".$data['item_id'])->row()->qty;
      //    $opening_stock-=$sales_return_qty;
         
      //     //start sales_return stock//
      //    $sales_return_stock= $this->db->query("select sum(quantity) as qty
      //                                  from sales_return_details
      //                                  inner join sales_return on sales_return_details.sales_return_id=sales_return.sales_return_id
      //                                  where sales_return_date>='$from_date' and sales_return_date<='$to_date' and item_id=".$data['item_id'])->row()->qty;
      //    //end sales_return stock//
         
          
      //      $opening_stock-= $this->db->query("select ifnull(sum(quantity),0) as quantity
      //                                              from stock_adjustment_details
      //                                              inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
      //                                              where adjustment_date>='$from_date' and stock_adjustment_details.item_id=".$data['item_id']." and action=1 ")->row()->quantity;
      // //   echo $this->db->last_query();exit;
      //     $opening_stock+= $this->db->query("select ifnull(sum(quantity),0) as quantity
      //                                              from stock_adjustment_details
      //                                              inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
      //                                              where adjustment_date>='$from_date' and stock_adjustment_details.item_id=".$data['item_id']." and action=2 ")->row()->quantity;
      //     //end opening stock
          
      //      //start stock adjustment//
      //    $stock_adj_add= $this->db->query("select ifnull(sum(quantity),0) as quantity
      //                                              from stock_adjustment_details
      //                                              inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
      //                                              where adjustment_date>='$from_date' and adjustment_date<='$to_date' and action=1 and  stock_adjustment_details.item_id=".$data['item_id'])->row()->quantity;;
        
      //     $stock_adj_sub= $this->db->query("select ifnull(sum(quantity),0) as quantity
      //                                              from stock_adjustment_details
      //                                              inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
      //                                              where adjustment_date>='$from_date' and adjustment_date<='$to_date' and action=2 and stock_adjustment_details.item_id=".$data['item_id'])->row()->quantity;;
         
      //    //end stock adjustment//
         
        
         
         
         
        
          
        
      //   //start closing stock//
      //    $closing_stock=$opening_stock+$purchase_stock-$purchase_return_stock-$sales_stock+$sales_return_stock+$stock_adj_add-$stock_adj_sub;


           $purchase_qty = $this->db->query("select sum(purchase_details.quantity) as purchase_qty
                                 from purchase_details
                                 inner join purchase on purchase_details.purchase_id=purchase.purchase_id
                                 where purchase_date>='$from_date' and item_id=" . $data['item_id'])->row()->purchase_qty;
          $opening_stock -= $purchase_qty;

          //start purchase stock//
          $purchase_stock = $this->db->query("select sum(purchase_details.quantity) as purchase_qty
                                 from purchase_details
                                 inner join purchase on purchase_details.purchase_id=purchase.purchase_id
                                 where purchase_date>='$from_date' and purchase_date<='$to_date' and item_id=" . $data['item_id'])->row()->purchase_qty;
          //end purchase stock//

          $purchase_return_qty = $this->db->query("select sum(quantity) as purchase_return_qty
                                 from purchase_return_details
                                 inner join purchase_return on purchase_return_details.purchase_return_id=purchase_return.purchase_return_id
                                 where purchase_return_date>='$from_date' and item_id=" . $data['item_id'])->row()->purchase_return_qty;

          $opening_stock += $purchase_return_qty;

          //start purchase return//
          $purchase_return_stock = $this->db->query("select sum(quantity) as purchase_return_qty
                                 from purchase_return_details
                                 inner join purchase_return on purchase_return_details.purchase_return_id=purchase_return.purchase_return_id
                                 where purchase_return_date>='$from_date' and purchase_return_date<='$to_date' and item_id=" . $data['item_id'])->row()->purchase_return_qty;
          //end purchase return//

          $sales_qty = $this->db->query("select sum(quantity) as qty
                                         from sales_details
                                         inner join sales_master on sales_details.sales_id=sales_master.sales_id
                                         where sales_date>='$from_date' and item_id=" . $data['item_id'])->row()->qty;
          $opening_stock += $sales_qty;

          //start sales stock//
          $sales_stock = $this->db->query("select sum(quantity) as qty
                                         from sales_details
                                         inner join sales_master on sales_details.sales_id=sales_master.sales_id
                                         where sales_date>='$from_date' and sales_date<='$to_date' and item_id=" . $data['item_id'])->row()->qty;
          //end sales stock//



          $sales_return_qty = $this->db->query("select sum(quantity) as qty
                                         from sales_return_details
                                         inner join sales_return on sales_return_details.sales_return_id=sales_return.sales_return_id
                                         where sales_return_date>='$from_date' and item_id=" . $data['item_id'])->row()->qty;
          $opening_stock -= $sales_return_qty;

          //start sales_return stock//
          $sales_return_stock = $this->db->query("select sum(quantity) as qty
                                         from sales_return_details
                                         inner join sales_return on sales_return_details.sales_return_id=sales_return.sales_return_id
                                         where sales_return_date>='$from_date' and sales_return_date<='$to_date' and item_id=" . $data['item_id'])->row()->qty;
          //end sales_return stock//


          $opening_stock -= $this->db->query("select ifnull(sum(quantity),0) as quantity
                                                     from stock_adjustment_details
                                                     inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
                                                     where adjustment_date>='$from_date' and stock_adjustment_details.item_id=" . $data['item_id'] . " and action=1 ")->row()->quantity;
          //   echo $this->db->last_query();exit;
          $opening_stock += $this->db->query("select ifnull(sum(quantity),0) as quantity
                                                     from stock_adjustment_details
                                                     inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
                                                     where adjustment_date>='$from_date' and stock_adjustment_details.item_id=" . $data['item_id'] . " and action=2 ")->row()->quantity;
          //end opening stock

          //start stock adjustment//
          $stock_adj_add = $this->db->query("select ifnull(sum(quantity),0) as quantity
                                                     from stock_adjustment_details
                                                     inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
                                                     where adjustment_date>='$from_date' and adjustment_date<='$to_date' and action=1 and  stock_adjustment_details.item_id=" . $data['item_id'])->row()->quantity;;

          $stock_adj_sub = $this->db->query("select ifnull(sum(quantity),0) as quantity
                                                     from stock_adjustment_details
                                                     inner join stock_adjustment on stock_adjustment_details.stock_adjustment_id=stock_adjustment.stock_adjustment_id
                                                     where adjustment_date>='$from_date' and adjustment_date<='$to_date' and action=2 and stock_adjustment_details.item_id=" . $data['item_id'])->row()->quantity;;

          //end stock adjustment//








          //start closing stock//
          $closing_stock = $opening_stock + $purchase_stock - $purchase_return_stock - $sales_stock + $sales_return_stock + $stock_adj_add - $stock_adj_sub;



          if($closing_stock>0)
          {


        
          $html.='<tr>
                <td>'.$sl.'</td>
                <td>'.$data['item_id'].'</td>
                <td>'.$data['name'].'</td>
                <td>' . $cp . '</td>
                  <td>' . $mrp . '</td>
                   <td>'.$cp*$closing_stock.'</td>
                 
                <td>'.$opening_stock.'</td>
                <td>'.$purchase_stock.'</td>
                <td>'.$purchase_return_stock.'</td>
                <td>'.$sales_stock.'</td>
                <td>'.$sales_return_stock.'</td>
                <td>'."+".$stock_adj_add."/"."-".$stock_adj_sub.'</td>
                <td>'.$closing_stock.'</td>
              </tr>';
              $sl++;
            }
              
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

  public function getsalesstockRegister()
    {
      $this->form_validation->set_rules('sfrom_date', 'From Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sto_date', 'To Date', 'trim|required|min_length[1]|max_length[20]');
      $this->form_validation->set_rules('sdet_item', 'Item', 'trim|min_length[1]|max_length[20]|numeric');
      
      if($this->form_validation->run() == TRUE)
      {
        $det_fromdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sfrom_date')))));
        $det_todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sto_date')))));
        $det_item=trim(htmlentities($this->input->post('sdet_item')));
    
     $getresult=$this->Stock_report_model->Get_Stock_Reg($det_fromdate,$det_todate,$det_item,$this->session->userdata('office_id'));
      if($getresult)
      {
        $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_dets">
            <thead>
                    <tr>
                         <th>SL NO</th>
                         <th>Item Name</th>
                         <th>Frame Model</th>
                         <th>Date</th>
                         <th>Qty</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        foreach ($getresult as $data) {
          
          
            $html.='<tr>
                  <td>'.$sl.'</td>
                  <td>'.$data['framename'].'</td>
                  <td>'.$data['frame_model'].'</td>
                  <td>'.$data['sales_date'].'</td>
                  <td>'.$data['quantity'].'</td>
                </tr>';
                $sl++;
                $sumnetamount+=$data['quantity'];
        }
              $html.='
                  
                  <tr>
                    <th>'.$sl.'</th>
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
