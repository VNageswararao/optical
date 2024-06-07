<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lens_stock_adjustment extends CI_Controller {
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
        
        $this->load->model('Stock_adjustment_model','dm',true);
    }
    public function ajax_call(){
           $param=$_REQUEST;
           $response=$this->dm->ajax_call_lens($param);
           echo json_encode($response);
    }
	public function index()
	{
      $data['title']='Optical::Lens Stock Adjustment';
      $data['activecls']='Lens_stock_adjustment';
      $var_array=array($this->session->office_id);
      $data['getsalesbill']=$this->dm->Get_sales_Bill($var_array);
      $content=$this->load->view('master/lens_stock_adjustment',$data,true);
      $this->load->view('includes/layout',['content'=>$content]);
	}

	  private function fetch_data() 
       {
       	$last_code_number=$this->db->select('max(number) as last_code_number')
                         ->from('lens_stock_adjustment')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_code_number;
                if($last_code_number>0)
                {
                    $code=$last_code_number+1;
                } else {
                    $code= $last_code_number+1;
                   
                }
           $office_id=$this->session->office_id;
           return array(
               "stock_adjustment_master"=>array(
                   "adjustment_date"=> date('Y-m-d'),
                   "number"=>$code,
                    "sales_id"=>$this->input->post('sales_id'),
                   "description"=>$this->input->post('description'),
                   "login_id"=>$this->session->login_id,
                   'office_id'=> $office_id
               ),
             "stock_adjustment_detail"=>array(
                 "item_id"=>$this->input->post('product_id'),
                 "stock_id"=>$this->input->post('stock_id'),
                 "action"=>$this->input->post('action'),
                 "quantity"=>$this->input->post('quantity')
             )
           );
       }

	public function savedata()
	{
		$this->form_validation->set_rules('action[]', 'Action', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|min_length[1]|max_length[20]|numeric');
		$this->form_validation->set_rules('product_id[]', 'Item ID', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('stock_id[]', 'Stock ID', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    		$data=$this->fetch_data();
	    		$getresult=$this->dm->savedata_lens($data);
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

	 public function viewdata()
    {
        $this->form_validation->set_rules('getid', 'Get ID', 'trim|required|numeric');
        if($this->form_validation->run() == TRUE)
        {
            $var_array=array($this->input->post('getid'),$this->session->userdata('office_id'));
            $getdata=$this->dm->getviewdata_lens($var_array);
          //  print_r($getdata);exit;
            if($getdata)
            {
            	

                $html='<div id="div_modal" class="modal fade animated fadeInRightBig text-left" role="dialog">
                                    <div class="modal-dialog modal-xl ">
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
                                            			<th>Item Name</th>
                                            			<th>Action</th>
                                            			<th>Stock Adjustment Qty</th>
                                            			<th>MRP</th>
                                            			<th>SP</th>
                                            			<th>Stock</th>
                                            		</tr>
                                            	</thead>
                                            	<tbody>';
                $sl=0;
                foreach($getdata as $data)
                {
                	$sl++;


                    						$html.='<tr>
                                            			<td>'.$sl.'</td>
                                            			<td>'.$data['item_name'].'</td>
                                            			<td>'.$data['status'].'</td>
                                            			<td>'.$data['quantity'].'</td>
                                            			<td>'.$data['mrp'].'</td>
                                            			<td>'.$data['selling_price'].'</td>
                                            			<td>'.$data['stockqty'].'</td>
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
	    		$getresult=$this->dm->deletedata_lens($delete_groupid);
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
	public function sales_search_stock()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->dm->getSalesSearchStock($product,$this->session->userdata('office_id'));
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
  public function sales_search_stock_Lens()
  {
      $this->form_validation->set_rules('product', 'product name', 'trim|required|min_length[1]|max_length[20]');
      if($this->form_validation->run() == TRUE)
      {
        $product=trim(htmlentities($this->input->post('product')));
        $var_array=array($product,$this->session->userdata('office_id'));
        $getresult=$this->dm->getSalesSearchStock_lens($product,$this->session->userdata('office_id'));
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
