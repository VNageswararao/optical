<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_entry extends CI_Controller {
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
        
        $this->load->model('Purchase_entry_model');
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
    }
	public function index()
	{
		$data['title']='Optical::Purchase Entry';
		$data['activecls']='Purchase_entry';
		$office_id=$this->session->office_id;
		$var_array=array($office_id);
		$data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
		$data['getitem']=$this->Common_model->getitemdata($var_array);
		$data['getpono']=$this->Purchase_entry_model->getbillno($var_array);
		$data['getmodeofpay']=$this->Common_model->GetModeofpayData($var_array);
		$content=$this->load->view('transaction/purchase_entry/insert',$data,true);
		$this->load->view('includes/layout',['content'=>$content]);
	}
  public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Purchase_entry_model->ajax_call($param);
           echo json_encode($response);
    }
	public function getproductdetails()
  {
      $this->form_validation->set_rules('getid', 'Product ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $getid=trim(htmlentities($this->input->post('getid')));
        $var_array=array($getid,$this->session->userdata('office_id'));
        $frame_array=array($this->session->userdata('office_id'));
        $chk_duplication=$this->Common_model->checkproduct($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Common_model->GetitemDatadetaxtails($var_array);
          //$getlastcostprice=$this->Purchase_order_model->Getitemcplcmrpspdetails($var_array);
          $getlastcostprice=0;
          if($getlastcostprice)
          {
            $getlastcostprice=$getlastcostprice;
          }
          else
          {
            $getlastcostprice=0;
          }
          $frame_type=$this->Common_model->GetframetypeData($frame_array);
          $frame_color=$this->Common_model->GetframecolorData($frame_array);
          $frame_model=$this->Common_model->GetframemodelData($frame_array);
          $frame_size=$this->Common_model->GetframesizeData($frame_array);
          if($getresult)
          {

              $this->msg='success';
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'error_message' => $this->error_message,
                  'getdata' => $getresult,
                  'getcpdata' => $getlastcostprice,
                  'getframetypedata' => $frame_type,
                  'getframecolordata' => $frame_color,
                  'getframemodeldata' => $frame_model,
                  'getframesizedata' => $frame_size
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
            $this->error='Product ID Not Found';
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
   public function editpurchaseentry()
  {
    $this->form_validation->set_rules('edit_purchase_id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
   $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('pe_date', 'Purchase  Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('pe_time', 'Purchase  time', 'trim|required|min_length[1]|max_length[15]');
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
    $chkframes=array(
             "purchaseentry_detail"=>array(
                 "item_id"=>$this->input->post('product_id'),
                 "quantity"=>$this->input->post('quantity'),
                 "mul_type"=>$this->input->post('mul_type'),
                 "frametype"=>$this->input->post('frametype'),
                 "framecolor"=>$this->input->post('framecolor'),
                 "framesize"=>$this->input->post('framesize'),
                 "framemodel"=>$this->input->post('framemodel'),
                 "mulframetype"=>$this->input->post('mulframetype'),
                 "mulframecolor"=>$this->input->post('mulframecolor'),
                 "mulframesize"=>$this->input->post('mulframesize'),
                 "mulframemodel"=>$this->input->post('mulframemodel')
             ),
           
           );
      $purchaseentry_details=$chkframes['purchaseentry_detail'];
      $item_ids=$purchaseentry_details['item_id'];
      $quantitys=$purchaseentry_details['quantity'];
      $mul_types=$purchaseentry_details['mul_type'];
      $frametypes=$purchaseentry_details['frametype'];
      $framecolors=$purchaseentry_details['framecolor'];
      $framesizes=$purchaseentry_details['framesize'];
      $framemodels=$purchaseentry_details['framemodel'];
      $mulframetypes=$purchaseentry_details['mulframetype'];
      $mulframecolors=$purchaseentry_details['mulframecolor'];
      $mulframesizes=$purchaseentry_details['mulframesize'];
      $mulframemodels=$purchaseentry_details['mulframemodel'];
      $i=0;
      foreach ($item_ids as $item_id) 
      {
             if($mul_types[$i]==1)
            {
                if($frametypes[$i]>0 || $framecolors[$i]>0 || $framesizes[$i]>0 || $framemodels[$i]!='')
                if($frametypes[$i]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($framecolors[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framesizes[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framemodels[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
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
              $qty=$quantitys[$i];
              $x = 1;
              $b=0;
              $mulframetype=explode(',',$mulframetypes[$i]);
              $mulframecolor=explode(',',$mulframecolors[$i]);
              $mulframesize=explode(',',$mulframesizes[$i]);
              $mulframemodel=explode(',',$mulframemodels[$i]);
              while($x <= $qty) 
              {
                if($mulframetype[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframecolor[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframesize[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframemodel[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                $x++;
                $b++;
              }
          }
      }
      if($this->form_validation->run() == TRUE)
      {
        $edit_purchase_id=trim(htmlentities($this->input->post('edit_purchase_id')));
        $var_array=array($edit_purchase_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Purchase_entry_model->deletecheckpurchaseentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $data=$this->fetch_data();
          $getresult=$this->Purchase_entry_model->updatedata($data,$edit_purchase_id);
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
  public function getsavedata()
  {
      $this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $getid=trim(htmlentities($this->input->post('getid')));
        $var_array=array($getid,$this->session->userdata('office_id'));
        $frame_array=array($this->session->userdata('office_id'));
        $var_framearray=array($getid);
        $chk_duplication=$this->Purchase_entry_model->deletecheckpurchaseentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getmasterdata=$this->Purchase_entry_model->Getmastertable($var_array);
          $getchilddata=$this->Purchase_entry_model->Getpurchasechildtable($var_array);
          //$getpurchaseframedata=$this->Purchase_order_model->Getpurchaseorderframetable($var_framearray);
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
                  $styleind='style="display:none;"';
                  $mulsell='selected';
                  $mulframetype =$data['frametype'];
                  $mulframecolor =$data['framecolor'];
                  $mulframesize =$data['framesize'];
                  $mulframemodel =$data['framemodel'];
                }
                $id=$sl;
                $html.='<tr><td>'.$sl.'</td>
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet();chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td><input type="hidden" id="calrow_id_'.$id.'" name="calrow_id[]" value="'.$sl.'" ><input type="hidden" id="producttid_'.$id.'" name="product_id[]" value="'.$data['item_id'].'" >'.$code.'</td>
                          <td>'.$item_name.'<input  type="hidden"  name="product[]" value="'.$item_name.'" class="form-control grid_table" id="product_'.$id.'" readonly></td>
                          <td><input type="number"  name="quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="quantity_'.$id.'" autocomplete="off"></td>
                          <td style="display: none;"><input type="number"  name="free[]" value="'.$free.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="free_'.$id.'" autocomplete="off"></td>
                          <td><input type="number" name="cost_price[]" id="cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="landing_cost[]" id="landing_cost_'.$id.'" value="'.$landing_cost.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input '.$styleind.' type="text" name="framemodel[]" class="form-control grid_table individual_'.$id.'" value="'.$getframemodel.'"></td>
                          <td><input type="number" name="mrp[]" id="mrp_'.$id.'" value="'.$mrp.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="selling_price[]" id="selling_price_'.$id.'" value="'.$selling_price.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td><select name="discount_type[]" class="form-control grid_table" id="discount_type_'.$id.'" onchange="calcrow('.$id.')"><option value="0">A</option><option value="1">P</option></select></td>
                           <td><input type="text" name="discount_input[]" value="0" class="form-control grid_table" onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')" id="discount_input_'.$id.'" value="'.$dis_amount.'" ><input type="hidden" name="discount_amount[]" value="'.$dis_amount.'" id="discount_amount_'.$id.'" value=""></td>
                           <td style="display: none;"><select onchange="calcrow('.$id.')" id="gstselind_'.$id.'" name="gstselind[]" class="form-control grid_table"><option value="0" '.$gstseln.'>N</option><option value="1" '.$gstsely.'>Y</option></select></td>
                           <td style="display: none;"><input type="text" readonly name="tax[]" id="tax_'.$id.'" value="'.$taxval.'" class="form-control grid_table"  onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')"></td>
                           <td style="display: none;" class="vat"><input type="text"  name="cgst[]" id="cgst_'.$id.'" value="'.$cgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                            <td style="display: none;" class="vat"><input type="text"  name="sgst[]" id="sgst_'.$id.'" value="'.$sgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                           <td ><input type="text"  name="amount[]" id="amount_'.$id.'" value="'.$total_amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"><input type="hidden" name="tax_type[]" id="tax_type_'.$id.'" value=""><input type="hidden" name="tax_amount[]" id="tax_amount_'.$id.'" value="0" ></td>
                           <td><select class="form-control grid_table" onchange="getchangetype('.$id.');" name="mul_type[]" id="ismultype_'.$id.'"><option value="1" '.$mulsel.'>N</option><option value="2" '.$mulsell.'>Y</option></select></td>
                          <td>
                           <div class="single_'.$id.'" '.$styleind.' >
                             <select   name="frametype[]"  class="form-control grid_table">'.$getframetype.'</select>
                          </div>
                          <div  class="multiple_'.$id.'"  '.$stylemul.'>
                            <a href="#" id="mult_'.$id.'" class="table-link danger serial_number_setting" data-target="#myModalframe" data-toggle="modal" onclick="pop('.$id.')"><button class="btn btn-sm btn-danger">TCSM</button></a>
                            <input type="hidden" name="mulframetype[]" id="mulframetype_'.$id.'" class="form-control span2" value="'.$mulframetype.'">
                            <input type="hidden" name="mulframecolor[]" id="mulframecolor_'.$id.'" value="'.$mulframecolor.'" class="form-control span2">
                            <input type="hidden" name="mulframesize[]" id="mulframesize_'.$id.'" value="'.$mulframesize.'" class="form-control span2">
                            <input type="hidden" name="mulframemodel[]" id="mulframemodel_'.$id.'" value="'.$mulframemodel.'" class="form-control span2">
                          </div>
                          </td>
                          <td><select '.$styleind.' name="framecolor[]" class="form-control grid_table individual_'.$id.'">'.$getframecolor.'</select></td>
                          <td><select '.$styleind.' name="framesize[]" class="form-control grid_table individual_'.$id.'">'.$getframesize.'</select></td>
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
  
  public function bulk_getsavedata()
  {
     
        $getid=$this->session->userdata('login_id');
        $var_array=array($getid,$this->session->userdata('office_id'));
        $frame_array=array($this->session->userdata('office_id'));
        
          
          $getmasterdata=$this->Purchase_entry_model->temp_Getmastertable($var_array);
		  if($getmasterdata) {
			  $var_array1=array($getmasterdata[0]['purchase_id'],$this->session->userdata('office_id'));
		  }else{
			  $var_array1="";
		  }
		 
          $getchilddata=$this->Purchase_entry_model->temp_Getpurchasechildtable($var_array1);
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
                  $styleind='style="display:none;"';
                  $mulsell='selected';
                  $mulframetype =$data['frametype'];
                  $mulframecolor =$data['framecolor'];
                  $mulframesize =$data['framesize'];
                  $mulframemodel =$data['framemodel'];
                }
                $id=$sl;
                $html.='<tr><td>'.$sl.'</td>
                         <td><a href="#" onclick="$(this).parent().parent().remove();bulk_calcnet();bulk_chkcount();"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td><input type="hidden" id="bulk_calrow_id_'.$id.'" name="bulk_calrow_id[]" value="'.$sl.'" ><input type="hidden" id="bulk_producttid_'.$id.'" name="bulk_product_id[]" value="'.$data['item_id'].'" >'.$code.'</td>
                          <td>'.$item_name.'<input  type="hidden"  name="bulk_product[]" value="'.$item_name.'" class="form-control grid_table" id="bulk_product_'.$id.'" readonly></td>
                          <td><input type="number"  name="bulk_quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="bulk_quantity_'.$id.'" autocomplete="off"></td>
                          <td style="display: none;"><input type="number"  name="bulk_free[]" value="'.$free.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="bulk_free_'.$id.'" autocomplete="off"></td>
                          <td><input type="number" name="bulk_cost_price[]" id="bulk_cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="bulk_landing_cost[]" id="bulk_landing_cost_'.$id.'" value="'.$landing_cost.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input '.$styleind.' type="text" name="bulk_framemodel[]" class="form-control grid_table individual_'.$id.'" value="'.$getframemodel.'"></td>
                          <td><input type="number" name="bulk_mrp[]" id="bulk_mrp_'.$id.'" value="'.$mrp.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="bulk_selling_price[]" id="bulk_selling_price_'.$id.'" value="'.$selling_price.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td><select name="bulk_discount_type[]" class="form-control grid_table" id="bulk_discount_type_'.$id.'" onchange="calcrow('.$id.')"><option value="0">A</option><option value="1">P</option></select></td>
                           <td><input type="text" name="bulk_discount_input[]" value="0" class="form-control grid_table" onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')" id="bulk_discount_input_'.$id.'" value="'.$dis_amount.'" ><input type="hidden" name="bulk_discount_amount[]" value="'.$dis_amount.'" id="bulk_discount_amount_'.$id.'" value=""></td>
                           <td style="display: none;"><select onchange="calcrow('.$id.')" id="bulk_gstselind_'.$id.'" name="bulk_gstselind[]" class="form-control grid_table"><option value="0" '.$gstseln.'>N</option><option value="1" '.$gstsely.'>Y</option></select></td>
                           <td style="display: none;"><input type="text" readonly name="bulk_tax[]" id="bulk_tax_'.$id.'" value="'.$taxval.'" class="form-control grid_table"  onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')"></td>
                           <td style="display: none;" class="vat"><input type="text"  name="bulk_cgst[]" id="bulk_cgst_'.$id.'" value="'.$cgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                            <td style="display: none;" class="vat"><input type="text"  name="bulk_sgst[]" id="bulk_sgst_'.$id.'" value="'.$sgst.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                           <td ><input type="text"  name="bulk_amount[]" id="bulk_amount_'.$id.'" value="'.$total_amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"><input type="hidden" name="bulk_tax_type[]" id="bulk_tax_type_'.$id.'" value=""><input type="hidden" name="bulk_tax_amount[]" id="bulk_tax_amount_'.$id.'" value="0" ></td>
                           <td><select class="form-control grid_table" onchange="getchangetype('.$id.');" name="bulk_mul_type[]" id="bulk_ismultype_'.$id.'"><option value="1" '.$mulsel.'>N</option><option value="2" '.$mulsell.'>Y</option></select></td>
                          <td>
                           <div class="single_'.$id.'" '.$styleind.' >
                             <select   name="bulk_frametype[]"  class="form-control grid_table">'.$getframetype.'</select>
                          </div>
                          <div  class="multiple_'.$id.'"  '.$stylemul.'>
                            <a href="#" id="bulk_mult_'.$id.'" class="table-link danger serial_number_setting" data-target="#myModalframe" data-toggle="modal" onclick="pop('.$id.')"><button class="btn btn-sm btn-danger">TCSM</button></a>
                            <input type="hidden" name="bulk_mulframetype[]" id="bulk_mulframetype_'.$id.'" class="form-control span2" value="'.$mulframetype.'">
                            <input type="hidden" name="bulk_mulframecolor[]" id="bulk_mulframecolor_'.$id.'" value="'.$mulframecolor.'" class="form-control span2">
                            <input type="hidden" name="bulk_mulframesize[]" id="bulk_mulframesize_'.$id.'" value="'.$mulframesize.'" class="form-control span2">
                            <input type="hidden" name="bulk_mulframemodel[]" id="bulk_mulframemodel_'.$id.'" value="'.$mulframemodel.'" class="form-control span2">
                          </div>
                          </td>
                          <td><select '.$styleind.' name="bulk_framecolor[]" class="form-control grid_table individual_'.$id.'">'.$getframecolor.'</select></td>
                          <td><select '.$styleind.' name="bulk_framesize[]" class="form-control grid_table individual_'.$id.'">'.$getframesize.'</select></td>
                         </tr>';
                         $sl++;
            }
            
          }
         
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

   public function get_purchase_order()
  {
      $this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $getid=trim(htmlentities($this->input->post('getid')));
        $var_array=array($getid,$this->session->userdata('office_id'));
        $frame_array=array($this->session->userdata('office_id'));
        $var_framearray=array($getid);
        $chk_duplication=$this->Purchase_order_model->deletecheckpurchaseorder($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getmasterdata=$this->Purchase_order_model->Getmastertable($var_array);
          $getchilddata=$this->Purchase_entry_model->Getchildtable($var_array);
          $getpurchaseframedata=$this->Purchase_order_model->Getpurchaseorderframetable($var_framearray);
          $frame_type=$this->Common_model->GetframetypeData($frame_array);
          $frame_color=$this->Common_model->GetframecolorData($frame_array);
          $frame_model=$this->Common_model->GetframemodelData($frame_array);
          $frame_size=$this->Common_model->GetframesizeData($frame_array);
          $getmasterpotime=date("h:i:sa",strtotime($getmasterdata[0]['purchase_order_time']));
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

                  if($frame_model)
                  {
                    foreach ($frame_model as $dataframemodelval) {
                        $demoframemodel.='<option value="'.$dataframemodelval['frame_id'].'" >'.$dataframemodelval['name'].'</option>';
                    }
                  }

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
                $total_amount=$data['total_amount'];
                $mul_type =$data['mul_type'];
                $taxval =$data['taxval'];
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
                          <td><input type="number"  name="quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="quantity_'.$id.'" autocomplete="off"></td>
                          <td style="display:none;"><input type="number"  name="free[]" value="" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="free_'.$id.'" autocomplete="off"></td>
                          <td><input type="number" name="cost_price[]" id="cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td style="display:none;"><input type="number" name="landing_cost[]" id="landing_cost_'.$id.'" value="" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="mrp[]" id="mrp_'.$id.'" value="" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="selling_price[]" id="selling_price_'.$id.'" value="" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td><select name="discount_type[]" class="form-control grid_table" id="discount_type_'.$id.'" onchange="calcrow('.$id.')"><option value="0">A</option><option value="1">P</option></select></td>
                           <td><input type="text" name="discount_input[]" value="0" class="form-control grid_table" onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')" id="discount_input_'.$id.'" value=""><input type="hidden" name="discount_amount[]" value="0" id="discount_amount_'.$id.'" value=""></td>
                           <td style="display:none;"><select onchange="calcrow('.$id.')" id="gstselind_'.$id.'" name="gstselind[]" class="form-control grid_table"><option value="0" '.$gstseln.'>N</option><option value="1" '.$gstsely.'>Y</option></select></td>
                           <td style="display:none;"><input type="text" readonly name="tax[]" id="tax_'.$id.'" value="'.$taxval.'" class="form-control grid_table"  onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')"></td>
                           <td style="display:none;" class="vat"><input type="text"  name="cgst[]" id="cgst_'.$id.'" value="0" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                            <td style="display:none;" class="vat"><input type="text"  name="sgst[]" id="sgst_'.$id.'" value="0" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                           <td><input type="text"  name="amount[]" id="amount_'.$id.'" value="'.$total_amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"><input type="hidden" name="tax_type[]" id="tax_type_'.$id.'" value=""><input type="hidden" name="tax_amount[]" id="tax_amount_'.$id.'" value="0" ></td>
                           <td><select class="form-control grid_table" onchange="getchangetype('.$id.');" name="mul_type[]" id="ismultype_'.$id.'"><option value="1" '.$mulsel.'>N</option><option value="2" '.$mulsell.'>Y</option></select></td>
                          <td>
                           <div class="single_'.$id.'" '.$styleind.' >
                             <select   name="frametype[]"  class="form-control grid_table">'.$getframetype.'</select>
                          </div>
                          <div  class="multiple_'.$id.'"  '.$stylemul.'>
                            <a href="#" id="mult_'.$id.'" class="table-link danger serial_number_setting" data-target="#myModalframe" data-toggle="modal" onclick="pop('.$id.')"><button class="btn btn-sm btn-danger">TCSM</button></a>
                            <input type="hidden" name="mulframetype[]" id="mulframetype_'.$id.'" class="form-control span2" value="'.$mulframetype.'">
                            <input type="hidden" name="mulframecolor[]" id="mulframecolor_'.$id.'" value="'.$mulframecolor.'" class="form-control span2">
                            <input type="hidden" name="mulframesize[]" id="mulframesize_'.$id.'" value="'.$mulframesize.'" class="form-control span2">
                            <input type="hidden" name="mulframemodel[]" id="mulframemodel_'.$id.'" value="'.$mulframemodel.'" class="form-control span2">
                          </div>
                          </td>
                          <td><select '.$styleind.' name="framecolor[]" class="form-control grid_table individual_'.$id.'">'.$getframecolor.'</select></td>
                          <td><select '.$styleind.' name="framesize[]" class="form-control grid_table individual_'.$id.'">'.$getframesize.'</select></td>
                          <td><input '.$styleind.' type="text" name="framemodel[]" class="form-control grid_table individual_'.$id.'" value="'.$getframemodel.'"></td>
                          
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
               "purchase_entry"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "purchase_date"=>date('Y-m-d',strtotime($this->input->post('pe_date'))),
                   "purchase_time"=>($this->input->post('pe_time'))?$this->input->post('pe_time'):date('H:i:s'),
                   "supplier_id"=>$this->input->post('supplier_id'),
                   "invoice_no"=>$this->input->post('invoice_no'),
                   'gstyesno'=>$this->input->post('gst_selection'),
                   'tax_type'=>$this->input->post('gst_type'),
                   'purchase_order_id'=>$this->input->post('purchase_order'),
                   'total_qty'=>$this->input->post('total_qty'),
                   'total_free_qty'=>$this->input->post('total_free_qty'),
                   'total_cgst'=>$this->input->post('total_cgst'),
                   'total_sgst'=>$this->input->post('total_sgst'),
                   'total_amount'=>$this->input->post('total_amount'),
                   'discount_amount'=>$this->input->post('discount'),
                   'discount_percentage'=>$this->input->post('discount_percentage'),
                   'other_charge'=>$this->input->post('other_charge'),
                   'modeofpay_id'=>$this->input->post('modeofpay_id'),
                   'net_amount'=>$this->input->post('net_amount'),
                   'office_id'=> $office_id
               ),
             "purchaseentry_detail"=>array(
                 "item_id"=>$this->input->post('product_id'),
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
                 "mulframemodel"=>$this->input->post('mulframemodel')
             ),
           
           );
            return $return;
       }
	           public function bulk_fetch_data() 
       {
           
           $office_id=$this->session->office_id;
           $var_array=array($office_id);
           $return=array(
               "purchase_entry"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "purchase_date"=>date('Y-m-d',strtotime($this->input->post('bulk_pe_date'))),
                   "purchase_time"=>($this->input->post('bulk_pe_time'))?$this->input->post('bulk_pe_time'):date('H:i:s'),
                   "supplier_id"=>$this->input->post('bulk_supplier_id'),
                   "invoice_no"=>$this->input->post('bulk_invoice_no'),
                   'gstyesno'=>$this->input->post('bulk_gst_selection'),
                   'tax_type'=>$this->input->post('bulk_gst_type'),
                   'purchase_order_id'=>$this->input->post('bulk_edit_purchase_id'),
                   'total_qty'=>$this->input->post('bulk_total_qty'),
                   'total_free_qty'=>$this->input->post('bulk_total_free_qty'),
                   'total_cgst'=>$this->input->post('bulk_total_cgst'),
                   'total_sgst'=>$this->input->post('bulk_total_sgst'),
                   'total_amount'=>$this->input->post('bulk_total_amount'),
                   'discount_amount'=>$this->input->post('bulk_discount'),
                   'discount_percentage'=>$this->input->post('bulk_discount_percentage'),
                   'other_charge'=>$this->input->post('bulk_other_charge'),
                   'modeofpay_id'=>$this->input->post('bulk_modeofpay_id'),
                   'net_amount'=>$this->input->post('bulk_net_amount'),
                   'office_id'=> $office_id
               ),
             "purchaseentry_detail"=>array(
                 "item_id"=>$this->input->post('bulk_product_id'),
                 "quantity"=>$this->input->post('bulk_quantity'),
                 "free"=>$this->input->post('bulk_free'),
                 "cost_price"=>$this->input->post('bulk_cost_price'),
                 "landing_cost"=>$this->input->post('bulk_landing_cost'),
                 "mrp"=>$this->input->post('bulk_mrp'),
                 "selling_price"=>$this->input->post('bulk_selling_price'),
                 "dis_type"=>$this->input->post('bulk_discount_type'),
                 "dis_amount"=>$this->input->post('bulk_discount_amount'),
                 "gst_selection_ind"=>$this->input->post('bulk_gstselind'),
                 "tax_val"=>$this->input->post('bulk_tax'),
                 "cgst"=>$this->input->post('bulk_cgst'),
                 "sgst"=>$this->input->post('bulk_sgst'),
                 "tot_amount"=>$this->input->post('bulk_amount'),
                 "mul_type"=>$this->input->post('bulk_mul_type'),
                 "frametype"=>$this->input->post('bulk_frametype'),
                 "framecolor"=>$this->input->post('bulk_framecolor'),
                 "framesize"=>$this->input->post('bulk_framesize'),
                 "framemodel"=>$this->input->post('bulk_framemodel'),
                 "mulframetype"=>$this->input->post('bulk_mulframetype'),
                 "mulframecolor"=>$this->input->post('bulk_mulframecolor'),
                 "mulframesize"=>$this->input->post('bulk_mulframesize'),
                 "mulframemodel"=>$this->input->post('bulk_mulframemodel')
             ),
           
           );
            return $return;
       }
  public function savepurchaseentry()
  {
    //print_r($_POST);exit;
    $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('pe_date', 'Purchase  Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('pe_time', 'Purchase  time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('gst_type', 'Tax type', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('total_free_qty', 'Total Free Qty', 'trim|min_length[1]|max_length[6]|numeric');
    $this->form_validation->set_rules('total_cgst', 'Total CGST', 'trim|numeric');
    $this->form_validation->set_rules('total_sgst', 'Total SGST', 'trim|numeric');
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
    $chkframes=array(
             "purchaseentry_detail"=>array(
                 "item_id"=>$this->input->post('product_id'),
                 "quantity"=>$this->input->post('quantity'),
                 "mul_type"=>$this->input->post('mul_type'),
                 "frametype"=>$this->input->post('frametype'),
                 "framecolor"=>$this->input->post('framecolor'),
                 "framesize"=>$this->input->post('framesize'),
                 "framemodel"=>$this->input->post('framemodel'),
                 "mulframetype"=>$this->input->post('mulframetype'),
                 "mulframecolor"=>$this->input->post('mulframecolor'),
                 "mulframesize"=>$this->input->post('mulframesize'),
                 "mulframemodel"=>$this->input->post('mulframemodel')
             ),
           
           );
      $purchaseentry_details=$chkframes['purchaseentry_detail'];
      $item_ids=$purchaseentry_details['item_id'];
      $quantitys=$purchaseentry_details['quantity'];
      $mul_types=$purchaseentry_details['mul_type'];
      $frametypes=$purchaseentry_details['frametype'];
      $framecolors=$purchaseentry_details['framecolor'];
      $framesizes=$purchaseentry_details['framesize'];
      $framemodels=$purchaseentry_details['framemodel'];
      $mulframetypes=$purchaseentry_details['mulframetype'];
      $mulframecolors=$purchaseentry_details['mulframecolor'];
      $mulframesizes=$purchaseentry_details['mulframesize'];
      $mulframemodels=$purchaseentry_details['mulframemodel'];
      $i=0;
      foreach ($item_ids as $item_id) 
      {
             if($mul_types[$i]==1)
            {
                if($frametypes[$i]>0 || $framecolors[$i]>0 || $framesizes[$i]>0 || $framemodels[$i]!='')
                if($frametypes[$i]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($framecolors[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framesizes[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framemodels[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
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
              $qty=$quantitys[$i];
              $x = 1;
              $b=0;
              $mulframetype=explode(',',$mulframetypes[$i]);
              $mulframecolor=explode(',',$mulframecolors[$i]);
              $mulframesize=explode(',',$mulframesizes[$i]);
              $mulframemodel=explode(',',$mulframemodels[$i]);
              while($x <= $qty) 
              {
                if($mulframetype[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframecolor[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframesize[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframemodel[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                $x++;
                $b++;
              }
          }
      }

 
      if($this->form_validation->run() == TRUE)
      {
        
          $data=$this->fetch_data();
          $getresult=$this->Purchase_entry_model->savedata($data);
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
  
  public function bulk_savepurchaseentry()
  {
  
    $this->form_validation->set_rules('bulk_invoice_no', 'Invoice No', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('bulk_supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('bulk_pe_date', 'Purchase  Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('bulk_pe_time', 'Purchase  time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('bulk_gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('bulk_gst_type', 'Tax type', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('bulk_total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('bulk_total_free_qty', 'Total Free Qty', 'trim|min_length[1]|max_length[6]|numeric');
    $this->form_validation->set_rules('bulk_total_cgst', 'Total CGST', 'trim|numeric');
    $this->form_validation->set_rules('bulk_total_sgst', 'Total SGST', 'trim|numeric');
    $this->form_validation->set_rules('bulk_discount', 'Discount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('bulk_discount_percentage', 'total_amount Discount Percentage', 'trim|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('bulk_charge_amount', 'Charge Amount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('bulk_modeofpay_id', 'Modeofpay', 'trim|min_length[1]|max_length[6]|numeric|required');
    $this->form_validation->set_rules('bulk_net_amount', 'Net Amount', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('bulk_quantity[]', 'Quantity', 'trim|min_length[1]|max_length[5]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_cost_price[]', 'Cost Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_landing_cost[]', 'Landing Cost', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_mrp[]', 'MRP', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_selling_price[]', 'Selling Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $chkframes=array(
             "purchaseentry_detail"=>array(
                 "item_id"=>$this->input->post('bulk_product_id'),
                 "quantity"=>$this->input->post('bulk_quantity'),
                 "mul_type"=>$this->input->post('bulk_mul_type'),
                 "frametype"=>$this->input->post('bulk_frametype'),
                 "framecolor"=>$this->input->post('bulk_framecolor'),
                 "framesize"=>$this->input->post('bulk_framesize'),
                 "framemodel"=>$this->input->post('bulk_framemodel'),
                 "mulframetype"=>$this->input->post('bulk_mulframetype'),
                 "mulframecolor"=>$this->input->post('bulk_mulframecolor'),
                 "mulframesize"=>$this->input->post('bulk_mulframesize'),
                 "mulframemodel"=>$this->input->post('bulk_mulframemodel')
             ),
           
           );
      $purchaseentry_details=$chkframes['purchaseentry_detail'];
      $item_ids=$purchaseentry_details['item_id'];
      $quantitys=$purchaseentry_details['quantity'];
      $mul_types=$purchaseentry_details['mul_type'];
      $frametypes=$purchaseentry_details['frametype'];
      $framecolors=$purchaseentry_details['framecolor'];
      $framesizes=$purchaseentry_details['framesize'];
      $framemodels=$purchaseentry_details['framemodel'];
      $mulframetypes=$purchaseentry_details['mulframetype'];
      $mulframecolors=$purchaseentry_details['mulframecolor'];
      $mulframesizes=$purchaseentry_details['mulframesize'];
      $mulframemodels=$purchaseentry_details['mulframemodel'];
      $i=0;
      foreach ($item_ids as $item_id) 
      {
             if($mul_types[$i]==1)
            {
                if($frametypes[$i]>0 || $framecolors[$i]>0 || $framesizes[$i]>0 || $framemodels[$i]!='')
                if($frametypes[$i]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($framecolors[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framesizes[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framemodels[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
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
              $qty=$quantitys[$i];
              $x = 1;
              $b=0;
              $mulframetype=explode(',',$mulframetypes[$i]);
              $mulframecolor=explode(',',$mulframecolors[$i]);
              $mulframesize=explode(',',$mulframesizes[$i]);
              $mulframemodel=explode(',',$mulframemodels[$i]);
              while($x <= $qty) 
              {
                if($mulframetype[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframecolor[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframesize[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframemodel[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                $x++;
                $b++;
              }
          }
  }
   if($this->form_validation->run() == TRUE)
      {
        
          $data=$this->bulk_fetch_data();
		 
          $getresult=$this->Purchase_entry_model->savedata($data);
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
	  } 
  }

  public function temp_savepurchaseentry()
  {
  //  print_r($_POST);exit;
    $this->form_validation->set_rules('bulk_invoice_no', 'Invoice No', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('bulk_supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('bulk_pe_date', 'Purchase  Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('bulk_pe_time', 'Purchase  time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('bulk_gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('bulk_gst_type', 'Tax type', 'trim|min_length[1]|max_length[1]|numeric');
    $this->form_validation->set_rules('bulk_total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('bulk_total_free_qty', 'Total Free Qty', 'trim|min_length[1]|max_length[6]|numeric');
    $this->form_validation->set_rules('bulk_total_cgst', 'Total CGST', 'trim|numeric');
    $this->form_validation->set_rules('bulk_total_sgst', 'Total SGST', 'trim|numeric');
    $this->form_validation->set_rules('bulk_discount', 'Discount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('bulk_discount_percentage', 'total_amount Discount Percentage', 'trim|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('bulk_charge_amount', 'Charge Amount', 'trim|min_length[1]|max_length[9]|numeric');
    $this->form_validation->set_rules('bulk_modeofpay_id', 'Modeofpay', 'trim|min_length[1]|max_length[6]|numeric|required');
    $this->form_validation->set_rules('bulk_net_amount', 'Net Amount', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('bulk_quantity[]', 'Quantity', 'trim|min_length[1]|max_length[5]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_cost_price[]', 'Cost Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_landing_cost[]', 'Landing Cost', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_mrp[]', 'MRP', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $this->form_validation->set_rules('bulk_selling_price[]', 'Selling Prize', 'trim|min_length[1]|max_length[8]|numeric|greater_than[0]|required');
    $chkframes=array(
             "purchaseentry_detail"=>array(
                 "item_id"=>$this->input->post('bulk_product_id'),
                 "quantity"=>$this->input->post('bulk_quantity'),
                 "mul_type"=>$this->input->post('bulk_mul_type'),
                 "frametype"=>$this->input->post('bulk_frametype'),
                 "framecolor"=>$this->input->post('bulk_framecolor'),
                 "framesize"=>$this->input->post('bulk_framesize'),
                 "framemodel"=>$this->input->post('bulk_framemodel'),
                 "mulframetype"=>$this->input->post('bulk_mulframetype'),
                 "mulframecolor"=>$this->input->post('bulk_mulframecolor'),
                 "mulframesize"=>$this->input->post('bulk_mulframesize'),
                 "mulframemodel"=>$this->input->post('bulk_mulframemodel')
             ),
           
           );
      $purchaseentry_details=$chkframes['purchaseentry_detail'];
      $item_ids=$purchaseentry_details['item_id'];
      $quantitys=$purchaseentry_details['quantity'];
      $mul_types=$purchaseentry_details['mul_type'];
      $frametypes=$purchaseentry_details['frametype'];
      $framecolors=$purchaseentry_details['framecolor'];
      $framesizes=$purchaseentry_details['framesize'];
      $framemodels=$purchaseentry_details['framemodel'];
      $mulframetypes=$purchaseentry_details['mulframetype'];
      $mulframecolors=$purchaseentry_details['mulframecolor'];
      $mulframesizes=$purchaseentry_details['mulframesize'];
      $mulframemodels=$purchaseentry_details['mulframemodel'];
      $i=0;
      foreach ($item_ids as $item_id) 
      {
             if($mul_types[$i]==1)
            {
                if($frametypes[$i]>0 || $framecolors[$i]>0 || $framesizes[$i]>0 || $framemodels[$i]!='')
                if($frametypes[$i]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($framecolors[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framesizes[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                 }
                elseif($framemodels[$i]=='')
                  {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
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
              $qty=$quantitys[$i];
              $x = 1;
              $b=0;
              $mulframetype=explode(',',$mulframetypes[$i]);
              $mulframecolor=explode(',',$mulframecolors[$i]);
              $mulframesize=explode(',',$mulframesizes[$i]);
              $mulframemodel=explode(',',$mulframemodels[$i]);
              while($x <= $qty) 
              {
                if($mulframetype[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame type';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframecolor[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Color';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframesize[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Size';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                elseif($mulframemodel[$b]=='')
                {
                    $this->msg='';
                    $this->error='Please Enter Frame Models';
                    $this->error_message ='';
                          echo json_encode(array(
                        'msg'           => $this->msg,
                        'error'         => $this->error,
                        'error_message' => $this->error_message
                      ));
                        exit;
                }
                $x++;
                $b++;
              }
          }
      }

 
      if($this->form_validation->run() == TRUE)
      {
        
          $data=$this->bulk_fetch_data();
		 
          $getresult=$this->Purchase_entry_model->temp_savedata($data);
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

  public function deletepurchaseentry()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_purchaseid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_purchaseid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Purchase_entry_model->deletecheckpurchaseentry($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Purchase_entry_model->deletedata($delete_purchaseid);
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
