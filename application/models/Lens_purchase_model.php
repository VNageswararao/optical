<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @19/11/2023
 */
class Lens_purchase_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	public function getbillno($var_array)
	  {
	      $sql = "select purchase_order_id,purchase_order_no  from purchase_order  where    office_id= ? and  purchase_order_id not  in  (select purchase_order_id from purchase) order by purchase_order_no ASC";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function deletecheckpurchaseentry($var_array)
	  {
	      $sql = "select count(*) as cnt  from lens_purchase where   lens_purchase_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getmastertable($var_array)
	  {
	      $sql = "select *  from lens_purchase where  lens_purchase_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getpurchasechildtable($var_array)
	  {
	     $sql = "select lens_purchase_details.free,lens_purchase_details.cgst,lens_purchase_details.sgst,lens_purchase_details.dis_type,lens_purchase_details.dis_amount,lens_purchase_details.mrp,lens_purchase_details.landing_cost,lens_purchase_details.selling_price,lens_purchase_details.tax_val,lens_purchase_details.spe,lens_purchase_details.cyl,lens_purchase_details.axis,lens_purchase_details.lens_add,lens_purchase_details.quantity,lens_purchase_details.cost_price,lens_purchase_details.tot_amount,lens_purchase_details.gst_selection_ind,lens_master.code,lens_master.name,lens_master.lens_master_id,tax_master.name as taxval from  lens_purchase_details  inner join lens_master  on  lens_purchase_details.item_id=lens_master.lens_master_id left join tax_master on lens_master.tax=tax_master.tax_id  where  lens_purchase_id=? and  lens_master.office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getchildtable($var_array)
	  {
	     $sql = "select purchaseorder_details.frametype,purchaseorder_details.framecolor,purchaseorder_details.framesize,purchaseorder_details.framemodel,purchaseorder_details.quantity,purchaseorder_details.cost_price,purchaseorder_details.total_amount,purchaseorder_details.mul_type,purchaseorder_details.gst_selection_ind,item_master.code,item_master.name,item_master.item_id,tax_master.name as taxval from  purchaseorder_details  inner join item_master  on  purchaseorder_details.item_id=item_master.item_id left join tax_master on item_master.tax=tax_master.tax_id  where  purchase_order_id=? and  purchaseorder_details.office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function checkpurchaseorder($var_array)
	  {
	      $sql = "select count(*) as cnt from purchase_order where   purchase_order_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function savedata($data)
        {
           $this->db->trans_begin();
           $purchase_entry=$data['purchase_entry'];
           $this->db->insert('lens_purchase',$purchase_entry);
           $lens_purchase_id=$this->db->insert_id();
           $office_id=$this->session->userdata('office_id');
           $login_id=$this->session->userdata('login_id');
           $purchaseentry_details=$data['purchaseentry_detail'];

           $item_ids=$purchaseentry_details['item_id'];
           $quantitys=$purchaseentry_details['quantity'];
           $cost_prices=$purchaseentry_details['cost_price'];
           $landing_costs=$purchaseentry_details['landing_cost'];
           $mrps=$purchaseentry_details['mrp'];
           $selling_prices=$purchaseentry_details['selling_price'];
           $dis_types=$purchaseentry_details['dis_type'];
           $dis_amounts=$purchaseentry_details['dis_amount'];
           $tax_vals=$purchaseentry_details['tax_val'];
           $cgsts=$purchaseentry_details['cgst'];
           $sgsts=$purchaseentry_details['sgst'];
           $tot_amounts=$purchaseentry_details['tot_amount'];
           $gstselinds=$purchaseentry_details['gst_selection_ind'];
           $spes=$purchaseentry_details['spe'];
           $cyls=$purchaseentry_details['cyl'];
           $axiss=$purchaseentry_details['axis'];
           $lens_adds=$purchaseentry_details['lens_add'];
           $i=0;
           foreach ($item_ids as $item_id) 
           {
               $this->db->insert('lens_purchase_details',array(
                                                          "lens_purchase_id"=>$lens_purchase_id,
                                                          "item_id"=>$item_id,
                                                          "quantity"=>$quantitys[$i],
                                                          "cost_price"=>$cost_prices[$i],
                                                          "landing_cost"=>$landing_costs[$i],
                                                          "mrp"=>$mrps[$i],
                                                          "selling_price"=>$selling_prices[$i],
                                                          "dis_type"=>$dis_types[$i],
                                                          "dis_amount"=>$dis_amounts[$i],
                                                          "tot_amount"=>$tot_amounts[$i],
                                                          "gst_selection_ind"=>$gstselinds[$i],
                                                          "tax_val"=>$tax_vals[$i],
                                                          "spe"=>$spes[$i],
                                                          "cyl"=>$cyls[$i],
                                                          "axis"=>$axiss[$i],
                                                          "lens_add"=>$lens_adds[$i]
                                                          ));

            $qty = ($quantitys[$i]);
            $qry = $this->db->get_where("lens_stock", "item_id=$item_id and cp='" . $cost_prices[$i] . "' and lc='" . $landing_costs[$i] . "' and selling_price='" . $selling_prices[$i] . "' and mrp='" . $mrps[$i] . "'  and office_id=$office_id");

            if ($qry->num_rows() > 0) 
            {
                $stock_id = $qry->row()->lens_stock_id;
                $this->db->query("update lens_stock set quantity=quantity+$qty  where lens_stock_id=$stock_id and office_id=$office_id");
            } 
            else
            {
                $this->db->insert('lens_stock', array(
                    "item_id" => $item_id,
                    "selling_price" => $selling_prices[$i],
                    "mrp" => $mrps[$i],
                    "cp" => $cost_prices[$i],
                    "lc" => $landing_costs[$i],
                    "quantity" => $qty,
                    "office_id" => $office_id,
                    "login_id" => $login_id
                ));
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

         function ajax_call($requestData)
  {
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'lens_purchase_id'
    );
 
    $this->db->select('lens_purchase_id');//s.photo_no,s.photo_name'
    $this->db->from('lens_purchase');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT lens_purchase_id,name,DATE_FORMAT(lens_purchase_date,'%d/%m/%Y') AS purchase_date ,invoice_no,total_qty,total_amount";
    $sql.=" FROM  lens_purchase inner join supplier on lens_purchase.supplier_id=supplier.supplier_id  where lens_purchase.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( lens_purchase_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR invoice_no LIKE '".$requestData['search']['value']."%'  ";
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
			$purchase_id=$row[$i]['lens_purchase_id'];
			

	     $edit="<button type='button'  onclick=\"editpurchase('$purchase_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletepurchase('.$purchase_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

         if(($this->auth->lock_up('purchase_return',"purchase_id='$purchase_id'")))
          {
              $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
              $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
          }
         //  $delete=$edit='<a class="table-link danger"><button type="button" class="btn-sm btn btn-secondary"><i class="fas fa-lock"></i></button></a>';
         // $product_id=$row[$i]['product_id'];
         //   if($row[$i]['office_id']==$office_id)
         //   {
         //    if($edit_privilage)
         //    {
         //    $edit='<a href="'.base_url('index.php/master/Product/edit/'.$product_id).'" class="table-link danger"><button type="button" class="btn-sm btn btn-warning"><i class="fas fa-edit"></i></button></a>';
         //    } 

         //    if(($delete_privilage)&&(!$this->uroll->lock_up('purchase_detail',"(product_id=$product_id)"))&&(!$this->uroll->lock_up('sales_detail',"(product_id=$product_id)")))
         //    {
         //    $delete='<a href="#" class="table-link danger"><span onclick="deletemasters('.$product_id.',$(this))"><button type="button" class="btn-sm btn btn-danger"><i class="fas fa-trash"></i></button></a>';
         //    }
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

   public function updatedata($data,$id)
        {
            $office_id=$this->session->office_id;
            $this->db->trans_begin();
            $items=$this->db->get_where('lens_purchase_details',"lens_purchase_id=$id")->result();
           
            foreach ($items as $item)
            {
                $item_id=$item->item_id;
                $free=$item->free;
                if($free)
                {
                	$freeqty=$free;
                }
                else
                {
                	$freeqty=0;
                }
                $qty=$item->quantity+$freeqty;
                $mrp=$item->mrp;
                $selling_price=$item->selling_price;
                $cp=$item->cost_price;
                $lc=$item->landing_cost;
                $lens_purchase_details_id=$item->lens_purchase_details_id;
                $this->db->query("update lens_stock set quantity=quantity-$qty where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and cp='$cp' and lc='$lc' and office_id=$office_id ");
            }
            $this->db->where('lens_purchase_id',$id);
            $this->db->delete('lens_purchase_details');
            
            
            
            
            $purchase=$data['purchase_entry'];
            $this->db->set($purchase);
            $this->db->where('lens_purchase_id', $id);
            $this->db->update('lens_purchase');
            $purchase_id=$id;
            $office_id=$this->session->userdata('office_id');
           $login_id=$this->session->userdata('login_id');
           $purchaseentry_details=$data['purchaseentry_detail'];
           $item_ids=$purchaseentry_details['item_id'];
           $quantitys=$purchaseentry_details['quantity'];
           $cost_prices=$purchaseentry_details['cost_price'];
           $landing_costs=$purchaseentry_details['landing_cost'];
           $mrps=$purchaseentry_details['mrp'];
           $selling_prices=$purchaseentry_details['selling_price'];
           $dis_types=$purchaseentry_details['dis_type'];
           $dis_amounts=$purchaseentry_details['dis_amount'];
           $tax_vals=$purchaseentry_details['tax_val'];
           $cgsts=$purchaseentry_details['cgst'];
           $sgsts=$purchaseentry_details['sgst'];
           $tot_amounts=$purchaseentry_details['tot_amount'];
           $gstselinds=$purchaseentry_details['gst_selection_ind'];
           $spes=$purchaseentry_details['spe'];
           $cyls=$purchaseentry_details['cyl'];
           $axiss=$purchaseentry_details['axis'];
           $lens_adds=$purchaseentry_details['lens_add'];
           $i=0;
           foreach ($item_ids as $item_id) 
           {
               $this->db->insert('lens_purchase_details',array(
                                                          "lens_purchase_id"=>$purchase_id,
                                                          "item_id"=>$item_id,
                                                          "quantity"=>$quantitys[$i],
                                                          "cost_price"=>$cost_prices[$i],
                                                          "landing_cost"=>$landing_costs[$i],
                                                          "mrp"=>$mrps[$i],
                                                          "selling_price"=>$selling_prices[$i],
                                                          "dis_type"=>$dis_types[$i],
                                                          "dis_amount"=>$dis_amounts[$i],
                                                          "tot_amount"=>$tot_amounts[$i],
                                                          "gst_selection_ind"=>$gstselinds[$i],
                                                          "tax_val"=>$tax_vals[$i],
                                                          "spe"=>$spes[$i],
                                                          "cyl"=>$cyls[$i],
                                                          "axis"=>$axiss[$i],
                                                          "lens_add"=>$lens_adds[$i]
                                                          )
                                    );
               

            $qty = ($quantitys[$i]);
            $qry = $this->db->get_where("lens_stock", "item_id=$item_id and cp='" . $cost_prices[$i] . "' and lc='" . $landing_costs[$i] . "' and selling_price='" . $selling_prices[$i] . "' and mrp='" . $mrps[$i] . "'  and office_id=$office_id");

            if ($qry->num_rows() > 0) 
            {
                $stock_id = $qry->row()->lens_stock_id;
                $this->db->query("update lens_stock set quantity=quantity+$qty  where lens_stock_id=$stock_id and office_id=$office_id");
            } 
            else
            {
                $this->db->insert('lens_stock', array(
                    "item_id" => $item_id,
                    "selling_price" => $selling_prices[$i],
                    "mrp" => $mrps[$i],
                    "cp" => $cost_prices[$i],
                    "lc" => $landing_costs[$i],
                    "quantity" => $qty,
                    "office_id" => $office_id,
                    "login_id" => $login_id
                ));
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

        public function deletedata($id) 
        {
            $this->db->trans_begin();
            $office_id=$this->session->office_id;
            $items=$this->db->get_where('lens_purchase_details',"lens_purchase_id=$id")->result();
            foreach ($items as $item)
            {
                $item_id=$item->item_id;
                $free=$item->free;
                if($free)
                {
                	$freeqty=$free;
                }
                else
                {
                	$freeqty=0;
                }
                $qty=$item->quantity+$freeqty;
                $mrp=$item->mrp;
                $item_id=$item->item_id;
                $selling_price=$item->selling_price;

                $this->db->query("update lens_stock set quantity=quantity-$qty where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and  office_id=$office_id ");
               
                
            }
            $this->db->where('lens_purchase_id',"$id");
            $this->db->delete('lens_purchase_details');
            $this->db->where('lens_purchase_id',"$id");
            $this->db->delete('lens_purchase');
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
}