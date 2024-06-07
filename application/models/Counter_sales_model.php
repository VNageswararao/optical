<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @26/12/2020
 */
class Counter_sales_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
    error_reporting(0);
  }
  public function getopticaladvicedata($opdate,$opaddate2)
  {
    $whr='';
    if($opdate)
    {
       $whr=" and opticaladvice_date between '$opdate' and '$opaddate2'";
    }
      $this->emrdb = $this->load->database('emrdb', TRUE);
      $sql = "select patient_registration_id,mrdno,fname,lname,mobileno,address,DATE_FORMAT(opticaladvice_date,'%d/%m/%Y') AS opticaladvice_date from patient_registration where optical_advice=1 $whr order by opticaladvice_date DESC";
      $result_row=$this->emrdb->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getlastemrexaminationid($patid)
  {
      $this->emrdb = $this->load->database('emrdb', TRUE);
      $sql = "select examination_id from examination where patient_registration_id=$patid order by examination_id desc limit 1";
      $result_row=$this->emrdb->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function deletecheckCounter_salesentry($var_array)
  {
      $sql = "select count(*) as cnt  from counter_sales_master where   counter_sales_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getlastidcustomer($var_array)
  {
      $sql = "select customer_id  from customer where   office_id= ? order by customer_id DESC limit 1";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getmastertable($var_array)
  {
      $sql = "select *  from counter_sales_master where  counter_sales_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getbarcode($product,$officeid)
  {
      $sql = "select item_master.name as name  from stock_barcode inner join stock on stock.stock_id=stock_barcode.stock_id inner join item_master on item_master.item_id=stock.item_id where  barcode='$product' and  stock_barcode.office_id= '$officeid'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getframemodel($product,$officeid)
  {
      $pro=strtoupper($product);
      $sql = "select item_master.name as name  from stock inner join item_master on item_master.item_id=stock.item_id where  UPPER(frame_model)='$pro' and  stock.office_id= '$officeid'";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function Getstatusdata($status,$office_id)
  {
    $statuscon='';
    if($status>0)
    {
      $statuscon.='  and counter_sales_master.status='.$status;
    }
   

       $sql = "select *  from counter_sales_master inner join customer on counter_sales_master.customer_id=customer.customer_id where   counter_sales_master.office_id= $office_id   $statuscon";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getpaidamount($var_array)
  {
      $sql = "select sum(advanced_amount) as advanced_amount  from payment_details where  counter_sales_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function getcustomerCounter_salesdata($var_array)
  {
      $sql = "select counter_sales_id,name,mobile,invoice_number  from counter_sales_master inner join customer on counter_sales_master.customer_id=customer.customer_id where   counter_sales_master.office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function Getcustomerdataindsales($var_array)
  {
      $sql = "select *  from counter_sales_master  inner join customer on counter_sales_master.customer_id=customer.customer_id where   counter_sales_master.counter_sales_id= ? and counter_sales_master.office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getcustomerdataindsaless($var_array)
  {
      $sql = "select discount_amount,discount_percentage from counter_sales_master   where   counter_sales_master.counter_sales_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  
  public function getallclassfication($var_array)
  {
      $sql = "select counter_sales_details.orginal_rate,counter_sales_details.tax_amount,counter_sales_details.cgst,counter_sales_details.sgst,counter_sales_details.tax,counter_sales_details.total_amount,counter_sales_details.discount_input,counter_sales_details.discount_value,counter_sales_details.stock_id,counter_sales_details.rate,stock.quantity as stock,counter_sales_details.product_type,stock.stock_id,counter_sales_details.item_id,counter_sales_details.tax_type,tax_master.name as taxval,stock.frame_model as framemodel ,item_master.name as name,item_master.code,stock.mrp,stock.selling_price,counter_sales_details.quantity,ftype.name as frametype,fcolor.name as framecolor,fsize.name as framesize  from counter_sales_details inner join item_master on counter_sales_details.item_id=item_master.item_id inner join stock on counter_sales_details.stock_id=stock.stock_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id  where  counter_sales_details.counter_sales_id=? and counter_sales_details.product_type=0";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getCounter_salesSearchStock($product,$office_id)
  {
      $sql = "select stock.stock_id,item_master.item_id,gst_type,tax_master.name as taxval ,item_master.name as name,item_master.code,COALESCE(stock.mrp, 0) as mrp,COALESCE(stock.selling_price, 0) as selling_price,COALESCE(stock.quantity, 0) as quantity from item_master left join stock on item_master.item_id=stock.item_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id where   item_master.name like '%$product%'   and item_master.office_id= $office_id ";
      $result_row=$this->db->query($sql);
      $res= $result_row->result_array ();
      return $res;
  }
  public function getSalesSearchStock_framemodel($product,$framemodel,$office_id)
  {
      $framemodel=strtoupper($framemodel);
      $sql = "select stock.stock_id,stock.item_id,gst_type,tax_master.name as taxval,stock.frame_model as framemodel ,item_master.name as name,item_master.code,stock.mrp,stock.selling_price,stock.quantity,ftype.name as frametype,fcolor.name as framecolor,fsize.name as framesize  from item_master inner join stock on item_master.item_id=stock.item_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id where   item_master.name like '%$product%' and UPPER(stock.frame_model)='$framemodel' and stock.quantity>0 and stock.office_id= $office_id and item_master.office_id= $office_id group by stock.item_id,stock.mrp,stock.selling_price,frame_type,frame_color,framemodel,frame_size";
      $result_row=$this->db->query($sql);
      $res= $result_row->result_array ();
      return $res;
  }
  public function getSalesSearchStock_barcode($product,$barcode,$office_id)
  {
  

      $sql = "select stock.stock_id,stock.item_id,gst_type,tax_master.name as taxval,stock.frame_model as framemodel ,item_master.name as name,item_master.code,stock.mrp,stock.selling_price,stock.quantity,ftype.name as frametype,fcolor.name as framecolor,fsize.name as framesize  from item_master inner join stock on item_master.item_id=stock.item_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id 
      left join stock_barcode on stock.stock_id=stock_barcode.stock_id 
      where   item_master.name like '%$product%' and barcode='$barcode' and stock.quantity>0 and stock.office_id= $office_id and item_master.office_id= $office_id group by stock.item_id,stock.mrp,stock.selling_price,frame_type,frame_color,framemodel,frame_size";
      $result_row=$this->db->query($sql);
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getlenstable($var_lensarray)
  {
      $sql = "select counter_sales_details.product_type,counter_sales_details.tax_amount,counter_sales_details.cgst,counter_sales_details.sgst,counter_sales_details.tax,counter_sales_details.item_id,counter_sales_details.quantity,counter_sales_details.total_amount,counter_sales_details.discount_input,counter_sales_details.discount_value,counter_sales_details.stock_id,counter_sales_details.rate,counter_sales_details.orginal_rate,lens_master.code,lens_master.name,ltype.name as lens_type,lcoating.name as lens_coating,lens_master.purchase_amount,lens_master.lens_master_id,counter_sales_details.tax_type,tax_master.name as taxval from counter_sales_details inner join  lens_master on counter_sales_details.stock_id=lens_master.lens_master_id left join lens_classification ltype on lens_master.lens_type_id=ltype.lens_classification_id left join lens_classification lcoating on lens_master.lens_coating_id=lcoating.lens_classification_id left join tax_master on lens_master.tax=tax_master.tax_id where  counter_sales_details.counter_sales_id=?  and product_type=1";
      $result_row=$this->db->query($sql,$var_lensarray);
      $res= $result_row->result_array ();
      return $res;
  }
  public function getSalesSearchLens($product,$supplier_id,$office_id)
  {
        $ct='';
        $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
         if($host_tvm=='aby')
        {
          $ct=' and  lens_master.supplier_id='.$supplier_id;
        }
      $sql = "select lens_master.code,lens_master.name,ltype.name as lens_type,lcoating.name as lens_coating,lens_master.purchase_amount,lens_master.lens_master_id,gst_type,tax_master.name as taxval from lens_master left join lens_classification ltype on lens_master.lens_type_id=ltype.lens_classification_id left join lens_classification lcoating on lens_master.lens_coating_id=lcoating.lens_classification_id left join tax_master on lens_master.tax=tax_master.tax_id where lens_master.office_id=$office_id  and lens_master.name like '%$product%' $ct";
      $result_row=$this->db->query($sql);
      $res= $result_row->result_array ();
      return $res;
  }

  public function savedata($data)
   { 
       $this->db->trans_begin();
       $office_id=$this->session->userdata('office_id');
       $login_id=$this->session->userdata('login_id');
       $sale=$data['Counter_sales'];
       $sales_date=$sale['sales_date'];
       $customer_id=$sale['customer_id'];
       $modeofpay_id=$sale['modeofpay_id'];
       $advanced_amount=$sale['advanced_amount'];
       $balance_amount=$sale['balance_amount'];
       $netamount=$sale['netamount'];

       $cash=$sale['cash'];
       $card=$sale['card'];
       $paytm=$sale['paytm'];
       $others=$sale['others'];

       $bill_setting_qry=$this->db->select('*')
                                              ->where(array('office_id'=>$this->session->office_id))
                                              ->get('counter_bill_settings');
       $bill_setting=$bill_setting_qry->row();
       $last_invoice_number=$this->db->select('max(bill_number) as last_invoice_number')
                         ->from('counter_sales_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->last_invoice_number;
                if($last_invoice_number>0)
                {
                    $invoice_number=$last_invoice_number+1;
                } else {
                    $invoice_number= $bill_setting->starting_billno;
                   
                }
         $bill_number=$invoice_number;
         $invoice_number=$bill_setting->prefix.str_pad($invoice_number, strlen($bill_setting->padding),$bill_setting->padding,STR_PAD_LEFT);
          
           $sale['bill_number']=$bill_number;
           $sale['invoice_number']=$invoice_number;
           $this->db->insert('counter_sales_master',$sale);
           $counter_sales_id=$this->db->insert_id();

      
           
           $counter_sales_details=$data['Counter_sales_detail'];
           $product_types=$counter_sales_details['product_type'];
           $product_ids=$counter_sales_details['item_id'];
           $stock_ids=$counter_sales_details['stock_id'];
           $quantitys=$counter_sales_details['quantity'];
           $rates=$counter_sales_details['rate'];
           $orginal_rates=$counter_sales_details['orginal_rate'];
           $discount_types=$counter_sales_details['discount_type'];
           $discount_inputs=$counter_sales_details['discount_input'];
           $discount_amounts=$counter_sales_details['discount_amount'];
           $cgsts=$counter_sales_details['cgst'];
           $sgsts=$counter_sales_details['sgst'];
           $tax_types=$counter_sales_details['tax_type'];
           $gsts=$counter_sales_details['tax'];
           $tax_amounts=$counter_sales_details['tax_amount'];
           $amounts=$counter_sales_details['total_amount'];
           $i=0;
           foreach ($stock_ids as $stock_id) 
           {
               $this->db->insert('counter_sales_details',array(
                                                      "counter_sales_id"=>$counter_sales_id,
                                                      "stock_id"=>$stock_id,
                                                      "product_type"=>$product_types[$i],
                                                      "item_id"=>$product_ids[$i],
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
                    $this->session->set_flashdata('counter_sales_id',$counter_sales_id);
                    return TRUE;
            }
        }

          public function updatedata($data,$id)
        {

            $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $items=$this->db->get_where('counter_sales_details',array('counter_sales_id =' => $id))->result();
            foreach ($items as $item)
            {
                $qty=$item->quantity;
                $stock_id=$item->stock_id;
                $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
            }
            $this->db->where('counter_sales_id',$id);
            $this->db->delete('counter_sales_details');
          //  $this->db->where('counter_sales_id',$id);
          //  $this->db->delete('payment_details');
            $sale=$data['Counter_sales'];

            $sales_date=$sale['sales_date'];
            $customer_id=$sale['customer_id'];
            // $advanced_amount=$sale['advanced_amount'];
            // $balance_amount=$sale['balance_amount'];
            $modeofpay_id=$sale['modeofpay_id'];
            $netamount=$sale['netamount'];
            $this->db->set($sale);
            $this->db->where('counter_sales_id', $id);
            $this->db->update('counter_sales_master');
            $counter_sales_id=$id;

          
           $counter_sales_details=$data['Counter_sales_detail'];
           $product_types=$counter_sales_details['product_type'];
           $product_ids=$counter_sales_details['item_id'];
           $stock_ids=$counter_sales_details['stock_id'];
           $quantitys=$counter_sales_details['quantity'];
           $rates=$counter_sales_details['rate'];
           $orginal_rates=$counter_sales_details['orginal_rate'];
           $discount_types=$counter_sales_details['discount_type'];
           $discount_inputs=$counter_sales_details['discount_input'];
           $discount_amounts=$counter_sales_details['discount_amount'];
           $cgsts=$counter_sales_details['cgst'];
           $sgsts=$counter_sales_details['sgst'];
           $tax_types=$counter_sales_details['tax_type'];
           $gsts=$counter_sales_details['tax'];
           $tax_amounts=$counter_sales_details['tax_amount'];
           $amounts=$counter_sales_details['total_amount'];
           $i=0;
           foreach ($stock_ids as $stock_id) 
           {
               $this->db->insert('counter_sales_details',array(
                                                      "counter_sales_id"=>$counter_sales_id,
                                                      "stock_id"=>$stock_id,
                                                      "product_type"=>$product_types[$i],
                                                      "item_id"=>$product_ids[$i],
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

        public function updatereadutodelivery($counter_sales_id)
      {
         
          $result_row=$this->db->query("update counter_sales_master set status=3 where counter_sales_id=$counter_sales_id");
          if($result_row)
          {
            return true;
          }
          
      }


        public function getalldatafunction($counter_sales_id)
      {
          $sql = "select status  from counter_sales_master where   counter_sales_id=$counter_sales_id";
          $result_row=$this->db->query($sql); 
          $res= $result_row->result_array ();
          return $res;
      }

         public function deletedata($id) 
        {
            $this->db->trans_begin();
           // $items=$this->db->get_where('counter_sales_details',"counter_sales_id=$id")->result();
            $items=$this->db->get_where('counter_sales_details',array('counter_sales_id =' => $id,'product_type =' => '0'))->result();
            $status=1;
            $getsalesstatus=$this->getalldatafunction($id);
            if($getsalesstatus)
            {
              $status=$getsalesstatus[0]['status'];
            }
            foreach ($items as $item)
            {
                $stock_id=$item->stock_id;
                if($stock_id)
                {
                  $qty=$item->quantity;
                 
                    $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
                  
                }
                
            }
            $this->db->where('counter_sales_id',"$id");
            $this->db->delete('counter_sales_details');
           // $this->db->where('counter_sales_id',$id);
           // $this->db->delete('payment_details');
            $this->db->where('counter_sales_id',"$id");
            $this->db->delete('counter_sales_master');
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

        public function updatepaymentdata($counter_sales_id,$payamount,$status,$customer_id,$netamount,$mode_id,$disamt,$disper)
        {
            $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $this->db->query("update counter_sales_master set status=$status,discount_amount=".$disamt.",discount_percentage=".$disper." where counter_sales_id=$counter_sales_id");
            $balance_amount=$netamount-$payamount;
            $this->db->insert('payment_details',
                       array(
                        'counter_sales_id'=>$counter_sales_id,
                        'customer_id'=>$customer_id,
                        'payment_date'=>date('Y-m-d'),
                         'advanced_amount'=>$payamount,
                         'balanced_amount'=>$balance_amount,
                         'net_amount'=>$netamount,
                         'payment_time'=>date('H:i:s'),
                         'mode_id'=>$mode_id,
                         'login_id'=>$login_id,
                         'office_id'=>$office_id
                        ));
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
      0 =>'counter_sales_id'
    );
 
    $this->db->select('counter_sales_id');//s.photo_no,s.photo_name'
    $this->db->from('counter_sales_master');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT counter_sales_id,counter_sales_master.status,name,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount";
    $sql.=" FROM  counter_sales_master inner join customer on counter_sales_master.customer_id=customer.customer_id  where counter_sales_master.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( sales_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR counter_sales_master.customer_id in (select customer_id from customer  where name  LIKE '".$requestData['search']['value']."%' or mobile  LIKE '".$requestData['search']['value']."%' or mrd  LIKE '".$requestData['search']['value']."%' ) ";
        $sql.="  OR invoice_number LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR netamount LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR total_qty LIKE '".$requestData['search']['value']."%') ";
        $isFilterApply=1;
      }
 
 
      $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."  desc     LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
      $result1 = $this->db->query($sql);
      
      if($isFilterApply==1){
        $totalFiltered =  $result1->num_rows(); 
      }
// echo $sql;exit;
       // when there is a search parameter then we have to modify total number filtered rows as per search result.
      $row=$result1->result_array();

      for ($i=0; $i < count($row); $i++) {
      $counter_sales_id=$row[$i]['counter_sales_id'];
      
      

      $print='<button onclick="printsale('.$counter_sales_id.')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';



       $edit="<button type='button'  onclick=\"editsales('$counter_sales_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

        // $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

        $delete='<button onclick="deletesales('.$counter_sales_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


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

        if($row[$i]['status']==1)
        {
          $stt="<span class='text-danger' style='font-weight:bold;'>Inprogress</span>";
          $ready='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1" onclick="changereadytodelivery('.$counter_sales_id.')"><i class="la la-check"></i></button>';
        }
        elseif($row[$i]['status']==3)
        {
          $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stt="<span class='text-warning' style='font-weight:bold;'>Ready To Delivery</span>";
        }
        else
        {
          $stt="<span class='text-success' style='font-weight:bold;'>Delivered</span>";
          $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
        }

        // if(($this->auth->lock_up('sales_return',"counter_sales_id='$counter_sales_id'")) || $row[$i]['status']==2 )
        //   {
        //       $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
        //       $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
        //   }
        

     
        $row[$i]['slno']=$i+1;
        $row[$i]['statuss']=$stt;
        $row[$i]['ready']=$ready;
        $row[$i]['print']=$print;
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
  function examination_print_bill($examinationid,$chkcomplaintsout,$chkopthalmicsout,$chkmedicalout,$chkeyepartout,$addmedicinessout,$investigationchkout,$preliminary_exout,$vsisonreadingsout,$curspecout,$objectchkout,$arkkchkout,$manchkout,$specchkout,$conlchkout,$pmtchkout,$office_id)
  {
    $this->emrdb = $this->load->database('emrdb', TRUE);
    $data['logo'] = "";
    $office=$this->db->get_where('office',"office_id=$office_id")->row();
    $data['logo']=($office->logo=='')?'':"<img style='width:10%;max-height:100px' src='". base_url('images/profile/')."$office->logo'>";
    $data['company_name']=$office->printable_company_name;
    $data['company_address']=$office->printable_company_address;
    $data['company_mobile']=$office->printable_company_mobile;
    $data['company_land_phone']=$office->printable_company_phone;
    $data['company_email']=$office->printable_emailid;
    $data['company_gst']=$office->license_no;
    $data['print_declaration']=$office->declaration;
    $data['gstin_no']=$office->gstin_no;
    $examination_masters=$this->emrdb->get_where('examination',"examination_id=$examinationid")->row();
    $data['doctorname']=$this->emrdb->get_where('doctors_registration',"doctors_registration_id=$examination_masters->doctor_id")->row()->name;
    $patient_details=$this->emrdb->get_where('patient_registration',"patient_registration_id=$examination_masters->patient_registration_id")->row();
    $data['fname']=$patient_details->fname; 
    $data['lname']=$patient_details->lname; 
    $data['mrdno']=$patient_details->mrdno; 
    $data['address']=$patient_details->address; 
    $data['mobileno']=$patient_details->mobileno; 
    
    if($patient_details->gender==1)
    {
      $age='Male';
    }
    elseif($patient_details->gender==2)
    {
      $age="Female";
    }
    else
    {
      $age='Transgender';
    }
    $data['gender']=$age; 
    $data['ageyy']=$patient_details->ageyy; 
    $data['agemm']=$patient_details->agemm; 
    $title_id=$patient_details->title; 
    $data['titlename']=$this->emrdb->get_where('patient_title',"patient_title_id=$title_id")->row()->name;
    $data['current_meditation']=$examination_masters->current_meditation;
    $data['family_history']=$examination_masters->family_history;
    $data['drug_history']=$examination_masters->drug_history;
    $data['cur1']=$examination_masters->cur1;
    $data['cur2']=$examination_masters->cur2;
    $data['cur3']=$examination_masters->cur3;
    $data['cur4']=$examination_masters->cur4;
    $data['cur5']=$examination_masters->cur5;
    $data['cur6']=$examination_masters->cur6;
    $data['cur7']=$examination_masters->cur7;
    $data['cur8']=$examination_masters->cur8;
    $data['cur9']=$examination_masters->cur9;
    $data['cur10']=$examination_masters->cur10;
    $data['cur11']=$examination_masters->cur11;
    $data['cur12']=$examination_masters->cur12;
    $data['cur13']=$examination_masters->cur13;
    $data['cur14']=$examination_masters->cur14;
    $data['cur15']=$examination_masters->cur15;
    $data['cur16']=$examination_masters->cur16;
    $data['vis1']=$examination_masters->vis1;
    $data['vis2']=$examination_masters->vis2;
    $data['vis3']=$examination_masters->vis3;
    $data['vis4']=$examination_masters->vis4;
    $data['vis5']=$examination_masters->vis5;
    $data['vis6']=$examination_masters->vis6;
    $data['vis7']=$examination_masters->vis7;
    $data['vis8']=$examination_masters->vis8;
    $data['vis9']=$examination_masters->vis9;
    $data['vis10']=$examination_masters->vis10;
    $data['ar1']=$examination_masters->ar1;
    $data['ar2']=$examination_masters->ar2;
    $data['ar3']=$examination_masters->ar3;
    $data['ar4']=$examination_masters->ar4;
    $data['ar5']=$examination_masters->ar5;
    $data['ar6']=$examination_masters->ar6;
    $data['ar7']=$examination_masters->ar7;
    $data['ar8']=$examination_masters->ar8;
    $data['ar9']=$examination_masters->ar9;
    $data['ar10']=$examination_masters->ar10;
    $data['man1']=$examination_masters->man1;
    $data['man2']=$examination_masters->man2;
    $data['man3']=$examination_masters->man3;
    $data['man4']=$examination_masters->man4;
    $data['man5']=$examination_masters->man5;
    $data['man6']=$examination_masters->man6;
    $data['man7']=$examination_masters->man7;
    $data['man8']=$examination_masters->man8;
    $data['man9']=$examination_masters->man9;
    $data['man10']=$examination_masters->man10;
    $data['spe1']=$examination_masters->spe1;
    $data['spe2']=$examination_masters->spe2;
    $data['spe3']=$examination_masters->spe3;
    $data['spe4']=$examination_masters->spe4;
    $data['spe5']=$examination_masters->spe5;
    $data['spe6']=$examination_masters->spe6;
    $data['spe7']=$examination_masters->spe7;
    $data['spe8']=$examination_masters->spe8;
    $data['spe9']=$examination_masters->spe9;
    $data['spe10']=$examination_masters->spe10;
    $data['spe11']=$examination_masters->spe11;
    $data['spe12']=$examination_masters->spe12;
    $data['spe13']=$examination_masters->spe13;
    $data['spe14']=$examination_masters->spe14;
    $data['spe15']=$examination_masters->spe15;
    $data['spe16']=$examination_masters->spe16;
    $data['con1']=$examination_masters->con1;
    $data['con2']=$examination_masters->con2;
    $data['con3']=$examination_masters->con3;
    $data['con4']=$examination_masters->con4;
    $data['con5']=$examination_masters->con5;
    $data['con6']=$examination_masters->con6;
    $data['con7']=$examination_masters->con7;
    $data['con8']=$examination_masters->con8;
    $data['con9']=$examination_masters->con9;
    $data['con10']=$examination_masters->con10;
    $data['con11']=$examination_masters->con11;
    $data['con12']=$examination_masters->con12;
    $data['con13']=$examination_masters->con13;
    $data['con14']=$examination_masters->con14;
    $data['con15']=$examination_masters->con15;
    $data['con16']=$examination_masters->con16;
    $data['pmt1']=$examination_masters->pmt1;
    $data['pmt2']=$examination_masters->pmt2;
    $data['pmt3']=$examination_masters->pmt3;
    $data['pmt4']=$examination_masters->pmt4;
    $data['pmt5']=$examination_masters->pmt5;
    $data['pmt6']=$examination_masters->pmt6;
    $data['pmt7']=$examination_masters->pmt7;
    $data['pmt8']=$examination_masters->pmt8;
    $data['pmt9']=$examination_masters->pmt9;
    $data['pmt10']=$examination_masters->pmt10;
    $data['pmt11']=$examination_masters->pmt11;
    $data['pmt12']=$examination_masters->pmt12;
    $data['pmt13']=$examination_masters->pmt13;
    $data['pmt14']=$examination_masters->pmt14;
    $data['pmt15']=$examination_masters->pmt15;
    $data['pmt16']=$examination_masters->pmt16;


    $showdata='<table  width="100%" style="line-height:10px;margin-top:0px;font-size: 14;"> 
    <tr>
         <td style="text-align: left;" class="tabledivideleft">Date:</td>
         <td style="text-align: left;" class="tabledivideright">'.$this->date->dateSql2View($examination_masters->examination_date).'</td> 
    </tr>';

    if($chkcomplaintsout=='true')
    {
        
        $complaints=$this->db->query("select * from examination_complaints inner join complaints on examination_complaints.complaints_id=complaints.complaints_id where examination_id=$examination_masters->examination_id")->result(); 
         if($complaints){
        $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Presenting Complaint:</td>
                     <td style="text-align: left;" class="tabledivideright">';
                          if($complaints){ foreach($complaints as $comp){
                              $lefteye='';
                              $righteye='';
                               if($comp->eye_left==1)
                              {
                                 $lefteye='<b>Left Eye</b>'.$comp->remarks;
                              }
                              if($comp->eye_right==1)
                              {
                                 $righteye='<b>Right Eye</b>'.$comp->remarks;
                              }
                           $showdata.='<span>'.$comp->name.'   '.$lefteye.'  '.$righteye.'<br/>

                          </span>';  
                      } }
                     $showdata.='</td> 
                </tr>';
            }

    }

    if($chkopthalmicsout=='true')
    {
       $ophthalmic_history=$this->db->query("select * from examination_ophthalmic_history inner join ophthalmic_history on examination_ophthalmic_history.ophthalmic_history_id=ophthalmic_history.ophthalmic_history_id where examination_id=$examination_masters->examination_id")->result(); 
if($ophthalmic_history){ 
        $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Ophthalmic History:</td>
                     <td style="text-align: left;" class="tabledivideright">';
                          if($ophthalmic_history){ foreach($ophthalmic_history as $opth){
                              $lefteye='';
                              $righteye='';
                               if($opth->eye_left==1)
                              {
                                 $lefteye='<b>Left Eye</b>'.$opth->remarks;
                              }
                              if($opth->eye_right==1)
                              {
                                 $righteye='<b>Right Eye</b>'.$opth->remarks;
                              }
                           $showdata.='<span>'.$opth->name.'   '.$lefteye.'  '.$righteye.'<br/>

                          </span>';  
                      } }
                     $showdata.='</td> 
                </tr>';
            }

    }

      if($chkmedicalout=='true')
    {
        $medical_history=$this->db->query("select * from examination_medical_history inner join medical_history on examination_medical_history.medical_history_id=medical_history.medical_history_id where examination_id=$examination_masters->examination_id")->result(); 
        if($medical_history){
        $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Medical History:</td>
                     <td style="text-align: left;" class="tabledivideright">';
                          if($medical_history){ foreach($medical_history as $medi){
                           $showdata.='<span>'.$medi->name.'<br/>
                          </span>';  
                      } }
                     $showdata.='</td> 
                </tr>';
            }
    }

    if($chkeyepartout=='true')
    {
         $eye_comp=$this->db->query("select * from examination_eye inner join eye_complaints on eye_complaints.eye_complaints_id=examination_eye.eye_complaints_id where examination_id=$examination_masters->examination_id")->result(); 
         if($eye_comp){
        $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Eye Details:</td>
                     <td style="text-align: left;" class="tabledivideright">
                           
                               <table width="100%" style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
                                <thead>
                                   <tr>
                                     <th>Right Eye</th>
                                     <th>Particulars</th>
                                     <th>Left Eye</th>
                                  </tr>
                                  </thead>
                                  <tbody id="showdataeyecomp">';
                                   foreach ($eye_comp as $datab) { 
                              $showdata.='<tr>
                                          <td>'.$datab->righteye.'</td>
                                          <td>'.$datab->name.'</td>
                                          <td>'.$datab->lefteye.'</td>
                                      </tr>';
                                    } 
                                $showdata.='</tbody></table>
                                  </td> 
                           
                      </tr>';
            }
    }

    if($addmedicinessout=='true')
    {
          $var_array=array($examination_masters->examination_id,$this->session->userdata('office_id'));
          $getdoctorprescription=$this->getdoctormedicinemodels($var_array);
         
         if($getdoctorprescription)
         {
         
          $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Medicine Details:</td>
                     <td style="text-align: left;" class="tabledivideright">
<br/>
                     <table  style="width:100%;margin-top:25px;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1"><thead><tr><th style="width:5%;">SL NO</th style="width:10%;"><th style="width:20%;">Drug Name</th><th style="width:20%;">Instruction</th><th style="width:20%;">No Of Days</th><th style="width:20%;">Qty</th><th style="width:5%;">Eye</th></tr></thead><tbody>';
           $sgl=0;
           foreach($getdoctorprescription as $datame)
           {
              $sgl++;
              $showdata.='<tr><td>'.$sgl.'</td><td>'.$datame['drugname'].'</td><td>'.$datame['instruction'].'</td><td>'.$datame['nodays'].'</td><td>'.$datame['qty'].'</td><td>'.$datame['med_eye'].'</td></tr>';
           }
            $showdata.='</tbody></table></td></tr>';
         }
    }

     if($investigationchkout=='true')
    {
          $var_array=array($examination_masters->examination_id);
          $Getdetailstableex=$this->Getdetailstable($var_array);
         
         if($Getdetailstableex)
         {
         
          $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Investigation Details:</td>
                     <td style="text-align: left;" class="tabledivideright">

                     <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1"><thead><tr><th>Particulars</th><th>Rate</th></tr></thead><tbody>';
           $sl=1;
            $this->load->model('Common_model');
           foreach($Getdetailstableex as $datai)
           {
              $getparticularname=$this->Common_model->getparticularsmodel($datai['charge_id'],$datai['particulars_id'],$this->session->userdata('office_id'));

               $showdata.='<tr>
                    <td>'.$getparticularname[0]['name'].'</td>
                    <td>'.$datai['rate'].'</td>
               </tr>';
               $sl++;

           }
            $showdata.='</tbody></table></td></tr>';
         }
    }

    if($preliminary_exout=='true')
    {
               $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Preliminary  Examination:</td>
                     <td style="text-align: left;" class="tabledivideright">
                        <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                      <tbody><tr>
                                          <th>Date</th>
                                          <th class="tab_tit">NCT</th>
                                          <th class="tab_tit">GAT</th>
                                          <th class="tab_tit">CCT</th>
                                          <th class="tab_tit">Angle</th>
                                          <th class="tab_tit">Color Vision</th>
                                          <th class="tab_tit">Pupil</th>
                                      </tr>
                                       <tr>
                                          <td class="tab_tit">Right Eye</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre1.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre2.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre3.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre4.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre5.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre6.'</td>
                                      </tr>
                                       <tr>
                                          <td class="tab_tit">Left Eye</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre7.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre8.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre9.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre10.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre11.'</td>
                                          <td style="padding:5px;" align="center">'.$examination_masters->pre12.'</td>
                                      </tr>
                                  </tbody></table>
                                  </td>
                                  </tr>';
    }

     if($vsisonreadingsout=='true')
    {
               $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Vision Readings:</td>
                     <td style="text-align: left;" class="tabledivideright">
                        <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                                <tbody><tr>
                                                  <th></th>
                                                  <th colspan="2" align="center">UCVA</th>
                                                  <th>PH</th>
                                                  <th colspan="2" align="center">BCVA</th>
                                                </tr>
                                                <tr>
                                                  <td></td>
                                                  <td>UCDVA</td>
                                                  <td>UCNVA</td>
                                                  <td>PH</td>
                                                  <td>UCDVA</td>
                                                  <td>UCNVA</td>
                                                </tr>
                                                 <tr>
                                                    <td>Right Eye</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis1.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis2.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis3.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis4.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis5.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Left Eye</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis6.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis7.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis8.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis9.'</td>
                                                    <td style="padding:5px;" align="center">'.$examination_masters->vis10.'</td>
                                                </tr>
                                            </tbody></table>
                                  </td>
                                  </tr>';
    }


        if($curspecout=='true')
    {
               $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Current Spectacle Prescription:</td>
                     <td style="text-align: left;" class="tabledivideright">
                        <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                              <tbody><tr>
                                  <th align="center" class="tab_tit">RE</th>
                                  <th align="center" class="tab_tit">LE</th>
                              </tr>
                              <tr>
                                  <td style="padding: 0px;">
                                     <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                          <tbody><tr>
                                              <td>
                                              </td><td class="tab_tit">SPH</td>
                                              <td class="tab_tit">CYL</td>
                                              <td class="tab_tit">AXIS</td>
                                              <td class="tab_tit">V/A</td>
                                          </tr>
                                           <tr>
                                              <td class="tab_tit">D.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur1.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur2.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur3.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur4.'</td>
                                          </tr>
                                           <tr>
                                              <td class="tab_tit">N.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur5.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur6.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur7.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur8.'</td>
                                          </tr>
                                      </tbody></table>
                                  </td>
                                  <td style="padding: 0px;">
                                     <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                          <tbody><tr>
                                              <td class="tab_tit">SPH</td>
                                              <td class="tab_tit">CYL</td>
                                              <td class="tab_tit">AXIS</td>
                                              <td class="tab_tit">V/A</td>
                                          </tr>
                                          <tr>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur9.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur10.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur11.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur12.'</td>
                                          </tr>
                                          <tr>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur13.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur14.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur15.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->cur16.'</td>
                                          </tr>
                                      </tbody></table>
                                  </td>
                              </tr>
                          </tbody></table>
                                  </td>
                                  </tr>';
    }
   
        if($objectchkout=='true')
    {
               $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top"> Objective Refraction:</td>
                     <td style="text-align: left;" class="tabledivideright">
                               <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                                <tbody><tr>
                                                  <th>UD</th>
                                                  <th>SPH</th>
                                                  <th>CYL</th>
                                                  <th>AXIS</th>
                                                  <th>CP</th>
                                                  <th>SPH</th>
                                                  <th>CYL</th>
                                                  <th>AXIS</th>
                                                </tr>
                                                <tr>
                                                   <td>RE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj1.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj2.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj3.'</td>
                                                   <td >RE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj4.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj5.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj6.'</td>
                                                </tr>
                                                 <tr>
                                                   <td>LE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj7.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj8.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj9.'</td>
                                                   <td >LE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj10.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj11.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->obj12.'</td>
                                                </tr>
                                                <tr>
                                                  <td>IPD</td>
                                                  <td style="padding:5px;" align="center">'.$examination_masters->obj13.'</td>
                                                  <td>PD RE</td>
                                                  <td style="padding:5px;" align="center">'.$examination_masters->obj14.'</td>
                                                  <td>PD LE</td>
                                                  <td style="padding:5px;" align="center">'.$examination_masters->obj15.'</td>
                                                </tr>
                                            </tbody></table>
                      </td>
                      </tr>';
    }

       if($arkkchkout=='true')
    {
               $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">AR Kerotometry:</td>
                     <td style="text-align: left;" class="tabledivideright">
                               <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                                <tbody><tr>
                                                  <th>ARK</th>
                                                  <th>K1</th>
                                                  <th>AXIS</th>
                                                  <th>K2</th>
                                                  <th>AXIS</th>
                                                  <th>CYL</th>
                                                  <th>AXIS</th>
                                                </tr>
                                                <tr>
                                                   <td>RE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar1.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar2.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar3.'</td>
                                                   <td>RE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar4.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar5.'</td>
                                                  
                                                </tr>
                                                 <tr>
                                                   <td>LE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar6.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar7.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar8.'</td>
                                                   <td>LE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar9.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->ar10.'</td>
                                                </tr>
                                            </tbody></table>
                      </td>
                      </tr>';
    }


     if($manchkout=='true')
    {
               $showdata.='<br/><tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Manual Kerotometry:</td>
                     <td style="text-align: left;" class="tabledivideright">
                               <table  style="width:100%;font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;border:0.6px solid black;" border="1">
                                                <tbody><tr>
                                                  <th>ARK</th>
                                                  <th>K1</th>
                                                  <th>AXIS</th>
                                                  <th>K2</th>
                                                  <th>AXIS</th>
                                                  <th>CYL</th>
                                                  <th>AXIS</th>
                                                </tr>
                                                <tr>
                                                   <td>RE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man1.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man2.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man3.'</td>
                                                   <td>RE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man4.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man5.'</td>
                                                  
                                                </tr>
                                                 <tr>
                                                   <td>LE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man6.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man7.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man8.'</td>
                                                   <td>LE</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man9.'</td>
                                                   <td style="padding:5px;" align="center">'.$examination_masters->man10.'</td>
                                                </tr>
                                            </tbody></table>
                      </td>
                      </tr>';
    }

$specchkout=true;
        if($specchkout=='true')
    {
               $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Spectacle Correction:</td>
                     <td style="text-align: left;" class="tabledivideright">
                            <table width="100%" style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="1">
                                          <tr>
                                              <th colspan="1"></th>
                                              <th colspan="4">RE</th>
                                              <th colspan="4">LE</th>
                                          </tr>
                                          <tr>
                                              <td></th>
                                              <td class="tab_tit">SPH</td>
                                              <td class="tab_tit">CYL</td>
                                              <td class="tab_tit">AXIS</td>
                                              <td class="tab_tit">V/A</td>
                                              <td class="tab_tit">SPH</td>
                                              <td class="tab_tit">CYL</td>
                                              <td class="tab_tit">AXIS</td>
                                              <td class="tab_tit">V/A</td>
                                          </tr>
                                           <tr>
                                              <td class="tab_tit">D.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe1.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe2.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe3.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe4.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe9.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe10.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe11.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe12.'</td>
                                          </tr>
                                           <tr>
                                              <td  class="tab_tit">N.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe5.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe6.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe7.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe8.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe13.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe14.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe15.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->spe16.'</td>
                                          </tr>
                                      </table>
                      </td>
                      </tr>';
    }

     if($conlchkout=='true')
    {
               $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Contact Lens Correction:</td>
                     <td style="text-align: left;" class="tabledivideright">
                            <table width="100%" style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="1">
                                          <tr>
                                              <th colspan="1"></th>
                                              <th colspan="4">RE</th>
                                              <th colspan="4">LE</th>
                                          </tr>
                                          <tr>
                                              <td></th>
                                              <td class="tab_tit">SPH</td>
                                              <td class="tab_tit">CYL</td>
                                              <td class="tab_tit">AXIS</td>
                                              <td class="tab_tit">V/A</td>
                                              <td class="tab_tit">SPH</td>
                                              <td class="tab_tit">CYL</td>
                                              <td class="tab_tit">AXIS</td>
                                              <td class="tab_tit">V/A</td>
                                          </tr>
                                           <tr>
                                              <td class="tab_tit">D.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con1.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con2.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con3.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con4.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con9.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con10.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con11.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con12.'</td>
                                          </tr>
                                           <tr>
                                              <td  class="tab_tit">N.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con5.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con6.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con7.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con8.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con13.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con14.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con15.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->con16.'</td>
                                          </tr>
                                      </table>
                      </td>
                      </tr>';
    }



$showdata.='</table>';

$data['conddata']=$showdata;




    $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    $printpage='examinationprint';
if($host_tvm=='arul')
{
    $html=$this->load->view("transaction/sales/$printpage",$data, true); 
                   $print_config=[
                                    'format' => 'A5-L',
                                    'margin_left' => 10,
                                    'margin_right' => 10,
                                    'margin_top' => 10,
                                    'margin_bottom' => 10,
                                    'margin_header' => 0,
                                    'margin_footer' => 0,
                                ];
}
else
{

    $html=$this->load->view("transaction/sales/$printpage",$data, true); 
                   $print_config=[
                                    'format' => 'A4',
                                    'margin_left' => 10,
                                    'margin_right' => 10,
                                    'margin_top' => 10,
                                    'margin_bottom' => 10,
                                    'margin_header' => 0,
                                    'margin_footer' => 0,
                                ];
}

            $mpdf = new \Mpdf\Mpdf($print_config);
            $pdfFilePath ="print-".time().".pdf"; 
            $labName=$company_name;
            $mpdf->SetWatermarkText($labName,0.03);
            $mpdf->showWatermarkText = true;
            $mpdf -> SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            if($supplier_id==''){
            $mpdf->Output();
            exit;
            }
            if($supplier_id>0)
            {
               $uploadpath = base_url() . 'salespdf/'.$pdfFilePath;
               $mpdf->Output('salespdf/invoice'.$pdfFilePath,'F');
            //$mpdf->Output('mpdf', "I");

            

        $supemail_id="";
        $subject=$company_name.' INVOICE BILL';
        $message = "Please Find Attachment";
        $qry=$this->db->get_where("supplier","supplier_id='$supplier_id'");
        $row=$qry->row();
        $supemail_id=$row->email_id; 
        if($supemail_id!='')
        {
                $config = array(
                                'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
                                'smtp_host' => 'smtp.argsolution.com', 
                                'smtp_port' => '587',
                                '_smtp_auth'=>TRUE,
                                'smtp_user' => 'mail@argsolution.com',
                                'smtp_pass' => 'INVOICE',
                                'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
                                'mailtype' => 'text', //plaintext 'text' mails or 'html'
                                'smtp_timeout' => '4', //in seconds
                                'charset' => 'iso-8859-1',
                                'wordwrap' => TRUE
                            );
            $this->load->library('email',$config);
            $this->email->set_newline("\r\n");
            $this->email->from('mail@argsolution.com');
            $this->email->to($supemail_id);
            $this->email->subject($subject);
            $this->email->message($message);
            $attachment_file = base_url() . 'salespdf/invoice'.$pdfFilePath;
            $this->email->attach($attachment_file);
            $this->email->send();
            $this->msg='Saved Successfully';

              $counter_sales_id=$this->db->select('max(counter_sales_id) as counter_sales_id')
                         ->from('counter_sales_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->counter_sales_id;
                if($counter_sales_id>0)
                {
                    $counter_sales_id=$counter_sales_id;
                } else {
                    $counter_sales_id= $counter_sales_id;
                }
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'counter_sales_id'=>$counter_sales_id,
                  'error_message' => $this->error_message
                ));
                  exit;
            }
            exit;
          }
  }

  function print_bill($counter_sales_id,$office_id,$supplier_id='')
  {
    $sales=$this->db->get_where('counter_sales_master',"counter_sales_id=$counter_sales_id")->row();
    $data['logo'] = "";
    $office_id=$sales->office_id;
    $office=$this->db->get_where('office',"office_id=$office_id")->row();
    $data['logo']=($office->logo=='')?'':"<img style='width:10%;max-height:100px' src='". base_url('images/profile/')."$office->logo'>";
    
    $data['company_name']=$office->printable_company_name;
    $data['company_address']=$office->printable_company_address;
    $data['company_mobile']=$office->printable_company_mobile;
    $data['company_land_phone']=$office->printable_company_phone;
    $data['company_email']=$office->printable_emailid;
    $data['company_gst']=$office->license_no;
    $data['print_declaration']=$office->declaration;
    $data['gstin_no']=$office->gstin_no;
    // $data['acc_holder_name']=$office->acc_holder_name;
    // $data['acc_no']=$office->acc_no;
    // $data['ifsc_code']=$office->ifsc_code;
    // $data['branch_name']=$office->branch_name;
    // $data['bank_name']=$office->bank_name;

    $customer=$this->db->get_where('customer',"customer_id in (select customer_id from counter_sales_master where counter_sales_id=$counter_sales_id)")->row();
    $data['customer_name']=$customer->name;
    $data['customer_address']=$customer->address;
    $data['customer_email']=$customer->email_id;
    $data['customer_land_phone']=$customer->mobile;
    $data['mrd']=$customer->mrd;

    $sales=$this->db->get_where('counter_sales_master',"counter_sales_id=$counter_sales_id")->row();
    $data['paying_amount']=$sales->advanced_amount;
    $data['balance_amount']=$sales->balance_amount;
    $data['sales']=$sales;

    $mode_id=$sales->modeofpay_id;
    $data['mode']=$this->db->get_where('modeofpay',"modeofpay_id=$mode_id")->row()->name;
    if($sales->supplier_id>0)
    {
     $data['suppliername']=$this->db->get_where('supplier',"supplier_id=$sales->supplier_id")->row()->name;
    }
    else
    {
      $data['suppliername']='';
    }

    $data['invoice_number']=$sales->invoice_number;
    $sdate=date_create($sales->sales_date);
    $data['sales_date']=date_format($sdate,"d/m/Y");

    $data['other_charge']=$sales->other_charge; 
    $data['description']=$sales->description; 
    $data['total_amount']=$sales->total_amount;
    $data['total_cgst']=$sales->total_cgst;
    $data['total_sgst']=$sales->total_sgst;
    $data['total_discount']=$sales->discount_amount;
    $data['total_gst']=$sales->total_cgst+$sales->total_sgst;
    $data['net_amount']=$sales->netamount;
    $data['net_amount_in_words']= $this->numberTowords($sales->netamount);
    $company_name=$office->printable_company_name;
    $data['round_off']= $sales->roundoff;
    $staff_id=$sales->staff_id;

    $data['staffname']=$this->db->get_where('staff',"staff_id=$staff_id")->row()->name;
   

 
     $this->load->model('Customer_model');
    $var_array=array($customer->customer_id,$this->session->userdata('office_id'));
    $getresult=$this->Customer_model->GetData($var_array);
    
    if($getresult[0]['resph1'])
    {
      $val=$getresult[0]['resph1'];
      $clr1='';
    }
    else
    {
      $val='.';
      $clr1="color:#fff;";

    }

    if($getresult[0]['resph2'])
    {
      $val2=$getresult[0]['resph2'];
       $clr2='';
    }
    else
    {
      $val2='.';
      $clr2="color:#fff;";
    }

    if($getresult[0]['resph3'])
    {
      $val3=$getresult[0]['resph3'];
      $clr3='';
    }
    else
    {
      $val3='.';
      $clr3="color:#fff;";
    }
    if($getresult[0]['resph4'])
    {
      $val4=$getresult[0]['resph4'];
      $clr4='';
    }
    else
    {
      $val4='.';
      $clr4="color:#fff;";
    }
    $data['customer_eye']=' <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="1">
                                        <tr>
                                            <td align="center" class="tab_tit">RE</td>
                                            <td align="center" class="tab_tit">LE</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px;">
                                                <table border="1" width="100%">
                                                    <tr style="padding: 0px;">
                                                        <td></td>
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">V/A</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="tab_tit" >D.V</td>
                                                        <td style="padding:5px;'.$clr1.'" align="center">'.$val.'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['recyl1'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reaxis1'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reva1'].'</td>
                                                    </tr>
                                                     <tr>
                                                        <td  class="tab_tit">N.V</td>
                                                        <td style="padding:5px;'.$clr2.'" align="center">'.$val2.'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['recyl2'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reaxis2'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reva2'].'</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="padding: 0px;">
                                                <table class="" border="1" width="100%">
                                                    <tr style="padding: 0px;">
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">V/A</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px;'.$clr3.'" align="center">'.$val3.'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['recyl3'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reaxis3'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reva3'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px;'.$clr4.'" align="center">'.$val4.'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['recyl4'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reaxis4'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reva4'].'</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>';
   $data['counter_sales_details']=$this->db->query("select counter_sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,item_master.name as itemname,(counter_sales_details.cgst+counter_sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from counter_sales_details
       left join stock on counter_sales_details.stock_id=stock.stock_id
        left join item_master on counter_sales_details.item_id=item_master.item_id and counter_sales_details.product_type=0
        left join lens_master on counter_sales_details.item_id=lens_master.lens_master_id and counter_sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where counter_sales_details.counter_sales_id=$counter_sales_id order by counter_sales_details.counter_sales_details_id ASC")->result();

   
error_reporting(0);

  

   $printpage='abyprint';


    $html=$this->load->view("transaction/counter/$printpage",$data, true); 
                   $print_config=[
                                    'format' => 'A4',
                                    'margin_left' => 10,
                                    'margin_right' => 10,
                                    'margin_top' => 10,
                                    'margin_bottom' => 10,
                                    'margin_header' => 0,
                                    'margin_footer' => 0,
                                ];


            $mpdf = new \Mpdf\Mpdf($print_config);
            $pdfFilePath ="print-".time().".pdf"; 
            $labName=$company_name;
            $mpdf->SetWatermarkText($labName,0.03);
            $mpdf->showWatermarkText = true;
            $mpdf -> SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
             $mpdf->Output();
            

            

     
           

          
           
            
           
          
  }

   

  function numberTowords($number)
{

    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . ' ' : '') . $paise. " Only";

}  

}