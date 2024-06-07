<?php
/**
 * Description of staff_model
 *
 * @author Prabhu @27/02/2021
 */
class Staff_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	
    public function checkstaff($var_array)
	{
		$sql = "select count(*) as cnt from staff where  code = ? or name = ? or mobile = ? and office_id= ?";
	  $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
	public function editstaff($var_array)
	{
		$sql = "select count(*) as cnt from staff where staff_id!=?  and  code = ? and name = ? and mobile = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function deletecheckstaff($var_array)
	{
		$sql = "select count(*) as cnt from staff where staff_id=?  and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
	public function savedata($data)
    {
        if($this->db->insert('staff',$data))
        {
             $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('staff_id', $id);
        if($this->db->update('staff'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
        $this->db->where('staff_id', $id);
        if($this->db->delete('staff'))
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
      0 =>'staff_id'
      
     
    );
 
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('staff');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT staff_id,code,name,mobile,email,address,description,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM staff where office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( code LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR name LIKE '".$requestData['search']['value']."%'  ";
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
			$staff_id=$row[$i]['staff_id'];
			$code=$row[$i]['code'];
			$name=$row[$i]['name'];
      $mobile=$row[$i]['mobile'];
      $email=$row[$i]['email'];
      $address=$row[$i]['address'];
			$description=$row[$i]['description'];
			$status=$row[$i]['status'];

	     $edit="<button type='button'  onclick=\"editstaff('$staff_id','$code','$name','$mobile','$email','$address','$description','$status');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editstaff('.$staff_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletestaff('.$staff_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        if(($this->auth->lock_up('sales_master',"staff_id='$staff_id'")))
          {
              $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
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