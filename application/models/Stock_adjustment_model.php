<?php
/**
 * Description of group_master_model
 *
 * @author Prabhu @12/12/2020
 */
class Stock_adjustment_model extends CI_Model{
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
     public function getSalesSearchStock($product,$office_id)
  {
      $sql = "select lens_stock.lens_stock_id as stock_id,lens_stock.item_id,gst_type,tax_master.name as taxval,lens_master.name as name,lens_master.code,lens_stock.mrp,lens_stock.selling_price,lens_stock.quantity from lens_master inner join lens_stock on lens_master.lens_master_id=lens_stock.item_id  left join tax_master on lens_master.tax=tax_master.tax_id where   lens_master.name like '%$product%' and lens_stock.quantity>0 and lens_stock.office_id= $office_id and lens_master.office_id= $office_id group by lens_stock.item_id,lens_stock.mrp,lens_stock.selling_price";
      $result_row=$this->db->query($sql);
      $res= $result_row->result_array ();
      return $res;
  }
   public function getSalesSearchStock_lens($product,$office_id)
  {
      $sql = "select lens_stock.lens_stock_id as stock_id,sales_details.item_id,gst_type,tax_master.name as taxval,lens_master.name as name,lens_master.code,lens_stock.mrp,sales_details.rate as selling_price,lens_stock.quantity from lens_master left join lens_stock on lens_master.lens_master_id=lens_stock.item_id  left join tax_master on lens_master.tax=tax_master.tax_id inner join sales_details on sales_details.item_id=lens_master.lens_master_id  where   sales_details.product_type=1 and  sales_details.sales_id='$product'  ";
      $result_row=$this->db->query($sql);
      $res= $result_row->result_array ();
     // echo $this->db->last_query();exit;
      return $res;
  }
    public function Get_sales_Bill($var_array)
    {
        $sql = "select sales_id,invoice_number,customer.name as cuname from sales_master inner join customer on sales_master.customer_id=customer.customer_id where sales_master.office_id=? and  sales_id in (select sales_id from sales_details where product_type=1)";
        $result_row=$this->db->query($sql, $var_array); 
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
        $sql = "select if(action=1,'Add','Minus') as status,stock.quantity as stockqty,item_master.name as item_name,action,frame_type,frame_color,frame_model,frame_size,stock.mrp,stock.selling_price,stock_adjustment_details.quantity from stock_adjustment_details inner join item_master on stock_adjustment_details.item_id=item_master.item_id inner join stock on stock.stock_id=stock_adjustment_details.stock_id where stock_adjustment_id=? and item_master.office_id= ?";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
        $this->logger->save($this->db);
        return $res;
    }
     public function getviewdata_lens($var_array)
    {
        $sql = "select if(action=1,'Add','Minus') as status,lens_stock.quantity as stockqty,lens_master.name as item_name,action,lens_stock.mrp,lens_stock.selling_price,lens_stock_adjustment_details.quantity from lens_stock_adjustment_details inner join lens_master on lens_stock_adjustment_details.item_id=lens_master.lens_master_id left join lens_stock on lens_stock.lens_stock_id=lens_stock_adjustment_details.stock_id where lens_stock_adjustment_id=? and lens_master.office_id= ?";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
       // echo $this->db->last_query();exit;
        $this->logger->save($this->db);
        return $res;
    }
	public function savedata($data)
    {
        $this->db->trans_begin();
        $this->db->insert('stock_adjustment',$data['stock_adjustment_master']);
       $stock_adjustment_id=$this->db->insert_id();
       $stock_adjustment_details=$data['stock_adjustment_detail'];
       $item_ids=$stock_adjustment_details['item_id'];
       $stock_ids=$stock_adjustment_details['stock_id'];
       $quantitys=$stock_adjustment_details['quantity'];
       $actions=$stock_adjustment_details['action'];
       $i=0;
       foreach ($stock_ids as $stock_id) 
       {
           $this->db->insert('stock_adjustment_details',array(
                                                      "stock_adjustment_id"=>$stock_adjustment_id,
                                                      "stock_id"=>$stock_id,
                                                      "item_id"=>$item_ids[$i],
                                                      "quantity"=>$quantitys[$i],
                                                      "action"=>$actions[$i]
                                                      )
                                );
            $qty=$quantitys[$i];
            if($actions[$i]==1)
            {
              $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
            }
            else
            {
              $this->db->query("update stock set quantity=quantity-$qty where stock_id=$stock_id");
            }
            
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
    public function savedata_lens($data)
    {
        $this->db->trans_begin();
        $this->db->insert('lens_stock_adjustment',$data['stock_adjustment_master']);
       $stock_adjustment_id=$this->db->insert_id();
       $stock_adjustment_details=$data['stock_adjustment_detail'];
       $item_ids=$stock_adjustment_details['item_id'];
       $stock_ids=$stock_adjustment_details['stock_id'];
       $quantitys=$stock_adjustment_details['quantity'];
       $actions=$stock_adjustment_details['action'];
       $i=0;
       foreach ($stock_ids as $stock_id) 
       {
           $this->db->insert('lens_stock_adjustment_details',array(
                                                      "lens_stock_adjustment_id"=>$stock_adjustment_id,
                                                      "stock_id"=>$stock_id,
                                                      "item_id"=>$item_ids[$i],
                                                      "quantity"=>$quantitys[$i],
                                                      "action"=>$actions[$i]
                                                      )
                                );
            $qty=$quantitys[$i];
            if($actions[$i]==1)
            {
              $this->db->query("update lens_stock set quantity=quantity+$qty where lens_stock_id=$stock_id");
            }
            else
            {
              $this->db->query("update lens_stock set quantity=quantity-$qty where lens_stock_id=$stock_id");
            }
            
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
            $items=$this->db->get_where('stock_adjustment_details',"stock_adjustment_id=$id")->result();
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

            $this->db->where('stock_adjustment_id',"$id");
            $this->db->delete('stock_adjustment_details');
            $this->db->where('stock_adjustment_id',"$id");
            $this->db->delete('stock_adjustment');

             

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

     public function deletedata_lens($id) 
    {
            $this->db->trans_begin();
            $items=$this->db->get_where('lens_stock_adjustment_details',"lens_stock_adjustment_id=$id")->result();
            foreach ($items as $item)
            {
                $qty=$item->quantity;
                $action=$item->action;
                $stock_id=$item->stock_id;
                 if($action==1)
                {
                   $this->db->query("update lens_stock set quantity=quantity-$qty where lens_stock_id=$stock_id");
                }
                else
                {
                  $this->db->query("update lens_stock set quantity=quantity+$qty where lens_stock_id=$stock_id");
                }
            }

            $this->db->where('lens_stock_adjustment_id',"$id");
            $this->db->delete('lens_stock_adjustment_details');
            $this->db->where('lens_stock_adjustment_id',"$id");
            $this->db->delete('lens_stock_adjustment');

             

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
      0 =>'stock_adjustment_id'
      
     
    );
 
    $this->db->select('number');//s.photo_no,s.photo_name'
    $this->db->from('stock_adjustment');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT * ";
    $sql.=" FROM stock_adjustment where office_id=$office_id ";
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
			$stock_adjustment_id=$row[$i]['stock_adjustment_id'];
			

	     $view="<button type='button'  onclick=\"viewdata('$stock_adjustment_id');\" class='btn btn-icon btn-success mr-1 mb-1'><i class='la la-eye'></i></button>";

      	

      	$delete='<button onclick="deletedata('.$stock_adjustment_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        
     
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
  function ajax_call_lens($requestData)
  {
  
    
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'lens_stock_adjustment_id'
      
     
    );
 
    $this->db->select('number');//s.photo_no,s.photo_name'
    $this->db->from('lens_stock_adjustment');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT * ";
    $sql.=" FROM lens_stock_adjustment where office_id=$office_id ";
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
            $stock_adjustment_id=$row[$i]['lens_stock_adjustment_id'];
            

         $view="<button type='button'  onclick=\"viewdata('$stock_adjustment_id');\" class='btn btn-icon btn-success mr-1 mb-1'><i class='la la-eye'></i></button>";

        

        $delete='<button onclick="deletedata('.$stock_adjustment_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

        
     
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