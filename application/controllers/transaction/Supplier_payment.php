<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_payment extends CI_Controller {
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
        
        $this->load->model('Supplier_payment_model');
        $this->load->model('Common_model');
    }

    public function index()
    {
        $data['title']='Pharmacy::Supplier Payment';
        $data['activecls']='Supplier_payment';
        $office_id=$this->session->office_id;
        $var_array=array($office_id);
        $data['getsupplier']=$this->Common_model->getsupplierdata($var_array);
        $content=$this->load->view('transaction/supplier_payment/insert',$data,true);
        $this->load->view('includes/layout',['content'=>$content]);
    }
     public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->Supplier_payment_model->ajax_call($param);
           echo json_encode($response);
    }
       public function getpurchasedetails()
      {
          $this->form_validation->set_rules('getid', 'Supplier ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
          if($this->form_validation->run() == TRUE)
          {
            $getid=trim(htmlentities($this->input->post('getid')));
            $var_array=array($getid,$this->session->userdata('office_id'));
            $getalldata=$this->Supplier_payment_model->getallsupplierpurchase($var_array);
            if($getalldata)
            {
               $html='<table class="table table-striped table-bordered dataex-html5-selectors" id="example_sum">
                    <thead>
                    <tr>
                         <th>#</th>
                         <th>SL NO</th>
                         <th>Date</th>
                         <th>Invoice No</th>
                         <th>Modeofpay</th>
                         <th>Total Qty</th>
                         <th>Net Amount</th>
                         <th>Paid Amount</th>
                     </tr>
                     </thead>
                   <tbody>';
                    $sl=1;
                    $sumnetamount='0.00';
                    foreach ($getalldata as $data) {
                
                    $html.='<tr>
                                <td><input type="hidden" name="purid[]"  value="'.$data['purchase_id'].'"><input type="checkbox" name="checksup[]" class="checkind"  value="'.$data['purchase_id'].'"></td>
                                <td>'.$sl.'</td>
                                <td>'.$data['purchase_date'].'</td>
                                <td>'.$data['invoice_no'].'</td>
                                <td>'.$data['mode'].'</td>
                                <td>'.$data['total_qty'].'</td>
                                <td>'.$data['total_amount'].'</td>
                                <td><input type="hidden"  name="purchase_amount[]" class="form-control checkBoxClass"  value="'.$data['total_amount'].'">
                                <input type="text" readonly  name="indtot[]" class="form-control checkBoxClass" id="tot_'.$sl.'" value="'.$data['total_amount'].'"></td>
                            </tr>';
                            $sl++;
                            $sumnetamount+=$data['total_amount'];
                }
                        $html.='<tr>
                                    <th></th>
                                    <th>'.$sl.'</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th>'.number_format((float)$sumnetamount,2,'.', '').'</th>
                                    <th></th>
                                </tr>
                                </tbody>
                                </table>';
            

             
             echo json_encode(array('msg'=>'success','error'=>'','error_message' =>'','getdata' => $html));
              
          }
          else
          {
            echo json_encode(array('msg'=>'','error'=>'','error_message' =>''));
          }
           
          }
          else
          {
              $this->error_message = $this->form_validation->error_array();
             echo json_encode(array('msg'=>'','error'=>'','error_message' =>''));
          }
      }

        public function fetch_data()
       {
          $office_id=$this->session->office_id;
           $return=array(
            "supplier_payment_master"=>array(
                   'supplier_id'=>$this->input->post('supplier_id'),
                   'payment_date'=>date('Y-m-d'),
                   'login_id'=>$this->session->userdata('login_id'),
                   'office_id'=> $office_id
               ),
              "supplier_payment_details"=>array(
                   'purchase_id'=>$this->input->post('purid'),
                   'checksup'=>$this->input->post('checksup'),
                   'purchase_amount'=>$this->input->post('purchase_amount'),
                   'indtot'=>$this->input->post('indtot')
               ),
           );
            return $return;
       }

      public function savesupplierpayment()
  {
      $this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required|min_length[1]|max_length[30]|numeric');
      $this->form_validation->set_rules('checksup[]', 'Select Checkbox', 'trim|required|min_length[1]|max_length[30]|numeric');
      if($this->form_validation->run() == TRUE)
      {
        
          $data=$this->fetch_data();
          $getresult=$this->Supplier_payment_model->savedata($data);
          if($getresult)
          {
            echo json_encode(array('msg'=>'Saved Successfully','error'=>'','error_message' =>''));
            
          }
          else
          {
            echo json_encode(array('msg'=>'Failed to save','error'=>'','error_message' =>''));
          }
       
      }
      else
      {
       echo json_encode(array('msg'=>'','error'=>'','error_message' =>$this->form_validation->error_array()));
      }
  }

   public function viewdata()
    {
        $this->form_validation->set_rules('getid', 'Get ID', 'trim|required|numeric');
        if($this->form_validation->run() == TRUE)
        {
            $var_array=array($this->input->post('getid'),$this->session->userdata('office_id'));
            $getdata=$this->Supplier_payment_model->getviewdata($var_array);
            if($getdata)
            {
                

                $html='<div id="div_modal" class="modal fade animated fadeInRightBig text-left" role="dialog">
                                    <div class="modal-dialog modal-lg ">
                                    <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Sl NO</th>
                                                        <th>Supplier Name</th>
                                                        <th>Payment Date</th>
                                                        <th>Paid Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                        $sl=0;
                                        foreach($getdata as $data)
                                        {
                                            $sl++;
                                            $html.='<tr>
                                                        <td>'.$sl.'</td>
                                                        <td>'.$data['name'].'</td>
                                                        <td>'.$data['payment_date'].'</td>
                                                        <td>'.$data['paid_amount'].'</td>
                                                    </tr>';
                                                   
                                        }
                                     $html.='</tbody>
                                            </table>
                                              </div>      
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                 echo json_encode(array('msg'=>$html,'error' =>'','error_message' =>''));
            }
            else
            {
                echo json_encode(array('msg'=>'','error' =>'No data Found','error_message' =>''));
            }
        }
        else
        {
            echo json_encode(array('msg'=>'','error'=> '','error_message' => $this->form_validation->error_array()));
        }
    }

    public function deletedata()
    {
        $this->form_validation->set_rules('getid', 'Delete ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
        if($this->form_validation->run() == TRUE)
        {
                $delete_groupid=trim(htmlentities($this->input->post('getid')));
                $getresult=$this->Supplier_payment_model->deletedata($delete_groupid);
                if($getresult)
                {
                 echo json_encode(array('msg'=>'Deleted Successfully','error'=>'','error_message'=>''));
                }
                else
                {
                  echo json_encode(array('msg'=>'Failed to Delete','error'=>'','error_message' =>''));
                }
            
        }
        else
        {
          echo json_encode(array('msg'=> $this->msg,'error'=>'','error_message' =>''));
        }
    }

}