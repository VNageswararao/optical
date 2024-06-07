<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @01/01/2021
 */
class Purchase_entry_model extends CI_Model{
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
	      $sql = "select count(*) as cnt  from purchase where   purchase_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getmastertable($var_array)
	  {
	      $sql = "select *  from purchase where  purchase_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function temp_Getmastertable($var_array)
	  {
	      $sql = "select *  from temp_purchase where  login_id=? and office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  }
	  public function Getpurchasechildtable($var_array)
	  {
	     $sql = "select purchase_details.free,purchase_details.cgst,purchase_details.sgst,purchase_details.dis_type,purchase_details.dis_amount,purchase_details.mrp,purchase_details.landing_cost,purchase_details.selling_price,purchase_details.tax_val,purchase_details.frametype,purchase_details.framecolor,purchase_details.framesize,purchase_details.framemodel,purchase_details.quantity,purchase_details.cost_price,purchase_details.tot_amount,purchase_details.mul_type,purchase_details.gst_selection_ind,item_master.code,item_master.name,item_master.item_id,tax_master.name as taxval from  purchase_details  inner join item_master  on  purchase_details.item_id=item_master.item_id left join tax_master on item_master.tax=tax_master.tax_id  where  purchase_id=? and  item_master.office_id= ?";
	      $result_row=$this->db->query($sql, $var_array); 
	      $res= $result_row->result_array ();
	      return $res;
	  } 
	  public function temp_Getpurchasechildtable($var_array)
	  {
	     $sql = "select temp_purchase_details.free,temp_purchase_details.cgst,temp_purchase_details.sgst,temp_purchase_details.dis_type,temp_purchase_details.dis_amount,temp_purchase_details.mrp,temp_purchase_details.landing_cost,temp_purchase_details.selling_price,temp_purchase_details.tax_val,temp_purchase_details.frametype,temp_purchase_details.framecolor,temp_purchase_details.framesize,temp_purchase_details.framemodel,temp_purchase_details.quantity,temp_purchase_details.cost_price,temp_purchase_details.tot_amount,temp_purchase_details.mul_type,temp_purchase_details.gst_selection_ind,item_master.code,item_master.name,item_master.item_id,tax_master.name as taxval from  temp_purchase_details  inner join item_master  on  temp_purchase_details.item_id=item_master.item_id left join tax_master on item_master.tax=tax_master.tax_id  where  purchase_id=? and  item_master.office_id= ?";
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
           $this->db->insert('purchase',$purchase_entry);
           $purchase_id=$this->db->insert_id();
		   
		    $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
			
		     $sql = "select purchase_id  from temp_purchase where   login_id=$login_id";
          $result_row=$this->db->query($sql); 
          $res= $result_row->result_array ();

			 
			 $this->db->where('purchase_id',$res[0]['purchase_id']);
            $this->db->delete('temp_purchase');
            $this->db->where('purchase_id',$res[0]['purchase_id']);
            $this->db->delete('temp_purchase_details');
			
           
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
           $mul_types=$purchaseentry_details['mul_type'];
           $frametypes=$purchaseentry_details['frametype'];
           $framecolors=$purchaseentry_details['framecolor'];
           $framesizes=$purchaseentry_details['framesize'];
           $framemodels=$purchaseentry_details['framemodel'];
           $mulframetypes=$purchaseentry_details['mulframetype'];
           $mulframecolors=$purchaseentry_details['mulframecolor'];
           $mulframesizes=$purchaseentry_details['mulframesize'];
           $mulframemodels=$purchaseentry_details['mulframemodel'];
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
               $this->db->insert('purchase_details',array(
                                                          "purchase_id"=>$purchase_id,
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
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel
                                                          )
                                    );
               $purchase_details_id=$this->db->insert_id();
               $qty=$quantitys[$i];
                if($mul_types[$i]==1)
                {
                	if($frametypes[$i]>0 || $framecolors[$i]>0 || $framesizes[$i]>0 || $framemodels[$i]!='')
                    {
                    	 $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$frametypes[$i]."' and frame_color='".$framecolors[$i]."'and frame_size='".$framesizes[$i]."' and frame_model='".$framemodels[$i]."'  and office_id=$office_id");
                                  $qty=$quantitys[$i];
                                  if($qry->num_rows()>0)
                                    {
                                        $stock_id=$qry->row()->stock_id;
                                        $this->db->query("update stock set quantity=quantity+$qty  where stock_id=$stock_id and office_id=$office_id");
                                    }
                                    else
                                    {
                                        $this->db->insert('stock',array(
                                        	"item_id"=>$item_id,
                                        	"selling_price"=>$selling_prices[$i],
                                        	"mrp"=>$mrps[$i],
                                        	"quantity"=>$qty,
                                        	"frame_type"=>$frametypes[$i],
	                                        "frame_color"=>$framecolors[$i],
	                                        "frame_size"=>$framesizes[$i],
	                                        "frame_model"=>$framemodels[$i],
                                        	"office_id"=>$office_id,
                                        	"login_id"=>$login_id
                                         ));
                                       
                                    }
                                    $y=1;
                     while($y <= $qty)  //barocode insert
	                {
	                	$last_barcode_number=$this->db->select('max(barcode) as last_barcode_number')
	                         ->from('stock_barcode')
	                         ->where(array('office_id'=>$this->session->office_id))
	                         ->get()->row()->last_barcode_number;
		                if($last_barcode_number>0)
		                {
		                    $last_barcode=$last_barcode_number+1;
		                } else {
		                    $last_barcode= '10000';
		                }
		                $barcode=$last_barcode;
		                
				        $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$frametypes[$i]."' and frame_color='".$framecolors[$i]."'and frame_size='".$framesizes[$i]."' and frame_model='".$framemodels[$i]."'  and office_id=$office_id");
		                      $qty=$quantitys[$i];
		                      if($qry->num_rows()>0)
		                        {
		                            $stock_id=$qry->row()->stock_id;
		                        }
				                $this->db->insert('stock_barcode',array(
			                                        	"barcode"=>$barcode,
			                                        	"stock_id"=>$stock_id,
			                                        	"quantity"=>1,
			                                        	"purchase_details_id"=>$purchase_details_id,
			                                        	"office_id"=>$office_id,
			                                        	"login_id"=>$login_id
			                                         ));
				                $y++;
			                }
                    }
                }
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
                    	if($mulframetype[$b]>0 || $mulframecolor[$b]>0 || $mulframesize[$b]>0 || $mulframemodel[$b]!='')
                        {
                        	     $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$mulframetype[$b]."' and frame_color='".$mulframecolor[$b]."'and frame_model='".$mulframemodel[$b]."' and frame_size='".$mulframesize[$b]."'  and office_id=$office_id");
                        	     
                                  $qty=$quantitys[$i];
                                  //echo $this->db->last_query();
                                  if($qry->num_rows()>0)
                                    {
                                         $stock_id=$qry->row()->stock_id;

                                        $this->db->query("update stock set quantity=quantity+1  where stock_id=$stock_id and office_id=$office_id");
                                        // echo $this->db->last_query();exit;
                                    }
                                    else
                                    {
                                        $this->db->insert('stock',array(
                                        	"item_id"=>$item_id,
                                        	"selling_price"=>$selling_prices[$i],
                                        	"mrp"=>$mrps[$i],
                                        	"quantity"=>1,
                                        	"frame_type"=>$mulframetype[$b],
	                                        "frame_color"=>$mulframecolor[$b],
	                                        "frame_size"=>$mulframesize[$b],
	                                        "frame_model"=>$mulframemodel[$b],
                                        	"office_id"=>$office_id,
                                        	"login_id"=>$login_id
                                         ));
                                       
                                    }
                        
                        }

                        $x++;
                        $b++;
                    }
                   // exit;

					 $y=1;
					 $b=0;
                     while($y <= $qty)  //barocode insert
	                {
	                	$last_barcode_number=$this->db->select('max(barcode) as last_barcode_number')
	                         ->from('stock_barcode')
	                         ->where(array('office_id'=>$this->session->office_id))
	                         ->get()->row()->last_barcode_number;
		                if($last_barcode_number>0)
		                {
		                    $last_barcode=$last_barcode_number+1;
		                } else {
		                    $last_barcode= '10000';
		                }
		                $barcode=$last_barcode;

		        $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$mulframetype[$b]."' and frame_color='".$mulframecolor[$b]."'and frame_model='".$mulframemodel[$b]."' and frame_size='".$mulframesize[$i]."'  and office_id=$office_id");
                      $qty=$quantitys[$i];
                      if($qry->num_rows()>0)
                        {
                            $stock_id=$qry->row()->stock_id;
                        }
		                $this->db->insert('stock_barcode',array(
	                                        	"barcode"=>$barcode,
	                                        	"stock_id"=>$stock_id,
	                                        	"quantity"=>1,
	                                        	"purchase_details_id"=>$purchase_details_id,
	                                        	"office_id"=>$office_id,
	                                        	"login_id"=>$login_id
	                                         ));
		                $y++;
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
		 public function temp_savedata($data)
        {
		//	print_r($data);exit;
           $this->db->trans_begin();
           $purchase_entry=$data['purchase_entry'];
		   
		    $this->db->where('purchase_id',$purchase_entry['purchase_order_id']);
            $this->db->delete('temp_purchase');
            $this->db->where('purchase_id',$purchase_entry['purchase_order_id']);
            $this->db->delete('temp_purchase_details');
			
           $this->db->insert('temp_purchase',$purchase_entry);
           $purchase_id=$this->db->insert_id();
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
           $mul_types=$purchaseentry_details['mul_type'];
           $frametypes=$purchaseentry_details['frametype'];
           $framecolors=$purchaseentry_details['framecolor'];
           $framesizes=$purchaseentry_details['framesize'];
           $framemodels=$purchaseentry_details['framemodel'];
           $mulframetypes=$purchaseentry_details['mulframetype'];
           $mulframecolors=$purchaseentry_details['mulframecolor'];
           $mulframesizes=$purchaseentry_details['mulframesize'];
           $mulframemodels=$purchaseentry_details['mulframemodel'];
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
               $this->db->insert('temp_purchase_details',array(
                                                          "purchase_id"=>$purchase_id,
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
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel
                                                          )
                                    );
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
      0 =>'purchase_id'
    );
 
    $this->db->select('purchase_id');//s.photo_no,s.photo_name'
    $this->db->from('purchase');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT purchase_id,name,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date ,invoice_no,total_qty,total_amount";
    $sql.=" FROM  purchase inner join supplier on purchase.supplier_id=supplier.supplier_id  where purchase.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( purchase_date LIKE '%".$requestData['search']['value']."%' ";
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
			$purchase_id=$row[$i]['purchase_id'];
			

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
            $items=$this->db->get_where('purchase_details',"purchase_id=$id")->result();
           
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
                $mul_type=$item->mul_type;
                $frametype=$item->frametype;
                $framecolor=$item->framecolor;
                $framesize=$item->framesize;
                $framemodel=$item->framemodel;
                $purchase_details_id=$item->purchase_details_id;
                if($mul_type==1)
                {
                $this->db->query("update stock set quantity=quantity-$qty where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and frame_type='$frametype' and frame_color='$framecolor' and frame_size='$framesize' and frame_model='$framemodel' and office_id=$office_id ");
                }
                else
                {
                	$mulframetype=explode(',',$frametype);
                    $mulframecolor=explode(',',$framecolor);
                    $mulframesize=explode(',',$framesize);
                    $mulframemodel=explode(',',$framemodel);
                    $x = 1;
                    $b=0;
                     while($x <= $qty) 
                    {
                    	$this->db->query("update stock set quantity=quantity-1 where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and frame_type='".$mulframetype[$b]."' and frame_color='".$mulframecolor[$b]."'and frame_model='".$mulframemodel[$b]."' and frame_size='".$mulframesize[$b]."' and office_id=$office_id ");
                    	$x++;
                    	$b++;
                    }
                }
                $this->db->query("update stock_barcode set quantity=quantity-1 where  office_id=$office_id and quantity=1 and purchase_details_id='".$purchase_details_id."'");
                
            }
            $this->db->where('purchase_id',$id);
            $this->db->delete('purchase_details');
            
            
            
            
            $purchase=$data['purchase_entry'];
            $this->db->set($purchase);
            $this->db->where('purchase_id', $id);
            $this->db->update('purchase');
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
           $mul_types=$purchaseentry_details['mul_type'];
           $frametypes=$purchaseentry_details['frametype'];
           $framecolors=$purchaseentry_details['framecolor'];
           $framesizes=$purchaseentry_details['framesize'];
           $framemodels=$purchaseentry_details['framemodel'];
           $mulframetypes=$purchaseentry_details['mulframetype'];
           $mulframecolors=$purchaseentry_details['mulframecolor'];
           $mulframesizes=$purchaseentry_details['mulframesize'];
           $mulframemodels=$purchaseentry_details['mulframemodel'];
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
               $this->db->insert('purchase_details',array(
                                                          "purchase_id"=>$purchase_id,
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
                                                          "mul_type"=>$mul_types[$i],
                                                          "frametype"=>$frametype,
                                                          "framecolor"=>$framecolor,
                                                          "framesize"=>$framesize,
                                                          "framemodel"=>$framemodel
                                                          )
                                    );
               $purchase_details_id=$this->db->insert_id();
               $qty=$quantitys[$i];
                if($mul_types[$i]==1)
                {
                	if($frametypes[$i]>0 || $framecolors[$i]>0 || $framesizes[$i]>0 || $framemodels[$i]!='')
                    {
                    	 $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$frametypes[$i]."' and frame_color='".$framecolors[$i]."'and frame_size='".$framesizes[$i]."' and frame_model='".$framemodels[$i]."'  and office_id=$office_id");
                                  $qty=$quantitys[$i];
                                  if($qry->num_rows()>0)
                                    {
                                        $stock_id=$qry->row()->stock_id;
                                        $this->db->query("update stock set quantity=quantity+$qty  where stock_id=$stock_id and office_id=$office_id");
                                    }
                                    else
                                    {
                                        $this->db->insert('stock',array(
                                        	"item_id"=>$item_id,
                                        	"selling_price"=>$selling_prices[$i],
                                        	"mrp"=>$mrps[$i],
                                        	"quantity"=>$qty,
                                        	"frame_type"=>$frametypes[$i],
	                                        "frame_color"=>$framecolors[$i],
	                                        "frame_size"=>$framesizes[$i],
	                                        "frame_model"=>$framemodels[$i],
                                        	"office_id"=>$office_id,
                                        	"login_id"=>$login_id
                                         ));
                                       
                                    }
                                    $y=1;
                     while($y <= $qty)  //barocode insert
	                {
	                	$last_barcode_number=$this->db->select('max(barcode) as last_barcode_number')
	                         ->from('stock_barcode')
	                         ->where(array('office_id'=>$this->session->office_id))
	                         ->get()->row()->last_barcode_number;
		                if($last_barcode_number>0)
		                {
		                    $last_barcode=$last_barcode_number+1;
		                } else {
		                    $last_barcode= '10000';
		                }
		                $barcode=$last_barcode;
		                
				        $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$frametypes[$i]."' and frame_color='".$framecolors[$i]."'and frame_size='".$framesizes[$i]."' and frame_model='".$framemodels[$i]."'  and office_id=$office_id");
		                      $qty=$quantitys[$i];
		                      if($qry->num_rows()>0)
		                        {
		                            $stock_id=$qry->row()->stock_id;
		                        }
				                $this->db->insert('stock_barcode',array(
			                                        	"barcode"=>$barcode,
			                                        	"stock_id"=>$stock_id,
			                                        	"quantity"=>1,
			                                        	"purchase_details_id"=>$purchase_details_id,
			                                        	"office_id"=>$office_id,
			                                        	"login_id"=>$login_id
			                                         ));
				                $y++;
			                }
                    }
                }
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
                    	if($mulframetype[$b]>0 || $mulframecolor[$b]>0 || $mulframesize[$b]>0 || $mulframemodel[$b]!='')
                        {
                        	     $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$mulframetype[$b]."' and frame_color='".$mulframecolor[$b]."'and frame_model='".$mulframemodel[$b]."' and frame_size='".$mulframesize[$b]."'  and office_id=$office_id");
                        	     
                                  $qty=$quantitys[$i];
                                  //echo $this->db->last_query();
                                  if($qry->num_rows()>0)
                                    {
                                         $stock_id=$qry->row()->stock_id;

                                        $this->db->query("update stock set quantity=quantity+1  where stock_id=$stock_id and office_id=$office_id");
                                        // echo $this->db->last_query();exit;
                                    }
                                    else
                                    {
                                        $this->db->insert('stock',array(
                                        	"item_id"=>$item_id,
                                        	"selling_price"=>$selling_prices[$i],
                                        	"mrp"=>$mrps[$i],
                                        	"quantity"=>1,
                                        	"frame_type"=>$mulframetype[$b],
	                                        "frame_color"=>$mulframecolor[$b],
	                                        "frame_size"=>$mulframesize[$b],
	                                        "frame_model"=>$mulframemodel[$b],
                                        	"office_id"=>$office_id,
                                        	"login_id"=>$login_id
                                         ));
                                       
                                    }
                        
                        }

                        $x++;
                        $b++;
                    }
                   // exit;

					 $y=1;
					 $b=0;
                     while($y <= $qty)  //barocode insert
	                {
	                	$last_barcode_number=$this->db->select('max(barcode) as last_barcode_number')
	                         ->from('stock_barcode')
	                         ->where(array('office_id'=>$this->session->office_id))
	                         ->get()->row()->last_barcode_number;
		                if($last_barcode_number>0)
		                {
		                    $last_barcode=$last_barcode_number+1;
		                } else {
		                    $last_barcode= '10000';
		                }
		                $barcode=$last_barcode;

		        $qry=$this->db->get_where("stock","item_id=$item_id and selling_price='".$selling_prices[$i]."' and mrp='".$mrps[$i]."' and frame_type='".$mulframetype[$b]."' and frame_color='".$mulframecolor[$b]."'and frame_model='".$mulframemodel[$b]."' and frame_size='".$mulframesize[$i]."'  and office_id=$office_id");
                      $qty=$quantitys[$i];
                      if($qry->num_rows()>0)
                        {
                            $stock_id=$qry->row()->stock_id;
                        }
		                $this->db->insert('stock_barcode',array(
	                                        	"barcode"=>$barcode,
	                                        	"stock_id"=>$stock_id,
	                                        	"quantity"=>1,
	                                        	"purchase_details_id"=>$purchase_details_id,
	                                        	"office_id"=>$office_id,
	                                        	"login_id"=>$login_id
	                                         ));
		                $y++;
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
                    return TRUE;
            }
        }

        public function deletedata($id) 
        {
            $this->db->trans_begin();
            $office_id=$this->session->office_id;
            $items=$this->db->get_where('purchase_details',"purchase_id=$id")->result();
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
                $mul_type=$item->mul_type;
                $frametype=$item->frametype;
                $framecolor=$item->framecolor;
                $framesize=$item->framesize;
                $framemodel=$item->framemodel;
                $purchase_details_id=$item->purchase_details_id;
                if($mul_type==1)
                {
                $this->db->query("update stock set quantity=quantity-$qty where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and frame_type='$frametype' and frame_color='$framecolor' and frame_size='$framesize' and frame_model='$framemodel' and office_id=$office_id ");
                }
                else
                {
                	$mulframetype=explode(',',$frametype);
                    $mulframecolor=explode(',',$framecolor);
                    $mulframesize=explode(',',$framesize);
                    $mulframemodel=explode(',',$framemodel);
                    $x = 1;
                    $b=0;
                     while($x <= $qty) 
                    {
                    	$this->db->query("update stock set quantity=quantity-1 where item_id=$item_id and mrp='$mrp' and selling_price='$selling_price' and frame_type='".$mulframetype[$b]."' and frame_color='".$mulframecolor[$b]."'and frame_model='".$mulframemodel[$b]."' and frame_size='".$mulframesize[$b]."' and office_id=$office_id ");
                    	$x++;
                    	$b++;
                    }
                }
                $this->db->query("update stock_barcode set quantity=quantity-1 where  office_id=$office_id and quantity=1 and purchase_details_id='".$purchase_details_id."'");
                
            }
            $this->db->where('purchase_id',"$id");
            $this->db->delete('purchase_details');
            $this->db->where('purchase_id',"$id");
            $this->db->delete('purchase');
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