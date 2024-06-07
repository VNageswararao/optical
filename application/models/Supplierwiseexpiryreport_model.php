<?php
/**
 * Description of Supplierwiseexpiryreport_model
 *
 * @author Prabhu @08/01/2022
 */
class Supplierwiseexpiryreport_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  public function getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$officeid,$staff,$status,$supplier_id)
  {
    $sup='';
    if($supplier_id)
    {
      $sup= ' and sales_master.supplier_id='.$supplier_id;
    }
    $cus='';
    if($sum_customer)
    {
      $cus= ' and sales_master.customer_id='.$sum_customer;
    }
    $mode='';
    if($sum_modeofpay)
    {
      $mode= ' and sales_master.modeofpay_id='.$sum_modeofpay;
    }
$staffcond='';
     if($staff)
    {
      $staffcond= ' and  staff.staff_id='.$staff;
    }
$stacond='';
     if($status)
    {
      $stacond= ' and sales_master.status='.$status;
    }
    $dte=" and sales_date >= '$sum_fromdate' AND sales_date <= '$sum_todate'";
      if($status==2)
      {
        $dte= " and payment_details.payment_date>= '$sum_fromdate' AND payment_details.payment_date <='$sum_todate'";
      }
    $sql = "select supplier.name as supname,staff.name as staffname,if(sales_master.status=1,'Inprogress','Delivered') as status,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode,netamount,total_qty,sales_master.discount_amount,sales_master.sales_id from sales_master  inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id inner join user on user.user_id=sales_master.login_id left join staff on sales_master.staff_id=staff.staff_id left join supplier on supplier.supplier_id=sales_master.supplier_id where  sales_master.office_id=$officeid  $cus  $mode  $staffcond  $stacond $dte $sup ";
      $result_row=$this->db->query($sql); 
    //  echo $this->db->last_query();exit;
    $res= $result_row->result_array ();
    return $res;
  }

  public function getallsuppliermdl($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$det_item,$officeid)
  {
    $cus='';
    if($det_supplier)
    {
      $cus= ' and supplier.supplier_id='.$det_supplier;
    }
    $mode='';
    if($det_modeofpay)
    {
      $mode= ' and sales_master.modeofpay_id='.$det_modeofpay;
    }
    $detitem='';
    if($det_item)
    {
      $detitem= ' and sales_details.item_id='.$det_item;
    }
    $detlens='';
  $det=' where 1=1 ';
    $sql = "select supplier.name as  suppliername,supplier_id from supplier $det $cus";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function getsupplierdetailsmdl($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$det_item,$officeid)
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
   $dte=" where  purchase_date >= '$det_fromdate' AND purchase_date <= '$det_todate'";
     $sql = "select DATEDIFF(purchase_details.expirydate, CURDATE())
         AS days,purchase_details.item_id,item_master.name as itemname,purchase_details.mrp,purchase_details.selling_price,expirydate as expdate,batchno,DATE_FORMAT(expirydate,'%m/%Y') AS expirydate,supplier.name as supname,sum(purchase_details.quantity)  as purqty,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date,invoice_no from purchase_details inner join item_master on purchase_details.item_id=item_master.item_id inner join purchase on purchase.purchase_id=purchase_details.purchase_id inner join supplier on supplier.supplier_id=purchase.supplier_id $dte  $cus  $mode $detitem group by purchase.supplier_id,purchase_details.batchno,purchase_details.expirydate   order by supplier.name ASC";
    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function salesdetails($det_fromdate,$det_todate,$item_id,$batch,$exp,$mrp,$sel,$officeid)
  {
    $detlens='';
    $dte=" where  sales_date >= '$det_fromdate' AND sales_date <= '$det_todate'";
     $sql = "select sum(sales_details.quantity) as salesqty from sales_details inner join stock on sales_details.stock_id=stock.stock_id where 
     sales_id in (select sales_id from sales_master where  sales_date >= '$det_fromdate' AND sales_date <= '$det_todate') and sales_details.item_id='$item_id' and stock.mrp='$mrp' and stock.selling_price='$sel' and stock.batchno='$batch' and stock.expirydate='$exp' group by stock.batchno,stock.expirydate";
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