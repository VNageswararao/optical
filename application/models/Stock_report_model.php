<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @22/01/2021
 */
class Stock_report_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  public function getsummaryreportmodel($itemname,$category_id,$officeid)
  {
    $stockzeronot=' and quantity>0';
    $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    if($host_tvm=='arul')
    {
      $stockzeronot=' and quantity>0';
    }
    $ite='';
    $cat='';
    if($itemname)
    {
      $ite= ' and item_master.item_id='.$itemname;
    }
    if($category_id)
    {
      $cat= ' and item_master.category_id='.$category_id;
    }
   
    $sql = "select item_master.item_id,item_master.name as name,sum(quantity) as stock,stock.mrp from stock left join item_master on item_master.item_id=stock.item_id where item_master.office_id=$officeid ".$stockzeronot."  ".$ite."  ".$cat." group by  item_master.item_id,stock.mrp order by item_master.name ASC";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
  public function Get_stockdetails($frmdate,$todate)
  {
     $sql = "select c.name as  cusname,d.name as supname,b.invoice_number,a.adjustment_date,a.number from lens_stock_adjustment a  inner join sales_master b on a.sales_id=b.sales_id inner join customer c on b.customer_id=c.customer_id left join supplier d on d.supplier_id=b.supplier_id where a.adjustment_date between  '$frmdate' and '$todate'";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
  public function Get_stockdetails1($frmdate,$todate)
  {
     $sql = "select g.rate,if(e.action=1,'Add','Minus') as action,e.quantity,f.name as lensname,c.name as  cusname,d.name as supname,b.invoice_number,a.adjustment_date,a.number from lens_stock_adjustment a  inner join sales_master b on a.sales_id=b.sales_id inner join customer c on b.customer_id=c.customer_id left join supplier d on d.supplier_id=b.supplier_id inner join lens_stock_adjustment_details e on e.lens_stock_adjustment_id=a.lens_stock_adjustment_id inner join lens_master f on f.lens_master_id=e.item_id
      inner join sales_details g on b.sales_id=g.sales_id
       where a.adjustment_date between  '$frmdate' and '$todate'";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

   public function getsummaryreportmodel_lens($itemname,$category_id,$officeid)
  {
    $stockzeronot='';
    $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    if($host_tvm=='arul')
    {
      $stockzeronot=' and quantity>0';
    }
    $ite='';
    $cat='';
    if($itemname)
    {
      $ite= ' and lens_master.lens_master_id='.$itemname;
    }
    if($category_id)
    {
      $cat= ' and lens_master.category_id='.$category_id;
    }
   
    $sql = "select lens_master.lens_master_id as item_id,lens_master.name as name,sum(quantity) as stock,lens_stock.mrp,lens_stock.cp from lens_master left join lens_stock on lens_master.lens_master_id=lens_stock.item_id where lens_master.office_id=$officeid ".$stockzeronot."  ".$ite."  ".$cat." group by  lens_master.lens_master_id,lens_stock.mrp order by lens_master.name ASC";
      $result_row=$this->db->query($sql); 
     // echo $this->db->last_query();exit();
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
    if($det_lens)
    {
      $detlens= '   and product_type=1 and sales_details.stock_id in (select lens_master_id from lens_master where lens_master_id='.$det_lens.')';
    }
    $sql = "select sales_details.quantity,sales_details.rate,sales_details.total_amount,sales_details.product_type,sales_details.stock_id,stock.frame_type,stock.frame_color,stock.frame_model,stock.frame_size,item_master.name as itemname,item_master.code as itemcode,customer.name as cusname,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,user.username username,modeofpay.name as mode from sales_master inner join sales_details on sales_master.sales_id=sales_details.sales_id inner join stock on sales_details.stock_id=stock.stock_id inner join item_master on  sales_details.item_id=item_master.item_id inner join customer on sales_master.customer_id=customer.customer_id inner join modeofpay on modeofpay.modeofpay_id=sales_master.modeofpay_id inner join user on user.user_id=sales_master.login_id where sales_date >= '$det_fromdate' AND sales_date <= '$det_todate' and sales_master.office_id=$officeid  $cus  $mode  $detitem  $detlens";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
  public function Get_Stock_Reg($det_fromdate,$det_todate,$det_item,$officeid)
  {
    $detitem='';
    if($det_item)
    {
      $detitem= ' and sales_details.item_id='.$det_item;
    }
    
   
    $sql = "select sales_details.quantity,item_master.name as framename,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,frame_model from sales_master inner join sales_details on sales_master.sales_id=sales_details.sales_id inner join stock on sales_details.item_id=stock.item_id and sales_details.stock_id=stock.stock_id inner join item_master on item_master.item_id=sales_details.item_id where sales_master.sales_date >= '$det_fromdate' AND sales_master.sales_date <= '$det_todate' and product_type=0  $detitem";

      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }

   public function getcolrepmdl($item_id,$mrp)
  {
    
    $sql = "select cost_price from purchase_details where item_id=$item_id and mrp='$mrp' order by purchase_details_id desc";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
 
   public function getcolrepmdl_dd($item_id,$mrp)
  {
    
    $sql = "select cost_price,mrp from purchase_details where item_id=$item_id  order by purchase_details_id desc";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
  public function getstockregistermodel($det_fromdate,$det_todate,$officeid,$det_item)
  {
    
    $detitem='';
    if($det_item>0)
    {
      $detitem= ' and stock.item_id='.$det_item;
    }
    $sql = "select stock.item_id,item_master.name,sum(stock.quantity) as total_stock,stock.mrp
                                  from stock
                                  inner join item_master on stock.item_id=item_master.item_id
                                  where stock.office_id='$officeid' $detitem
                                  group by stock.item_id";
      $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
 
}