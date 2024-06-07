 <?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @01/01/2021
 */
class Purchaseexcel_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}
	
	public function Itemnamecheckingmodel($array)
	  {
	      $this->db->select('count(*) as cnt,item_id');
	      $this->db->where($array);
          $result_row = $this->db->get('item_master');
	      $res= $result_row->result_array ();
	      return $res;
	  }
	public function Suppliernamecheckingmodel($array)
	  {
	      $this->db->select('count(*) as cnt,supplier_id');
	      $this->db->where($array);
          $result_row = $this->db->get('supplier');
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function FrameCLAScheckingmodel($array)
	  {
	      $this->db->select('count(*) as cnt,frame_id');
	      $this->db->where($array);
          $result_row = $this->db->get('frame_classification');
	      $res= $result_row->result_array ();
	      return $res;
	  }

	  public function SaveExceldetails($array)
	  {
	  	   $result=array();
	  	   $this->db->trans_begin();
           $purchase_entry=$array;
           $this->db->insert('purchaseexceldetails',$purchase_entry);
           $lastinsert_id=$this->db->insert_id();
           //$result[] = $lastinsert_id;
           if($lastinsert_id>0)
           {
           	 	if ($this->db->trans_status() === FALSE)
	            {
	                    $this->db->trans_rollback();
	                    return FALSE;
	            }
	            else
	            {
	                    $this->db->trans_commit();
	                    return $lastinsert_id;
	            }
           }
           else
           {
           	   $this->db->trans_rollback();
	           return FALSE;
           }
	  }
	  public function Getsupplierdetails($var_array)
	  {
	      $sql = "select supplier.supplier_id,supplier.name,purchaseexceldetails.invoiceno,purchaseexceldetails.taxtype,purchaseexceldetails.gst  from purchaseexceldetails inner join supplier on purchaseexceldetails.suppliername=supplier.supplier_id  where   purchaseexceldetails.purchaseexceldetails_id=? and supplier.office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getchilddetails($var_array)
	  {
	      $sql = "select purchaseexceldetails.taxtype,purchaseexceldetails.gst,purchaseexceldetails.qty,purchaseexceldetails.cp,purchaseexceldetails.mrp,purchaseexceldetails.sp,purchaseexceldetails.frametype_id,purchaseexceldetails.framecolour_id,purchaseexceldetails.framesize_id,purchaseexceldetails.framemodel_id,purchaseexceldetails.multype,item_master.code,item_master.name,item_master.item_id,tax_master.name as taxval   from purchaseexceldetails inner join item_master  on  purchaseexceldetails.itemname=item_master.item_id left join tax_master on item_master.tax=tax_master.tax_id  where   purchaseexceldetails.purchaseexceldetails_id in ($var_array)";
	      $result_row=$this->db->query($sql); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function deletedata($id) 
        {
            $this->db->trans_begin();
            $sql="delete from purchaseexceldetails where purchaseexceldetails_id in ($id)";
            $result_row=$this->db->query($sql); 
           if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
                    return FALSE;
            }
            else
            {
                    $this->db->trans_commit();
                    return TRUE;
            }
        }

}
