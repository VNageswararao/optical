<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @24/01/2021
 */
class Purchase_return_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}
  public function deletecheckpurchasereturn($var_array)
  {
      $sql = "select count(*) as cnt  from purchase_return where   purchase_return_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getmastertable($var_array)
  {
      $sql = "select *  from purchase_return where  purchase_return_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getpurchasereturnchildtable($var_array)
    {
       $sql = "select  purchase_return_details.purchase_return_id,purchase_return_details.purchase_quantity,purchase_return_details.stock_id,purchase_return_details.return_stock_id,purchase_return_details.free,purchase_return_details.cgst,purchase_return_details.sgst,purchase_return_details.dis_type,purchase_return_details.dis_amount,purchase_return_details.mrp,purchase_return_details.landing_cost,purchase_return_details.selling_price,purchase_return_details.tax_val,purchase_return_details.frametype,purchase_return_details.framecolor,purchase_return_details.framesize,purchase_return_details.framemodel,purchase_return_details.quantity,purchase_return_details.cost_price,purchase_return_details.tot_amount,purchase_return_details.mul_type,purchase_return_details.gst_selection_ind,item_master.code,item_master.name,item_master.item_id,tax_master.name as taxval from  purchase_return_details  inner join item_master  on  purchase_return_details.item_id=item_master.item_id left join tax_master on item_master.tax=tax_master.tax_id  where  purchase_return_id=? and  item_master.office_id= ?";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
        return $res;
    }
  public function savedata($data)
  {
           $this->db->trans_begin();
           $purchase_entry=$data['purchase_return'];
           $last_invoice_number=$this->db->select('max(bill_no) as last_invoice_number')
                         ->from('purchase_return')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_invoice_number;
            if($last_invoice_number>0)
            {
                $invoice_number=$last_invoice_number+1;
            } 
            else 
            {
                $invoice_number=1;
            }
           $purchase_entry['bill_no']=$invoice_number;
           $this->db->insert('purchase_return',$purchase_entry);
           $purchase_return_id=$this->db->insert_id();
           $office_id=$this->session->userdata('office_id');
           $login_id=$this->session->userdata('login_id');
           $purchasereturn_details=$data['purchasereturn_detail'];
           $item_ids=$purchasereturn_details['item_id'];
           $purchasequantitys=$purchasereturn_details['purchase_quantity'];
           $quantitys=$purchasereturn_details['quantity'];
           $cost_prices=$purchasereturn_details['cost_price'];
           $landing_costs=$purchasereturn_details['landing_cost'];
           $mrps=$purchasereturn_details['mrp'];
           $selling_prices=$purchasereturn_details['selling_price'];
           $dis_types=$purchasereturn_details['dis_type'];
           $dis_amounts=$purchasereturn_details['dis_amount'];
           $tax_vals=$purchasereturn_details['tax_val'];
           $cgsts=$purchasereturn_details['cgst'];
           $sgsts=$purchasereturn_details['sgst'];
           $tot_amounts=$purchasereturn_details['tot_amount'];
           $gstselinds=$purchasereturn_details['gst_selection_ind'];
           $mul_types=$purchasereturn_details['mul_type'];
           $frametypes=$purchasereturn_details['frametype'];
           $framecolors=$purchasereturn_details['framecolor'];
           $framesizes=$purchasereturn_details['framesize'];
           $framemodels=$purchasereturn_details['framemodel'];
           $return_stock_ids=$purchasereturn_details['return_stock_id'];
           $stock_ids=$purchasereturn_details['stock_id'];
           $mulframetypes=$purchasereturn_details['mulframetype'];
           $mulframecolors=$purchasereturn_details['mulframecolor'];
           $mulframesizes=$purchasereturn_details['mulframesize'];
           $mulframemodels=$purchasereturn_details['mulframemodel'];
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
               $this->db->insert('purchase_return_details',array(
                                                          "purchase_return_id"=>$purchase_return_id,
                                                          "item_id"=>$item_id,
                                                          "purchase_quantity"=>$purchasequantitys[$i],
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
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel,
                                                          "stock_id"=>$stock_ids[$i],
                                                          "return_stock_id"=>$return_stock_ids[$i]
                                                          )
                                    );
               $purchase_return_details_id=$this->db->insert_id();
               $qty=$quantitys[$i];
                if($mul_types[$i]==1)
                {
                    $stockid=$stock_ids[$i];
                    if($stockid>0)
                    {
                         $this->db->query("update stock set quantity=quantity-$qty  where stock_id=$stockid and office_id=$office_id");
                    }
                    else
                    {
                      //$this->db->trans_rollback();
                      return FALSE;
                    }
                }
                if($mul_types[$i]==2)
                {
                    $retstockid=$return_stock_ids[$i];
                    if($retstockid)
                    {
                        $b=0;
                        $x = 1;
                        $mulreturnstock=explode(',',$return_stock_ids[$i]);
                        while($x <= $qty) 
                        {
                            if($mulreturnstock[$b]>0)
                            {
                               $this->db->query("update stock set quantity=quantity-1  where stock_id='".$mulreturnstock[$b]."' and office_id=$office_id");
                            }
                            else
                            {
                              return FALSE;
                            }
                            $x++;
                            $b++;
                        }
                    }
                    else
                    {
                        //$this->db->trans_rollback();
                        return FALSE;
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
          
            $office_id=$this->session->office_id;
            $this->db->trans_begin();
            $items=$this->db->get_where('purchase_return_details',"purchase_return_id=$id")->result();
           
            foreach ($items as $item)
            {
                $item_id=$item->item_id;
                $qty=$item->quantity;
                $stock_id=$item->stock_id;
                $return_stock_id=$item->return_stock_id;
                $mul_type=$item->mul_type;
                $frametype=$item->frametype;
                $framecolor=$item->framecolor;
                $framesize=$item->framesize;
                $framemodel=$item->framemodel;
                
                if($mul_type==1)
                {
                $this->db->query("update stock set quantity=quantity+$qty where item_id=$item_id and stock_id='$stock_id'  and office_id=$office_id");
                }
                else
                {
                    $mulretstock=explode(',',$return_stock_id);
                    $x = 1;
                    $b=0;
                     while($x <= $qty) 
                    {
                      $this->db->query("update stock set quantity=quantity+1 where item_id=$item_id and stock_id='".$mulretstock[$b]."'  and office_id=$office_id ");
                      $x++;
                      $b++;
                    }
                }
               // $this->db->query("update stock_barcode set quantity=quantity-1 where  office_id=$office_id and quantity=1 and purchase_details_id='".$purchase_details_id."'");
                
            }
            $this->db->where('purchase_return_id',$id);
            $this->db->delete('purchase_return_details');
            $purchase_return=$data['purchase_return'];
            //print_r($purchase_return);exit;
            $this->db->set($purchase_return);
            $this->db->where('purchase_return_id', $id);
            $this->db->update('purchase_return');
            $purchase_return_id=$id;
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $purchasereturn_details=$data['purchasereturn_detail'];
           $item_ids=$purchasereturn_details['item_id'];
           $purchasequantitys=$purchasereturn_details['purchase_quantity'];
           $quantitys=$purchasereturn_details['quantity'];
           $cost_prices=$purchasereturn_details['cost_price'];
           $landing_costs=$purchasereturn_details['landing_cost'];
           $mrps=$purchasereturn_details['mrp'];
           $selling_prices=$purchasereturn_details['selling_price'];
           $dis_types=$purchasereturn_details['dis_type'];
           $dis_amounts=$purchasereturn_details['dis_amount'];
           $tax_vals=$purchasereturn_details['tax_val'];
           $cgsts=$purchasereturn_details['cgst'];
           $sgsts=$purchasereturn_details['sgst'];
           $tot_amounts=$purchasereturn_details['tot_amount'];
           $gstselinds=$purchasereturn_details['gst_selection_ind'];
           $mul_types=$purchasereturn_details['mul_type'];
           $frametypes=$purchasereturn_details['frametype'];
           $framecolors=$purchasereturn_details['framecolor'];
           $framesizes=$purchasereturn_details['framesize'];
           $framemodels=$purchasereturn_details['framemodel'];
           $return_stock_ids=$purchasereturn_details['return_stock_id'];
           $stock_ids=$purchasereturn_details['stock_id'];
           $mulframetypes=$purchasereturn_details['mulframetype'];
           $mulframecolors=$purchasereturn_details['mulframecolor'];
           $mulframesizes=$purchasereturn_details['mulframesize'];
           $mulframemodels=$purchasereturn_details['mulframemodel'];
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
               $this->db->insert('purchase_return_details',array(
                                                          "purchase_return_id"=>$purchase_return_id,
                                                          "item_id"=>$item_id,
                                                          "purchase_quantity"=>$purchasequantitys[$i],
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
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel,
                                                          "stock_id"=>$stock_ids[$i],
                                                          "return_stock_id"=>$return_stock_ids[$i]
                                                          )
                                    );
               $purchase_return_details_id=$this->db->insert_id();
               $qty=$quantitys[$i];
                if($mul_types[$i]==1)
                {
                    $stockid=$stock_ids[$i];
                    if($stockid>0)
                    {
                         $this->db->query("update stock set quantity=quantity-$qty  where stock_id=$stockid and office_id=$office_id");
                    }
                    else
                    {
                      //$this->db->trans_rollback();
                      return FALSE;
                    }
                }
                if($mul_types[$i]==2)
                {
                    $retstockid=$return_stock_ids[$i];
                    if($retstockid)
                    {
                        $b=0;
                        $x = 1;
                        $mulreturnstock=explode(',',$return_stock_ids[$i]);
                        while($x <= $qty) 
                        {
                            if($mulreturnstock[$b]>0)
                            {
                               $this->db->query("update stock set quantity=quantity-1  where stock_id='".$mulreturnstock[$b]."' and office_id=$office_id");
                            }
                            else
                            {
                              return FALSE;
                            }
                            $x++;
                            $b++;
                        }
                    }
                    else
                    {
                        //$this->db->trans_rollback();
                        return FALSE;
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
        function ajax_call($requestData)
  {
    $office_id=$this->session->office_id;
    //$office_id=$this->session->office_id;
    $columns = array(
      // datatable column index  => database column name
      0 =>'purchase_return_id'
    );
 
    $this->db->select('purchase_return_id');//s.photo_no,s.photo_name'
    $this->db->from('purchase_return');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT purchase_return_id,name,DATE_FORMAT(purchase_return_date,'%d/%m/%Y') AS purchase_return_date ,bill_no,purchase_return.total_qty,purchase_return.total_amount";
    $sql.=" FROM  purchase_return inner join purchase on purchase.purchase_id=purchase_return.purchase_id inner join supplier on purchase.supplier_id=supplier.supplier_id  where purchase_return.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( purchase_return_date LIKE '%".$requestData['search']['value']."%' ";
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
      $purchase_return_id=$row[$i]['purchase_return_id'];
      

       $edit="<button type='button'  onclick=\"editpurchasereturn('$purchase_return_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

        // $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

        $delete='<button onclick="deletepurchasereturn('.$purchase_return_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


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

  public function deletedata($id) 
        {
            $this->db->trans_begin();
            $office_id=$this->session->office_id;
            $items=$this->db->get_where('purchase_return_details',"purchase_return_id=$id")->result();
            foreach ($items as $item)
            {
                $item_id=$item->item_id;
                $qty=$item->quantity;
                $stock_id=$item->stock_id;
                $return_stock_id=$item->return_stock_id;
                $mul_type=$item->mul_type;
                $frametype=$item->frametype;
                $framecolor=$item->framecolor;
                $framesize=$item->framesize;
                $framemodel=$item->framemodel;
                
                if($mul_type==1)
                {
                $this->db->query("update stock set quantity=quantity+$qty where item_id=$item_id and stock_id='$stock_id'  and office_id=$office_id");
                }
                else
                {
                    $mulretstock=explode(',',$return_stock_id);
                    $x = 1;
                    $b=0;
                     while($x <= $qty) 
                    {
                      $this->db->query("update stock set quantity=quantity+1 where item_id=$item_id and stock_id='".$mulretstock[$b]."'  and office_id=$office_id ");
                      $x++;
                      $b++;
                    }
                }
               // $this->db->query("update stock_barcode set quantity=quantity-1 where  office_id=$office_id and quantity=1 and purchase_details_id='".$purchase_details_id."'");
                
            }
            $this->db->where('purchase_return_id',"$id");
            $this->db->delete('purchase_return_details');
            $this->db->where('purchase_return_id',"$id");
            $this->db->delete('purchase_return');
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