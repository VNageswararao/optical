<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @22/01/2021
 */
class Stock_transfer_report_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  public function Get_register_Data($det_fromdate,$det_todate,$det_item,$officeid)
  {
    
    $detitem='';
    if($det_item)
    {
      $detitem= ' and stock_transfer_details.item_id='.$det_item;
    }
    
     $sql = "select stock.frame_type,stock.frame_color,stock.frame_model,stock.frame_size,stock_transfer_details.amount,stock.quantity as stockqty,item_master.name as item_name,action,stock.mrp,stock.selling_price,stock_transfer_details.quantity from stock_transfer_details inner join item_master on stock_transfer_details.item_id=item_master.item_id inner join stock on stock.stock_id=stock_transfer_details.stock_id where    stock_transfer_id in (select stock_transfer_id from stock_transfer where transfer_date >= '$det_fromdate' AND transfer_date <= '$det_todate' ) $detitem";
        $result_row=$this->db->query($sql); 
        $res= $result_row->result_array ();
       // echo $this->db->last_query();exit;
        $this->logger->save($this->db);
        return $res;
  }
}