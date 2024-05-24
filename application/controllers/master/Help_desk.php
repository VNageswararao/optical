<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help_desk extends CI_Controller {
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
    }

    public function index()
    {
      $data['title']='Optical::Help Desk';
      $data['activecls']='Help desk';
      $content=$this->load->view('master/help_desk',$data,true);
      $this->load->view('includes/layout',['content'=>$content]);
    }
}