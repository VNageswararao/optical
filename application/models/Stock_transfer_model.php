<?php
/**
 * Description of group_master_model
 *
 * @author Prabhu @29/06/2023
 */
class Stock_transfer_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	
    public function checkgroup($var_array)
	{
		$sql = "select count(*) as cnt from group_master where type=? and  code = ? or name = ? and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
     public function Get_branch()
    {
        $sql = "select name,branch_id from branch where status=1";
        $result_row=$this->db->query($sql); 
        $res= $result_row->result_array ();
        $this->logger->save($this->db);
        return $res;
    }
	public function editcheckgroup($var_array)
	{
		$sql = "select count(*) as cnt from group_master where group_master_id!=? and  type=? and  (code = ? or name = ? ) and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
	public function deletecheckgroup($var_array)
	{
		$sql = "select count(*) as cnt from group_master where group_master_id=? and  type=?  and office_id= ?";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
    public function getdataframeclass($var_array)
    {
        $sql = "select name from frame_classification where frame_id=? and  type=? ";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
        $this->logger->save($this->db);
        return $res;
    }
    public function getviewdata($var_array)
    {
        $sql = "select if(action=1,'Add','Minus') as status,stock.quantity as stockqty,item_master.name as item_name,action,frame_type,frame_color,frame_model,frame_size,stock.mrp,stock.selling_price,stock_transfer_details.quantity from stock_transfer_details inner join item_master on stock_transfer_details.item_id=item_master.item_id inner join stock on stock.stock_id=stock_transfer_details.stock_id where stock_transfer_id=? and item_master.office_id= ?";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
        $this->logger->save($this->db);
        return $res;
    }
	public function savedata($data)
    {
        $this->db->trans_begin();
        $this->db->insert('stock_transfer',$data['stock_transfer_master']);
       $stock_transfer_id=$this->db->insert_id();
       $stock_transfer_details=$data['stock_transfer_detail'];
       $item_ids=$stock_transfer_details['item_id'];
       $stock_ids=$stock_transfer_details['stock_id'];
       $quantitys=$stock_transfer_details['quantity'];
       $amounts=$stock_transfer_details['amount'];
       $actions=2;
       $i=0;
       foreach ($stock_ids as $stock_id) 
       {
           $this->db->insert('stock_transfer_details',array(
                                                      "stock_transfer_id"=>$stock_transfer_id,
                                                      "stock_id"=>$stock_id,
                                                      "item_id"=>$item_ids[$i],
                                                      "quantity"=>$quantitys[$i],
                                                      "amount"=>$amounts[$i],
                                                      "action"=>2
                                                      )
                                );
            $qty=$quantitys[$i];
            $this->db->query("update stock set quantity=quantity-$qty where stock_id=$stock_id");
            
            $i++;
       }
       if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
                return FALSE;
        }
        else
        {
                $this->db->trans_commit();
                return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('group_master_id', $id);
        if($this->db->update('group_master'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
            $this->db->trans_begin();
            $items=$this->db->get_where('stock_transfer_details',"stock_transfer_id=$id")->result();
            foreach ($items as $item)
            {
                $qty=$item->quantity;
                $action=$item->action;
                $stock_id=$item->stock_id;
                 if($action==1)
                {
                   $this->db->query("update stock set quantity=quantity-$qty where stock_id=$stock_id");
                }
                else
                {
                  $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
                }
            }

            $this->db->where('stock_transfer_id',"$id");
            $this->db->delete('stock_transfer_details');
            $this->db->where('stock_transfer_id',"$id");
            $this->db->delete('stock_transfer');

             

           if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
                    return FALSE;
            }
            else
            {
                    $this->db->trans_commit();
                    
                    return TRUE;
            }
    }

       function ajax_call($requestData)
  {
  
    
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'stock_transfer_id'
      
     
    );
 
    $this->db->select('number');//s.photo_no,s.photo_name'
    $this->db->from('stock_transfer');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT * ";
    $sql.=" FROM stock_transfer where office_id=$office_id ";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( number LIKE '%".$requestData['search']['value']."%' ";
       // $sql.="  OR number LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR adjustment_date LIKE '".$requestData['search']['value']."%') ";
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
			$stock_transfer_id=$row[$i]['stock_transfer_id'];
			

	     $view="<button type='button'  onclick=\"viewdata('$stock_transfer_id');\" class='btn btn-icon btn-success mr-1 mb-1'><i class='la la-eye'></i></button>";

      	

      	$delete='<button onclick="deletedata('.$stock_transfer_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        
     
        $row[$i]['slno']=$i+1;
        $row[$i]['view']=$view;
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