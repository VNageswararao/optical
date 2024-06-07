<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @10/04/2022
 */
class Change_password_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	 public function insert($data)
    {
        if($this->db->insert('classification',$data))
        {
           
            return TRUE;
        }
    }
    public function checkpwd($var_array)
	{
		$sql = "select count(*) as cnt from user where password=? and  user_id = ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function updatedatapassword($var_array)
	{
		$sql = "update user set password=? where password=? and user_id=?";
	    $result_row=$this->db->query($sql, $var_array); 
        $this->logger->save($this->db);
        if($result_row)
        {
            return true;
        }
		
	}
	
}