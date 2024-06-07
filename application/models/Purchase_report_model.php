<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @11/01/2021
 */
class Purchase_report_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	 public function getsummaryreportmodel($sum_fromdate,$sum_todate,$sum_supplier,$sum_modeofpay,$officeid)
	{
		$sup='';
		if($sum_supplier)
		{
			$sup= ' and purchase.supplier_id='.$sum_supplier;
		}
		$mode='';
		if($sum_modeofpay)
		{
			$mode= ' and purchase.modeofpay_id='.$sum_modeofpay;
		}
		$sql = "select supplier.name as supname,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date,invoice_no,user.username username,modeofpay.name as mode,total_amount,total_qty from purchase inner join supplier on purchase.supplier_id=supplier.supplier_id inner join modeofpay on modeofpay.modeofpay_id=purchase.modeofpay_id inner join user on user.user_id=purchase.login_id where purchase_date >= '$sum_fromdate' AND purchase_date <= '$sum_todate' and purchase.office_id=$officeid  $sup  $mode";
	    $result_row=$this->db->query($sql); 
		$res= $result_row->result_array ();
		return $res;
	}

	public function getdetailedreportmodel($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$officeid,$det_item)
	{
		$sup='';
		if($det_supplier)
		{
			$sup= ' and purchase.supplier_id='.$det_supplier;
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
		$sql = "select purchase_details.quantity,purchase_details.free,purchase_details.cost_price,purchase_details.mrp,purchase_details.tot_amount,purchase_details.mul_type,purchase_details.frametype,purchase_details.framecolor,purchase_details.framesize,purchase_details.framemodel,item_master.name as itemname,item_master.code as itemcode,supplier.name as supname,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date,invoice_no,user.username username,modeofpay.name as mode,total_amount,total_qty from purchase inner join purchase_details on purchase.purchase_id=purchase_details.purchase_id inner join item_master on  purchase_details.item_id=item_master.item_id inner join supplier on purchase.supplier_id=supplier.supplier_id inner join modeofpay on modeofpay.modeofpay_id=purchase.modeofpay_id inner join user on user.user_id=purchase.login_id where purchase_date >= '$det_fromdate' AND purchase_date <= '$det_todate' and purchase.office_id=$officeid  $sup  $mode  $detitem";
	    $result_row=$this->db->query($sql); 
		$res= $result_row->result_array ();
		return $res;
	}
	 public function getCountPayment($sales_id,$period)
  {
    $datecon=date('Y-m-d');
     $sql = "SELECT DATEDIFF('$datecon', purchase_date)  AS SubscriptionDueDate
    FROM purchase_details inner join purchase on purchase.purchase_id=purchase_details.purchase_id  WHERE purchase_details_id=$sales_id ";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }


		public function getdetailedreportmodel1($det_fromdate,$det_todate,$det_supplier,$det_modeofpay,$officeid,$det_item)
	{
		$sup='';
		if($det_supplier)
		{
			$sup= ' and purchase.supplier_id='.$det_supplier;
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
		$sql = "select stock.quantity,purchase_details_id,purchase_details.quantity,purchase_details.free,purchase_details.cost_price,purchase_details.mrp,purchase_details.tot_amount,purchase_details.mul_type,purchase_details.frametype,purchase_details.framecolor,purchase_details.framesize,purchase_details.framemodel,item_master.name as itemname,item_master.code as itemcode,supplier.name as supname,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date,invoice_no,user.username username,modeofpay.name as mode,total_amount,total_qty from purchase inner join purchase_details on purchase.purchase_id=purchase_details.purchase_id inner join item_master on  purchase_details.item_id=item_master.item_id inner join supplier on purchase.supplier_id=supplier.supplier_id inner join modeofpay on modeofpay.modeofpay_id=purchase.modeofpay_id inner join user on user.user_id=purchase.login_id inner join stock on purchase_details.item_id=stock.item_id and purchase_details.mrp=stock.mrp and purchase_details.selling_price=stock.selling_price  and stock.created_date=purchase_details.created_date where stock.quantity>0 and purchase_date >= '$det_fromdate' AND purchase_date <= '$det_todate' and purchase.office_id=$officeid  $sup  $mode  $detitem";
	    $result_row=$this->db->query($sql); 
		$res= $result_row->result_array ();
		return $res;
	}
	
}