<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @11/01/2021
 */
class Purchase_return_report_model extends CI_Model{
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
		$sql = "select supplier.name as supname,purchase.invoice_no,DATE_FORMAT(purchase_return_date,'%d/%m/%Y') AS purchase_return_date,user.username username,modeofpay.name as mode,purchase_return.total_amount,purchase_return.total_qty from purchase_return 
		inner join modeofpay on modeofpay.modeofpay_id=purchase_return.modeofpay_id 
		inner join purchase on purchase_return.purchase_id = purchase.purchase_id
		inner join supplier on purchase.supplier_id=supplier.supplier_id
		inner join user on user.user_id=purchase_return.login_id 
		where purchase_return_date >= '$sum_fromdate' AND purchase_return_date <= '$sum_todate' and purchase_return.office_id=$officeid $sup  $mode";
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
			$mode= ' and purchase_return.modeofpay_id='.$det_modeofpay;
		}
		$detitem='';
		if($det_item)
		{
			$detitem= ' and purchase_return_details.item_id='.$det_item;
		}
				$sql = "select purchase_return_details.tax_val,purchase_return_details.ret_quantity,purchase_return_details.free,
			purchase_return_details.cost_price,purchase_return_details.mrp,
			purchase_return_details.tot_amount,
			item_master.name as itemname,item_master.code as itemcode,supplier.name as supname,
			DATE_FORMAT(purchase_return.purchase_return_date,'%d/%m/%Y') AS purchase_return_date,
			invoice_no,user.username username,modeofpay.name as mode,purchase_return.total_amount,purchase_return.total_qty from purchase_return_details
			inner join purchase_return on purchase_return.purchase_return_id=purchase_return_details.purchase_return_id 
			inner join item_master on purchase_return_details.item_id=item_master.item_id 
			INNER join purchase on purchase_return.purchase_id=purchase.purchase_id
			inner join supplier on purchase.supplier_id=supplier.supplier_id
			inner join modeofpay on modeofpay.modeofpay_id=purchase_return.modeofpay_id 
			inner join user on user.user_id=purchase_return.login_id
			where purchase_return_date  between  '$det_fromdate' and '$det_todate' 
			$detitem  $sup $mode
			and purchase_return.office_id=$officeid ";
	    $result_row=$this->db->query($sql); 
		$res= $result_row->result_array ();
		return $res;
	}
	
}