<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_user extends CI_Controller {
  public function __construct() {
        parent::__construct();
        if (!isset($this->session->optical_login))
         {
		 	redirect('login');
         }
        $this->load->model('Create_user_model');
      
    }
    public function ajax_call()
    {
        $param=$_REQUEST;
        $response=$this->Create_user_model->ajax_call($param);
        echo json_encode($response);
 	}
	public function index()
	{
	   $getuserdesgn1=  $this->db->get_where("user","1=1")->row_array();
       if(isset($getuserdesgn1['description'])!='')
      {
          $this->db->query("ALTER TABLE `user`  ADD `description` TEXT NULL DEFAULT NULL  AFTER `read_pwd`;");
          $this->db->query("ALTER TABLE `user`  ADD `status` INT(5) NOT NULL DEFAULT '1' COMMENT '1:active,0:de active'  AFTER `description`;");
      }
      $data['title']='Optical::Createuser';
      $data['activecls']='Createuser';
      $content=$this->load->view('master/create_user',$data,true);
      $this->load->view('includes/layout',['content'=>$content]);
	}
    private function fetch_data() 
    {
    	$status=trim($this->input->post('status'));
        if(!$this->input->post('status'))
        {
            $status=0;
        }
        $office_id=$this->session->office_id;
        return array(
            'user_type'=>trim($this->input->post('role')),
            'name'=>trim($this->input->post('username')),
            'username'=>trim($this->input->post('username')),
            'password'=>trim($this->input->post('password')),
            'description'=>trim($this->input->post('description')),
            'status'=>$status,
            'office_id'=>1
            
           );
    }

    public function savedata()
	{
		$this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('username', 'Usernmae', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$username=trim(htmlentities($this->input->post('username')));
	    	$password=trim(htmlentities($this->input->post('password')));
	    	$var_array=array($username,$password,$this->session->userdata('office_id'));
	    	$chk_duplication=$this->Create_user_model->checkingval($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data();
	    		$getresult=$this->Create_user_model->savedata($data);
	    		if($getresult)
	    		{
			      echo json_encode(array('msg' =>'Saved Successfully','error'=>'','error_message' =>''));
	    		}
	    		else
	    		{
			        echo json_encode(array('msg' =>'','error'=> 'Failed to save','error_message' =>''));
	    		}
	    	}
	    	else
	    	{
	              echo json_encode(array('msg'=>'','error' =>'Username and Password already Used','error_message' =>''));
	    	}
	    }
	    else
	    {
	         echo json_encode(array('msg'=>'','error'=> '','error_message' => $this->form_validation->error_array()));
	    }
	}

	public function editdata()
	{
		$this->form_validation->set_rules('getid', 'Get ID', 'trim|required|numeric');
		if($this->form_validation->run() == TRUE)
	    {
	    	$var_array=array($this->input->post('getid'));
	    	$getdata=$this->Create_user_model->geteditdata($var_array);
	    	if($getdata)
	    	{
	    		$html='';
	    		foreach($getdata as $data)
	    		{
	    			$sel1='';
	    			$sel2='';
	    			if($data['status']==1)
	    			{
	    				$sel1='selected';
	    			}
	    			if($data['status']==0)
	    			{
	    				$sel2='selected';
	    			}
	    			$role2=$role3=$role4=$role5=$role6=$role7='';
	    			if($data['user_type']==2) {$role2='selected';}
	    			if($data['user_type']==3) {$role3='selected';}
	    			if($data['user_type']==4) {$role4='selected';}
	    			if($data['user_type']==5) {$role5='selected';}
	    			if($data['user_type']==6) {$role6='selected';}
	    			if($data['user_type']==7) {$role7='selected';}
	    			
	    			
	    			$html='<form id="edit_form" action="#" method="post"> 
							 <div id="div_modal" class="modal fade" role="dialog">
							        <div class="modal-dialog modal-lg">
							        <!-- Modal content-->
							            <div class="modal-content">
							                <div class="modal-header">
							                    <h4 class="modal-title"></h4>
							                    <button type="button" class="close" data-dismiss="modal">&times;</button>
							                </div>
							                <div class="modal-body">
							                    <div class="row">
							                        <div class="col-lg-12 col-md-12" >
							                          <input type="hidden" name="id" id="id" value="'.$data['user_id'].'">
							                           <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="'.$this->security->get_csrf_hash().'"> 
							                                 
							                                 <div class="row col-md-12">
							                                   <div class="col-md-4 form-group">
							                                         <label for="lastname">Role: <span class="text-danger">*</span></label>
							                                          <select class="form-control" name="role" id="role">
							                                                <option value="" >Select Role</option>
							                                                <option value="2" '.$role2.'>Staff</option>
							                                              
							                                            </select>
							                                    </div>
							                                    <div class="col-md-4 form-group">
							                                         <label for="lastname">Username: <span class="text-danger">*</span></label>
							                                         <input type="text" name="username" id="username" class="form-control" value="'.$data['name'].'">
							                                    </div>
							                                    <div class="col-md-4 form-group">
							                                         <label for="lastname">Password: <span class="text-danger">*</span></label>
							                                         <input type="password" name="password" id="password" class="form-control" value="'.$data['password'].'">
							                                    </div>
							                                </div>

							                                 
							                                
							                                  <div class="row col-md-12">
							                                    <div class="col-md-12 form-group">
							                                         <label for="lastname">Description: </label>
							                                         <textarea class="form-control" name="description" id="description">'.$data['description'].'</textarea>
							                                    </div>
							                                </div>
							                                 <div class="row col-md-12">
							                                     <div class="col-md-12 form-group">
							                                         <label for="lastname">Status: </label>
							                                        <select class="form-control" name="status" id="status">
							                                            <option value="1" '.$sel1.'>Active</option>
							                                            <option value="0" '.$sel2.'>De-Active</option>
							                                        </select>
							                                        </div>
							                                </div>
							                        </div>
							                    </div>
							                </div>
							                <div class="modal-footer">
		<button id="save" class="btn btn-primary btn-sm" type="button" onclick="updatedataval();"><i class="fas fa-plus-square"></i>Update</button>
			<button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
							                </div>
							            </div>
							        </div>
							    </div>
							</form>';
							echo json_encode(array('msg'=>$html,'error' =>'','error_message' =>''));
	    		}
	    	}
	    	else
	    	{
	    		echo json_encode(array('msg'=>'','error' =>'Name data Found','error_message' =>''));
	    	}
	    }
	    else
	    {
	    	echo json_encode(array('msg'=>'','error'=> '','error_message' => $this->form_validation->error_array()));
	    }
	}

	public function updatedata()
	{
		$this->form_validation->set_rules('id', 'Edit ID', 'trim|required|min_length[1]|max_length[1000]|numeric');
		$this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[1]|max_length[1]|numeric');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|max_length[30]');
    	$this->form_validation->set_rules('description', 'Description', 'trim');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$edit_id=trim(htmlentities($this->input->post('id')));
	    	$role=trim(htmlentities($this->input->post('role')));
	    	$username=trim(htmlentities($this->input->post('username')));
	    	$password=trim(htmlentities($this->input->post('password')));
	    	$description=trim(htmlentities($this->input->post('description')));
	    	$status=trim(htmlentities($this->input->post('status')));
	    	$var_array=array($edit_id,$username,$password);
	    	$chk_duplication=$this->Create_user_model->editcheck($var_array);
	    	if($chk_duplication[0]['cnt']==0)
	    	{
	    		$data=$this->fetch_data();
	    		$getresult=$this->Create_user_model->updatedata($data,$edit_id);
	    		if($getresult)
	    		{
		    		echo json_encode(array('msg'=>'Updated Successfully','error' =>'','error_message' =>''));
	    		}
	    		else
	    		{
	    			echo json_encode(array('msg'=>'','error' =>'Failed to Update','error_message' =>''));
	    		}
	    	}
	    	else
	    	{
	    		echo json_encode(array('msg'=>'','error' =>'Username password already Used','error_message' =>''));
	    	}
	    }
	    else
	    {
	    echo json_encode(array('msg'=>'','error' =>'','error_message' =>$this->form_validation->error_array()));
	    }
	}

	public function deletedata()
	{
		$this->form_validation->set_rules('getid', 'Delete ID', 'trim|required|min_length[1]|max_length[100]|numeric');
	    if($this->form_validation->run() == TRUE)
	    {
	    	$delete_id=trim(htmlentities($this->input->post('getid')));
	    	$var_array=array($delete_id);
	    	$chk_duplication=$this->Create_user_model->deletecheck($var_array);
	    	if($chk_duplication[0]['cnt']==1)
	    	{
	    		$getresult=$this->Create_user_model->deletedata($delete_id);
	    		if($getresult)
	    		{
			       echo json_encode(array('msg'=>'Deleted Successfully','error'=>'','error_message' =>''));
	    		}
	    		else
	    		{
			      echo json_encode(array('msg'=>'','error'=>'Failed to Delete','error_message' =>''));
	    		}
	    	}
	    	else
	    	{
	            echo json_encode(array('msg'=> '', 'error'=> 'Delete ID Not Found','error_message' =>''));
	    	}
	    }
	    else
	    {
	      echo json_encode(array('msg'=>'','error'=>'','error_message' => $this->form_validation->error_array()));
	    }
	}

}
