<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_return extends CI_Controller {
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
        
        $this->load->model('Sales_return_model');
        $this->load->model('Common_model');
        $this->load->model('Sales_models');
        
    }
	public function index()
	{
          $data['title']='Optical::Sales Return';
          $data['activecls']='Sales_return';
          $office_id=$this->session->office_id;
          $var_array=array($office_id);
		  $data['getinvoiceno']=$this->Common_model->GetSalesData($var_array);
		  $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
          $content=$this->load->view('transaction/sales_return/insert',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	public function getsalessaveddata()
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
          $var_array_child=array($getid);
          $getmasterdata=$this->Sales_models->Getmastertable($var_array);
          $getallclassfication=$this->Sales_models->getallclassfication($var_array_child);
          if($getallclassfication)
          {
              foreach ($getallclassfication as $data) {
                  $sl=1;
                  $bg='style="background:#a4ffde;"';
                  $stockin='<td style="display:none;"><input type="text" name="stock[]" id="stock_'.$sl.'" readonly="" class="form-control grid_table"  value="'.$data['stock'].'"></td>';
                  $itemclassfn='<td>'.$data['frametype'].'</td>
                                <td>'.$data['framecolor'].'</td>
                                <td>'.$data['framesize'].'</td>
                                <td>'.$data['framemodel'].'</td><td></td><td></td>
                                ';
                  $name=$data['name'];
                  $code=$data['code'];
                  $taxsec='<td class="mbl_view" style="display: none;">
                     <select name="tax_type[]" id="tax_type_'.$sl.'" style="font-size:12px" class="form-control grid_table disabled_select"><option value="0">Non Tax</option><option value="1">Inclusive</option><option value="2">Exclusive</option>
                     </select></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'.$sl.'" readonly="" value="'.$data['tax'].'"></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="cgst[]" id="cgst_'.$sl.'" readonly="" value="'.$data['cgst'].'"></td>
                   <td style="display: none;" class="vat mbl_view"><input type="text" class="form-control grid_table" name="sgst[]" id="sgst_'.$sl.'" readonly="" value="'.$data['sgst'].'" ></td>';
               
               
                $html.='<tr '.$bg.'>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td>'.$code.'</td>
                         <td><b>'.$name.'</b><input type="hidden" value="'.$name.'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$sl.'" value="'.$data['orginal_rate'].'"></td>
                         '.$stockin.'
                         <td><input type="text" readonly name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" ></td>
                         <td><input type="number" readonly step="any" name="sales_quantity[]" id="sales_quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>

                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>
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
              $getlensmasterdata=$this->Sales_models->Getlenstable($var_array_child);
              if($getlensmasterdata)
              {
                foreach ($getlensmasterdata as $data) {
                    
                  
                  $bg='style="background:#ffedb8;"';
                  $stockin='<td style="display:none;"><input type="hidden" name="stock[]" id="stock_'.$sl.'" readonly="" class="form-control grid_table" ></td>';
                  $itemclassfn='<td></td>
                                <td></td>
                                <td></td>
                                <td></td><td>'.$getlensmasterdata[0]['lens_type'].'</td><td>'.$getlensmasterdata[0]['lens_coating'].'</td>';
                  $name=$data['name'];
                  $code=$data['code'];
                  $taxsec='<td class="mbl_view" style="display:none;">
                    <input type="hidden" name="tax_type[]" id="tax_type_'.$sl.'"></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="gst[]" id="gst_'.$sl.'" readonly=""></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="cgst[]" id="cgst_'.$sl.'" readonly="" ></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="sgst[]" id="sgst_'.$sl.'" readonly=""  ></td>';  

                    $html.='<tr '.$bg.'>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td>'.$code.'</td>
                         <td><b>'.$name.'</b><input type="hidden" value="'.$name.'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$sl.'" value="'.$data['orginal_rate'].'"></td>
                         '.$stockin.'
                         <td><input type="text" readonly name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" ></td>
                         <td><input type="number" readonly step="any" name="sales_quantity[]" id="sales_quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>
                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>
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
   public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Sales_return_model->ajax_call($param);
           echo json_encode($response);
    }
public function fetch_data() 
       {
           
           $office_id=$this->session->office_id;
           $return=array(
               "sales_return"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "sales_return_date"=>date('Y-m-d',strtotime($this->input->post('sales_return_date'))),
                   "sales_return_time"=>($this->input->post('sales_return_time'))?$this->input->post('sales_return_time'):date('H:i:s'),
                   'sales_id'=>$this->input->post('sales_id'),
                   'total_qty'=>$this->input->post('total_qty'),
                   'total_cgst'=>$this->input->post('total_cgst'),
                   'total_sgst'=>$this->input->post('total_sgst'),
                   'total_amount'=>$this->input->post('total_amount'),
                   'discount_amount'=>$this->input->post('total_discount_amount'),
                   'discount_percentage'=>$this->input->post('total_discount_percentage'),
                   'other_charge'=>$this->input->post('other_charge'),
                   'advanced_amount'=>$this->input->post('paying_amount'),
                   'balance_amount'=>$this->input->post('balance_amount'),
                   'roundoff'=>$this->input->post('roundoff'),
                   'netamount'=>$this->input->post('invoice_amount'),
                   'modeofpay_id'=>$this->input->post('modeofpay_id'),
                   'expected_del_date'=>date('Y-m-d',strtotime($this->input->post('edate'))),
                   'status'=>$this->input->post('bill_status'),
                   'office_id'=> $office_id
               ),
             "sales_return_detail"=>array(
                 "product_type"=>$this->input->post('product_type'),
                 "item_id"=>$this->input->post('product_id'),
                 "rate"=>$this->input->post('selling_price'),
                 "orginal_rate"=>$this->input->post('original_selling_price'),
                 "sales_quantity"=>$this->input->post('sales_quantity'),
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
  public function savesalesreturn()
  {
    $this->form_validation->set_rules('sales_id', 'Sales bill no', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total qty', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('bill_status', 'Bill Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    $this->form_validation->set_rules('quantity[]', 'quantity', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('selling_price[]', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
   // $this->form_validation->set_rules('paying_amount', 'advanced amount', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
      
      if($this->form_validation->run() == TRUE)
      {
          $data=$this->fetch_data();
          $getresult=$this->Sales_return_model->savedata($data);
          if($getresult)
          {
              $this->msg='Saved Successfully';
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
        $chk_duplication=$this->Sales_return_model->deletechecksalesreturn($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $html='';
          $var_array_child=array($getid);
          $getmasterdata=$this->Sales_return_model->Getmastertable($var_array);
          $getallclassfication=$this->Sales_return_model->getallclassfication($var_array_child);
          if($getallclassfication)
          {
              foreach ($getallclassfication as $data) {
                  $sl=1;
                  $bg='style="background:#a4ffde;"';
                  $stockin='<td style="display:none;"><input type="text" name="stock[]" id="stock_'.$sl.'" readonly="" class="form-control grid_table"  value="'.$data['stock'].'"></td>';
                  $itemclassfn='<td>'.$data['frametype'].'</td>
                                <td>'.$data['framecolor'].'</td>
                                <td>'.$data['framesize'].'</td>
                                <td>'.$data['framemodel'].'</td><td></td><td></td>
                                ';
                  $name=$data['name'];
                  $code=$data['code'];
                  $taxsec='<td class="mbl_view" style="display: none;">
                     <select name="tax_type[]" id="tax_type_'.$sl.'" style="font-size:12px" class="form-control grid_table disabled_select"><option value="0">Non Tax</option><option value="1">Inclusive</option><option value="2">Exclusive</option>
                     </select></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'.$sl.'" readonly="" value="'.$data['tax'].'"></td>
                   <td style="display: none;"><input type="text" class="form-control grid_table" name="cgst[]" id="cgst_'.$sl.'" readonly="" value="'.$data['cgst'].'"></td>
                   <td style="display: none;" class="vat mbl_view"><input type="text" class="form-control grid_table" name="sgst[]" id="sgst_'.$sl.'" readonly="" value="'.$data['sgst'].'" ></td>';
               
               
                $html.='<tr '.$bg.'>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td>'.$code.'</td>
                         <td><b>'.$name.'</b><input type="hidden" value="'.$name.'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$sl.'" value="'.$data['orginal_rate'].'"></td>
                         '.$stockin.'
                         <td><input type="text" readonly name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" ></td>
                         <td><input type="number" readonly step="any" name="sales_quantity[]" id="sales_quantity_'.$sl.'" class="form-control grid_table" value="'.$data['sales_quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>

                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>
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
              $getlensmasterdata=$this->Sales_models->Getlenstable($var_array_child);
              if($getlensmasterdata)
              {
                foreach ($getlensmasterdata as $data) {
                    
                  
                  $bg='style="background:#ffedb8;"';
                  $stockin='<td style="display:none;"><input type="hidden" name="stock[]" id="stock_'.$sl.'" readonly="" class="form-control grid_table" ></td>';
                  $itemclassfn='<td></td>
                                <td></td>
                                <td></td>
                                <td></td><td>'.$getlensmasterdata[0]['lens_type'].'</td><td>'.$getlensmasterdata[0]['lens_coating'].'</td>';
                  $name=$data['name'];
                  $code=$data['code'];
                  $taxsec='<td class="mbl_view" style="display:none;">
                    <input type="hidden" name="tax_type[]" id="tax_type_'.$sl.'"></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="gst[]" id="gst_'.$sl.'" readonly=""></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="cgst[]" id="cgst_'.$sl.'" readonly="" ></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="sgst[]" id="sgst_'.$sl.'" readonly=""  ></td>';  

                    $html.='<tr '.$bg.'>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td>'.$code.'</td>
                         <td><b>'.$name.'</b><input type="hidden" value="'.$name.'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'.$sl.'" value="'.$data['orginal_rate'].'"></td>
                         '.$stockin.'
                         <td><input type="text" readonly name="selling_price[]" id="selling_price_'.$sl.'" class="form-control grid_table" value="'.$data['rate'].'" onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))" ></td>
                         <td><input type="number" readonly step="any" name="sales_quantity[]" id="sales_quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>
                        <td><input type="number" step="any" name="quantity[]" id="quantity_'.$sl.'" class="form-control grid_table" value="'.$data['quantity'].'"  onKeyUp="calcrow('.$sl.')"  onkeydown="changefocus(event,$(this))"   required  autocomplete="off"></td>
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

  public function editsalesreturn()
  {
    $this->form_validation->set_rules('edit_sales_return_id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
   $this->form_validation->set_rules('sales_id', 'Sales Bill No', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total qty', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay ID', 'trim|required|min_length[1]|max_length[100]|numeric');
    $this->form_validation->set_rules('bill_status', 'Bill Status', 'trim|required|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('invoice_amount', 'Invoice Amount', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
    $this->form_validation->set_rules('quantity[]', 'quantity', 'trim|required|min_length[1]|max_length[20]|numeric|greater_than[0]');
    $this->form_validation->set_rules('selling_price[]', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
  //  $this->form_validation->set_rules('paying_amount', 'advanced amount', 'trim|required|min_length[1]|max_length[100]|numeric|greater_than[0]');
      if($this->form_validation->run() == TRUE)
      {
        $edit_sales_return_id=trim(htmlentities($this->input->post('edit_sales_return_id')));
        $var_array=array($edit_sales_return_id,$this->session->userdata('office_id'));
     
          $data=$this->fetch_data();
          $getresult=$this->Sales_return_model->updatedata($data,$edit_sales_return_id);
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

  public function deletesalesreturn()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_sales_returnid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_sales_returnid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Sales_return_model->deletechecksalesreturn($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Sales_return_model->deletedata($delete_sales_returnid);
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

}
