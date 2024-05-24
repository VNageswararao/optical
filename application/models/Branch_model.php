<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @12/12/2020
 */
class Branch_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}
	public function checkBranch($var_array)
	{
		$sql = "select count(*) as cnt from branch where  name = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}

	public function savedata($data)
    {
        if($this->db->insert('branch',$data))
        {
            return TRUE;
        }
    }

	function ajax_call($requestData)
  {
  
    
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'branch_id'
      
     
    );
 
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('branch');
    $whrcon = array('office_id' => $office_id,'type' => 1);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT branch_id,name,description,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM branch where office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( name LIKE '%".$requestData['search']['value']."%' ";
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
			$branch_id=$row[$i]['branch_id'];
			$name=$row[$i]['name'];
			$description=$row[$i]['description'];
			$status=$row[$i]['status'];

	     $edit="<button type='button'  onclick=\"editBranch('$branch_id','$name','$description','$status');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	

      	$delete='<button onclick="deleteBranch('.$branch_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


       
     
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

  public function editcheckBranch($var_array)
	{
		$sql = "select count(*) as cnt from branch where branch_id!=? and   name = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}

	public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('branch_id', $id);
        if($this->db->update('branch'))
        {
            return TRUE;
        }
    }
    public function deletechkBranch($var_array)
	{
		$sql = "select count(*) as cnt from branch where branch_id=?   and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function deletedata($id) 
    {
        $this->db->where('branch_id', $id);
        if($this->db->delete('branch'))
        {
            return TRUE;
        }
    }

}