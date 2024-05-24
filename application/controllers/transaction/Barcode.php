<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends CI_Controller {
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
        
        
        $this->load->model('Barcode_model');
        $this->load->model('Common_model');
    }

    public function index()
    {

        $data['title']='Optical::Barcode';
        $data['activecls']='Barcode';
        $office_id=$this->session->office_id;
        $var_array=array($office_id);
        $data['getinvoiceno']=$this->Common_model->getpurchasedata($var_array);
        $content=$this->load->view('transaction/barcode/barcode',$data,true);
        $this->load->view('includes/layout',['content'=>$content]);
    }
    public function Generatebarcode() 
    {
       $this->Barcode_model->generatemoderate_bill($this->input->post('barcode_id'),$this->session->userdata('office_id'));
    }

}