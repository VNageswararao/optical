<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends CI_Controller {
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
        
        $this->load->model('Purchase_order_model');
        $this->load->model('Common_model');
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Purchase_order_model->ajax_call($param);
           echo json_encode($response);
    }
    public function index()
    {
        $data['title']='Optical::Purchase Order';
        $data['activecls']='Purchase_order';
        $office_id=$this->session->office_id;
        $var_array=array($office_id);
        $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
        $data['getitem']=$this->Common_model->getitemdata($var_array);
        $data['getbillno']=$this->Purchase_order_model->getlastbillno($var_array);
        $content=$this->load->view('transaction/purchase_order/insert',$data,true);
        $this->load->view('includes/layout',['content'=>$content]);
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
          
          $getresult=$this->Common_model->GetitemDatadetails($var_array);
          $getlastcostprice=$this->Purchase_order_model->Getitemcpdetails($var_array);
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
 public function fetch_data() 
       {
           
           $office_id=$this->session->office_id;
           $var_array=array($office_id);
           $getbilno=$this->Purchase_order_model->getlastbillno($var_array);
           if($getbilno[0]['last_order_no'])
           {
            $bill_no= $getbilno[0]['last_order_no']+1; 
            }
            else
            {
              $bill_no= 1;
            } 

           $return=array(
               "purchase_order"=>array(
                   "login_id"=>$this->session->userdata('login_id'),
                   "purchase_order_date"=>date('Y-m-d',strtotime($this->input->post('po_date'))),
                   "purchase_order_time"=>($this->input->post('po_time'))?$this->input->post('po_time'):date('H:i:s'),
                   "supplier_id"=>$this->input->post('supplier_id'),
                   'gst_selection'=>$this->input->post('gst_selection'),
                   'total_qty'=>$this->input->post('total_qty'),
                   'total_amount'=>$this->input->post('total_amount'),
                   'office_id'=> $office_id
               ),
             "purchaseorder_detail"=>array(
                 "item_id"=>$this->input->post('product_id'),
                 "quantity"=>$this->input->post('quantity'),
                 "cost_price"=>$this->input->post('cost_price'),
                 "total_amount"=>$this->input->post('amount'),
                 "gst_selection_ind"=>$this->input->post('gstselind'),
                 "mul_type"=>$this->input->post('mul_type'),
                 "frametype"=>$this->input->post('frametype'),
                 "framecolor"=>$this->input->post('framecolor'),
                 "framesize"=>$this->input->post('framesize'),
                 "framemodel"=>$this->input->post('framemodel'),
                 "mulframetype"=>$this->input->post('mulframetype'),
                 "mulframecolor"=>$this->input->post('mulframecolor'),
                 "mulframesize"=>$this->input->post('mulframesize'),
                 "mulframemodel"=>$this->input->post('mulframemodel'),
                 "login_id"=>$this->session->userdata('login_id'),
                 "office_id"=>$office_id
             ),
           
           );
            return $return;
       }
  public function savepurchaseorder()
  {
    $this->form_validation->set_rules('po_no', 'Purchase Order No', 'trim|required|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('po_date', 'Purchase Order Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('po_time', 'Purchase Order time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric|required');
    $this->form_validation->set_rules('total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|min_length[1]|max_length[15]|numeric|greater_than[0]');
    $this->form_validation->set_rules('cost_price[]', 'Cost Prize', 'trim|min_length[1]|max_length[15]|numeric|greater_than[0]');
      if($this->form_validation->run() == TRUE)
      {
        $po_no=trim(htmlentities($this->input->post('po_no')));
        $supplier_id=trim(htmlentities($this->input->post('supplier_id')));
        $po_date=trim(htmlentities($this->input->post('po_date')));
        $po_time=trim(htmlentities($this->input->post('po_time')));
        $gst_selection=trim(htmlentities($this->input->post('gst_selection')));
        $total_qty=trim(htmlentities($this->input->post('total_qty')));
        $total_amount=trim(htmlentities($this->input->post('total_amount')));
        $description=trim(htmlentities($this->input->post('description')));
        $contact_person_name=trim(htmlentities($this->input->post('contact_person_name')));
        $contact_person_mobile=trim(htmlentities($this->input->post('contact_person_mobile')));
        $gstin_type=trim(htmlentities($this->input->post('gstin_type')));
        $gst_no=trim(htmlentities($this->input->post('gst_no')));
          $data=$this->fetch_data();
          $getresult=$this->Purchase_order_model->savedata($data);
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
        $chk_duplication=$this->Purchase_order_model->deletecheckpurchaseorder($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getmasterdata=$this->Purchase_order_model->Getmastertable($var_array);
          $getchilddata=$this->Purchase_order_model->Getchildtable($var_array);
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

                  if($frame_model)
                  {
                    
                    foreach ($frame_model as $dataframemodelval) {
                          $framemodelsel='';
                          if($dataframemodelval['frame_id']==$data['framemodel'])
                          {
                            $framemodelsel='selected';
                          }
                        $getframemodel.='<option value="'.$dataframemodelval['frame_id'].'" '.$framemodelsel.'>'.$dataframemodelval['name'].'</option>';
                    }
                  }

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
                         <td><a href="#" onclick="$(this).parent().parent().remove();calcnet()"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td><input type="hidden" id="producttid_'.$id.'" name="product_id[]" value="'.$id.'" >'.$code.'</td>
                          <td>'.$item_name.'<input  type="hidden"  name="product[]" value="'.$item_name.'" class="form-control grid_table" id="product_'.$id.'" readonly></td>
                          <td><input type="number"  name="quantity[]" value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="quantity_'.$id.'" autocomplete="off"></td>
                          <td><input type="text" name="cost_price[]" id="cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td><input type="text"  name="amount[]" id="amount_'.$id.'" value="'.$total_amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
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
                          <td><select '.$styleind.' name="framemodel[]" class="form-control grid_table individual_'.$id.'">'.$getframemodel.'</select></td>
                          <td><select  name="gstselind[]" class="form-control grid_table"><option value="0" '.$gstseln.'>N</option><option value="1" '.$gstsely.'>Y</option></select></td>
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

  public function editpurchaseorder()
  {
    $this->form_validation->set_rules('edit_purchase_order_id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('po_no', 'Purchase Order No', 'trim|required|min_length[1]|max_length[1000]|numeric');
    $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
    $this->form_validation->set_rules('po_date', 'Purchase Order Date', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('po_time', 'Purchase Order time', 'trim|required|min_length[1]|max_length[15]');
    $this->form_validation->set_rules('gst_selection', 'GST Selection', 'trim|min_length[1]|max_length[1]|numeric|required');
    $this->form_validation->set_rules('total_qty', 'Total Qty', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|min_length[1]|max_length[30]|numeric|required');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|min_length[1]|max_length[15]|numeric|greater_than[0]');
    $this->form_validation->set_rules('cost_price[]', 'Cost Prize', 'trim|min_length[1]|max_length[15]|numeric|greater_than[0]');
      if($this->form_validation->run() == TRUE)
      {
        $edit_purchase_order_id=trim(htmlentities($this->input->post('edit_purchase_order_id')));
        $po_no=trim(htmlentities($this->input->post('po_no')));
        $supplier_id=trim(htmlentities($this->input->post('supplier_id')));
        $po_date=trim(htmlentities($this->input->post('po_date')));
        $po_time=trim(htmlentities($this->input->post('po_time')));
        $gst_selection=trim(htmlentities($this->input->post('gst_selection')));
        $total_qty=trim(htmlentities($this->input->post('total_qty')));
        $total_amount=trim(htmlentities($this->input->post('total_amount')));
        $description=trim(htmlentities($this->input->post('description')));
        $contact_person_name=trim(htmlentities($this->input->post('contact_person_name')));
        $contact_person_mobile=trim(htmlentities($this->input->post('contact_person_mobile')));
        $gstin_type=trim(htmlentities($this->input->post('gstin_type')));
        $gst_no=trim(htmlentities($this->input->post('gst_no')));
        $var_array=array($edit_purchase_order_id,$this->session->userdata('office_id'));
        $chk_duplication=$this->Purchase_order_model->editcheckpurchaseorder($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          $data=$this->fetch_data();
          $getresult=$this->Purchase_order_model->updatedata($data,$edit_purchase_order_id);
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

  public function deletepurchaseorder()
  {
    $this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        $delete_purchaseorderid=trim(htmlentities($this->input->post('id')));
        $var_array=array($delete_purchaseorderid,$this->session->userdata('office_id'));
        $chk_duplication=$this->Purchase_order_model->deletecheckpurchaseorder($var_array);
        if($chk_duplication[0]['cnt']==1)
        {
          
          $getresult=$this->Purchase_order_model->deletedata($delete_purchaseorderid);
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
