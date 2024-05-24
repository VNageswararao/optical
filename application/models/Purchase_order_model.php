<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @12/12/2020
 */
class Purchase_order_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	public function getlastbillno($var_array)
	  {
	      $sql = "select max(purchase_order_no) as last_order_no  from purchase_order where    office_id= ? limit 1";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function deletecheckpurchaseorder($var_array)
	  {
	      $sql = "select count(*) as cnt  from purchase_order where   purchase_order_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getmastertable($var_array)
	  {
	      $sql = "select *  from purchase_order where  purchase_order_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function editcheckpurchaseorder($var_array)
	  {
	      $sql = "select count(*) as cnt  from purchase_order where  purchase_order_id=?  and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getitemcpdetails($var_array)
	  {
	      $sql = "select cost_price  from purchaseorder_details where  item_id=?  and office_id= ? order by purchaseorder_details_id DESC limit 1";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      if($res){
	      return $res[0]['cost_price'];
	      }
	      else
	      {
	      	return 0;
	      }
	  }
	  public function Getchildtable($var_array)
	  {
	     $sql = "select *  from  purchaseorder_details inner join item_master on  purchaseorder_details.item_id=item_master.item_id  where  purchase_order_id=? and  purchaseorder_details.office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getpurchaseorderframetable($var_array)
	  {
	      $sql = "select *  from purchase_order_framedetails where  purchase_order_id=?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	   public function savedata($data)
        {
           $this->db->trans_begin();
           $purchase_order=$data['purchase_order'];
           $last_invoice_number=$this->db->select('max(purchase_order_no) as last_invoice_number')
                         ->from('purchase_order')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_invoice_number;
                if($last_invoice_number>0)
                {
                    $invoice_number=$last_invoice_number+1;
                } else {
                    $invoice_number= 1;
                   
                }
                $bill_number=$invoice_number;
                
          
                
           $purchase_order['purchase_order_no']=$bill_number;
           $this->db->insert('purchase_order',$purchase_order);
           $purchase_order_id=$this->db->insert_id();
           
           $purchaseorder_details=$data['purchaseorder_detail'];
           $item_ids=$purchaseorder_details['item_id'];
           $quantitys=$purchaseorder_details['quantity'];
           $cost_prices=$purchaseorder_details['cost_price'];
           $amounts=$purchaseorder_details['total_amount'];
           $gstselinds=$purchaseorder_details['gst_selection_ind'];
           $mul_types=$purchaseorder_details['mul_type'];
           $frametypes=$purchaseorder_details['frametype'];
           $framecolors=$purchaseorder_details['framecolor'];
           $framesizes=$purchaseorder_details['framesize'];
           $framemodels=$purchaseorder_details['framemodel'];
           $mulframetypes=$purchaseorder_details['mulframetype'];
           $mulframecolors=$purchaseorder_details['mulframecolor'];
           $mulframesizes=$purchaseorder_details['mulframesize'];
           $mulframemodels=$purchaseorder_details['mulframemodel'];
           $i=0;
           foreach ($item_ids as $item_id) 
           {
           	    if($mul_types[$i]==1)
                {
                	$frametype=$frametypes[$i];
                	$framecolor=$framecolors[$i];
                	$framesize=$framesizes[$i];
                	$framemodel=$framemodels[$i];
                }
                else
                {
                	$frametype=$mulframetypes[$i];
                	$framecolor=$mulframecolors[$i];
                	$framesize=$mulframesizes[$i];
                	$framemodel=$mulframemodels[$i];
                }
               $this->db->insert('purchaseorder_details',array(
                                                          "purchase_order_id"=>$purchase_order_id,
                                                          "item_id"=>$item_id,
                                                          "quantity"=>$quantitys[$i],
                                                          "cost_price"=>$cost_prices[$i],
                                                          "total_amount"=>$amounts[$i],
                                                          "gst_selection_ind"=>$gstselinds[$i],
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel,
                                                          "login_id"=>$this->session->userdata('login_id'),
                                                          "office_id"=>$this->session->userdata('office_id'),
                                                          )
                                    );
               $purchaseorder_details_id=$this->db->insert_id();
               $qty=$quantitys[$i];
               if($mul_types[$i]==2)
                {
                	$x = 1;
                    $b=0;
                    $mulframetype=explode(',',$mulframetypes[$i]);
                    $mulframecolor=explode(',',$mulframecolors[$i]);
                    $mulframesize=explode(',',$mulframesizes[$i]);
                    $mulframemodel=explode(',',$mulframemodels[$i]);
                    while($x <= $qty) 
                    {
                    	if($mulframetype[$b]>0 || $mulframecolor[$b]>0 || $mulframesize[$b]>0 || $mulframemodel[$b]>0)
                        {
                        	$this->db->insert('purchase_order_framedetails',array(
                                                          "purchase_order_id"=>$purchase_order_id,
                                                          "purchaseorder_details_id	"=>$purchaseorder_details_id,
                                                          "frametype_id"=>$mulframetype[$b],
                                                          "framecolor_id"=>$mulframecolor[$b],
                                                          "framesize_id"=>$mulframesize[$b],
                                                          "framemodel_id"=>$mulframemodel[$b]
                                                          )
                                    );
                        }
                        $x++;
                        $b++;
                    }
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
                    //$this->session->set_flashdata('sales_id',$sales_id);
                    return TRUE;
            }
        }
        public function updatedata($data,$id)
	    {
	        $this->db->trans_begin();
	        $this->db->where('purchase_order_id',$id);
            $this->db->delete('purchaseorder_details');
            $this->db->where('purchase_order_id',$id);
            $this->db->delete('purchase_order_framedetails');
	        $this->db->where('purchase_order_id', $id);
	        
	        
            $purchaseorder=$data['purchase_order'];
            $this->db->set($purchaseorder);
	        if($this->db->update('purchase_order'))
	        {
	       $purchase_order_id=$id;
	       $purchaseorder_details=$data['purchaseorder_detail'];
           $item_ids=$purchaseorder_details['item_id'];
           $quantitys=$purchaseorder_details['quantity'];
           $cost_prices=$purchaseorder_details['cost_price'];
           $amounts=$purchaseorder_details['total_amount'];
           $gstselinds=$purchaseorder_details['gst_selection_ind'];
           $mul_types=$purchaseorder_details['mul_type'];
           $frametypes=$purchaseorder_details['frametype'];
           $framecolors=$purchaseorder_details['framecolor'];
           $framesizes=$purchaseorder_details['framesize'];
           $framemodels=$purchaseorder_details['framemodel'];
           $mulframetypes=$purchaseorder_details['mulframetype'];
           $mulframecolors=$purchaseorder_details['mulframecolor'];
           $mulframesizes=$purchaseorder_details['mulframesize'];
           $mulframemodels=$purchaseorder_details['mulframemodel'];
           $i=0;
           foreach ($item_ids as $item_id) 
           {
           	    if($mul_types[$i]==1)
                {
                	$frametype=$frametypes[$i];
                	$framecolor=$framecolors[$i];
                	$framesize=$framesizes[$i];
                	$framemodel=$framemodels[$i];
                }
                else
                {
                	$frametype=$mulframetypes[$i];
                	$framecolor=$mulframecolors[$i];
                	$framesize=$mulframesizes[$i];
                	$framemodel=$mulframemodels[$i];
                }
               $this->db->insert('purchaseorder_details',array(
                                                          "purchase_order_id"=>$purchase_order_id,
                                                          "item_id"=>$item_id,
                                                          "quantity"=>$quantitys[$i],
                                                          "cost_price"=>$cost_prices[$i],
                                                          "total_amount"=>$amounts[$i],
                                                          "gst_selection_ind"=>$gstselinds[$i],
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel,
                                                          "login_id"=>$this->session->userdata('login_id'),
                                                          "office_id"=>$this->session->userdata('office_id'),
                                                          )
                                    );
               $purchaseorder_details_id=$this->db->insert_id();
               $qty=$quantitys[$i];
               if($mul_types[$i]==2)
                {
                	$x = 1;
                    $b=0;
                    $mulframetype=explode(',',$mulframetypes[$i]);
                    $mulframecolor=explode(',',$mulframecolors[$i]);
                    $mulframesize=explode(',',$mulframesizes[$i]);
                    $mulframemodel=explode(',',$mulframemodels[$i]);
                    while($x <= $qty) 
                    {
                    	if($mulframetype[$b]>0 || $mulframecolor[$b]>0 || $mulframesize[$b]>0 || $mulframemodel[$b]>0)
                        {
                        	$this->db->insert('purchase_order_framedetails',array(
                                                          "purchase_order_id"=>$purchase_order_id,
                                                          "purchaseorder_details_id	"=>$purchaseorder_details_id,
                                                          "frametype_id"=>$mulframetype[$b],
                                                          "framecolor_id"=>$mulframecolor[$b],
                                                          "framesize_id"=>$mulframesize[$b],
                                                          "framemodel_id"=>$mulframemodel[$b]
                                                          )
                                    );
                        }
                        $x++;
                        $b++;
                    }
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
	                    //$this->session->set_flashdata('sales_id',$sales_id);
	                    return TRUE;
	            }
	            
	        }
	    }
      public function deletedata($id) 
    {
        $this->db->where('purchase_order_id', $id);
        if($this->db->delete('purchase_order'))
        {
            $this->db->where('purchase_order_id',$id);
            $this->db->delete('purchaseorder_details');
            $this->db->where('purchase_order_id',$id);
            $this->db->delete('purchase_order_framedetails');
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
      0 =>'purchase_order_id'
    );
 
    $this->db->select('purchase_order_no');//s.photo_no,s.photo_name'
    $this->db->from('purchase_order');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT purchase_order_id,name,DATE_FORMAT(purchase_order_date,'%d/%m/%Y') AS purchase_order_date ,purchase_order_no,total_qty,total_amount";
    $sql.=" FROM  purchase_order inner join supplier on purchase_order.supplier_id=supplier.supplier_id  where purchase_order.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( purchase_order_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR purchase_order_no LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR total_amount LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR total_qty LIKE '".$requestData['search']['value']."%') ";
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
			$purchase_order_id=$row[$i]['purchase_order_id'];
			

	     $edit="<button type='button'  onclick=\"editpurchaseorder('$purchase_order_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletepurchaseorder('.$purchase_order_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


         if(($this->auth->lock_up('purchase',"purchase_order_id='$purchase_order_id'")))
          {
              $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
               $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
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