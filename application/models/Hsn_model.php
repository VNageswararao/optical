<?php
/**
 * Description of hsn_master_id_model
 *
 * @author Prabhu @29/06/2021
 */
class Hsn_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	
    public function checkingval($var_array)
	{
		$sql = "select count(*) as cnt from hsn_master where  hsn_code = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
        $this->logger->save($this->db);
		return $res;
	}
    public function geteditdata($var_array)
    {
        $sql = "select * from hsn_master where hsn_master_id=? and office_id= ?";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
        return $res;
    }
	public function editcheck($var_array)
	{
		$sql = "select count(*) as cnt from hsn_master where hsn_master_id!=?  and hsn_code = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function deletecheck($var_array)
	{
		$sql = "select count(*) as cnt from hsn_master where hsn_master_id=?  and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function savedata($data)
    {
        if($this->db->insert('hsn_master',$data))
        {
             return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('hsn_master_id', $id);
        if($this->db->update('hsn_master'))
        {
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
        $this->db->where('hsn_master_id', $id);
        if($this->db->delete('hsn_master'))
        {
            return TRUE;
        }
    }

       function ajax_call($requestData)
  {
  
    
    $office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column hsn_code
      0 =>'hsn_master_id',
      1 =>'hsn_code'
     
    );
 
    $this->db->select('hsn_code');//s.photo_no,s.photo_hsn_code'
    $this->db->from('hsn_master');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT name,hsn_master_id,hsn_code,hsn_master.description,if(hsn_master.status=1,'Active','Deactive') as status";
    $sql.=" FROM hsn_master inner join tax_master on hsn_master.tax_id=tax_master.tax_id where hsn_master.office_id=$office_id ";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //hsn_code
      $sql.="  and (  ";
        $sql.="  OR hsn_code LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR description LIKE '".$requestData['search']['value']."%') ";
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
			$hsn_master_id=$row[$i]['hsn_master_id'];


	     $edit="<button type='button'  onclick=\"editdata('$hsn_master_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="edithsn_master_id('.$hsn_master_id_id.',1,$(this),'.$code.','.$hsn_code.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletedata('.$hsn_master_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        // if(($this->auth->lock_up('item_master',"category_id='$hsn_master_id_id'")) || ($this->auth->lock_up('supplier',"category_id='$hsn_master_id_id'")) ||in_array($hsn_master_id_id,[1,2,3]))
        //   {
        //       $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
        //   }
        //   if(in_array($hsn_master_id_id,[1,2,3]))
        //   {
        //       $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
        //   }
     
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