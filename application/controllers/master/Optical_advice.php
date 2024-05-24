<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Optical_advice extends CI_Controller {
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
        
        $this->load->model('Optical_advice_model');
    }
	public function index()
	{
          $data['title']='Optical::Optical Advice';
          $data['activecls']='Optical_advice';
          $content=$this->load->view('master/optical_advice',$data,true);
	      $this->load->view('includes/layout',['content'=>$content]);
	}
	  public function getopticaladvice()
       {
             $opaddate=$this->input->post('opticaladvice_date1');
             $val=$this->input->post('val');
             $opaddate2=$this->input->post('opticaladvice_date2');
             if($opaddate)
             {
                $opening_date = $opaddate;
                $current_date = '2022-09-21';

                if ($opening_date > $current_date) {
                   $opdate=$opening_date;
                }
                else {
                  $opdate='';
                }
               
            $optica_advice_type='';
             $optica_advice_reason='';
                $getresult=$this->Optical_advice_model->getopticaladvicedata($opdate,$opaddate2,$val);
                if($getresult)
                {
                  $html='<table id="opadv'.$val.'" class="table table-bordered table-hover"><thead><tr><th>SL NO</th><th>Patient Name</th><th>MRD NO</th><th>Mobile No</th><th>Address</th><th>Optical Advice Date</th><th>Print</th><th>Action</th></tr></thead><tbody>';
                  $sl=1;
                  $exid='';
                  foreach ($getresult as $datr) {
                    $getresultdata=$this->Optical_advice_model->getlastemrexaminationid($datr['patient_registration_id'],$val);
                  //  print_r($getresultdata);exit;
                    if($getresultdata)
                    {
                      $exid=$getresultdata[0]['examination_id'];
                      $optica_advice_type=$getresultdata[0]['optica_advice_type'];
                      $optica_advice_reason=$getresultdata[0]['optica_advice_reason'];
                    }
                     $action='<button onclick="getaction('.$exid.')" type="button" class="btn btn-danger btn-info mr-1 mb-1"><i class="la la-cog"></i></button>';
                     if($val!=0)
                     {
                     	if($optica_advice_type==1)
	                    {
	                    	$action='<span class="badge bg-success">Converted</span>';
	                    }
	                    if($optica_advice_type==2)
	                    {
	                    	$action='<span class="badge bg-danger">Not Converted</span>';
	                    }
                     }
                    
                   
                    $print='<button onclick="examinationprint('.$exid.')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';
                    $html.='<tr><td>'.$sl.'</td><td>'.$datr['fname'].' '.$datr['lname'].'</td><td>'.$datr['mrdno'].'</td><td>'.$datr['mobileno'].'</td><td>'.$datr['address'].'</td><td>'.$datr['opticaladvice_date'].'</td><td>'.$print.'</td><td>'.$action.'</td></tr>';
                    $sl++;
                  }
                  echo json_encode(array('msg'=>$html,'error'=>'','error_message' =>''));
                }
                else {
                  echo json_encode(array('msg'=>'No Data Found','error'=>'No data found','error_message' =>''));
                }
             }
             else {
                echo json_encode(array('msg'=>'failed','error'=>'Please select Date','error_message' =>''));
             }
             
       }
       public function updatetype()
       {
              $exid=$this->input->post('exid');
              $advicetype=$this->input->post('advicetype');
              $reason=$this->input->post('reason');
              if($exid)
              {
              		$getresultdata=$this->Optical_advice_model->Update_Examination($exid,$advicetype,$reason);
              		if($getresultdata)
              		{
              			  echo json_encode(array(
			                  'msg'           => 'Updated Successfully',
			                  'error'         => '',
			                  'error_message' => ''
			                ));
              		}
              		else
              		{
              				echo json_encode(array('msg'=>'','error'=>'failed to update.please contact administrator','error_message' =>''));
              		}
              }
              else
              {
              	echo json_encode(array('msg'=>'','error'=>'ID Not Found.please contact administrator','error_message' =>''));
              }
       }

}


