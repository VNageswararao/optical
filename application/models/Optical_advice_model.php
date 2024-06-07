<?php
/**
 * Description of Optical_advice_model
 *
 * @author Prabhu @20/07/2023
 */
class Optical_advice_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	
    public function getopticaladvicedata($opdate,$opaddate2,$val)
  {
    $whr='';
    if($opdate)
    {
       $whr=" and opticaladvice_date between '$opdate' and '$opaddate2'";
    }
    $addtype='';
    if($val==1 || $val==2)
    {
        $addtype= " and patient_registration_id in (select patient_registration_id from examination where optica_advice_type=$val order by examination_id desc)";
    }
    
      $this->emrdb = $this->load->database('emrdb', TRUE);
      $sql = "select patient_registration_id,mrdno,fname,lname,mobileno,address,DATE_FORMAT(opticaladvice_date,'%d/%m/%Y') AS opticaladvice_date from patient_registration where optical_advice=1 $whr $addtype order by opticaladvice_date DESC";
      $result_row=$this->emrdb->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getlastemrexaminationid($patid,$val)
  {
    $adtype='';
    if($val==0)
    {
      $adtype='';
    }
    if($val==1 || $val==2)
    {
      $adtype=" and optica_advice_type=$val";
    }
      $this->emrdb = $this->load->database('emrdb', TRUE);
      $sql = "select examination_id,optica_advice_type,optica_advice_reason,DATE_FORMAT(optica_advice_date,'%d/%m/%Y') AS optica_advice_date from examination where patient_registration_id=$patid $adtype order by examination_id desc limit 1";
      $result_row=$this->emrdb->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Update_Examination($exid,$advicetype,$reason)
  {
      $this->emrdb = $this->load->database('emrdb', TRUE);
      $date=date('Y-m-d');
      $sql = "update examination set optica_advice_type=$advicetype,optica_advice_reason='$reason',optica_advice_date='$date' where examination_id=$exid";
      $result_row=$this->emrdb->query($sql); 
      return $result_row;
  }
}