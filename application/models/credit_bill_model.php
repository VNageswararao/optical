<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @29/10/2022
 */
class Credit_bill_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
   public function getmodemodel($office_id)
  {
      $sql = "select name,modeofpay_id from modeofpay where office_id=$office_id and status=1 and name!='M PAYMENT'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
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
    $sql = "select cash,card,paytm,others,supplier.name as supname,staff.name as staffname,if(sales_master.status=1,'Inprogress','Delivered') as status,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode,netamount,total_qty,sales_master.discount_amount,sales_master.sales_id from sales_master  inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id inner join user on user.user_id=sales_master.login_id left join staff on sales_master.staff_id=staff.staff_id left join supplier on supplier.supplier_id=sales_master.supplier_id where  sales_master.office_id=$officeid  $cus  $mode  $staffcond  $stacond $dte $sup ";
      $result_row=$this->db->query($sql); 
    //  echo $this->db->last_query();exit;
    $res= $result_row->result_array ();
    return $res;
  }

  public function getdetailedreportmodel($det_fromdate,$det_todate,$det_customer,$det_modeofpay,$officeid,$det_item,$det_lens)
  {
    $cus='';
    if($det_customer)
    {
      $cus= ' and sales_master.customer_id='.$det_customer;
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
  
    $sql = "select sales_details.quantity,sales_details.rate,sales_details.total_amount,sales_details.product_type,sales_details.stock_id,stock.batchno,DATE_FORMAT(stock.expirydate,'%m/%Y') AS expirydate,item_master.name as itemname,item_master.code as itemcode,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode from sales_master inner join sales_details on sales_master.sales_id=sales_details.sales_id inner join stock on sales_details.stock_id=stock.stock_id inner join item_master on  sales_details.item_id=item_master.item_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id inner join user on user.user_id=sales_master.login_id where sales_date >= '$det_fromdate' AND sales_date <= '$det_todate' and sales_master.office_id=$officeid  $cus  $mode  $detitem  $detlens";
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