<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_return extends CI_Controller {
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
        
        $this->load->model('Purchase_return_model');
        $this->load->model('Common_model');
        $this->load->model('Purchase_entry_model');
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Purchase_return_model->ajax_call($param);
           echo json_encode($response);
    }
	public function index()
	{
          $data['title']='Optical::Purchase Return';
          $data['activecls']='Purchase_return';
          $office_id=$this->session->office_id;
          $var_array=array($office_id);
		  $data['getinvoiceno']=$this->Common_model->getpurchasedata($var_array);
		  $data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
          $content=$this->load->view('transaction/purchase_return/insert',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	public function getpurchasedetails()
  {
      $this->form_validation->set_rules('purchase_id', 'Supp/Invoice No', 'trim|required|min_length[1]|max_length[100]|numeric');
      if($this->form_validation->run() == TRUE)
      {
      	$office_id=$this->session->userdata('office_id');
        $getid=trim(htmlentities($this->input->post('purchase_id')));
        $var_array=array($getid,$this->session->userdata('office_id'));
        $frame_array=array($this->session->userdata('office_id'));
        $var_framearray=array($getid);
        $chk_duplication=$this->Purchase_entry_model->deletecheckpurchaseentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getmasterdata=$this->Purchase_entry_model->Getmastertable($var_array);
          $getchilddata=$this->Purchase_entry_model->Getpurchasechildtable($var_array);
          $frame_type=$this->Common_model->GetframetypeData($frame_array);
          $frame_color=$this->Common_model->GetframecolorData($frame_array);
          $frame_model=$this->Common_model->GetframemodelData($frame_array);
          $frame_size=$this->Common_model->GetframesizeData($frame_array);
          $getmasterpotime=date("h:i:sa",strtotime($getmasterdata[0]['purchase_time']));
          if($getchilddata)
          {
            $demoframetype='';
            $demoframecolor='';
            $demoframemodel='';
            $demoframesize='';
                   if($frame_type)
                  {
                    foreach ($frame_type as $dataframetypeval) {
                        $demoframetype.='<option value="'.$dataframetypeval['frame_id'].'">'.$dataframetypeval['name'].'</option>';
                    }
                  }

                  if($frame_color)
                  {
                    foreach ($frame_color as $dataframecolorval) {
                        $demoframecolor.='<option value="'.$dataframecolorval['frame_id'].'" >'.$dataframecolorval['name'].'</option>';
                    }
                  }

                 $demoframemodel='';

                   if($frame_size)
                  {
                    foreach ($frame_size as $dataframesizeval) {
                        $demoframesize.='<option value="'.$dataframesizeval['frame_id'].'" >'.$dataframesizeval['name'].'</option>';
                    }
                  }

            $html='';
            $sl=1;
            $mulframetype ='';
            $mulframecolor ='';
            $mulframesize ='';
            $mulframemodel ='';
            $getframetype='';
            $getframecolor='';
            $getframemodel='';
            $getframesize='';
            foreach ($getchilddata as $data) {
                $id=$data['item_id'];
                $code=$data['code'];
                $item_name=$data['name'];
                $qty=$data['quantity'];
                $cost_price=$data['cost_price'];
                $landing_cost=$data['landing_cost'];
                $free=$data['free'];
                $mrp=$data['mrp'];
                $selling_price=$data['selling_price'];
                $dis_type=$data['dis_type'];
                $dis_amount=$data['dis_amount'];
                $total_amount=$data['tot_amount'];
                $cgst=$data['cgst'];
                $sgst=$data['sgst'];
                $mul_type =$data['mul_type'];
                $taxval =$data['tax_val'];
                $gst_selection_ind =$data['gst_selection_ind'];
                $gstseln='';
                $gstsely='';
                if($gst_selection_ind==0)
                {
                  $gstseln='selected';
                }
                else
                {
                  $gstsely='selected';
                }
                $mulsel='';
                $mulsell='';
                $styleind='';
                $stylemul='';
                if($mul_type==1)
                {
                	 $qry=$this->db->get_where("stock","item_id=$id and selling_price='".$selling_price."' and mrp='".$mrp."' and frame_type='".$data['frametype']."' and frame_color='".$data['framecolor']."'and frame_size='".$data['framesize']."' and frame_model='".$data['framemodel']."'  and office_id=$office_id");
                	  if($qry->num_rows()>0)
	                {
	                    $stockidval=$qry->row()->stock_id;
	                   
	                }
                  $stylemul='style="display:none;"';
                  $mulsel='selected';
                  if($frame_type)
                  {
                    $getframetype='';
                    foreach ($frame_type as $dataframetypeval) {
                          $frametypesel='';
                          if($dataframetypeval['frame_id']==$data['frametype'])
                          {
                            $frametypesel='selected';
                          }
                        $getframetype.='<option value="'.$dataframetypeval['frame_id'].'" '.$frametypesel.'>'.$dataframetypeval['name'].'</option>';
                    }
                  }

                  if($frame_color)
                  {
                    
                    foreach ($frame_color as $dataframecolorval) {
                          $framecolorsel='';
                          if($dataframecolorval['frame_id']==$data['framecolor'])
                          {
                            $framecolorsel='selected';
                          }
                        $getframecolor.='<option value="'.$dataframecolorval['frame_id'].'" '.$framecolorsel.'>'.$dataframecolorval['name'].'</option>';
                    }
                  }

                  $getframemodel=$data['framemodel'];

                   if($frame_size)
                  {
                    
                    foreach ($frame_size as $dataframesizeval) {
                          $framesizesel='';
                          if($dataframesizeval['frame_id']==$data['framesize'])
                          {
                            $framesizesel='selected';
                          }
                        $getframesize.='<option value="'.$dataframesizeval['frame_id'].'" '.$framesizesel.'>'.$dataframesizeval['name'].'</option>';
                    }
                  }
                }
                else
                {
                  $stockidval='';
                  $styleind='style="display:none;"';
                  $mulsell='selected';
                  $mulframetype =$data['frametype'];
                  $mulframecolor =$data['framecolor'];
                  $mulframesize =$data['framesize'];
                  $mulframemodel =$data['framemodel'];

                    $x = 1;
                    $b=0;
                    $mulframetypes=explode(',',$data['frametype']);
                    $mulframecolors=explode(',',$data['framecolor']);
                    $mulframesizes=explode(',',$data['framesize']);
                    $mulframemodels=explode(',',$data['framemodel']);
                    $stockval='';
                    while($x <= $qty) 
                    {
                    	if($mulframetypes[$b]>0 || $mulframecolors[$b]>0 || $mulframesizes[$b]>0 || $mulframemodels[$b]!='')
                        {
                          $qry=$this->db->get_where("stock","item_id=$id and selling_price='".$selling_price."' and mrp='".$mrp."' and frame_type='".$mulframetypes[$b]."' and frame_color='".$mulframecolors[$b]."'and frame_model='".$mulframemodels[$b]."' and frame_size='".$mulframesizes[$b]."'  and office_id=$office_id");
                                  //echo $this->db->last_query();
                              if($qry->num_rows()>0)
                                {
                                     $stock_id=$qry->row()->stock_id;
                                     $stockval.=$stock_id.',';
                                }
                                    
                        
                        }

                        $x++;
                        $b++;
                    }
                    $stockidval=$stockval;
                }
                $html.='<tr><td>'.$sl.'</td>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td><input type="hidden" id="producttid_'.$id.'" name="product_id[]" value="'.$id.'" >'.$code.'</td>
                          <td>'.$item_name.'<input  type="hidden"  name="product[]" value="'.$item_name.'" class="form-control grid_table" id="product_'.$id.'" readonly></td>
                          <td><input type="number" readonly  name="purchase_quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="purchase_quantity_'.$id.'" autocomplete="off"></td>
                          <td><input type="number"  name="quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="quantity_'.$id.'" autocomplete="off"></td>
                          <td style="display: none;"><input type="number"  name="free[]" value="'.$free.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="free_'.$id.'" autocomplete="off"></td>
                          <td><input type="number" readonly name="cost_price[]" id="cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td style="display: none;"><input readonly type="number" name="landing_cost[]" id="landing_cost_'.$id.'" value="'.$landing_cost.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" readonly name="mrp[]" id="mrp_'.$id.'" value="'.$mrp.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" readonly name="selling_price[]" id="selling_price_'.$id.'" value="'.$selling_price.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td><select name="discount_type[]" class="form-control grid_table" id="discount_type_'.$id.'" onchange="calcrow('.$id.')"><option value="0">A</option><option value="1">P</option></select></td>
                           <td><input type="text" name="discount_input[]" value="0" class="form-control grid_table" onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')" id="discount_input_'.$id.'" value="'.$dis_amount.'" ><input type="hidden" name="discount_amount[]" value="'.$dis_amount.'" id="discount_amount_'.$id.'" value=""></td>
                           <td style="display: none;"><select onchange="calcrow('.$id.')" id="gstselind_'.$id.'" name="gstselind[]" class="form-control grid_table"><option value="0" '.$gstseln.'>N</option><option value="1" '.$gstsely.'>Y</option></select></td>
                           <td style="display: none;"><input type="text" readonly name="tax[]" id="tax_'.$id.'" value="'.$taxval.'" class="form-control grid_table"  onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')"></td>
                           <td style="display: none;" class="vat"><input type="text"  name="cgst[]" id="cgst_'.$id.'" value="'.$cgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                            <td style="display: none;" class="vat"><input type="text"  name="sgst[]" id="sgst_'.$id.'" value="'.$sgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                           <td ><input type="text"  name="amount[]" id="amount_'.$id.'" value="'.$total_amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"><input type="hidden" name="tax_type[]" id="tax_type_'.$id.'" value=""><input type="hidden" name="tax_amount[]" id="tax_amount_'.$id.'" value="0" ></td>
                           <td style="display: none;"><select class="form-control grid_table" onchange="getchangetype('.$id.');" name="mul_type[]" id="ismultype_'.$id.'"><option value="1" '.$mulsel.'>N</option><option value="2" '.$mulsell.'>Y</option></select></td>
                          <td>
                           <div class="single_'.$id.'" '.$styleind.' >
                             <select   name="frametype[]"  class="form-control disabled_select grid_table">'.$getframetype.'</select>
                          </div>
                          <div  class="multiple_'.$id.'"  '.$stylemul.'>
                            <a href="#" id="mult_'.$id.'" class="table-link danger serial_number_setting" data-target="#myModalframe" data-toggle="modal" onclick="pop('.$id.')"><button class="btn btn-sm btn-danger">TCSM</button></a>
                            <input type="hidden" name="mulframetype[]" id="mulframetype_'.$id.'" class="form-control span2" value="'.$mulframetype.'">
                            <input type="hidden" name="mulframecolor[]" id="mulframecolor_'.$id.'" value="'.$mulframecolor.'" class="form-control span2">
                            <input type="hidden" name="mulframesize[]" id="mulframesize_'.$id.'" value="'.$mulframesize.'" class="form-control span2">
                            <input type="hidden" name="mulframemodel[]" id="mulframemodel_'.$id.'" value="'.$mulframemodel.'" class="form-control span2">
                            <input type="hidden" name="stock_id[]" id="stock_id_'.$id.'" value="'.$stockidval.'" class="form-control span2">
                            <input type="hidden" name="return_stock_id[]" id="return_stock_id_'.$id.'"  class="form-control span2">
                          </div>
                          </td>
                          <td><select '.$styleind.' name="framecolor[]" class="form-control disabled_select grid_table individual_'.$id.'">'.$getframecolor.'</select></td>
                          <td><select '.$styleind.' name="framesize[]" class="form-control disabled_select grid_table individual_'.$id.'">'.$getframesize.'</select></td>
                          <td><input '.$styleind.' type="text" name="framemodel[]" readonly class="form-control grid_table individual_'.$id.'" value="'.$getframemodel.'"></td>
                          
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
                  'getchilddata' => $html,
                  'demoframetype' => $demoframetype,
                  'demoframecolor' => $demoframecolor,
                  'demoframesize' => $demoframesize,
                  'demoframemodel' => $demoframemodel
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
public function fetch_data() 
       {
           
           $office_id=$this->session->office_id;
           $var_array=array($office_id);
           $return=array(
               "purchase_return"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "purchase_return_date"=>date('Y-m-d',strtotime($this->input->post('pur_ret_date'))),
                   "purchase_return_time"=>($this->input->post('pur_ret_time'))?$this->input->post('pur_ret_time'):date('H:i:s'),
                   "purchase_id"=>$this->input->post('purchase_entry_id'),
                   'gstyesno'=>$this->input->post('gst_selection'),
                   'tax_type'=>$this->input->post('gst_type'),
                   'total_qty'=>$this->input->post('total_qty'),
                   'total_free_qty'=>$this->input->post('total_free_qty'),
                   'total_cgst'=>$this->input->post('total_cgst'),
                   'total_sgst'=>$this->input->post('total_sgst'),
                   'total_amount'=>$this->input->post('total_amount'),
                   'discount_amount'=>$this->input->post('discount'),
                   'discount_percentage'=>$this->input->post('discount_percentage'),
                   'other_charge'=>$this->input->post('charge_amount'),
                   'modeofpay_id'=>$this->input->post('modeofpay_id'),
                   'net_amount'=>$this->input->post('net_amount'),
                   'office_id'=> $office_id
               ),
             "purchasereturn_detail"=>array(
                 "item_id"=>$this->input->post('product_id'),
                 "purchase_quantity"=>$this->input->post('purchase_quantity'),
                 "quantity"=>$this->input->post('quantity'),
                 "free"=>$this->input->post('free'),
                 "cost_price"=>$this->input->post('cost_price'),
                 "landing_cost"=>$this->input->post('landing_cost'),
                 "mrp"=>$this->input->post('mrp'),
                 "selling_price"=>$this->input->post('selling_price'),
                 "dis_type"=>$this->input->post('discount_type'),
                 "dis_amount"=>$this->input->post('discount_amount'),
                 "gst_selection_ind"=>$this->input->post('gstselind'),
                 "tax_val"=>$this->input->post('tax'),
                 "cgst"=>$this->input->post('cgst'),
                 "sgst"=>$this->input->post('sgst'),
                 "tot_amount"=>$this->input->post('amount'),
                 "mul_type"=>$this->input->post('mul_type'),
                 "frametype"=>$this->input->post('frametype'),
                 "framecolor"=>$this->input->post('framecolor'),
                 "framesize"=>$this->input->post('framesize'),
                 "framemodel"=>$this->input->post('framemodel'),
                 "mulframetype"=>$this->input->post('mulframetype'),
                 "mulframecolor"=>$this->input->post('mulframecolor'),
                 "mulframesize"=>$this->input->post('mulframesize'),
                 "mulframemodel"=>$this->input->post('mulframemodel'),
                 "return_stock_id"=>$this->input->post('return_stock_id'),
                 "stock_id"=>$this->input->post('stock_id')
             ),
           
           );
            return $return;
       }
public function savepurchasereturn()
  {
    $this->form_validation->set_rules('purchase_id', 'Purchase ID', 'trim|required|min_length[1]|max_length[10]');
    $this->form_validation->set_rules('purchase_entry_id', 'Purchase ID', 'trim|required|min_length[1]|max_length[10]|numeric');
    $this->form_validation->set_rules('pur_ret_date', 'Purchase Return  Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('pur_ret_time', 'Purchase Return time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('gst_type', 'Tax type', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('total_free_qty', 'Total Free Qty', 'trim|min_length[1]|max_length[6]|numeric');
    $this->form_validation->set_rules('total_cgst', 'Total CGST', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('total_sgst', 'Total SGST', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('discount_percentage', 'total_amount Discount Percentage', 'trim|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('charge_amount', 'Charge Amount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay', 'trim|min_length[1]|max_length[6]|numeric|required');
    $this->form_validation->set_rules('net_amount', 'Net Amount', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|min_length[1]|max_length[5]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('cost_price[]', 'Cost Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('landing_cost[]', 'Landing Cost', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('mrp[]', 'MRP', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('selling_price[]', 'Selling Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
     if($this->form_validation->run() == TRUE)
      {
        
          $data=$this->fetch_data();
          $getresult=$this->Purchase_return_model->savedata($data);
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
        $chk_duplication=$this->Purchase_return_model->deletecheckpurchasereturn($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getmasterdata=$this->Purchase_return_model->Getmastertable($var_array);
          $getchilddata=$this->Purchase_return_model->Getpurchasereturnchildtable($var_array);
          $frame_type=$this->Common_model->GetframetypeData($frame_array);
          $frame_color=$this->Common_model->GetframecolorData($frame_array);
          $frame_model=$this->Common_model->GetframemodelData($frame_array);
          $frame_size=$this->Common_model->GetframesizeData($frame_array);
          $getmasterpotime=date("h:i:sa",strtotime($getmasterdata[0]['purchase_return_time']));
          if($getchilddata)
          {
            $demoframetype='';
            $demoframecolor='';
            $demoframemodel='';
            $demoframesize='';
                   if($frame_type)
                  {
                    foreach ($frame_type as $dataframetypeval) {
                        $demoframetype.='<option value="'.$dataframetypeval['frame_id'].'">'.$dataframetypeval['name'].'</option>';
                    }
                  }

                  if($frame_color)
                  {
                    foreach ($frame_color as $dataframecolorval) {
                        $demoframecolor.='<option value="'.$dataframecolorval['frame_id'].'" >'.$dataframecolorval['name'].'</option>';
                    }
                  }

                 $demoframemodel='';

                   if($frame_size)
                  {
                    foreach ($frame_size as $dataframesizeval) {
                        $demoframesize.='<option value="'.$dataframesizeval['frame_id'].'" >'.$dataframesizeval['name'].'</option>';
                    }
                  }

            $html='';
            $sl=1;
            $mulframetype ='';
            $mulframecolor ='';
            $mulframesize ='';
            $mulframemodel ='';
            $getframetype='';
            $getframecolor='';
            $getframemodel='';
            $getframesize='';
            foreach ($getchilddata as $data) {
                $id=$data['item_id'];
                $code=$data['code'];
                $item_name=$data['name'];
                $purqty=$data['purchase_quantity'];
                $qty=$data['quantity'];
                $cost_price=$data['cost_price'];
                $landing_cost=$data['landing_cost'];
                $free=$data['free'];
                $mrp=$data['mrp'];
                $selling_price=$data['selling_price'];
                $dis_type=$data['dis_type'];
                $dis_amount=$data['dis_amount'];
                $total_amount=$data['tot_amount'];
                $cgst=$data['cgst'];
                $sgst=$data['sgst'];
                $mul_type =$data['mul_type'];
                $taxval =$data['tax_val'];
                $gst_selection_ind =$data['gst_selection_ind'];
                $gstseln='';
                $gstsely='';
                if($gst_selection_ind==0)
                {
                  $gstseln='selected';
                }
                else
                {
                  $gstsely='selected';
                }
                $mulsel='';
                $mulsell='';
                $styleind='';
                $stylemul='';
                if($mul_type==1)
                {
                  $return_stock_id='';
                  $stock_id=$data['stock_id'];
                  $stylemul='style="display:none;"';
                  $mulsel='selected';
                  if($frame_type)
                  {
                    $getframetype='';
                    foreach ($frame_type as $dataframetypeval) {
                          $frametypesel='';
                          if($dataframetypeval['frame_id']==$data['frametype'])
                          {
                            $frametypesel='selected';
                          }
                        $getframetype.='<option value="'.$dataframetypeval['frame_id'].'" '.$frametypesel.'>'.$dataframetypeval['name'].'</option>';
                    }
                  }

                  if($frame_color)
                  {
                    
                    foreach ($frame_color as $dataframecolorval) {
                          $framecolorsel='';
                          if($dataframecolorval['frame_id']==$data['framecolor'])
                          {
                            $framecolorsel='selected';
                          }
                        $getframecolor.='<option value="'.$dataframecolorval['frame_id'].'" '.$framecolorsel.'>'.$dataframecolorval['name'].'</option>';
                    }
                  }

                  $getframemodel=$data['framemodel'];

                   if($frame_size)
                  {
                    
                    foreach ($frame_size as $dataframesizeval) {
                          $framesizesel='';
                          if($dataframesizeval['frame_id']==$data['framesize'])
                          {
                            $framesizesel='selected';
                          }
                        $getframesize.='<option value="'.$dataframesizeval['frame_id'].'" '.$framesizesel.'>'.$dataframesizeval['name'].'</option>';
                    }
                  }
                }
                else
                {
                  $return_stock_id=$data['return_stock_id'];
                  $stock_id='';
                  $styleind='style="display:none;"';
                  $mulsell='selected';
                  $mulframetype =$data['frametype'];
                  $mulframecolor =$data['framecolor'];
                  $mulframesize =$data['framesize'];
                  $mulframemodel =$data['framemodel'];
                }
                 $html.='<tr><td>'.$sl.'</td>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td><input type="hidden" id="producttid_'.$id.'" name="product_id[]" value="'.$id.'" >'.$code.'</td>
                          <td>'.$item_name.'<input  type="hidden"  name="product[]" value="'.$item_name.'" class="form-control grid_table" id="product_'.$id.'" readonly></td>
                          <td><input type="number" readonly  name="purchase_quantity[]" value="'.$purqty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="purchase_quantity_'.$id.'" autocomplete="off"></td>
                          <td><input type="number"  name="quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="quantity_'.$id.'" autocomplete="off"></td>
                          <td style="display: none;"><input type="number"  name="free[]" value="'.$free.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="free_'.$id.'" autocomplete="off"></td>
                          <td><input type="number" name="cost_price[]" id="cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table" readonly   onKeyUp="calcrow('.$id.')" ></td>
                          <td style="display: none;"><input type="number" readonly name="landing_cost[]" id="landing_cost_'.$id.'" value="'.$landing_cost.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" readonly name="mrp[]" id="mrp_'.$id.'" value="'.$mrp.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" readonly name="selling_price[]" id="selling_price_'.$id.'" value="'.$selling_price.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td><select name="discount_type[]" class="form-control grid_table" id="discount_type_'.$id.'" onchange="calcrow('.$id.')"><option value="0">A</option><option value="1">P</option></select></td>
                           <td><input type="text" name="discount_input[]" value="0" class="form-control grid_table" onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')" id="discount_input_'.$id.'" value="'.$dis_amount.'" ><input type="hidden" name="discount_amount[]" value="'.$dis_amount.'" id="discount_amount_'.$id.'" value=""></td>
                           <td style="display: none;"><select onchange="calcrow('.$id.')" id="gstselind_'.$id.'" name="gstselind[]" class="form-control grid_table"><option value="0" '.$gstseln.'>N</option><option value="1" '.$gstsely.'>Y</option></select></td>
                           <td style="display: none;"><input type="text" readonly name="tax[]" id="tax_'.$id.'" value="'.$taxval.'" class="form-control grid_table"  onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')"></td>
                           <td style="display: none;" class="vat"><input type="text"  name="cgst[]" id="cgst_'.$id.'" value="'.$cgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                            <td style="display: none;" class="vat"><input type="text"  name="sgst[]" id="sgst_'.$id.'" value="'.$sgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                           <td ><input type="text"  name="amount[]" id="amount_'.$id.'" value="'.$total_amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"><input type="hidden" name="tax_type[]" id="tax_type_'.$id.'" value=""><input type="hidden" name="tax_amount[]" id="tax_amount_'.$id.'" value="0" ></td>
                           <td style="display: none;"><select class="form-control grid_table" onchange="getchangetype('.$id.');" name="mul_type[]" id="ismultype_'.$id.'"><option value="1" '.$mulsel.'>N</option><option value="2" '.$mulsell.'>Y</option></select></td>
                          <td>
                           <div class="single_'.$id.'" '.$styleind.' >
                             <select   name="frametype[]"  class="form-control disabled_select grid_table">'.$getframetype.'</select>
                          </div>
                          <div  class="multiple_'.$id.'"  '.$stylemul.'>
                            <a href="#" id="mult_'.$id.'" class="table-link danger serial_number_setting" data-target="#myModalframe" data-toggle="modal" onclick="pop('.$id.')"><button class="btn btn-sm btn-danger">TCSM</button></a>
                            <input type="hidden" name="mulframetype[]" id="mulframetype_'.$id.'" class="form-control span2" value="'.$mulframetype.'">
                            <input type="hidden" name="mulframecolor[]" id="mulframecolor_'.$id.'" value="'.$mulframecolor.'" class="form-control span2">
                            <input type="hidden" name="mulframesize[]" id="mulframesize_'.$id.'" value="'.$mulframesize.'" class="form-control span2">
                            <input type="hidden" name="mulframemodel[]" id="mulframemodel_'.$id.'" value="'.$mulframemodel.'" class="form-control span2">
                            <input type="hidden" name="stock_id[]" id="stock_id_'.$id.'" value="'.$stock_id.'" class="form-control span2">
                            <input type="hidden" name="return_stock_id[]" value="'.$return_stock_id.'" id="return_stock_id_'.$id.'"  class="form-control span2">
                          </div>
                          </td>
                          <td><select '.$styleind.' name="framecolor[]" class="form-control disabled_select grid_table individual_'.$id.'">'.$getframecolor.'</select></td>
                          <td><select '.$styleind.' name="framesize[]" class="form-control disabled_select grid_table individual_'.$id.'">'.$getframesize.'</select></td>
                          <td><input '.$styleind.' type="text" name="framemodel[]" readonly class="form-control grid_table individual_'.$id.'" value="'.$getframemodel.'"></td>
                          
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
                  'getchilddata' => $html,
                  'demoframetype' => $demoframetype,
                  'demoframecolor' => $demoframecolor,
                  'demoframesize' => $demoframesize,
                  'demoframemodel' => $demoframemodel
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


   public function editpurchasereturn()
  {
    $this->form_validation->set_rules('edit_purchase_return_id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('purchase_id', 'Purchase ID/Invoice No', 'trim|required|min_length[1]|max_length[15]');
    
    $this->form_validation->set_rules('pur_ret_date', 'Purchase Return  Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('pur_ret_time', 'Purchase Return  Time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('gst_type', 'Tax type', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('total_free_qty', 'Total Free Qty', 'trim|min_length[1]|max_length[6]|numeric');
    $this->form_validation->set_rules('total_cgst', 'Total CGST', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('total_sgst', 'Total SGST', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('discount_percentage', 'total_amount Discount Percentage', 'trim|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('charge_amount', 'Charge Amount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('modeofpay_id', 'Modeofpay', 'trim|min_length[1]|max_length[6]|numeric|required');
    $this->form_validation->set_rules('net_amount', 'Net Amount', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|min_length[1]|max_length[5]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('cost_price[]', 'Cost Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('landing_cost[]', 'Landing Cost', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('mrp[]', 'MRP', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('selling_price[]', 'Selling Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
      if($this->form_validation->run() == TRUE)
      {
        $edit_purchase_return_id=trim(htmlentities($this->input->post('edit_purchase_return_id')));
        $var_array=array($edit_purchase_return_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Purchase_return_model->deletecheckpurchasereturn($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $data=$this->fetch_data();
          $getresult=$this->Purchase_return_model->updatedata($data,$edit_purchase_return_id);
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

  public function deletepurchasereturn()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[10]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_purchasereturnid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_purchasereturnid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Purchase_return_model->deletecheckpurchasereturn($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Purchase_return_model->deletedata($delete_purchasereturnid);
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
