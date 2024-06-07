<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseExcelupload extends CI_Controller {
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
        $this->load->model('Purchaseexcel_model');
        $this->load->model('Common_model');
    }
    public function upload_file()
   {
          if(isset($_FILES['file']['name']))
         {
               $str=$_FILES['file']['name'];
               $allowed_mime_type_arr = array('gif|csv');
               $mime = get_mime_by_extension($str);
               if(isset($str) && $str!="")
               {
                        
                        $config['upload_path']   = 'excel/purchase/'; 
                        $config['allowed_types'] = 'csv'; 
                        $config['max_size']      = 2000; 
                        $config['encrypt_name'] = TRUE;

                        $this->load->library('upload');
                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('file'))
                        {
                            $this->msg='';
                            $this->error=$this->upload->display_errors('', '');
                            $this->error_message = '';
                                echo json_encode(array(
                              'msg'           => $this->msg,
                              'error'         => $this->error,
                              'error_message' => $this->error_message
                            ));
                              exit;
                        }
                        else
                        {
                            $file = $_FILES['file']['tmp_name'];
                             $handle = fopen($file, "r");
                            // $c = 0;//
                            // while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
                            // {
                            //     $fname = $filesop[0];
                            //     echo $lname = $filesop[1];exit;
                            //     if($c<>0){                  //SKIP THE FIRST ROW
                            //         // $this->Crud_model->saverecords($fname,$lname);
                            //     }
                            //     $c = $c + 1;
                            // }
                            $itemlastinsertid='';
                           // print_r($_POST);EXIT;
                            while($data = fgetcsv($handle,1024)) 
                             {
                                for ($i = 0, $j = count($data); $i < $j; $i++)
                                {   
                                    $item['suppliername']=$data[0];
                                    $item['invoiceno'] =  $data[1];
                                    $item['taxtype'] =  $data[2];
                                    $item['gst(y/n)'] =  $data[3];
                                    $item['itemname'] =  $data[4];
                                    $item['qty'] =  $data[5];
                                    $item['cp'] =  $data[6];
                                    $item['mrp'] =  $data[7];
                                    $item['sp'] =  $data[8];
                                    $item['framemultipletype(y/n)'] =  $data[9];
                                    $item['frametype'] =  $data[10];
                                    $item['framecolour'] =  $data[11];
                                    $item['framesize'] =  $data[12];
                                    $item['framemodel'] =  $data[13];
                                    
                                }
                                $supplier_id=$item_id=$gst=$taxtype=$mulselection='';
                                $data = array('office_id' => $this->session->office_id,
                                                  'suppliername' => trim(strtolower($item['suppliername'])),
                                                  'invoiceno' => trim($item['invoiceno']),
                                                  'taxtype' => trim($item['taxtype']),
                                                  'gst(y/n)' => trim($item['gst(y/n)']),
                                                  'itemname' => trim($item['itemname']),
                                                  'qty' => trim($item['qty']),
                                                  'cp' => trim($item['cp']),
                                                  'mrp' => trim($item['mrp']),
                                                  'sp' => trim($item['sp']),
                                                  'framemultipletype(y/n)' => trim($item['framemultipletype(y/n)']),
                                                  'frametype' => trim($item['frametype']),
                                                  'framecolour' => trim($item['framecolour']),
                                                  'framesize' => trim($item['framesize']),
                                                  'framemodel' => trim($item['framemodel'])
                                                );
                                 $itemdata = array('office_id' => $this->session->office_id,
                                                  'name' => trim(strtolower($item['itemname']))
                                                ) ;
                                 $supplierdata = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($item['suppliername']))
                                                ) ;
                                  if($item['taxtype']=='Nontax' || $item['taxtype']=='Inclusive' || $item['taxtype']=='Exclusive' 
                                    || $item['taxtype']!='taxtype')
                                 {
                                     if($item['taxtype']=='Nontax')
                                     {
                                        $taxtype=0;
                                     }
                                     else if($item['taxtype']=='Inclusive')
                                     {
                                        $taxtype=1;
                                     }
                                     else if($item['taxtype']=='Exclusive')
                                     {
                                        $taxtype=2;
                                     }
                                     else
                                     {
                                                $this->msg='';
                                                $this->error='Please check Tax Type  Column';
                                                $this->error_message = '';
                                                    echo json_encode(array(
                                                  'msg'           => $this->msg,
                                                  'error'         => $this->error,
                                                  'error_message' => $this->error_message
                                                ));
                                                  exit;
                                     }
                                 }
                                 
                                if($item['gst(y/n)']=='Y' || $item['gst(y/n)']=='N' || $item['gst(y/n)']!='gst(y/n)')
                                 {
                                     if($item['gst(y/n)']=='Y')
                                     {
                                        $gst=1;
                                     }
                                     else if($item['gst(y/n)']=='N')
                                     {
                                        $gst=0;
                                     }
                                     else
                                     {
                                                $this->msg='';
                                                $this->error='Please check GST  Column';
                                                $this->error_message = '';
                                                    echo json_encode(array(
                                                  'msg'           => $this->msg,
                                                  'error'         => $this->error,
                                                  'error_message' => $this->error_message
                                                ));
                                                  exit;
                                     }
                                 }
                                 
                                 if($item['framemultipletype(y/n)']=='Y' || $item['framemultipletype(y/n)']=='N' || $item['framemultipletype(y/n)']=='framemultipletype(y/n)')
                                 {

                                     if($item['framemultipletype(y/n)']=='N')
                                     {
                                        $mulselection=1;
                                        $singleframetype = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($item['frametype']))
                                                ) ;
                                        $frametypechecking=$this->Purchaseexcel_model->FrameCLAScheckingmodel($singleframetype);
                                        if($frametypechecking[0]['cnt']==0)
                                        {
                                                $dupframetype=$item['frametype'];
                                                $this->msg='';
                                                $this->error='Not Availabe  '.$dupframetype.'  in this Frametype';
                                                $this->error_message = '';
                                                    echo json_encode(array(
                                                  'msg'           => $this->msg,
                                                  'error'         => $this->error,
                                                  'error_message' => $this->error_message
                                                ));
                                                  exit;
                                        }
                                         else
                                        {
                                            $frametype_id=$frametypechecking[0]['frame_id'];
                                        }

                                        $singleframecolor = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($item['framecolour']))
                                                ) ;
                                        $framecolorchecking=$this->Purchaseexcel_model->FrameCLAScheckingmodel($singleframecolor);
                                        if($framecolorchecking[0]['cnt']==0)
                                        {
                                                $dupframecolour=$item['framecolour'];
                                                $this->msg='';
                                                $this->error='Not Availabe  '.$dupframecolour.'  in this Frametype';
                                                $this->error_message = '';
                                                    echo json_encode(array(
                                                  'msg'           => $this->msg,
                                                  'error'         => $this->error,
                                                  'error_message' => $this->error_message
                                                ));
                                                  exit;
                                        }
                                        else
                                        {
                                            $framecolour_id=$framecolorchecking[0]['frame_id'];
                                        }

                                        $singleframesize = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($item['framesize']))
                                                ) ;
                                        $framesizechecking=$this->Purchaseexcel_model->FrameCLAScheckingmodel($singleframesize);
                                        if($framesizechecking[0]['cnt']==0)
                                        {
                                                $dupframesize=$item['framesize'];
                                                $this->msg='';
                                                $this->error='Not Availabe  '.$dupframesize.'  in this Frametype';
                                                $this->error_message = '';
                                                    echo json_encode(array(
                                                  'msg'           => $this->msg,
                                                  'error'         => $this->error,
                                                  'error_message' => $this->error_message
                                                ));
                                                  exit;
                                        }
                                        else
                                        {
                                            $framesize_id=$framesizechecking[0]['frame_id'];
                                        }
                                        $framemodel_id=trim($item['framemodel']);
                                     }
                                     if($item['framemultipletype(y/n)']=='Y' && $item['qty']!='qty')
                                     {
                                        $mulselection=2;
                                        $framemodel_id='';
                                        $mulframemodels=trim($item['framemodel']);
                                        $mulframemodel=explode(',',$mulframemodels);
                                        $num_framemodel = count($mulframemodel);
                                        if($num_framemodel==trim($item['qty']))
                                        {
                                            $framemodel_id=trim($item['framemodel']);
                                        }
                                        else
                                        {
                                            $this->msg='';
                                            $this->error='Please Check Framemodel Column (Qty And Frame Model Mismatched)';
                                            $this->error_message = '';
                                                echo json_encode(array(
                                              'msg'           => $this->msg,
                                              'error'         => $this->error,
                                              'error_message' => $this->error_message
                                            ));
                                              exit;
                                        }
                                        $mulframetypes =trim(strtolower($item['frametype']));
                                        $x = 1;
                                        $b=0;
                                        $mulframetype=explode(',',$mulframetypes);
                                        $num_frametype = count($mulframetype);
                                        if($num_frametype==trim($item['qty']))
                                        {
                                            $mulframetype_id='';
                                            $frametype_id='';
                                            while($x <= $item['qty']) 
                                            {
                                               if($mulframetype[$b])
                                                {
                                                    $singleframetype = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($mulframetype[$b]))
                                                ) ;
                                                    $frametypechecking=$this->Purchaseexcel_model->FrameCLAScheckingmodel($singleframetype);
                                                    if($frametypechecking[0]['cnt']==0)
                                                    {
                                                            $dupframetype=$mulframetype[$b];
                                                            $this->msg='';
                                                            $this->error='Not Availabe  '.$dupframetype.'  in this Frametype';
                                                            $this->error_message = '';
                                                                echo json_encode(array(
                                                              'msg'           => $this->msg,
                                                              'error'         => $this->error,
                                                              'error_message' => $this->error_message
                                                            ));
                                                              exit;
                                                    }
                                                    else
                                                    {
                                                        $mulframetype_id.=$frametypechecking[0]['frame_id'].',';
                                                    } 
                                                }
                                                $x++;
                                                $b++;
                                            }
                                            $frametype_id=$mulframetype_id;
                                        }
                                        else
                                        {
                                            $this->msg='';
                                            $this->error='Please Check Frametype Column (Qty And Frame Type Mismatched)';
                                            $this->error_message = '';
                                                echo json_encode(array(
                                              'msg'           => $this->msg,
                                              'error'         => $this->error,
                                              'error_message' => $this->error_message
                                            ));
                                              exit;
                                        }

                                        //////frame color
                                        $mulframecolors =trim(strtolower($item['framecolour']));
                                        $x = 1;
                                        $b=0;
                                        $mulframecolour=explode(',',$mulframecolors);
                                        $num_framecolour = count($mulframecolour);
                                        if($num_framecolour==trim($item['qty']))
                                        {
                                            $mulframecolour_id='';
                                            $framecolour_id='';
                                            while($x <= $item['qty']) 
                                            {
                                               if($mulframecolour[$b])
                                                {
                                                    $singleframecolour = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($mulframecolour[$b]))
                                                ) ;
                                                    $framecolourchecking=$this->Purchaseexcel_model->FrameCLAScheckingmodel($singleframecolour);
                                                    if($framecolourchecking[0]['cnt']==0)
                                                    {
                                                            $dupframecolour=$mulframecolour[$b];
                                                            $this->msg='';
                                                            $this->error='Not Availabe  '.$dupframecolour.'  in this Framecolour';
                                                            $this->error_message = '';
                                                                echo json_encode(array(
                                                              'msg'           => $this->msg,
                                                              'error'         => $this->error,
                                                              'error_message' => $this->error_message
                                                            ));
                                                              exit;
                                                    }
                                                    else
                                                    {
                                                        $mulframecolour_id.=$framecolourchecking[0]['frame_id'].',';
                                                    } 
                                                }
                                                $x++;
                                                $b++;
                                            }
                                            $framecolour_id=$mulframecolour_id;
                                        }
                                        else
                                        {
                                            $this->msg='';
                                            $this->error='Please Check Framecolour Column (Qty And Frame Colour Mismatched)';
                                            $this->error_message = '';
                                                echo json_encode(array(
                                              'msg'           => $this->msg,
                                              'error'         => $this->error,
                                              'error_message' => $this->error_message
                                            ));
                                              exit;
                                        }

                                        //////frame size
                                        $mulframesizes =trim(strtolower($item['framesize']));
                                        $x = 1;
                                        $b=0;
                                        $mulframesize=explode(',',$mulframesizes);
                                        $num_framesize = count($mulframesize);
                                        if($num_framesize==trim($item['qty']))
                                        {
                                            $mulframesize_id='';
                                            $framesize_id='';
                                            while($x <= $item['qty']) 
                                            {
                                               if($mulframesize[$b])
                                                {
                                                    $singleframesize = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($mulframesize[$b]))
                                                ) ;
                                                    $framesizechecking=$this->Purchaseexcel_model->FrameCLAScheckingmodel($singleframesize);
                                                    if($framesizechecking[0]['cnt']==0)
                                                    {
                                                            $dupframesize=$mulframesize[$b];
                                                            $this->msg='';
                                                            $this->error='Not Availabe  '.$dupframesize.'  in this Framecolour';
                                                            $this->error_message = '';
                                                                echo json_encode(array(
                                                              'msg'           => $this->msg,
                                                              'error'         => $this->error,
                                                              'error_message' => $this->error_message
                                                            ));
                                                              exit;
                                                    }
                                                    else
                                                    {
                                                        $mulframesize_id.=$framesizechecking[0]['frame_id'].',';
                                                    } 
                                                }
                                                $x++;
                                                $b++;
                                            }
                                            $framesize_id=$mulframesize_id;
                                        }
                                        else
                                        {
                                            $this->msg='';
                                            $this->error='Please Check Framesize Column (Qty And Frame Size Mismatched)';
                                            $this->error_message = '';
                                                echo json_encode(array(
                                              'msg'           => $this->msg,
                                              'error'         => $this->error,
                                              'error_message' => $this->error_message
                                            ));
                                              exit;
                                        }
                                     }
                                 }
                                 else
                                 {
                                    $this->msg='';
                                    $this->error='Please Check  Frame Multiple Column(Y/N)';
                                    $this->error_message = '';
                                        echo json_encode(array(
                                      'msg'           => $this->msg,
                                      'error'         => $this->error,
                                      'error_message' => $this->error_message
                                    ));
                                      exit;
                                 }
                                 $supplierdata = array('office_id' => $this->session->office_id,
                                                   'name' => trim(strtolower($item['suppliername']))
                                                ) ;
                                   
                                   if($item['suppliername']!='suppliername')
                                   {    
                                         if($item['suppliername'])
                                        {
                                            $suppliernamechecking=$this->Purchaseexcel_model->Suppliernamecheckingmodel($supplierdata);
                                            if($suppliernamechecking[0]['cnt']==0)
                                            {
                                                    $dupsuppliername=$item['suppliername'];
                                                    $this->msg='';
                                                    $this->error='Not Availabe  '.$dupsuppliername.'  in this Supplier';
                                                    $this->error_message = '';
                                                        echo json_encode(array(
                                                      'msg'           => $this->msg,
                                                      'error'         => $this->error,
                                                      'error_message' => $this->error_message
                                                    ));
                                                      exit;
                                            }
                                            else
                                            {
                                                $supplier_id=$suppliernamechecking[0]['supplier_id'];
                                            }
                                        }
                                   }
                                   if($item['itemname']!='itemname')
                                    {
                                        if($item['itemname'])
                                        {
                                            $itemchecking=$this->Purchaseexcel_model->Itemnamecheckingmodel($itemdata);
                                            if($itemchecking[0]['cnt']==0)
                                            {
                                                    $dupitemname=$item['itemname'];
                                                    $this->msg='';
                                                    $this->error='Not Availabe  '.$dupitemname.'  in this product';
                                                    $this->error_message = '';
                                                        echo json_encode(array(
                                                      'msg'           => $this->msg,
                                                      'error'         => $this->error,
                                                      'error_message' => $this->error_message
                                                    ));
                                                      exit;
                                            }
                                            else
                                            {
                                                $item_id=$itemchecking[0]['item_id'];
                                            }
                                        }
                                        else
                                        {
                                            $this->msg='';
                                            $this->error='Item Name Missing in this Excel';
                                            $this->error_message = '';
                                                echo json_encode(array(
                                              'msg'           => $this->msg,
                                              'error'         => $this->error,
                                              'error_message' => $this->error_message
                                            ));
                                              exit; 
                                        }
                                   }
                                   $checkingcomplete=1;
                                   if($checkingcomplete==1)
                                   {
                                        $datachk=array();
                                       if($item['suppliername']!='suppliername' && $item['itemname']!='itemname' && $item['itemname']!='gst(y/n)' && $item['taxtype']!='taxtype' && $item['qty']!='qty' && $item['cp']!='cp' && $item['mrp']!='mrp' && $item['sp']!='sp' && $item['framemultipletype(y/n)']!='framemultipletype(y/n)' && $item['frametype']!='frametype' && $item['framecolour']!='framecolour' && $item['framesize']!='framesize' && $item['framemodel']!='framemodel' && $item['invoiceno']!='invoiceno' )
                                       {
                                            $datachk = array('office_id' => $this->session->office_id,
                                                           'suppliername' => $supplier_id,
                                                           'invoiceno' => trim($item['invoiceno']),
                                                           'itemname' => $item_id,
                                                           'gst' => $gst,
                                                           'taxtype' => $taxtype,
                                                           'qty' => trim($item['qty']),
                                                           'cp' => trim($item['cp']),
                                                           'mrp' => trim($item['mrp']),
                                                           'sp' => trim($item['sp']),
                                                           'multype' => $mulselection,
                                                           'frametype_id' => $frametype_id,
                                                           'framecolour_id' => $framecolour_id,
                                                           'framesize_id' => $framesize_id,
                                                           'framemodel_id' => $framemodel_id
                                                        );
                                            //print_r($datachk);exit;
                                             $itemchecking=$this->Purchaseexcel_model->SaveExceldetails($datachk);
                                              //$itemlastinsertid='';
                                             if($itemchecking=='')
                                             {
                                                $this->msg='';
                                                $this->error='Somecolumn value Mismatched please check excel details';
                                                $this->error_message = '';
                                                    echo json_encode(array(
                                                  'msg'           => $this->msg,
                                                  'error'         => $this->error,
                                                  'error_message' => $this->error_message
                                                ));
                                                  exit; 
                                             }
                                             $itemlastinsertid.=$itemchecking.',';
                                       }
                                        
                                   }

                            }
                            if($itemchecking)
                            {
                              $office_id=$this->session->office_id;
                              $var_array=array($office_id);
                              $modeofpay=$this->Common_model->GetModeofpayData($var_array);
                              if($modeofpay)
                              {
                                $mode='';
                                foreach ($modeofpay as $data) 
                                {
                                   $mode.='<option value="'.$data['modeofpay_id'].'">'.$data['name'].'</option>';
                                }
                              }
                                $frame_array=array($this->session->userdata('office_id'));
                                $frame_type=$this->Common_model->GetframetypeData($frame_array);
                                $frame_color=$this->Common_model->GetframecolorData($frame_array);
                                $frame_model=$this->Common_model->GetframemodelData($frame_array);
                                $frame_size=$this->Common_model->GetframesizeData($frame_array);
                              $lastinsert=$itemlastinsertid;
                              $lastcharremoveids = rtrim($lastinsert, ", ");
                              $getexcelids=explode(',',$lastinsert);
                              $office_id=$this->session->userdata('office_id');
                              $vararray=array($getexcelids[0],$office_id);
                              $getmasterdata=$this->Purchaseexcel_model->Getsupplierdetails($vararray);
                              if($getmasterdata[0]['taxtype']==0)
                              {
                                $taxdet='<option value="0">Nontax</option>';
                              }
                              elseif ($getmasterdata[0]['taxtype']==1) 
                              {
                                 $taxdet='<option value="1">Inclusive</option>';
                              }
                              else
                              {
                                $taxdet='<option value="2">Exclusive</option>';
                              }
                              if($getmasterdata[0]['gst']==0)
                              {
                                $gstdet='<option value="0">N</option>';
                              }
                              elseif ($getmasterdata[0]['gst']==1) 
                              {
                                 $gstdet='<option value="1">Y</option>';
                              }
                             
                              //print_r($getmasterdata);exit;
                              if($getmasterdata)
                              {
                                $masterdata='';
                                $masterdata.='<div class="row"><div class="col-md-12"><button style="float:right;" onclick="deleteexceldata()" type="button" class="btn btn-icon btn-danger mr-1 mb-1">Delete Excel Data</button></div></div><div class="row">
                                    <div class="col-md-2">
                                        <label for="lastname">Supplier: <span class="text-danger">*</span></label><input type="hidden" id="deleteexcelid" name="deleteexcelid" value="'.$lastinsert.'">
                                        <select class="form-control select2-diacritics" name="supplier_id" id="ssupplier_id">
                                            <option value="'.$getmasterdata[0]['supplier_id'].'">'.$getmasterdata[0]['name'].'</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="lastname">Invoice No: <span class="text-danger">*</span></label>
                                        <input type="text" readonly name="invoice_no" id="sinvoice_no"  value="'.$getmasterdata[0]['invoiceno'].'" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname"> Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="pe_date" id="spe_date" value="'.date('d/m/Y').'" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname"> Time: <span class="text-danger">*</span></label>
                                            <input type="time" name="pe_time" id="spe_time" class="form-control" value="'.date('H:s').'" >
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Tax Type: <span class="text-danger">*</span></label>
                                            <select class="form-control" id="gst_type" name="gst_type">
                                               '.$taxdet.'
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">GST(Y/N): <span class="text-danger">*</span></label>
                                            <select class="form-control" id="gst_selection" name="gst_selection">
                                                '.$gstdet.'
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                           <div class="table-responsive">
                                            <table class="table table-hover" id="productdetails">
                                                <thead>
                                                    <tr>
                                                        <th>Sl No</th>
                                                        <th>Remove</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Qty</th>
                                                        <th style="display: none;">Free</th>
                                                        <th>CP</th>
                                                        <th style="display: none;">LC</th>
                                                        <th>MRP</th>
                                                        <th>SP</th>
                                                        <th style="display:none;">D.Type</th>
                                                        <th style="display:none;">Amount</th>
                                                        <th style="display: none;">GST(Y/N)</th>
                                                        <th style="display: none;">TAX</th>
                                                        <th style="display: none;">CGST</th>
                                                        <th style="display: none;">SGST</th>
                                                        <th>Tot Amt</th>
                                                        <th>Mul type?</th>
                                                        <th>Frame Type</th>
                                                        <th>Colour</th>
                                                        <th>Size</th>
                                                        <th>Model</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                 $getchilddata=$this->Purchaseexcel_model->Getchilddetails($lastcharremoveids);  
                                                 if($getchilddata)
                                                 {
                                                    $sl=1;
                                                    $total_qty=0;
                                                    $total_free=0;
                                                    $total_cgst=0;
                                                    $total_sgst=0;
                                                    $total_amount=0;
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
                                                        $qty=$data['qty'];
                                                        $cost_price=$data['cp'];
                                                        $landing_cost=$data['cp'];
                                                        $free=0;
                                                        $mrp=$data['mrp'];
                                                        $taxval=$data['taxval'];
                                                        $selling_price=$data['sp'];
                                                        $dis_type=0;
                                                        $dis_amount=0;
                                                        $price=$qty*$cost_price;
                                                        if($getmasterdata[0]['gst']==0)
                                                       {
                                                          $tax_type=0;
                                                       }
                                                       else
                                                       {
                                                          $tax_type=$getmasterdata[0]['taxtype'];
                                                       }
                                                        $gst_type=$tax_type;
                                                        if($gst_type==0)
                                                        {
                                                            $cgst_ind=0;
                                                            $sgst_ind=0;
                                                            $amount=number_format((float)$price, 2, '.', '');
                                                            $indamount=$price/$qty;
                                                            $landing_cost=number_format((float)$indamount, 2, '.', '');
                                                        }
                                                        elseif ($gst_type==1) 
                                                        { 
                                                            $taxamount=$this->findInclusive_taxamount($price,$taxval);
                                                            $cgst_ind=$taxamount/2;
                                                            $sgst_ind=$taxamount/2;
                                                            $amount=number_format((float)$price, 2, '.', '');
                                                        }
                                                        elseif ($gst_type==2) 
                                                        {
                                                            $taxamount=$this->findExclusive_taxamount($price,$taxval);
                                                            $cgst_ind=$taxamount/2;
                                                            $sgst_ind=$taxamount/2;
                                                            $amount=$price+$taxamount;
                                                            $amount=number_format((float)$amount, 2, '.', '');
                                                        }
                                                        $mul_type =$data['multype'];
                                                        $gst_selection_ind =$getmasterdata[0]['taxtype'];
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
                                                          $mulselll='<option value="1">N</option>';
                                                          $stylemul='style="display:none;"';
                                                          $mulsel='selected';
                                                          if($frame_type)
                                                          {
                                                            $getframetype='';
                                                            foreach ($frame_type as $dataframetypeval) {
                                                                  $frametypesel='';
                                                                  if($dataframetypeval['frame_id']==$data['frametype_id'])
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
                                                                  if($dataframecolorval['frame_id']==$data['framecolour_id'])
                                                                  {
                                                                    $framecolorsel='selected';
                                                                  }
                                                                $getframecolor.='<option value="'.$dataframecolorval['frame_id'].'" '.$framecolorsel.'>'.$dataframecolorval['name'].'</option>';
                                                            }
                                                          }

                                                          $getframemodel=$data['framemodel_id'];

                                                           if($frame_size)
                                                          {
                                                            
                                                            foreach ($frame_size as $dataframesizeval) {
                                                                  $framesizesel='';
                                                                  if($dataframesizeval['frame_id']==$data['framesize_id'])
                                                                  {
                                                                    $framesizesel='selected';
                                                                  }
                                                                $getframesize.='<option value="'.$dataframesizeval['frame_id'].'" '.$framesizesel.'>'.$dataframesizeval['name'].'</option>';
                                                            }
                                                          }
                                                        }
                                                        else
                                                        {
                                                         $mulselll='<option value="2">Y</option>';
                                                          $styleind='style="display:none;"';
                                                          $mulsell='selected';
                                                          $mulframetype =$data['frametype_id'];
                                                          $mulframecolor =$data['framecolour_id'];
                                                          $mulframesize =$data['framesize_id'];
                                                          $mulframemodel =$data['framemodel_id'];
                                                        }
                                                        $id=$sl;
                                                        $masterdata.='<tr><td>'.$sl.'</td>
                         <td><a href="#"><button disabled class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>
                         <td><input type="hidden" id="producttid_'.$id.'" name="product_id[]" value="'.$data['item_id'].'" >'.$code.'</td>
                          <td>'.$item_name.'<input  type="hidden"  name="product[]" value="'.$item_name.'" class="form-control grid_table" id="product_'.$id.'" readonly></td>
                          <td><input type="number"  name="quantity[]" readonly value="'.$qty.'" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="quantity_'.$id.'" autocomplete="off"></td>
                          <td style="display:none;"><input type="number"  name="free[]" value="" class="form-control grid_table"  onKeyUp="calcrow('.$id.')" id="free_'.$id.'" autocomplete="off"></td>
                          <td><input type="number" name="cost_price[]" id="cost_price_'.$id.'" value="'.$cost_price.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td style="display:none;"><input type="number" name="landing_cost[]" id="landing_cost_'.$id.'" value="'.$landing_cost.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="mrp[]" id="mrp_'.$id.'" readonly value="'.$mrp.'" class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                          <td><input type="number" name="selling_price[]" id="selling_price_'.$id.'" readonly value="'.$selling_price.'"  class="form-control grid_table"   onKeyUp="calcrow('.$id.')" ></td>
                           <td style="display:none;"><select name="discount_type[]" class="form-control grid_table" id="discount_type_'.$id.'" onchange="calcrow('.$id.')"><option value="0">A</option><option value="1">P</option></select></td>
                           <td style="display:none;"><input type="text" name="discount_input[]" value="0" class="form-control grid_table" onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')" id="discount_input_'.$id.'" value=""><input type="hidden" name="discount_amount[]" value="0" id="discount_amount_'.$id.'" value=""></td>
                           <td style="display:none;"><select onchange="calcrow('.$id.')" id="gstselind_'.$id.'" name="gstselind[]" class="form-control grid_table">'.$gstdet.'</select></td>
                           <td style="display:none;"><input type="text" readonly name="tax[]" id="tax_'.$id.'" value="'.$taxval.'" class="form-control grid_table"  onkeydown="changefocus(event,$(this))"  onKeyUp="calcrow('.$id.')"></td>
                           <td style="display:none;" class="vat"><input type="text"  name="cgst[]" id="cgst_'.$id.'" value="'.$cgst_ind.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                            <td style="display:none;" class="vat"><input type="text"  name="sgst[]" id="sgst_'.$id.'" value="'.$sgst_ind.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"></td>
                           <td><input type="text"  name="amount[]" id="amount_'.$id.'" value="'.$amount.'" class="form-control grid_table" readonly onKeyUp="calcrow('.$id.')"><input type="hidden" name="tax_type[]" id="tax_type_'.$id.'" value="'.$tax_type.'"><input type="hidden" name="tax_amount[]" id="tax_amount_'.$id.'" value="'.$taxamount.'" ></td>
                            <td><select class="form-control grid_table" onchange="getchangetype('.$id.');" name="mul_type[]" id="ismultype_'.$id.'">'.$mulselll.'</select></td>
                          <td>
                           <div class="single_'.$id.'" '.$styleind.' >
                             <select   name="frametype[]"  class="form-control grid_table">'.$getframetype.'</select>
                          </div>
                          <div  class="multiple_'.$id.'"  '.$stylemul.'>
                            <a href="#" id="mult_'.$id.'" class="table-link danger serial_number_setting" ><button disabled class="btn btn-sm btn-danger">TCSM</button></a>
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
                                                             $total_qty+=$qty;
                                                             $total_cgst+=$cgst_ind;
                                                             $total_sgst+=$sgst_ind;
                                                             $total_amount+=$amount;
                                                    }
                                                 }
                                 $masterdata.='</tbody>
                                            </table>
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                                   <div class="row">
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Total Qty: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="stotal_qty" name="total_qty" readonly="" value="'.$total_qty.'" style="text-align:center;">
                                        </div>
                                    </div>
                                     <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Total Free Qty: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total_free_qty" name="total_free_qty" readonly="" value="0" style="text-align:center">
                                        </div>
                                    </div>
                                       <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Total CGST: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total_cgst" name="total_cgst" readonly="" value="'.$total_cgst.'" style="text-align:right;font-weight:bold">
                                        </div>
                                    </div>
                                       <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Total SGST: <span class="text-danger">*</span></label>
                                             <input type="text" class="form-control" id="total_sgst" name="total_sgst" readonly="" value="'.$total_sgst.'" style="text-align:right;font-weight:bold">
                                        </div>
                                    </div>
                                      <div class="col-md-3" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Total Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="stotal_amount" name="total_amount" readonly="" value="'.$total_amount.'" style="text-align:right;font-weight:bold">
                                        </div>
                                    </div>
                                     <div class="col-md-2" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Dis Amount: <span class="text-danger">*</span></label>
                                             <input type="text" class="form-control" id="total_discount_input" name="discount" style="text-align:right"  onkeyup="find_discount_percentage();calcnet();" onkeypress="return isFloat(event)" >
                                        </div>
                                    </div>
                                     <div class="col-md-2" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Dis Percentage: <span class="text-danger">*</span></label>
                                             <input type="text" class="form-control" id="discount_percentage" name="discount_percentage" style="text-align:right"  onkeyup="find_discount_amount();calcnet();" onkeypress="return isFloat(event)">
                                        </div>
                                    </div>
                                     <div class="col-md-2" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Other Charge: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="charge_amount" name="charge_amount" onkeyup="calcnet();"  style="text-align:right" onkeypress="return isFloat(event)">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="modeofpay_id" id="modeofpay_id">
                                               <option value="">Select Modeofpay</option>
                                                   '.$mode.'
                                               </select>
                                        </div>
                                    </div>

                                      <div class="col-md-3" >
                                        <div class="form-group">
                                            <label for="lastname">Net Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="net_amount" name="net_amount" style="text-align:right;font-size: 20px;" readonly="" value="'.$total_amount.'">
                                        </div>
                                    </div>
                                 </div>
                                  <div class="card-footer ml-auto">
                                    <button id="savepurchaseexcel" type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savepurchaseentry_excel();">Submit</button>
                                    <button style="display: none;" id="update" type="button" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1" onclick="updatepurchaseentry();">Update</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onClick="window.location.reload();">Reset</button>
                                </div>';
                              }
                                  $this->msg='Excel Saved Successfully';
                                  $this->error='';
                                  $this->error_message ='';
                                        echo json_encode(array(
                                      'msg'           => $this->msg,
                                      'getmasterdata' => $masterdata,
                                      'error'         => $this->error,
                                      'error_message' => $this->error_message
                                    ));
                                      exit;
                            }

                        }
                    
                }
                else
                {
                    $this->msg='';
                    $this->error='No File Found';
                    $this->error_message = '';
                        echo json_encode(array(
                      'msg'           => $this->msg,
                      'error'         => $this->error,
                      'error_message' => $this->error_message
                    ));
                      exit;
                }
         }  else {
                    $this->msg='';
                    $this->error='Please Choose Upload Excel';
                    $this->error_message = '';
                        echo json_encode(array(
                      'msg'           => $this->msg,
                      'error'         => $this->error,
                      'error_message' => $this->error_message
                    ));
                      exit;
         }
   }
   public function findInclusive_taxamount($price,$tax)
 {
     $taxable_amount=$price*100/(100+$tax);
    return $taxable_amount*$tax/100;
 }
 public   function findExclusive_taxamount($price,$tax)
 {
     return $price*$tax/100;
 }
    public function deleteexceldata()
  {
     $this->form_validation->set_rules('deleteexcelid', 'Delete ID', 'trim|required|min_length[1]|max_length[50]');
      if($this->form_validation->run() == TRUE)
      {
        $delete_excelid=trim(htmlentities($this->input->post('deleteexcelid')));
        $deleteid = rtrim($delete_excelid, ", ");
          $getresult=$this->Purchaseexcel_model->deletedata($deleteid);
          if($getresult)
          {
              $this->msg='Excel Data Deleted Successfully';
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