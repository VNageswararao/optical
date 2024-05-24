<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @26/12/2020
 */
class Common_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  public function getcategory($var_array)
  {
    $sql = "select * from classification where    office_id= ? and status=1 and type=1";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
  public function getsupplierdata($var_array)
  {
      $sql = "select *  from supplier where  status=1 and  office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function Get_Pat_Source($mrd)
    {
        $this->emrdb = $this->load->database('emrdb', TRUE);
        $sql = "select b.name as source from patient_appointment a inner join source b on a.source=b.source_id  where  patient_registration_id in (select patient_registration_id from patient_registration where mrdno='$mrd') order by a.patient_appointment_id ASC limit 1";
        $result_row=$this->emrdb->query($sql); 
        $res= $result_row->result_array ();
        $this->logger->save($this->db);
        return $res;
    }
  public function GetStaffData($var_array)
  {
      $sql = "select *  from staff where  status=1 and  office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getlensmaster($var_array)
  {
      $sql = "select *  from lens_master where  status=1 and  office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getcustomerdata($var_array)
  {
      $sql = "select *  from customer where  status=1 and  office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
	  return $res;
  }
 /*  public function getcustomerdatalimit($var_array)
  {
      $sql = "select *  from customer where  status=1 and  office_id= ? ORDER BY customer_id DESC LIMIT 10";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
	  return $res;
  } */
  public function checkcustomer($var_array)
  {
      $sql = "select count(*) as cnt  from customer where  status=1 and  customer_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getcustomerdataind($var_array)
  {
      $sql = "select *  from customer where  status=1 and  customer_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getitemdata($var_array)
  {
      $sql = "select item_id,name  from item_master where  status=1 and  office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function checkproduct($var_array)
  {
      $sql = "select count(*) as cnt  from item_master where item_id=?   and  office_id= ? and status=1";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function checkproduct_Lens($var_array)
  {
      $sql = "select count(*) as cnt  from lens_master where lens_master_id=?   and  office_id= ? and status=1";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function GetitemDatadetails($var_array)
  {
      $sql = "select *  from item_master where  status=1 and item_id=? and   office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function GetitemDatadetaxtails($var_array)
  {
      $sql = "select tax_master.name as taxval,item_master.item_id,item_master.name as name,item_master.code as code  from item_master left join tax_master on item_master.tax=tax_master.tax_id where  item_master.status=1 and item_id=? and   item_master.office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function GetitemDatadetaxtails_Lens($var_array)
  {
      $sql = "select tax_master.name as taxval,lens_master.lens_master_id,lens_master.name as name,lens_master.code as code  from lens_master left join tax_master on lens_master.tax=tax_master.tax_id where  lens_master.status=1 and lens_master_id=? and   lens_master.office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetframetypeData($frame_array)
  {
      $sql = "select frame_id,name  from frame_classification where  status=1 and type=1 and   office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetframecolorData($frame_array)
  {
      $sql = "select frame_id,name  from frame_classification where  status=1 and type=2 and   office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetframemodelData($frame_array)
  {
      $sql = "select frame_id,name  from frame_classification where  status=1 and type=3 and   office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetframesizeData($frame_array)
  {
      $sql = "select frame_id,name  from frame_classification where  status=1 and type=4 and   office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetModeofpayData($var_array)
  {
      $sql = "select modeofpay_id,name  from modeofpay where  status=1 and   office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }

   public function GetframeclassficationData($frame_array)
  {
      $sql = "select name  from frame_classification where  status=1 and   frame_id=? and   office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetLenstypeData($frame_array)
  {
      $sql = "select lens_classification.name as lenstype  from lens_master inner join lens_classification on lens_master.lens_type_id=lens_classification.lens_classification_id where  lens_master.status=1 and   lens_master.lens_master_id=? and   lens_master.office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function GetLenscoatingData($frame_array)
  {
      $sql = "select lens_classification.name as lenscoating  from lens_master  inner join lens_classification on lens_master.lens_coating_id=lens_classification.lens_classification_id where  lens_master.status=1 and   lens_master.lens_master_id=? and   lens_master.office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function GetLensData($frame_array)
  {
      $sql = "select code,name  from lens_master where  status=1 and   lens_master_id=? and   office_id= ?";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getpurchasedata($var_array)
  {
      $sql = "select purchase.purchase_id,supplier.name,purchase.invoice_no  from purchase inner join supplier on purchase.supplier_id=supplier.supplier_id where  purchase.office_id= ?  order by purchase_id desc";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function GetSalesData($frame_array)
  {
      $sql = "select sales_master.sales_id,customer.name,sales_master.invoice_number  from sales_master inner join customer on sales_master.customer_id=customer.customer_id where  sales_master.office_id= ?  order by sales_id desc";
      $result_row=$this->db->query($sql, $frame_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getsupplierdataval($var_array)
  {
      $sql = "select supplier_id,name  from supplier  where  office_id= ? and status=1  order by name ASC";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }

}