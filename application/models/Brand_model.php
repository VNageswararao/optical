<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @12/12/2020
 */
class Brand_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	 public function insert($data)
    {
        if($this->db->insert('classification',$data))
        {
           
            return TRUE;
        }
    }
    public function checkclassification($var_array)
	{
		$sql = "select count(*) as cnt from classification where type=? and  code = ? or name = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function editcheckclassification($var_array)
	{
		$sql = "select count(*) as cnt from classification where classification_id!=? and  type=? and  code = ? and name = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function deletecheckclassification($var_array)
	{
		$sql = "select count(*) as cnt from classification where classification_id=? and  type=?  and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function savedata($data)
    {
        if($this->db->insert('classification',$data))
        {
            return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('classification_id', $id);
        if($this->db->update('classification'))
        {
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
        $this->db->where('classification_id', $id);
        if($this->db->delete('classification'))
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
      0 =>'classification_id'
      
     
    );
 
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('classification');
    $whrcon = array('office_id' => $office_id,'type' => 1);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT classification_id,code,name,description,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM classification where office_id=$office_id and type=2";
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
			$classification_id=$row[$i]['classification_id'];
			$code=$row[$i]['code'];
			$name=$row[$i]['name'];
			$description=$row[$i]['description'];
			$status=$row[$i]['status'];

	     $edit="<button type='button'  onclick=\"editclassification('$classification_id',2,'$code','$name','$description','$status');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

  

      	$delete='<button onclick="deleteclassification('.$classification_id.',2)" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        if(($this->auth->lock_up('item_master',"brand_id='$classification_id'")))
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