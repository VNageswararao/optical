<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @31/01/2021
 */
class Sales_return_report_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  public function getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$officeid)
  {
    $cus='';
    if($sum_customer)
    {
      $cus= ' and sales_master.customer_id='.$sum_customer;
    }
    $mode='';
    if($sum_modeofpay)
    {
      $mode= ' and sales_return.modeofpay_id='.$sum_modeofpay;
    }
    $sql = "select customer.name as cusname,DATE_FORMAT(sales_return_date,'%d/%m/%Y') AS sales_return_date,sales_return.bill_number as invoice_number,user.username username,modeofpay.name as mode,sales_return.total_amount,sales_return.total_qty from sales_return inner join sales_master on sales_return.sales_id=sales_master.sales_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_return.modeofpay_id inner join user on user.user_id=sales_return.login_id where sales_return_date >= '$sum_fromdate' AND sales_return_date <= '$sum_todate' and sales_return.office_id=$officeid  $cus  $mode";
      $result_row=$this->db->query($sql); 
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
      $mode= ' and sales_return.modeofpay_id='.$det_modeofpay;
    }
    $detitem='';
    if($det_item)
    {
      $detitem= ' and sales_return_details.item_id='.$det_item;
    }
    $detlens='';
    if($det_lens)
    {
      $detlens= '   and product_type=1 and sales_return_details.stock_id in (select lens_master_id from lens_master where lens_master_id='.$det_lens.')';
    }
    $sql = "select sales_return_details.quantity,sales_return_details.rate,sales_return_details.total_amount,sales_return_details.product_type,sales_return_details.stock_id,stock.frame_type,stock.frame_color,stock.frame_model,stock.frame_size,item_master.name as itemname,item_master.code as itemcode,customer.name as cusname,DATE_FORMAT(sales_return_date,'%d/%m/%Y') AS sales_return_date,sales_return.bill_number,user.username username,modeofpay.name as mode from sales_return inner join sales_return_details on sales_return.sales_return_id=sales_return_details.sales_return_id inner join sales_master on sales_return.sales_id=sales_master.sales_id inner join stock on sales_return_details.stock_id=stock.stock_id inner join item_master on  sales_return_details.item_id=item_master.item_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_return.modeofpay_id inner join user on user.user_id=sales_return.login_id where sales_return_date >= '$det_fromdate' AND sales_return_date <= '$det_todate' and sales_return.office_id=$officeid  $cus  $mode  $detitem  $detlens";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
 

}