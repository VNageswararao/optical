<?php
/**
 * Description of lens_classification_model
 *
 * @author Prabhu @20/12/2020
 */
class Lens_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	public function getlenstype($var_array)
  {
    $sql = "select lens_classification_id,name from lens_classification where type=1 and  status = 1 and office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    return $res;
  }
    
  public function getlenscoating($var_array)
  {
    $sql = "select lens_classification_id,name from lens_classification where type=2 and  status = 1 and office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    return $res;
  }
    public function checklens($var_array)
	{
		$sql = "select count(*) as cnt from lens_classification where type=? and  code = ? or name = ? and office_id= ?";
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
  public function checklensmaster($var_array)
  {
    $sql = "select count(*) as cnt from lens_master where   code = ? and name = ? and office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
  public function GetData($var_array)
  {
    $sql = "select * from lens_master where    lens_master_id = ? and office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
  public function editchecklensmaster($var_array)
  {
    $sql = "select count(*) as cnt from lens_master where lens_master_id!=? and   code = ? and name = ? and office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    return $res;
  }
	public function editchecklens($var_array)
	{
		$sql = "select count(*) as cnt from lens_classification where lens_classification_id!=? and  type=? and  code = ? and name = ? and office_id= ?";
	  $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function deletechecklens($var_array)
	{
		$sql = "select count(*) as cnt from lens_classification where lens_classification_id=? and  type=?  and office_id= ?";
	   $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
  public function deletechecklensmaster($var_array)
  {
    $sql = "select count(*) as cnt from lens_master where lens_master_id=?   and office_id= ?";
     $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    $this->logger->save($this->db);
    return $res;
  }
	public function savedata($data)
    {
        if($this->db->insert('lens_classification',$data))
        {
             $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function savelensdata($data)
    {
        if($this->db->insert('lens_master',$data))
        {
             $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('lens_classification_id', $id);
        if($this->db->update('lens_classification'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
     public function updatelensmasterdata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('lens_master_id', $id);
        if($this->db->update('lens_master'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
        $this->db->where('lens_classification_id', $id);
        if($this->db->delete('lens_classification'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
     public function deletelensmasterdata($id) 
    {
        $this->db->where('lens_master_id', $id);
        if($this->db->delete('lens_master'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }

       function ajax_call($requestData,$type)
  {
  
    
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'lens_classification_id'
      
     
    );
 
    
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('lens_classification');
    $whrcon = array('office_id' => $office_id,'type' => $type);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $query = $this->db->query('SELECT name FROM lens_classification where office_id='.$office_id.' and type='.$type.'');
    $totalData=$totalFiltered=$query->num_rows();
    //$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT lens_classification_id,code,name,description,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM lens_classification where office_id=$office_id and type=$type";
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
			$lens_classification_id=$row[$i]['lens_classification_id'];
			$code=$row[$i]['code'];
			$name=$row[$i]['name'];
			$description=$row[$i]['description'];
			$status=$row[$i]['status'];

	     $edit="<button type='button'  onclick=\"editlens('$lens_classification_id','$type','$code','$name','$description','$status');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editlens_classification('.$lens_classification_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletelens('.$lens_classification_id.','.$type.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        if($type==1)
        {
            if(($this->auth->lock_up('lens_master',"lens_type_id='$lens_classification_id'")))
            {
                $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
                
            }
        }
        else
        {
            if(($this->auth->lock_up('lens_master',"lens_coating_id='$lens_classification_id'")))
            {
                $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
                
            }
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
  function lensajax_call($requestData)
  {
  
    
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'lens_master_id'
      
     
    );
 
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('lens_master');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT lens_master_id,code,name,description,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM lens_master where office_id=$office_id";
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
      $lens_master_id=$row[$i]['lens_master_id'];
      $code=$row[$i]['code'];
      $name=$row[$i]['name'];
      $description=$row[$i]['description'];
      $status=$row[$i]['status'];


       $edit="<button type='button'  onclick=\"editlensmasternew('$lens_master_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

        // $edit='<button  onclick="editlens_classification('.$lens_classification_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';
        $type=3;
        $delete='<button onclick="deletelens('.$lens_master_id.','.$type.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

      if(($this->auth->lock_up('sales_details',"item_id='$lens_master_id' and product_type=1")))
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