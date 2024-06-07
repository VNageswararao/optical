<?php
/**
 * Description of customer_model
 *
 * @author Prabhu @23/12/2020
 */
class Item_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}
  public function getcategory($var_array)
  {
    $sql = "select * from classification where    office_id= ? and status=1 and type=1";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
  public function getbrand($var_array)
  {
    $sql = "select * from classification where    office_id= ? and status=1 and type=2";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
   public function gethsncode($var_array)
  {
	$sql = "select * from hsn_master where    office_id= ? and status=1";
	$result_row = $this->db->query($sql, $var_array);
	$res = $result_row->result_array();
	$this->logger->save($this->db);
	return $res;
  }
   public function gethsncode1($var_array)
  {
    $sql = "select count(*) as cnt from hsn_master where   hsn_master_id=? and office_id= ?";
    $result_row = $this->db->query($sql, $var_array);
    $res = $result_row->result_array();
    $this->logger->save($this->db);
    return $res;
  }
   public function gethsncodedata($var_array)
  {
    $sql = "select * from hsn_master where    hsn_master_id=? and  office_id= ?";
    $result_row = $this->db->query($sql, $var_array);
    $res = $result_row->result_array();
    return $res;
  }
  public function getcompany($var_array)
  {
    $sql = "select * from company where    office_id= ? and status=1";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
  public function gettax($var_array)
  {
    $sql = "select * from tax_master where    office_id= ? and status=1";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
    public function checkitem($var_array)
	{
		$sql = "select count(*) as cnt from item_master where   code = ? or  (name = ? ) and office_id= ?";
	  $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
  public function gettaxid($var_array)
  {
    $sql = "select count(*) as cnt from tax_master where   tax_id=? and office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
	public function editcheckitem_master($var_array)
	{
		$sql = "select count(*) as cnt from item_master where    item_id!=? and    code = ?  and   name = ?   and office_id= ?";
	  $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
  public function GetData($var_array)
  {
    $sql = "select * from item_master where    item_id=? and  office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    return $res;
  }
  public function gettaxdata($var_array)
  {
    $sql = "select * from tax_master where    tax_id=? and  office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    return $res;
  }
	public function deletecheckitem($var_array)
	{
		$sql = "select count(*) as cnt from item_master where item_id=?  and office_id= ?";
	   $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
	public function savedata($data)
    {
        if($this->db->insert('item_master',$data))
        {
             $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('item_id', $id);
        if($this->db->update('item_master'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
        $this->db->where('item_id', $id);
        if($this->db->delete('item_master'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }

       function ajax_call($requestData)
  {
  
    
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'item_id'
      
     
    );
 
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('item_master');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT item_id,code,name,hsn_code,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM item_master where office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( code LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR name LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR hsn_code LIKE '".$requestData['search']['value']."%') ";
        $isFilterApply=1;
      }
 
 
      $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."  desc     LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
      $result1 = $this->db->query($sql);
      
      if($isFilterApply==1){
        $totalFiltered =  $result1->num_rows(); 
      }

       // when there is a search parameter then we have to modify total number filtered rows as per search result.
      $row=$result1->result_array();

      for ($i=0; $i < count($row); $i++) {
			$item_id=$row[$i]['item_id'];
			$code=$row[$i]['code'];
			$name=$row[$i]['name'];
			$hsn_code=$row[$i]['hsn_code'];
			$status=$row[$i]['status'];

	     $edit="<button type='button'  onclick=\"edititem('$item_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deleteitem_master('.$item_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


          if(($this->auth->lock_up('sales_details',"item_id='$item_id' and product_type=0"))  || ($this->auth->lock_up('stock',"item_id='$item_id'")))
          {
              $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
            //  $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
          }

     
        $row[$i]['slno']=$i+1;
        $row[$i]['edit']=$edit;
        $row[$i]['delete']=$delete;
        
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