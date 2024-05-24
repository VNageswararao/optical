<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cloginredirect extends CI_Controller
{
	private $msg;
	private $error;
	private $error_message;
	private $randval;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
	}
	function random_name($length = 5)
	{
		$charArray = array();
		$upper = range('A', 'Z');
		$lower = range('a', 'z');
		$num = range(0, 9);
		$special = array('~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-');
		$charArray = array_merge($charArray, $upper, $lower, $num);
		/* Do we need to seed the random number generator? */
		if (version_compare(PHP_VERSION, '7.2.0') == -1) {
			mt_srand((float)microtime() * 1234567);
		}
		shuffle($charArray);
		$pass = '';
		for ($x = 0; $x < $length; $x++) {
			$pass .= $charArray[mt_rand(0, (sizeof($charArray) - 1))];
		}
		return $pass;
	}
	public function index()
	{
		$data = array();
		$getres=$this->Login_model->get_optical_Admin_details();
		if($getres)
		{
			$utype=1;
			$uname=$getres[0]['username'];
			$loginPaswd=$getres[0]['password'];
			$result = $this->Login_model->chklogin($utype, $uname, $loginPaswd);
			$cnt = $result[0]['cnt'];
			if ($cnt > 0) {
				$result_data = $this->Login_model->getuserdetails($utype, $uname, $loginPaswd);
				$this->session->set_userdata('username', $result_data[0]['name']); //get username
				$this->session->set_userdata('office_id', $result_data[0]['office_id']);
				$this->session->set_userdata('login_id', $result_data[0]['user_id']);
				$this->session->set_userdata('user_type', $result_data[0]['user_type']);

				
				$utype = 1;
				$uname = $uname;
				$pwd = $loginPaswd;
				$ip = $this->input->ip_address();
				$logintime = date("Y-m-d h:i:s");
				$var_array = array($this->session->userdata('login_id'), $utype, $uname, $pwd, $ip, $logintime, $this->session->userdata('office_id'));
				$result_data = $this->Login_model->savelog($var_array);
				$this->session->set_userdata("optical_login", true);
				redirect(base_url() . 'transaction/Sales');
				// exit;
				// $this->msg = 'success';
				// echo json_encode(array(
				// 	'msg'           => $this->msg,
				// 	'error'         => $this->error,
				// 	'url'         => base_url() . 'transaction/Sales',
				// 	'error_message' => $this->error_message
				// ));
				// exit;
			}
		}
	}

	public function checklogin()
	{
		$this->form_validation->set_rules('select_login_type', 'Login type', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('text_login_username', 'Username', 'trim|required|min_length[1]|max_length[30]|alpha_numeric');
		$this->form_validation->set_rules('text_login_password', 'Password', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$utype = $this->input->post('select_login_type');
			$uname = $this->input->post('text_login_username');
			$loginPaswd = $this->input->post('text_login_password');
			$result = $this->Login_model->chklogin($utype, $uname, $loginPaswd);
			$cnt = $result[0]['cnt'];
			if ($cnt > 0) {
				$result_data = $this->Login_model->getuserdetails($utype, $uname, $loginPaswd);
				$this->session->set_userdata('username', $result_data[0]['name']); //get username
				$this->session->set_userdata('office_id', $result_data[0]['office_id']);
				$this->session->set_userdata('login_id', $result_data[0]['user_id']);
				$this->session->set_userdata('user_type', $result_data[0]['user_type']);

				if ($this->input->post("remember") == '1') {
					setcookie("utype", $utype, time() + (10 * 365 * 24 * 60 * 60), "/");
					setcookie("name", $uname, time() + (10 * 365 * 24 * 60 * 60), "/");
					setcookie("password", $loginPaswd, time() + (10 * 365 * 24 * 60 * 60), "/");
				} else {
					if (isset($_COOKIE["name"])) {
						setcookie("name", "");
					}
					if (isset($_COOKIE["password"])) {
						setcookie("password", "");
					}
					if (isset($_COOKIE["utype"])) {
						setcookie("utype", "");
					}
				}
				$utype = $this->input->post('select_login_type');
				$uname = $this->input->post('text_login_username');
				$pwd = $this->input->post('text_login_password');
				$ip = $this->input->ip_address();
				$logintime = date("Y-m-d h:i:s");
				$var_array = array($this->session->userdata('login_id'), $utype, $uname, $pwd, $ip, $logintime, $this->session->userdata('office_id'));
				$result_data = $this->Login_model->savelog($var_array);
				$this->session->set_userdata("optical_login", true);
				$this->msg = 'success';
				echo json_encode(array(
					'msg'           => $this->msg,
					'error'         => $this->error,
					'url'         => base_url() . 'master/Dashboard',
					'error_message' => $this->error_message
				));
				exit;
			} else {
				$this->error_message = 'Invalid login details';
				echo json_encode(array(
					'msg'           => $this->msg,
					'error'         => $this->error,
					'error_message' => $this->error_message
				));
				exit;
			}
		} else {
			$this->error_message = $this->form_validation->error_array();
			echo json_encode(array(
				'msg'           => $this->msg,
				'error'         => $this->error,
				'error_message' => $this->error_message
			));
			exit;
		}
	}

	public function logout()
	{

		$lotime = date("h:i:s");
		// $logout_time=$this->session->userdata('time');
		// $this->db->query("update log_book set logout_time='$lotime' where time='$logout_time'");
		$this->session->sess_destroy();
		redirect('Login');
	}
}
