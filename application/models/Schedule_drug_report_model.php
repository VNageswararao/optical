<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @26/08/2021
 */
class Schedule_drug_report_model extends CI_Model{
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

  public function getdetailedreportmodel($sum_fromdate,$sum_todate,$det_item,$schedule_drug,$officeid)
  {
    $detitem='';
    if($det_item)
    {
      $detitem= ' and sales_details.item_id='.$det_item;
    }
    $detlens='';
  
    $sql = "select stock.expirydate as expirydaterr,sales_details.item_id,sales_details.quantity,staff.name as docname,sales_details.rate,sales_details.total_amount,sales_details.product_type,sales_details.stock_id,stock.batchno,DATE_FORMAT(stock.expirydate,'%m/%Y') AS expirydate,item_master.name as itemname,item_master.code as itemcode,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode from sales_master inner join sales_details on sales_master.sales_id=sales_details.sales_id inner join stock on sales_details.stock_id=stock.stock_id inner join item_master on  sales_details.item_id=item_master.item_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id left join staff on staff.staff_id=sales_master.doctor_id inner join user on user.user_id=sales_master.login_id where sales_date >= '$sum_fromdate' AND sales_date <= '$sum_todate' and sales_master.office_id=$officeid  and schedule_drug_id=$schedule_drug  $detitem ";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

  public function getsuppliernameinitem($batchno,$expirydate,$itemid,$officeid)
  {
   
    $sql = "select company.name as supname from  item_master inner join company on company.company_id=item_master.company_id where  item_id=$itemid";
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