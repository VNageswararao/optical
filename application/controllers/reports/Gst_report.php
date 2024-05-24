<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gst_report extends CI_Controller {
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
		$data['title']='Optical::GST Report';
		$data['activecls']='Gst_report';
		$office_id=$this->session->office_id;
		$var_array=array($office_id);
        $data['tax']=$this->Item_model->gettax($var_array);
        $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
		$content=$this->load->view('reports/gst_report',$data,true);
		$this->load->view('includes/layout',['content'=>$content]);
	}

	public function getgstreport()   // summary 
     {
     	//error_reporting(0);
     	$discount_sum=0;
     	$other_charge_sum=0;
     	$roundoff_sum=0;
     	$gross_amount_sum=0;
        $is_vat= $this->session->is_vat;
        $office_id=$this->session->office_id;
        $taxs=$this->db->get('tax_master')->result();
        $frmdate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_fromdate')))));
        $todate=trim(htmlentities(date('Y-m-d',strtotime($this->input->post('sum_todate')))));
        $taxy=$this->input->post('tax');
        $mode=$this->input->post('mode');
        $taxcon=$modecon='';
        if($taxy)
        {
            $taxcon=" and sales_details.tax=".$taxy;
            $taxs= $this->db->get_where('tax_master', array('name =' => $taxy))->result();
            
        }

        $mode=$this->input->post('mode');
         if($mode)
        {
            $modecon=" and sales_master.modeofpay_id=".$mode;
        }
        $qry="select sales_master.*,customer.name as name,sales_master.sales_id,sum(sales_details.total_amount) as amount,sales_master.other_charge,sales_master.discount_amount";
        $qry.=" from sales_master";
        $qry.=" inner join customer on sales_master.customer_id=customer.customer_id";
        $qry.=" inner join sales_details on sales_master.sales_id=sales_details.sales_id";
         $qry.=" where  sales_master.sales_date>='$frmdate' and sales_master.sales_date<='$todate'  and sales_master.office_id=".$office_id."  ".$taxcon."  ".$modecon." group by sales_details.sales_id";
     
        $result=$this->db->query($qry)->result();

         $url='Gst_report/print/'.$frmdate.'/'.$todate.'/'.$taxy.'/'.$mode;
    
       $html='<div class="row"><div class="col-md-8"></div><div class="col-md-4"><a href="'.$url.'" target="_blank"><button type="button" class="btn btn-danger"><i class="la la-print"></i></button></a></div></div><table class="table table-striped m-b-none table-bordered" id="example_sum"><thead>
       			<tr>
       				<th>SL NO</th>
       				<th>Sales Date</th>
       				<th>Invoice No</th>
       				<th>Customer Name</th>
       				<th>TAXABLE</th>
					<th>Discount</th>
       				';
       				$non_taxable_sum=0;
       				foreach ($taxs as $tax)
			        {
			             $amount_sum="amount_sum_".$tax->tax_id;
           			     $$amount_sum=0;
						$cgst_sum="cgst_sum_".$tax->tax_id;
						$sgst_sum="sgst_sum_".$tax->tax_id;
						//$igst_sum="igst_sum_".$tax->tax_id;
						$$cgst_sum=$$sgst_sum=0;
			             $html.='<th>'.$tax->name.' % TAXABLE</th>
			            		<th> CGST '.($tax->name/2).' %</th>
			            		<th> SGST '.($tax->name/2).' %</th>';

			        }
       			$html.='<th>Other Charge</th><th>Round Off</th><th>Gross Amount</th>
       			</tr></thead><tbody>';
        $i=1;
        foreach($result as $row)
        {
        	$html.='<tr>
        				<td>'.$i.'</td>
        				<td>'.date('d/m/Y', strtotime($row->sales_date)).'</td>
        				<td>'.$row->invoice_number.'</td>
        				<td>'.$row->name.'</td>';
        	       
           $qry_tax="select sum(sales_details.total_amount) as  amount
                       from  sales_details
                       inner join item_master on sales_details.item_id=item_master.item_id  and sales_details.sales_id=$row->sales_id";
           $row_tax=$this->db->query($qry_tax)->row();
            $non_taxable_sum+=$row->amount ;
            $html.='<td>'.number_format($row_tax->amount ).'</td>
			<td>'.$row->discount_amount.'</td>';
			
			$id_tax="select DISTINCT tax
                       from  sales_details
                       where sales_id=$row->sales_id";
					 
           $id_tax=$this->db->query($id_tax)->result();
		   	
        foreach ($taxs as $tax)
        {
             $qry_tax="select sum(sales_details.total_amount) as  amount,sum(sales_details.cgst) as cgst,sum(sales_details.sgst) as sgst,sales_details.tax as tax_val,sales_details.quantity 
                       from  sales_details
                       where  sales_details.tax=$tax->name and sales_details.sales_id=$row->sales_id";
                $row_tax=$this->db->query($qry_tax)->row();
                //echo $this->db->last_query();
			 if(count($id_tax) =="2"){
				 
					$dis_per_iten = ($row->discount_amount / $row->total_qty) * $row_tax->quantity;
				}else{
					
					$dis_per_iten = ($row->discount_amount) * $row_tax->quantity;
				} 
				//$dis_per_iten = ($row->discount_amount * $row_tax->quantity) / $row->total_qty;
				$gst_sum = ($row_tax->amount-$dis_per_iten)*(($row_tax->tax_val)/100)/2;
				
				//print_r($row->discount_amount/$row->total_qty);exit;  
				//$gst_sum = ($row_tax->amount-($row_tax->amount*(100/(100+$row_tax->tax_val))))/2;
				//print_r($row_tax->amount);exit;
                $cgst_sum="cgst_sum_".$tax->tax_id;
                $sgst_sum="sgst_sum_".$tax->tax_id;
                //$igst_sum="igst_sum_".$tax->tax_id;
                $$cgst_sum+=$gst_sum;
                $$sgst_sum+=$gst_sum;
                $gst_val=$gst_sum + $gst_sum;
				//print_r($gst_val);exit;  
              //  echo "hello-".$row_tax->amount;
				$per_amount = ($row_tax->amount-$dis_per_iten) - $gst_val;
				//$per_amount = ($row_tax->amount-$dis_per_iten);
				if ($per_amount < 0) $per_amount = 0;
				$html.='<td>'.round($per_amount,2).'</td>'; 
				
                $html.='<td>'.round($gst_sum,2).'</td>
                		<td>'.round($gst_sum,2).'</td>
                		';
  
        }
         $html.='
         		<td>'.$row->other_charge.'</td>
         		<td>'.$row->roundoff.'</td>
         		<td>'.$row->netamount.'</td></tr>';
       
        
        $discount_sum+=$row->discount_amount;
        $charge=0;
        if($row->other_charge)
        {
        	$charge=$row->other_charge;
        }

        $other_charge_sum+=$charge;
        $roundoff_sum+=$row->roundoff;
        $gross_amount_sum+=$row->netamount;
        
           
            $i++;
        }
        $html.='</tbody><tfoot>
        		<tr>
        			<td>'.$i.'</td>
        			<td>Total</td>
        			<td></td>
        			<td></td>
        			
        			<td>'.round($non_taxable_sum,2).'</td>
					<td>'.round($discount_sum,2).'</td>';
					

        
        foreach ($taxs as $tax)
        {
             $amount_sum="amount_sum_".$tax->tax_id;
             $html.='<td></td>';
           
           
                $cgst_sum="cgst_sum_".$tax->tax_id;
                $sgst_sum="sgst_sum_".$tax->tax_id;
               
                  $html.='<td>'.round($$cgst_sum,2).'</td>
                		  <td>'.round($$sgst_sum,2).'</td>';
              
          
        }
         $html.='
                <td>'.round($other_charge_sum,2).'</td>
                <td>'.round($roundoff_sum,2).'</td>
                <td>'.round($gross_amount_sum,2).'</td>
              ';
        $html.='</tr>
        </tfoot></table>';

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

     public function print($sum_fromdate,$sum_todate,$taxy='',$mode='')
  {
    error_reporting(0);
    $office_id=$this->session->userdata('office_id');
    $sum_modeofpay='';
    $staff='';
    $status='';
    $sum_customer='';
    $supplier_id='';
   ;
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
$taxs=$this->db->get('tax_master')->result();

     $taxcon=$modecon='';
        if($taxy)
        {
            $taxcon=" and sales_details.tax=".$taxy;
            $taxs= $this->db->get_where('tax_master', array('name =' => $taxy))->result();
            
        }

      
         if($mode)
        {
            $modecon=" and sales_master.modeofpay_id=".$mode;
        }

        $qry="select sales_master.*,customer.name as name,sales_master.sales_id,sum(sales_details.total_amount) as amount,sales_master.other_charge,sales_master.discount_amount";
        $qry.=" from sales_master";
        $qry.=" inner join customer on sales_master.customer_id=customer.customer_id";
        $qry.=" inner join sales_details on sales_master.sales_id=sales_details.sales_id";
         $qry.=" where  sales_master.sales_date>='$sum_fromdate' and sales_master.sales_date<='$sum_todate'  and sales_master.office_id=".$office_id."  ".$taxcon."  ".$modecon." group by sales_details.sales_id";

        $result=$this->db->query($qry)->result();

         
       $html='<table style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1"><thead>
                <tr>
                    <th>SL NO</th>
                    <th>Sales Date</th>
                    <th>Invoice No</th>
                    <th>Customer Name</th>
                    <th>TAXABLE</th>
                    ';
                    $non_taxable_sum=0;
                    foreach ($taxs as $tax)
                    {
                         $amount_sum="amount_sum_".$tax->tax_id;
                         $$amount_sum=0;
                        $cgst_sum="cgst_sum_".$tax->tax_id;
                        $sgst_sum="sgst_sum_".$tax->tax_id;
                        //$igst_sum="igst_sum_".$tax->tax_id;
                        $$cgst_sum=$$sgst_sum=0;
                         $html.='<th>'.$tax->name.' % TAXABLE</th>
                                <th> CGST '.($tax->name/2).' %</th>
                                <th> SGST '.($tax->name/2).' %</th>';

                    }
                $html.='<th>Discount</th><th>Other Charge</th><th>Round Off</th><th>Gross Amount</th>
                </tr></thead><tbody>';
        $i=1;
        foreach($result as $row)
        {
            $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.date('d/m/Y', strtotime($row->sales_date)).'</td>
                        <td>'.$row->invoice_number.'</td>
                        <td>'.$row->name.'</td>';
                   
           $qry_tax="select sum(sales_details.total_amount) as  amount
                       from  sales_details
                       inner join item_master on sales_details.item_id=item_master.item_id  and sales_details.sales_id=$row->sales_id";
           $row_tax=$this->db->query($qry_tax)->row();
            $non_taxable_sum+=$row->amount;
            $html.='<td>'.$row_tax->amount.'</td>';
           
        foreach ($taxs as $tax)
        {
             $qry_tax="select sum(sales_details.total_amount) as  amount,sum(sales_details.cgst) as cgst,sum(sales_details.sgst) as sgst,sales_details.tax as tax_val
                       from  sales_details
                       inner join item_master on sales_details.item_id=item_master.item_id and sales_details.tax_type>0 and item_master.tax=$tax->tax_id and sales_details.sales_id=$row->sales_id";
               $row_tax=$this->db->query($qry_tax)->row();

				//$gst_sum = ($row_tax->amount-$row->discount_amount)*($row_tax->tax_val/100)/2;
				$gst_sum = (($row_tax->amount-$row->discount_amount)-(($row_tax->amount-$row->discount_amount)*(100/(100+$row_tax->tax_val))))/2;
				
                $cgst_sum="cgst_sum_".$tax->tax_id;
                $sgst_sum="sgst_sum_".$tax->tax_id;
                //$igst_sum="igst_sum_".$tax->tax_id;
                $$cgst_sum+=$gst_sum;
                $$sgst_sum+=$gst_sum;
                //$$igst_sum+=$row_tax->igst;
				$html.='<td>'.round(($row_tax->amount-$row->discount_amount)*(100/(100+$row_tax->tax_val)),2).'</td>'; 
				
                $html.='<td>'.round($gst_sum,2).'</td>
                		<td>'.round($gst_sum,2).'</td>
                		';
               
         
            
        }
         $html.='<td>'.$row->discount_amount.'</td>
                <td>'.$row->other_charge.'</td>
                <td>'.$row->roundoff.'</td>
                <td>'.$row->netamount.'</td></tr>';
       
        
        $discount_sum+=$row->discount_amount;
        $charge=0;
        if($row->other_charge)
        {
            $charge=$row->other_charge;
        }

        $other_charge_sum+=$charge;
        $roundoff_sum+=$row->roundoff;
        $gross_amount_sum+=$row->netamount;
        
           
            $i++;
        }
        $html.='</tbody><tfoot>
                <tr>
                    <td>'.$i.'</td>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    
                    <td>'.round($non_taxable_sum,2).'</td>';

        
        foreach ($taxs as $tax)
        {
             $amount_sum="amount_sum_".$tax->tax_id;
             $html.='<td></td>';
           
           
                $cgst_sum="cgst_sum_".$tax->tax_id;
                $sgst_sum="sgst_sum_".$tax->tax_id;
               
                  $html.='<td>'.round($$cgst_sum,2).'</td>
                          <td>'.round($$sgst_sum,2).'</td>';
              
          
        }
         $html.='<td>'.round($discount_sum,2).'</td>
                <td>'.round($other_charge_sum,2).'</td>
                <td>'.round($roundoff_sum,2).'</td>
                <td>'.round($gross_amount_sum,2).'</td>
              ';
        $html.='</tr>
        </tfoot></table>';

   
    

   
          $data['htmldata']=$html;

     $htmld=$this->load->view("reports/salesreportprint",$data, true); 
                   $print_config=[
                                    'format' => 'A4-L',
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
            $mpdf->WriteHTML($htmld);
            $mpdf->Output();
  }

}