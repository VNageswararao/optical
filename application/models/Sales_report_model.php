<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @14/01/2021
 */
class Sales_report_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  public function getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$officeid,$staff,$status,$supplier_id,$emid='')
  {
    //echo $emid;exit;
    $sup='';
    $emrr='';
    
    if($emid==0)
    {
      
      $emrr= ' and sales_master.emergency_order='.$emid;
    }
    if($emid==1)
    {
      $emrr= ' and sales_master.emergency_order='.$emid;
    }
    if($emid=='')
    {
      $emrr='';
    }
   // echo $emid;exit;
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
    $dte=" and payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate'";
      if($status==2)
      {
        $dte= " and payment_details.payment_date>= '$sum_fromdate' AND payment_details.payment_date <='$sum_todate'";
      }
    $sql = "select sales_master.description,payment_details.mode_id,payment_details.cash,payment_details.card,payment_details.paytm,payment_details.others,sales_master.advanced_amount,supplier.name as supname,staff.name as staffname,if(sales_master.status=1,'Inprogress','Delivered') as status,sales_master.status as sts,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode,netamount,total_qty,sales_master.discount_amount,sales_master.sales_id from sales_master inner join payment_details on sales_master.sales_id=payment_details.sales_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id inner join user on user.user_id=sales_master.login_id left join staff on sales_master.staff_id=staff.staff_id left join supplier on supplier.supplier_id=sales_master.supplier_id where  sales_master.office_id=$officeid  $cus  $mode  $staffcond  $stacond $dte $sup  $emrr  group by payment_details.sales_id";
      $result_row=$this->db->query($sql); 
    //  echo $this->db->last_query();exit;
    $res= $result_row->result_array ();
    return $res;
  }

  public function getsummaryreportmodell($sum_fromdate,$sum_todate,$sum_customer,$sum_modeofpay,$officeid,$staff,$status,$supplier_id)
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
    $dte=" and payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate'";
      if($status==2)
      {
        $dte= " and payment_details.payment_date>= '$sum_fromdate' AND payment_details.payment_date <='$sum_todate'";
      }
    $sql = "select sales_date as sdate,sales_master.advanced_amount,supplier.name as supname,staff.name as staffname,if(sales_master.status=1,'Inprogress','Delivered') as status,sales_master.status as sts,customer.name as cusname,DATE_FORMAT(payment_date,'%d/%m/%Y') AS sales_date,payment_date,invoice_number,user.username username,modeofpay.name as mode,netamount,total_qty,sales_master.discount_amount,sales_master.sales_id from sales_master inner join payment_details on sales_master.sales_id=payment_details.sales_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id inner join user on user.user_id=sales_master.login_id left join staff on sales_master.staff_id=staff.staff_id left join supplier on supplier.supplier_id=sales_master.supplier_id where  sales_master.office_id=$officeid  $cus  $mode  $staffcond  $stacond $dte $sup  group by payment_details.sales_id";
      $result_row=$this->db->query($sql); 
    //  echo $this->db->last_query();exit;
    $res= $result_row->result_array ();
    return $res;
  }

  public function getdetailedreportmodel($det_fromdate,$det_todate,$det_customer,$det_modeofpay,$officeid,$det_item,$det_lens,$det_category='')
  {
    $cus=$detcat='';
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
      $detitem= ' and product_type=0 and stock.item_id='.$det_item;
    }
    $detlens='';
    if($det_lens)
    {
      $detlens= '   and product_type=1 and sales_details.stock_id in (select lens_master_id from lens_master where lens_master_id='.$det_lens.')';
    }
    //echo $det_category;exit;
    if($det_category)
    {
      $detcat= " and product_type=$det_category";
    }
    if($det_category==2)
    {
      $detcat= ' and product_type=0';
    }
    $sql = "select sales_details.item_id,stock.selling_price,stock.mrp,sales_details.quantity,sales_details.rate,sales_details.total_amount,supplier.name as supname,sales_details.product_type,sales_details.stock_id,stock.frame_type,stock.frame_color,stock.frame_model,stock.frame_size,item_master.name as itemname,item_master.code as itemcode,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode from sales_master inner join sales_details on sales_master.sales_id=sales_details.sales_id inner join stock on sales_details.stock_id=stock.stock_id inner join item_master on  sales_details.item_id=item_master.item_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id left join supplier on supplier.supplier_id=sales_master.supplier_id inner join user on user.user_id=sales_master.login_id where sales_date >= '$det_fromdate' AND sales_date <= '$det_todate' and sales_master.office_id=$officeid  $cus  $mode  $detitem  $detlens $detcat";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

   public function getlensreportmodel($det_fromdate,$det_todate,$det_customer,$det_modeofpay,$officeid,$det_item,$det_lens)
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
    if($det_lens)
    {
      $detlens= '   and sales_details.stock_id in (select lens_master_id from lens_master where lens_master_id='.$det_lens.')';
    }
    $sql = "select sales_details.quantity,sales_details.rate,sales_details.total_amount,sales_details.product_type,sales_details.stock_id,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,supplier.name as supname,invoice_number,user.username username,modeofpay.name as mode from sales_master inner join sales_details on sales_master.sales_id=sales_details.sales_id inner join stock on sales_details.stock_id=stock.stock_id  inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id left join supplier on supplier.supplier_id=sales_master.supplier_id inner join user on user.user_id=sales_master.login_id where sales_date >= '$det_fromdate' AND sales_date <= '$det_todate'  and product_type=1 and sales_master.office_id=$officeid  $cus  $mode  $detitem  $detlens";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

   public function getincomemdl($sum_fromdate,$sum_todate,$officeid)
  {
      $sql = "select sales_id,payment_details.mode_id,cash,card,sum(advanced_amount) as adamount,net_amount,DATE_FORMAT(payment_date,'%d/%m/%Y') AS payment_date,modeofpay.name as  mode from payment_details inner join modeofpay on modeofpay.modeofpay_id=payment_details.mode_id where payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate' and payment_details.office_id='$officeid' group by payment_details.sales_id";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getincomemdl_counter($sum_fromdate,$sum_todate,$officeid)
  {
      $sql = "select invoice_number,counter_sales_id,netamount,DATE_FORMAT(sales_date,'%d/%m/%Y') AS payment_date,modeofpay.name as  mode,customer.name as cusname from counter_sales_master inner join customer on counter_sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=counter_sales_master.modeofpay_id where sales_date >= '$sum_fromdate' AND sales_date <= '$sum_todate' and counter_sales_master.office_id='$officeid'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function Get_Purchasedetails_price_Details($item_id,$selling_price,$mrp,$framemodel)
  {
      $sql = "select cost_price from purchase_details where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and framemodel='$framemodel'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }


public function getadamt($salesid)
  {
      $sql = "select sum(advanced_amount) as adamount from payment_details where sales_id=$salesid";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getpaidamt($salesid,$sum_fromdate,$sum_todate)
  {
      $sql = "select sum(advanced_amount) as paidamount from payment_details where sales_id=$salesid and payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getsalesdetails($sales_id)
  {
      $sql = "select customer.name as cusname,invoice_number,sales_master.status from  sales_master inner join customer on sales_master.customer_id=customer.customer_id  where sales_id=$sales_id ";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getmodedata($sum_fromdate,$sum_todate,$sales_id)
  {
      $sql = "select modeofpay.name,advanced_amount,cash,card from payment_details inner join modeofpay on modeofpay.modeofpay_id=payment_details.mode_id where payment_date >= '$sum_fromdate' AND payment_date <= '$sum_todate' and sales_id='$sales_id'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getcountofpayment($sales_id)
  {
      $sql = "select count(*) as CNT from payment_details where sales_id=$sales_id";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

  public function getcountofpaymentt($sales_id)
  {
      $sql = "select modeofpay.name from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id where sales_id=$sales_id order by payment_id DESC limit 1";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function getmodemodel($office_id)
  {
      $sql = "select name,modeofpay_id from modeofpay where office_id=$office_id and status=1 and name!='M PAYMENT'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getdelpayment($sales_id)
  {
      $sql = "select advanced_amount from payment_details where sales_id=$sales_id and sales_id  in (select sales_id from sales_master where status=2) order by payment_id DESC limit 1";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }

    public function getdelpaymentt($sales_id,$pa)
  {
      $sql = "select advanced_amount from payment_details where  sales_id=$sales_id and payment_date='$pa' and sales_id  in (select sales_id from sales_master where status=2) order by payment_id DESC limit 1";
    
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
 

}