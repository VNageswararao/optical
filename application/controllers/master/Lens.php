<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lens extends CI_Controller {
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
        
        $this->load->model('Lens_model');
        $this->load->model('Item_model');
        $this->load->model('Common_model');
    }
	public function index()
	{
          $data['title']='Optical::Lens';
          $data['activecls']='Lens';
          $var_array=array($this->session->office_id);
          $data['lenstype']=$this->Lens_model->getlenstype($var_array);
          $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
          $data['lenscoating']=$this->Lens_model->getlenscoating($var_array);
          $data['tax']=$this->Item_model->gettax($var_array);
          $content=$this->load->view('master/lens',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Lens_model->lensajax_call($param);
           echo json_encode($response);
    }
	private function fetch_data($code,$name,$lens_type_id,$lens_coating_id,$purchase_date,$purchase_amount,$amount,$description,$status,$gst_type,$tax,$cgst,$sgst) 
    {
        if(!$status)
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'code'=>$code,
            'name'=>$name,
            'lens_type_id'=>$lens_type_id,
            'lens_coating_id'=>$lens_coating_id,
            'purchase_date'=>$purchase_date,
            'purchase_amount'=>$purchase_amount,
            'amount'=>$amount,
            'description'=>$description,
            'gst_type'=>$gst_type,
            'tax'=>$tax,
            'cgst'=>$cgst,
            'sgst'=>$sgst,
            'supplier_id'=>$this->input->post('supplier_id'),
            'status'=>$status,
            'login_id'=>$this->session->userdata('login_id'),
            'office_id'=> $this->session->userdata('office_id')
           );
    }

	public function savelens()
	{
		$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
		//$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('name', 'Coating Name', 'trim|required|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('lens_type_id', 'Type', 'trim|required|min_length[1]|max_length[100]|numeric');
		$this->form_validation->set_rules('lens_coating_id', 'Coating', 'trim|required|min_length[1]|max_length[100]|numeric');
		$this->form_validation->set_rules('purchase_date', 'Type', 'trim|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('purchase_amount', 'Type', 'trim|required|min_length[1]|max_length[100]|numeric');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$last_code_number=$this->db->select('max(code) as last_code_number')
                         ->from('lens_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }


	    	$code=$code;
	    	$name=trim(htmlentities($this->input->post('name')));
	    	$lens_type_id=trim(htmlentities($this->input->post('lens_type_id')));
	    	$lens_coating_id=trim(htmlentities($this->input->post('lens_coating_id')));
	    	$purchase_date=trim(htmlentities($this->input->post('purchase_date')));
	    	$purchase_date = explode("/", $this->input->post('purchase_date'));
	        $purchase_date = $purchase_date[0];
	    	$purchase_amount=trim(htmlentities($this->input->post('purchase_amount')));
	    	$amount=trim(htmlentities($this->input->post('amount')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$gst_type=trim(htmlentities($this->input->post('gst_type')));
	    	$tax=trim(htmlentities($this->input->post('tax')));
	    	$cgst=trim(htmlentities($this->input->post('cgst')));
	    	$sgst=trim(htmlentities($this->input->post('sgst')));
	    	$var_array=array($code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Lens_model->checklensmaster($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$lens_type_id,$lens_coating_id,$purchase_date,$purchase_amount,$amount,$description,$status,$gst_type,$tax,$cgst,$sgst);
	    		$getresult=$this->Lens_model->savelensdata($data);
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
	    		  $this->error='Code and Lens Name already Used';
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

	public function editlens()
	{
		$this->form_validation->set_rules('edit_lensid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('edit_type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('edit_name', 'Coating Name', 'trim|required|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('edit_lens_type_id', 'Type', 'trim|required|min_length[1]|max_length[100]|numeric');
		$this->form_validation->set_rules('edit_lens_coating_id', 'Coating', 'trim|required|min_length[1]|max_length[100]|numeric');
		$this->form_validation->set_rules('edit_purchase_date', 'Purchase Date', 'trim|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('edit_purchase_amount', 'Amount', 'trim|required|min_length[1]|max_length[100]|numeric');
    	$this->form_validation->set_rules('edit_description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_lensid=trim(htmlentities($this->input->post('edit_lensid')));
	    	$type=trim(htmlentities($this->input->post('edit_type')));
	    	$code=trim(htmlentities($this->input->post('edit_code')));
	    	$name=trim(htmlentities($this->input->post('edit_name')));
	    	$lens_type_id=trim(htmlentities($this->input->post('edit_lens_type_id')));
	    	$lens_coating_id=trim(htmlentities($this->input->post('edit_lens_coating_id')));
	    	$purchase_date=trim(htmlentities($this->input->post('edit_purchase_date')));
	    	$purchase_date = explode("/", $this->input->post('edit_purchase_date'));
	        $purchase_date = $purchase_date[0];
	    	$purchase_amount=trim(htmlentities($this->input->post('edit_purchase_amount')));
	    	$amount=trim(htmlentities($this->input->post('edit_amount')));
	    	$description=trim(htmlentities($this->input->post('edit_description')));
	    	$tax=trim(htmlentities($this->input->post('edit_tax')));
            $gst_type=trim(htmlentities($this->input->post('edit_gst_type')));
            $cgst=trim(htmlentities($this->input->post('edit_cgst')));
            $sgst=trim(htmlentities($this->input->post('edit_sgst')));
	    	$status=trim(htmlentities($this->input->post('edit_status')));
	    	$var_array=array($edit_lensid,$code,$name,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Lens_model->editchecklensmaster($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data($code,$name,$lens_type_id,$lens_coating_id,$purchase_date,$purchase_amount,$amount,$description,$status,$gst_type,$tax,$cgst,$sgst);
	    		$getresult=$this->Lens_model->updatelensmasterdata($data,$edit_lensid);
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
	    		  $this->error='Code and Lens Name already Used';
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

	public function deletelens()
	{
		$this->form_validation->set_rules('id', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[1]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_lensid=trim(htmlentities($this->input->post('id')));
	    	$type=trim(htmlentities($this->input->post('type')));
	    	$var_array=array($delete_lensid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Lens_model->deletechecklensmaster($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Lens_model->deletelensmasterdata($delete_lensid);
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
	public function getsavedata()
	{
		$this->form_validation->set_rules('getid', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$getid=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($getid,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Lens_model->deletechecklensmaster($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		
	    		$getresult=$this->Lens_model->GetData($var_array);
	    		if($getresult)
	    		{
		    		  $this->msg='success';
		    		  $this->error='';
		    		  $this->error_message ='';
			              echo json_encode(array(
					        'msg'           => $this->msg,
					        'error'         => $this->error,
					        'error_message' => $this->error_message,
					        'getdata' => $getresult
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

	public function createsaleslens()
	{	

		  $var_array=array($this->session->office_id);
          $lenstype=$this->Lens_model->getlenstype($var_array);
            $len='';
            foreach ($lenstype as $data) {
               $len.='<option value="'.$data['lens_classification_id'].'">'.$data['name'].'</option>';
            }
	       
          $getsupplier=$this->Common_model->getsupplierdata($var_array);
          $getsupplie='';
            foreach ($getsupplier as $data) {
               $getsupplie.='<option value="'.$data['supplier_id'].'">'.$data['name'].'</option>';
            }
          $lenscoating=$this->Lens_model->getlenscoating($var_array);
          $lenscoatin='';
            foreach ($lenscoating as $data) {
               $lenscoatin.='<option value="'.$data['lens_classification_id'].'">'.$data['name'].'</option>';
            }
          $tax=$this->Item_model->gettax($var_array);
           $taxx='';
            foreach ($tax as $data) {
               $taxx.='<option value="'.$data['tax_id'].'">'.$data['name'].'</option>';
            }

	    			
	    			$html='<form id="lens_form" action="#" method="post"> 
							 <div id="div_modallens" class="modal fade" role="dialog">
							        <div class="modal-dialog modal-xl">
							        <!-- Modal content-->
							            <div class="modal-content">
							                <div class="modal-header">
							                    <h4 class="modal-title">Create Lens Master</h4>
							                    <button type="button" class="close" data-dismiss="modal">&times;</button>
							                </div>
							                <div class="modal-body">
							                    <div class="row">
							                        <div class="col-lg-12 col-md-12" >
							                           <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="'.$this->security->get_csrf_hash().'"> 
							                                 
							                               <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Code: </label>
                                            <input type="text" class="form-control" name="code" placeholder="Code" id="code" required readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Lens Type: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="lens_type_id" id="lens_type_id">
                                                <option value="">Select Lens Type</option>
                                               '.$len.'
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Coating: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="lens_coating_id" id="lens_coating_id">
                                                <option value="">Select Coating</option>
                                                    '.$lenscoatin.'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" required>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Purchase Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Purchase Date" id="purchase_date" name="purchase_date" pattern="\d{4}-\d{2}-\d{2}" >
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">MRP: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="MRP" id="purchase_amount" name="purchase_amount" required>
                                        </div>
                                    </div>
                                      <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Gst: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="gst_type" id="gst_type" onchange="changeVat($(this).val())">
                                               <option value="0">NonTax</option>
                                               <option value="1">Inclusive</option>
                                               <option value="2">Exclusive</option>
                                           </select>
                                        </div>
                                    </div>

                                    <div class="row col-md-6" id="tax_gstt" style="display: none;">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Tax: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="tax" id="taxt" onchange="changeTaxvall($(this).val())">
                                            <option value="">Select Tax</option>
                                              '.$taxx.'
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">CGST%: </label>
                                           <input type="text" readonly name="cgst" id="cgstt" class="form-control" placeholder="CGST">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">SGST%: </label>
                                           <input type="text" readonly name="sgst" id="sgstt" class="form-control" placeholder="SGST">
                                        </div>
                                    </div>
                                </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                          <select class="form-control select2" name="supplier_id" id="supplier_id">
                                                <option value="">Select supplier</option>
                                                '.$getsupplie.'
                                            </select>
                                        </div>
                                    </div>
									<div class="col-md-3">
                                       <div class="form-group">
                                            <label for="lastname">Purchase Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Purchase Amount" id="amount" name="amount" required>
                                        </div>
                                    </div>

                                   
                                </div>
                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="description" name="description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

							                        </div>
							                    </div>
							                </div>
							                <div class="modal-footer">
		<button id="save" class="btn btn-primary btn-sm" type="button" onclick="lensclassificationn(3);"><i class="fas fa-plus-square"></i>Save</button>
			<button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							                </div>
							            </div>
							        </div>
							    </div>
							</form>';
							echo json_encode(array('msg'=>$html,'error' =>'','error_message' =>''));
	    	
	}

}
