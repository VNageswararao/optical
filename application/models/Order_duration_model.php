<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @14/01/2021
 */
class Order_duration_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }
  
  public function get_four_month_duration($today, $after_3month)
  {
	$office_id=$this->session->office_id;
	
	$sql = "select sales_id,sales_master.status,name,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date,invoice_number,total_qty,netamount from sales_master inner join customer on sales_master.customer_id=customer.customer_id where sales_master.office_id=$office_id and expirydate<='$after_3month' and expirydate>='$today'";
    $result_row = $this->db->query($sql);
	$res = $result_row->result_array();
	return $res;
  }

 function ajax_call($requestData,$page)
  {
   if($page == "Four_month"){
	$today_date = new DateTime('now');
	$today = $today_date->format('Y-m-d');
	$today_date->modify('-4 month'); // or you can use '-90 day' for deduct
	$befoure_month = $today_date->format('Y-m-d');
    $sql = "SELECT sales_id,sales_master.status,customer.name,customer.mobile,customer.address,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount FROM sales_master inner join customer on sales_master.customer_id=customer.customer_id WHERE sales_date >= DATE_SUB('$today', INTERVAL 4 MONTH) AND sales_date < DATE_SUB('$today', INTERVAL 3 MONTH)";
	}
	else if($page == "eight_month"){
	$today_date = new DateTime('now');
	$today = $today_date->format('Y-m-d');
	$today_date->modify('-8 month'); // or you can use '-90 day' for deduct
	$befoure_month = $today_date->format('Y-m-d');
     $sql = "SELECT sales_id,sales_master.status,customer.name,customer.mobile,customer.address,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount FROM sales_master inner join customer on sales_master.customer_id=customer.customer_id WHERE sales_date >= DATE_SUB('$today', INTERVAL 8 MONTH) AND sales_date < DATE_SUB('$today', INTERVAL 7 MONTH)";
	}
	else if($page == "twelve_months"){
	$today_date = new DateTime('now');
	$today = $today_date->format('Y-m-d');
	$today_date->modify('-12 month'); // or you can use '-90 day' for deduct
	$befoure_month = $today_date->format('Y-m-d');
	 $sql = "SELECT sales_id,sales_master.status,customer.name,customer.mobile,customer.address,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount FROM sales_master inner join customer on sales_master.customer_id=customer.customer_id WHERE sales_date >= DATE_SUB('$today', INTERVAL 12 MONTH) AND sales_date < DATE_SUB('$today', INTERVAL 11 MONTH)";
	 
    }
	else{
   $today ="";
   $befoure_month ="";
}
	

    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'sales_id'
    );
	$query = $sql;
    $result = $this->db->query($query);
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  
   
 
    //$sql = "SELECT sales_id,sales_master.status,name,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount";
    //$sql.=" FROM  sales_master inner join customer on sales_master.customer_id=customer.customer_id  where sales_master.office_id=$office_id and sales_master.sales_date>='$befoure_month' and sales_master.sales_date<='$today'";
 // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( sales_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR sales_master.customer_id in (select customer_id from customer  where name  LIKE '".$requestData['search']['value']."%' or mobile  LIKE '".$requestData['search']['value']."%' or mrd  LIKE '".$requestData['search']['value']."%' ) ";
        $sql.="  OR invoice_number LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR netamount LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR total_qty LIKE '".$requestData['search']['value']."%') ";
        $isFilterApply=1;
      }
 
 
      $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."  desc     LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
      $result1 = $this->db->query($sql);
     // die(print_r($this->db->last_query()));
      if($isFilterApply==1){
        $totalFiltered =  $result1->num_rows(); 
      }
// echo $sql;exit;
       // when there is a search parameter then we have to modify total number filtered rows as per search result.
      $row=$result1->result_array();

      for ($i=0; $i < count($row); $i++) {
      $sales_id=$row[$i]['sales_id'];

        $row[$i]['slno']=$i+1;
       
        
      }


      $json_data = array(
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
        "recordsTotal"    => intval( $totalData ),  // total number of records
        "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            =>   $row  // total data array
 
      );

      return $json_data;
 
  }
  
}