<?php
/**
 * Description of Supplierwiseexpiryreport_model
 *
 * @author Prabhu @09/01/2022
 */
class Product_history_report_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
 
  public function getalldetailsreport($det_fromdate,$det_todate,$det_item,$officeid)
  {
    $cus='';
    $detitem='';
    if($det_item)
    {
      $detitem= ' and sales_details.item_id='.$det_item;
    }
    $detlens='';
    $det=' where 1=1 ';
    $sql = "select item_master.name as itemname,purchase_details.item_id,mrp,expirydate as expdate,DATE_FORMAT(expirydate,'%m/%Y') AS expirydate,batchno,selling_price,sum(quantity) as quantity from item_master inner join purchase_details on item_master.item_id=purchase_details.item_id where purchase_details.item_id=$det_item group by batchno,expirydate,purchase_details.item_id";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function getsupplierdetailsmdl($det_supplier,$det_modeofpay,$det_item,$officeid)
  {
    $cus='';
    if($det_supplier)
    {
      $cus= ' and purchase.supplier_id='.$det_supplier;
    }
    $mode='';
    if($det_modeofpay)
    {
      $mode= ' and purchase.modeofpay_id='.$det_modeofpay;
    }
    $detitem='';
    if($det_item)
    {
      $detitem= ' and purchase_details.item_id='.$det_item;
    }
    $detlens='';
  // $dte=" where  purchase_date >= '$det_fromdate' AND purchase_date <= '$det_todate'";
     $sql = "select DATEDIFF(purchase_details.expirydate, CURDATE())
         AS days,purchase_details.item_id,item_master.name as itemname,purchase_details.mrp,purchase_details.selling_price,expirydate as expdate,batchno,DATE_FORMAT(expirydate,'%m/%Y') AS expirydate,supplier.name as supname,sum(purchase_details.quantity)  as purqty,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date,invoice_no from purchase_details inner join item_master on purchase_details.item_id=item_master.item_id inner join purchase on purchase.purchase_id=purchase_details.purchase_id inner join supplier on supplier.supplier_id=purchase.supplier_id   $cus  $mode $detitem group by purchase.supplier_id,purchase_details.batchno,purchase_details.expirydate   order by supplier.name ASC";
    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function salesdetails($item_id,$batch,$exp,$mrp,$sel,$officeid)
  {
    $detlens='';
   // $dte=" where  sales_date >= '$det_fromdate' AND sales_date <= '$det_todate'";
     $sql = "select sum(sales_details.quantity) as salesqty from sales_details inner join stock on sales_details.stock_id=stock.stock_id where 
       sales_details.item_id='$item_id' and stock.mrp='$mrp' and stock.selling_price='$sel' and stock.batchno='$batch' and stock.expirydate='$exp' group by stock.batchno,stock.expirydate";
    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function salesretdetails($item_id,$batch,$exp,$mrp,$sel,$officeid)
  {
    $detlens='';
   // $dte=" where  sales_date >= '$det_fromdate' AND sales_date <= '$det_todate'";
      $sql = "select sum(sales_return_details.quantity) as salesretqty from sales_return_details inner join stock on sales_return_details.stock_id=stock.stock_id and sales_return_details.item_id=stock.item_id where 
       sales_return_details.item_id='$item_id' and stock.mrp='$mrp' and stock.selling_price='$sel' and stock.batchno='$batch' and stock.expirydate='$exp' group by stock.batchno,stock.expirydate";

    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function stockadj($item_id,$batch,$exp,$mrp,$sel,$flag,$officeid)
  {
    $detlens='';
   // $dte=" where  sales_date >= '$det_fromdate' AND sales_date <= '$det_todate'";
     $sql = "select sum(stock_adjustment_details.quantity) as stkadjqty from stock_adjustment_details inner join stock on stock_adjustment_details.stock_id=stock.stock_id where action=$flag and 
       stock_adjustment_details.item_id='$item_id' and stock.mrp='$mrp' and stock.selling_price='$sel' and stock.batchno='$batch' and stock.expirydate='$exp' group by stock.batchno,stock.expirydate";
    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

   public function getmondetailedreportmodel($det_fromdate,$det_todate,$det_item,$officeid)
  {
    $cus='';
    
    $detitem='';
    if($det_item)
    {
      $detitem= ' and sales_details.item_id='.$det_item;
    }
    $detlens='';
  
    $sql = "select sum(sales_details.quantity) as quantity,sales_details.rate,sales_details.stock_id,stock.batchno,DATE_FORMAT(stock.expirydate,'%m/%Y') AS expirydate,item_master.name as itemname,item_master.code as itemcode from  sales_details  inner join stock on sales_details.stock_id=stock.stock_id inner join item_master on  sales_details.item_id=item_master.item_id  where sales_id in (select sales_id from sales_master  where sales_date >= '$det_fromdate' AND sales_date <= '$det_todate' and sales_master.office_id=$officeid)       $detitem group by stock.batchno,stock.expirydate,stock.item_id,stock.selling_price";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function getcollectionreportmodel($det_fromdate,$det_todate,$officeid)
  {
  
    $sql = "select MIN(bill_number) AS from_invoice_no,MAX(bill_number) AS to_invoice_no,sales_date as sdate,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,sum(netamount) as total from sales_master  where sales_date >= '$det_fromdate' AND sales_date <= '$det_todate' and sales_master.office_id=$officeid group by sales_date";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
  public function getmodeamount($mode,$date)
  {
  
    $sql = "select sum(netamount) as modeamount from sales_master  where sales_date = '$date' and modeofpay_id=$mode";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
 

}