<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @25/01/2021
 */
class Sales_return_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}
   public function deletechecksalesreturn($var_array)
  {
      $sql = "select count(*) as cnt  from sales_return where   sales_return_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function Getmastertable($var_array)
  {
      $sql = "select *  from sales_return where  sales_return_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getallclassfication($var_array)
  {
      $sql = "select sales_return_details.sales_quantity,sales_return_details.orginal_rate,sales_return_details.tax_amount,sales_return_details.cgst,sales_return_details.sgst,sales_return_details.tax,sales_return_details.total_amount,sales_return_details.discount_input,sales_return_details.discount_value,sales_return_details.stock_id,sales_return_details.rate,stock.quantity as stock,sales_return_details.product_type,stock.stock_id,sales_return_details.item_id,sales_return_details.tax_type,tax_master.name as taxval,stock.frame_model as framemodel ,item_master.name as name,item_master.code,stock.mrp,stock.selling_price,sales_return_details.quantity,ftype.name as frametype,fcolor.name as framecolor,fsize.name as framesize  from sales_return_details inner join item_master on sales_return_details.item_id=item_master.item_id inner join stock on sales_return_details.stock_id=stock.stock_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id  where  sales_return_details.sales_return_id=? and sales_return_details.product_type=0";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
	public function savedata($data)
   { 
       $this->db->trans_begin();
       $office_id=$this->session->userdata('office_id');
       $login_id=$this->session->userdata('login_id');
       $sales_return=$data['sales_return'];
       $bill_setting_qry=$this->db->select('*')
                                              ->where(array('office_id'=>$this->session->office_id))
                                              ->get('bill_settings');
       $bill_setting=$bill_setting_qry->row();
       $last_invoice_number=$this->db->select('max(bill_number) as last_invoice_number')
                         ->from('sales_return')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_invoice_number;
                if($last_invoice_number>0)
                {
                    $invoice_number=$last_invoice_number+1;
                } else {
                    $invoice_number= 1;
                   
                }
	       $bill_number=$invoice_number;
	       
           $sales_return['bill_number']=$bill_number;
           
           $this->db->insert('sales_return',$sales_return);
           $sales_return_id=$this->db->insert_id();
           
           $sales_return_details=$data['sales_return_detail'];
           $product_types=$sales_return_details['product_type'];
           $product_ids=$sales_return_details['item_id'];
           $stock_ids=$sales_return_details['stock_id'];
           $sales_quantitys=$sales_return_details['sales_quantity'];
           $quantitys=$sales_return_details['quantity'];
           $rates=$sales_return_details['rate'];
           $orginal_rates=$sales_return_details['orginal_rate'];
           $discount_types=$sales_return_details['discount_type'];
           $discount_inputs=$sales_return_details['discount_input'];
           $discount_amounts=$sales_return_details['discount_amount'];
           $cgsts=$sales_return_details['cgst'];
           $sgsts=$sales_return_details['sgst'];
           $tax_types=$sales_return_details['tax_type'];
           $gsts=$sales_return_details['tax'];
           $tax_amounts=$sales_return_details['tax_amount'];
           $amounts=$sales_return_details['total_amount'];
           $i=0;
           foreach ($stock_ids as $stock_id) 
           {
               $this->db->insert('sales_return_details',array(
                                                      "sales_return_id"=>$sales_return_id,
                                                      "stock_id"=>$stock_id,
                                                      "product_type"=>$product_types[$i],
                                                      "item_id"=>$product_ids[$i],
                                                      "sales_quantity"=>$sales_quantitys[$i],
                                                      "quantity"=>$quantitys[$i],
                                                      "rate"=>$rates[$i],
                                                      "orginal_rate"=>$orginal_rates[$i],
                                                      "discount_type"=>$discount_types[$i],
                                                      "discount_input"=>$discount_inputs[$i],
                                                      "discount_value"=>$discount_amounts[$i],
                                                      "tax_type"=>$tax_types[$i],
                                                      "cgst"=>$cgsts[$i],
                                                      "sgst"=>$sgsts[$i],
                                                      "tax"=>$gsts[$i],
                                                      "tax_amount"=>$tax_amounts[$i],
                                                      "total_amount"=>$amounts[$i]
                                                          )
                                    );
               if($product_types[$i]==0)
               {
	               $qty=$quantitys[$i];
	               $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
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
      0 =>'sales_return_id'
    );
 
    $this->db->select('sales_return_id');//s.photo_no,s.photo_name'
    $this->db->from('sales_return');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT sales_return_id,name,DATE_FORMAT(sales_return_date,'%d/%m/%Y') AS sales_return_date ,sales_return.bill_number,sales_return.total_qty,sales_return.netamount";
    $sql.=" FROM  sales_return inner join sales_master on sales_return.sales_id=sales_master.sales_id inner join customer on sales_master.customer_id=customer.customer_id  where sales_return.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( sales_return_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR bill_number LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR netamount LIKE '".$requestData['search']['value']."%'  ";
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
			$sales_return_id=$row[$i]['sales_return_id'];
			
      

     



	     $edit="<button type='button'  onclick=\"editsalesreturn('$sales_return_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletesalesreturn('.$sales_return_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


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
        // if($row[$i]['status']==2)
        //   {
        //       $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
        //       $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
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

            $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $items=$this->db->get_where('sales_return_details',"sales_return_id=$id")->result();
            foreach ($items as $item)
            {
                $qty=$item->quantity;
                $stock_id=$item->stock_id;
                $this->db->query("update stock set quantity=quantity-$qty where stock_id=$stock_id");
            }
            $this->db->where('sales_return_id',$id);
            $this->db->delete('sales_return_details');
            $this->db->where('sales_return_id',$id);
            $sales_return=$data['sales_return'];
            $this->db->set($sales_return);
            $this->db->where('sales_return_id', $id);
            $this->db->update('sales_return');
            $sales_return_id=$id;
           $sales_return_details=$data['sales_return_detail'];
           $product_types=$sales_return_details['product_type'];
           $product_ids=$sales_return_details['item_id'];
           $stock_ids=$sales_return_details['stock_id'];
           $sales_quantitys=$sales_return_details['sales_quantity'];
           $quantitys=$sales_return_details['quantity'];
           $rates=$sales_return_details['rate'];
           $orginal_rates=$sales_return_details['orginal_rate'];
           $discount_types=$sales_return_details['discount_type'];
           $discount_inputs=$sales_return_details['discount_input'];
           $discount_amounts=$sales_return_details['discount_amount'];
           $cgsts=$sales_return_details['cgst'];
           $sgsts=$sales_return_details['sgst'];
           $tax_types=$sales_return_details['tax_type'];
           $gsts=$sales_return_details['tax'];
           $tax_amounts=$sales_return_details['tax_amount'];
           $amounts=$sales_return_details['total_amount'];
           $i=0;
           foreach ($stock_ids as $stock_id) 
           {
               $this->db->insert('sales_return_details',array(
                                                      "sales_return_id"=>$sales_return_id,
                                                      "stock_id"=>$stock_id,
                                                      "product_type"=>$product_types[$i],
                                                      "item_id"=>$product_ids[$i],
                                                      "sales_quantity"=>$sales_quantitys[$i],
                                                      "quantity"=>$quantitys[$i],
                                                      "rate"=>$rates[$i],
                                                      "orginal_rate"=>$orginal_rates[$i],
                                                      "discount_type"=>$discount_types[$i],
                                                      "discount_input"=>$discount_inputs[$i],
                                                      "discount_value"=>$discount_amounts[$i],
                                                      "tax_type"=>$tax_types[$i],
                                                      "cgst"=>$cgsts[$i],
                                                      "sgst"=>$sgsts[$i],
                                                      "tax"=>$gsts[$i],
                                                      "tax_amount"=>$tax_amounts[$i],
                                                      "total_amount"=>$amounts[$i]
                                                          )
                                    );
               if($product_types[$i]==0)
               {
	               $qty=$quantitys[$i];
	               $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
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
            $items=$this->db->get_where('sales_return_details',"sales_return_id=$id")->result();
           
            foreach ($items as $item)
            {
                $stock_id=$item->stock_id;
                $qty=$item->quantity;
                $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
            }
            $this->db->where('sales_return_id',"$id");
            $this->db->delete('sales_return_details');
            $this->db->where('sales_return_id',"$id");
            $this->db->delete('sales_return');
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