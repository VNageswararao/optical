<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer_report extends CI_Controller {
  private $msg;
  private $error;
  private $error_message;
  private $randval;
  private $er;
  public function __construct() {
        parent::__construct();
        if (!isset($this->session->optical_login))
         {
          redirect('login');
         }
        
        $this->load->model('Stock_transfer_report_model');
        $this->load->model('Common_model');
       
       
    }
  public function index()
  {
    $data['title']='Optical::Stock Transfer Report';
    $data['activecls']='Stock_transfer_report';
    $office_id=$this->session->office_id;
    $var_array=array($office_id);
    $data['getitem']=$this->Common_model->getitemdata($var_array);
    $content=$this->load->view('reports/stock_transfer_report',$data,true);
    $this->load->view('includes/layout',['content'=>$content]);
  }

     public function getstockRegister_data()
    {
      
        $sfrom_date=trim(htmlentities($this->input->post('sfrom_date')));
        $to_date=trim(htmlentities($this->input->post('sto_date')));
        $det_item=trim(htmlentities($this->input->post('sdet_item')));
     $getresult=$this->Stock_transfer_report_model->Get_register_Data($sfrom_date,$to_date,$det_item,$this->session->userdata('office_id'));
      if($getresult)
      {

   
        $html='
                  <table class="table table-striped table-bordered dataex-html5-selectors" id="example_suma">
            <thead>
                    <tr>
                         <th>Sl NO</th>
                          <th>Item Name</th>
                          <th>Stock Transfer Qty</th>
                          <th>MRP</th>
                          <th>SP</th>
                          <th>Amount</th>
                          <th>Frame Type</th>
                          <th>Frame Color</th>
                          <th>Frame Size</th>
                          <th>Frame Model</th>
                     </tr>
                     </thead>
                   <tbody>';
        $sl=1;
        $sumnetamount='0.00';
        
         $sl=0;
                foreach($getresult as $data)
                {
                    $frametype_array=array($data['frame_type'],$this->session->userdata('office_id'));
                    $frame_type=$this->Common_model->GetframeclassficationData($frametype_array);
                    $frame_type=$frame_type[0]['name'];
                    $framecolor_array=array($data['frame_color'],$this->session->userdata('office_id'));
                    $frame_color=$this->Common_model->GetframeclassficationData($framecolor_array);
                    $frame_color=$frame_color[0]['name'];
                    $framesize_array=array($data['frame_size'],$this->session->userdata('office_id'));
                    $frame_size=$this->Common_model->GetframeclassficationData($framesize_array);
                    $frame_size=$frame_size[0]['name'];
                    $framemodel=$data['frame_model'];
                    $sl++;


                  $html.='<tr>
                                    <td>'.$sl.'</td>
                                    <td>'.$data['item_name'].'</td>
                                    <td>'.$data['quantity'].'</td>
                                    <td>'.$data['mrp'].'</td>
                                    <td>'.$data['selling_price'].'</td>
                                    <td>'.$data['amount'].'</td>
                                    <td>'.$frame_type.'</td>
                                  <td>'.$frame_color.'</td>
                                  <td>'.$frame_size.'</td>
                                  <td>'.$framemodel.'</td>
                                  </tr>';
                           
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
