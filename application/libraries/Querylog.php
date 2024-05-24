<?php
class Querylog {
    protected $CI;

    public function __construct() {        
        $this->CI =& get_instance();
    }

    function save_query_in_db() {
        $query = $this->CI->db->last_query();
        $times = $this->CI->db->query_times; 
        $time = round(doubleval($times[2]), 5);
        $this->CI->db->query('INSERT INTO queryLog_tbl(`query`, `executedTime`, `timeTaken`, `executedBy`) '
            . 'VALUES ("'.$query.'", "'.date('Y-m-d h:i:s').'", "'.$time.'","'.$this->CI->session->userdata('UserID').'")');
    }
}