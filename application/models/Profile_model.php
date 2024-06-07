<?php
/**
 * Description of Profile_model
 *
 * @author Prabhu @25/12/2020
 */
class Profile_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	public function getprofile($var_array)
	{
		$sql = "select * from office where  office_id= ?";
		$result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		$this->logger->save($this->db);
		return $res;
	}
	public function checkprofile($var_array)
	{
		$sql = "select count(*) as cnt from office where  office_id= ?";
		$result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		$this->logger->save($this->db);
		return $res;
	}
	public function removelogo($var_array,$id)
	{
		$this->db->set($var_array);
        $this->db->where('office_id', $id);
        if($this->db->update('office'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
	}
	public function savedata($data)
    {
        if($this->db->insert('office',$data))
        {
             $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('office_id', $id);
        if($this->db->update('office'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }


}