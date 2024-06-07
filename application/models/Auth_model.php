<?php
/**
 * Description of Auth_model
 *
 * @author rajesh @25/12/2020
 */
class Auth_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}


    public function lock_up($table,$condition) 
    {
      
        $this->db->select('count(*) as tcount');
        $this->db->where($condition);
        if($this->db->get($table)->row()->tcount>0)
        {
            return true;
        }
        return false;
    }

  
}