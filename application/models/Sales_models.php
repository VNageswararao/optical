<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @26/12/2020
 */
class Sales_models extends CI_Model{
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
  public function deletechecksalesentry($var_array)
  {
      $sql = "select count(*) as cnt  from sales_master where   sales_id=? and office_id= ?";
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
      $sql = "select *  from sales_master where  sales_id=? and office_id= ?";
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
      $statuscon.='  and sales_master.status='.$status;
    }
   

       $sql = "select *  from sales_master inner join customer on sales_master.customer_id=customer.customer_id where   sales_master.office_id= $office_id   $statuscon";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getpaidamount($var_array)
  {
      $sql = "select sum(advanced_amount) as advanced_amount  from payment_details where  sales_id=? and office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function getcustomersalesdata($var_array)
  {
      $sql = "select sales_id,name,mobile,invoice_number  from sales_master inner join customer on sales_master.customer_id=customer.customer_id where   sales_master.office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
   public function Getcustomerdataindsales($var_array)
  {
      $sql = "select *  from sales_master  inner join customer on sales_master.customer_id=customer.customer_id where   sales_master.sales_id= ? and sales_master.office_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function Getcustomerdataindsaless($var_array)
  {
      $sql = "select discount_amount,discount_percentage from sales_master   where   sales_master.sales_id= ?";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  
  public function getallclassfication($var_array)
  {
      $sql = "select sales_details.orginal_rate,sales_details.tax_amount,sales_details.cgst,sales_details.sgst,sales_details.tax,sales_details.total_amount,sales_details.discount_input,sales_details.discount_value,sales_details.stock_id,sales_details.rate,stock.quantity as stock,sales_details.product_type,stock.stock_id,sales_details.item_id,sales_details.tax_type,tax_master.name as taxval,stock.frame_model as framemodel ,item_master.name as name,item_master.code,stock.mrp,stock.selling_price,sales_details.quantity,ftype.name as frametype,fcolor.name as framecolor,fsize.name as framesize  from sales_details inner join item_master on sales_details.item_id=item_master.item_id inner join stock on sales_details.stock_id=stock.stock_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id  where  sales_details.sales_id=? and sales_details.product_type=0";
      $result_row=$this->db->query($sql, $var_array); 
      $res= $result_row->result_array ();
      return $res;
  }
  public function getSalesSearchStock($product,$office_id)
  {
      $sql = "select stock.stock_id,stock.item_id,gst_type,tax_master.name as taxval,stock.frame_model as framemodel ,item_master.name as name,item_master.code,stock.mrp,stock.selling_price,stock.quantity,ftype.name as frametype,fcolor.name as framecolor,fsize.name as framesize  from item_master inner join stock on item_master.item_id=stock.item_id left join frame_classification ftype on stock.frame_type=ftype.frame_id left join frame_classification fcolor on stock.frame_color=fcolor.frame_id  left join frame_classification fsize on stock.frame_size=fsize.frame_id left join tax_master on item_master.tax=tax_master.tax_id where   item_master.name like '%$product%' and stock.quantity>0 and stock.office_id= $office_id and item_master.office_id= $office_id group by stock.item_id,stock.mrp,stock.selling_price,frame_type,frame_color,framemodel,frame_size";
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
      $sql = "select sales_details.product_type,sales_details.tax_amount,sales_details.cgst,sales_details.sgst,sales_details.tax,sales_details.item_id,sales_details.quantity,sales_details.total_amount,sales_details.discount_input,sales_details.discount_value,sales_details.stock_id,sales_details.rate,sales_details.orginal_rate,lens_master.code,lens_master.name,ltype.name as lens_type,lcoating.name as lens_coating,lens_master.purchase_amount,lens_master.lens_master_id,sales_details.tax_type,tax_master.name as taxval from sales_details inner join  lens_master on sales_details.stock_id=lens_master.lens_master_id left join lens_classification ltype on lens_master.lens_type_id=ltype.lens_classification_id left join lens_classification lcoating on lens_master.lens_coating_id=lcoating.lens_classification_id left join tax_master on lens_master.tax=tax_master.tax_id where  sales_details.sales_id=?  and product_type=1";
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
       $sale=$data['sales'];
	  
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

       
      $sql_off = "select * from office limit 1";
      $result_rows=$this->db->query($sql_off); 
      $ress= $result_rows->result_array ();
       if($ress[0]['fin_year_settings']==1)
       {
            $fin_year=$ress[0]['fin_year'];
            $last_invoice_number=$this->db->select('max(bill_number) as last_invoice_number')
                         ->from('sales_master')
                         ->where(array('fin_year'=>$fin_year))
                         ->get()->row()->last_invoice_number;
            if($last_invoice_number>0){$invoice_number=$last_invoice_number;} else { $invoice_number= '0';}
           // Convert the starting bill number to integer
            $startBillNo = intval($last_invoice_number);

            // Increment the bill number
            $nextBillNo = $startBillNo + 1;

            // Format the bill number with leading zeros
            $newBillNo = sprintf('%04d', $nextBillNo);



          $billnocode='OJO';
          if($ress[0]['printable_company_code'])
          {
            $billnocode='';
            $billnocode.=$ress[0]['printable_company_code'];
          }
          if($ress[0]['apps_code'])
          {
            $billnocode.='-'.$ress[0]['apps_code'];
          }
          else
          {
            $billnocode.='-A';
          }

           $billnocodev=$billnocode.'-'.$newBillNo.'/'.$fin_year;
           $bill_number=$newBillNo;
           $invoice_number=$billnocodev;
       }
       else
       {
          $bill_setting_qry=$this->db->select('*')
                                              ->where(array('office_id'=>$this->session->office_id))
                                              ->get('bill_settings');
       $bill_setting=$bill_setting_qry->row();
       $last_invoice_number=$this->db->select('max(bill_number) as last_invoice_number')
                         ->from('sales_master')
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
         $fin_year='23-24';
       }



       
          
           $sale['bill_number']=$bill_number;
           $sale['invoice_number']=$invoice_number;
           $sale['fin_year']=$fin_year;

           $this->db->insert('sales_master',$sale);
		  
           $sales_id=$this->db->insert_id();

           $this->db->insert('payment_details',
                       array(
                        'sales_id'=>$sales_id,
                        'customer_id'=>$customer_id,
                        'payment_date'=>$sales_date,
                         'advanced_amount'=>$advanced_amount,
                         'balanced_amount'=>$balance_amount,
                         'net_amount'=>$netamount,
                         'cash'=>$cash,
                         'card'=>$card,
                         'paytm'=>$paytm,
                         'others'=>$others,
                         'payment_time'=>date('H:i:s'),
                         'mode_id'=>$modeofpay_id,
                         'login_id'=>$login_id,
                         'office_id'=>$office_id
                        ));
           
           $sales_details=$data['sales_detail'];
           $product_types=$sales_details['product_type'];
           $product_ids=$sales_details['item_id'];
           $stock_ids=$sales_details['stock_id'];
           $quantitys=$sales_details['quantity'];
           $rates=$sales_details['rate'];
           $orginal_rates=$sales_details['orginal_rate'];
           $discount_types=$sales_details['discount_type'];
           $discount_inputs=$sales_details['discount_input'];
           $discount_amounts=$sales_details['discount_amount'];
           $cgsts=$sales_details['cgst'];
           $sgsts=$sales_details['sgst'];
           $tax_types=$sales_details['tax_type'];
           $gsts=$sales_details['tax'];
           $tax_amounts=$sales_details['tax_amount'];
           $amounts=$sales_details['total_amount'];
           $i=0;
           foreach ($stock_ids as $stock_id) 
           {
               $this->db->insert('sales_details',array(
                                                      "sales_id"=>$sales_id,
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
                    $this->session->set_flashdata('sales_id',$sales_id);
                    return TRUE;
            }
        }

        function getCurrentFinancialYear() {
    // Get the current month and year
    $currentMonth = date('n');
    $currentYear = date('Y');

    // If the current month is January, the financial year starts from the current year
    // Otherwise, it starts from the previous year
    $startYear = $currentMonth == 1 ? $currentYear : $currentYear - 1;

    // The financial year ends on December 31st of the current year
    $endYear = $currentYear;

    // Format the financial year
    $startYearShort = substr($startYear, 2);
    $endYearShort = substr($endYear, 2);
    return $startYearShort . '-' . $endYearShort;
}

  public function updatedata($data,$id)
    {
             $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $items=$this->db->get_where('sales_details',array('sales_id =' => $id,'product_type =' => '0'))->result();
            foreach ($items as $item)
            {
                $qty=$item->quantity;
                $stock_id=$item->stock_id;
                $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
            }
            $this->db->where('sales_id',$id);
            $this->db->delete('sales_details');
            $this->db->where('sales_id',$id);
            $this->db->delete('payment_details');
            $sale=$data['sales'];
            $sales_date=$sale['sales_date'];
            $customer_id=$sale['customer_id'];
            $advanced_amount=$sale['advanced_amount'];
            $balance_amount=$sale['balance_amount'];
            $modeofpay_id=$sale['modeofpay_id'];
            $netamount=$sale['netamount'];
            $this->db->set($sale);
            $this->db->where('sales_id', $id);
            $this->db->update('sales_master');
            $sales_id=$id;

            $this->db->insert('payment_details',
                       array(
                        'sales_id'=>$sales_id,
                        'customer_id'=>$customer_id,
                        'payment_date'=>$sales_date,
                         'advanced_amount'=>$advanced_amount,
                         'balanced_amount'=>$balance_amount,
                         'net_amount'=>$netamount,
                         'payment_time'=>date('H:i:s'),
                         'mode_id'=>$modeofpay_id,
                         'login_id'=>$login_id,
                         'office_id'=>$office_id
                        ));
            
           $sales_details=$data['sales_detail'];
           $product_types=$sales_details['product_type'];
           $product_ids=$sales_details['item_id'];
           $stock_ids=$sales_details['stock_id'];
           $quantitys=$sales_details['quantity'];
           $rates=$sales_details['rate'];
           $orginal_rates=$sales_details['orginal_rate'];
           $discount_types=$sales_details['discount_type'];
           $discount_inputs=$sales_details['discount_input'];
           $discount_amounts=$sales_details['discount_amount'];
           $cgsts=$sales_details['cgst'];
           $sgsts=$sales_details['sgst'];
           $tax_types=$sales_details['tax_type'];
           $gsts=$sales_details['tax'];
           $tax_amounts=$sales_details['tax_amount'];
           $amounts=$sales_details['total_amount'];
           $i=0;
           foreach ($stock_ids as $stock_id) 
           {
               $this->db->insert('sales_details',array(
                                                      "sales_id"=>$sales_id,
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
		public function secoundupdatedata($data,$id)
        {
			print_r("secoundupdatedata");exit;
            $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
           
			$sale=$data['sales'];
            $sales_date=$sale['sales_date'];
            $customer_id=$sale['customer_id'];
            $modeofpay_id=$sale['modeofpay_id'];
            $expected_del_date=$sale['expected_del_date'];
            $staff_id=$sale['staff_id'];
            $sdescription=$sale['sdescription'];
            $status=$sale['status'];
            $credit_name=$sale['credit_name'];
            $emergency_order=$sale['emergency_order'];
            $supplier_id=$sale['supplier_id'];
           
			$update_data = [ 
						 'sales_date' => $sales_date,
						 'customer_id' => $customer_id,
						 'modeofpay_id' => $modeofpay_id,
						 'expected_del_date' => $expected_del_date,
						 'staff_id' => $staff_id,
						 'status' => $status,
						 'credit_name' => $credit_name,
						 'emergency_order' => $emergency_order,
						 'supplier_id' => $supplier_id,
						];	
		
            $this->db->set($update_data);
            $this->db->where('sales_id', $id);
            $this->db->update('sales_master');
           
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

        public function updatereadutodelivery($sales_id)
      {
         
          $result_row=$this->db->query("update sales_master set status=3 where sales_id=$sales_id");
          if($result_row)
          {
            return true;
          }
          
      }


        public function getalldatafunction($sales_id)
      {
          $sql = "select status  from sales_master where   sales_id=$sales_id";
          $result_row=$this->db->query($sql); 
          $res= $result_row->result_array ();
          return $res;
      }

         public function deletedata($id) 
        {
            $this->db->trans_begin();
           // $items=$this->db->get_where('sales_details',"sales_id=$id")->result();
            $items=$this->db->get_where('sales_details',array('sales_id =' => $id,'product_type =' => '0'))->result();
            $status=1;
            $getsalesstatus=$this->getalldatafunction($id);
            if($getsalesstatus)
            {
              $status=$getsalesstatus[0]['status'];
            }
            foreach ($items as $item)
            {
                $stock_id=$item->stock_id;
                $qty=$item->quantity;
                if($status==1)
                {
                  $this->db->query("update stock set quantity=quantity+$qty where stock_id=$stock_id");
                }
            }
            $this->db->where('sales_id',"$id");
            $this->db->delete('sales_details');
            $this->db->where('sales_id',$id);
            $this->db->delete('payment_details');
            $this->db->where('sales_id',"$id");
            $this->db->delete('sales_master');
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

        public function updatepaymentdata($sales_id,$payamount,$status,$customer_id,$netamount,$mode_id,$cash_bill,$card_bill,$paytm_bill,$disamt,$disper)
        {
            $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $this->db->query("update sales_master set status=$status,discount_amount=".$disamt.",discount_percentage=".$disper." where sales_id=$sales_id");
            $balance_amount=$netamount-$payamount;
            $this->db->insert('payment_details',
                       array(
                        'sales_id'=>$sales_id,
                        'customer_id'=>$customer_id,
                        'payment_date'=>date('Y-m-d'),
                         'advanced_amount'=>$payamount,
                         'balanced_amount'=>$balance_amount,
                         'net_amount'=>$netamount,
                         'payment_time'=>date('H:i:s'),
                         'mode_id'=>$mode_id,
                         'cash'=>$cash_bill,
                         'card'=>$card_bill,
                         'paytm'=>$paytm_bill,
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
		
	   public function sec_ad_updatepaymentdata($sales_id,$payamount,$status,$customer_id,$netamount,$mode_id,$cash_bill,$card_bill,$paytm_bill,$disamt,$disper)
        {
            $this->db->trans_begin();
            $office_id=$this->session->userdata('office_id');
            $login_id=$this->session->userdata('login_id');
            $this->db->query("update sales_master set discount_amount=".$disamt.",discount_percentage=".$disper." where sales_id=$sales_id");
            $balance_amount=$netamount-$payamount;
            $this->db->insert('payment_details',
                       array(
                        'sales_id'=>$sales_id,
                        'customer_id'=>$customer_id,
                        'payment_date'=>date('Y-m-d'),
                         'advanced_amount'=>$payamount,
                         'balanced_amount'=>$balance_amount,
                         'net_amount'=>$netamount,
                         'payment_time'=>date('H:i:s'),
                         'mode_id'=>$mode_id,
                         'cash'=>$cash_bill,
                         'card'=>$card_bill,
                         'paytm'=>$paytm_bill,
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
      0 =>'sales_id'
    );
 
    $this->db->select('sales_id');//s.photo_no,s.photo_name'
    $this->db->from('sales_master');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT sales_master.customer_id,sales_id,sales_master.status,name,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount";
    $sql.=" FROM  sales_master inner join customer on sales_master.customer_id=customer.customer_id  where sales_master.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( sales_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR sales_master.customer_id in (select customer_id from customer  where name  LIKE '".$requestData['search']['value']."%' or mobile  LIKE '".$requestData['search']['value']."%' or mrd  LIKE '".$requestData['search']['value']."%' ) ";
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
      $sales_id=$row[$i]['sales_id'];
      $customer_id=$row[$i]['customer_id'];
      
      

      $print='<button onclick="printsale('.$sales_id.')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';
      
		$edit="<button type='button'  onclick=\"editsales('$sales_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";
       $advance="<button type='button' onclick=\"secend_advance('$sales_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

        // $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

        $delete='<button onclick="deletesales('.$sales_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


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
         $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1" onclick="send_to_fitt('.$sales_id.')"><i class="la la-check"></i></button>';
        }
        elseif($row[$i]['status']==3)
        {
          $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stt="<span class='text-warning' style='font-weight:bold;'>Ready To Delivery</span>";
          
        }
		 elseif($row[$i]['status']==4)
        {
          
		  $ready='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1" onclick="changereadytodelivery('.$sales_id.')"><i class="la la-check"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stt="<span class='text-primary' style='font-weight:bold;'>Send To Fitting</span>";
          
        }
        else
        {
          $stt="<span class='text-success' style='font-weight:bold;'>Delivered</span>";
          $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
        }

        // if(($this->auth->lock_up('sales_return',"sales_id='$sales_id'")) || $row[$i]['status']==2 )
         if(($this->auth->lock_up('sales_return',"sales_id='$sales_id'")) || $row[$i]['status']==3 || $row[$i]['status']==4)
           {
               $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
              // $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
           }
        
 $of='<button type="button" class="btn btn-icon btn-info mr-1 mb-1" onclick="getorderform('.$sales_id.','.$customer_id.')"><i class="ft ft-clipboard"></i></button>';
     
        $row[$i]['slno']=$i+1;
        $row[$i]['statuss']=$stt;
        $row[$i]['advance']=$advance;
        $row[$i]['ready']=$ready;
        $row[$i]['stf']=$stf;
        $row[$i]['print']=$print;
        $row[$i]['edit']=$edit;
        $row[$i]['of']=$of;
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
  
     function emorder($requestData)
  {
	  
    $office_id=$this->session->office_id;
	$columns = array(
      0 =>'sales_id'
    );

	$query = "select * from sales_master where sales_master.emergency_order ='1' and office_id<='$office_id' and sales_master.status !='2'";
    $result = $this->db->query($query);
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

 
    $sql = "SELECT sales_id,sales_master.status,name,DATE_FORMAT(sales_date,'%d/%m/%Y') AS sales_date ,invoice_number,total_qty,netamount";
    $sql.=" FROM  sales_master inner join customer on sales_master.customer_id=customer.customer_id where sales_master.office_id=$office_id and sales_master.emergency_order ='1' and sales_master.status !='2'";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( sales_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR sales_master.customer_id in (select customer_id from customer  where name  LIKE '".$requestData['search']['value']."%' or mobile  LIKE '".$requestData['search']['value']."%' or mrd  LIKE '".$requestData['search']['value']."%' ) ";
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
      $sales_id=$row[$i]['sales_id'];

       $print='<button onclick="printsale('.$sales_id.')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';
      
		$edit="<button type='button'  onclick=\"editsales('$sales_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";
       $advance="<button type='button' onclick=\"secend_advance('$sales_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      
        $delete='<button onclick="deletesales('.$sales_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


        if($row[$i]['status']==1)
        {
          $stt="<span class='text-danger' style='font-weight:bold;'>Inprogress</span>";
         $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1" onclick="send_to_fitt('.$sales_id.')"><i class="la la-check"></i></button>';
        }
        elseif($row[$i]['status']==3)
        {
          $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stt="<span class='text-warning' style='font-weight:bold;'>Ready To Delivery</span>";
          
        }
		 elseif($row[$i]['status']==4)
        {
          
		  $ready='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1" onclick="changereadytodelivery('.$sales_id.')"><i class="la la-check"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stt="<span class='text-primary' style='font-weight:bold;'>Send To Fitting</span>";
          
        }
        else
        {
          $stt="<span class='text-success' style='font-weight:bold;'>Delivered</span>";
          $ready='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
          $stf='<button type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-lock"></i></button>';
        }

     
        $row[$i]['slno']=$i+1;
        $row[$i]['statuss']=$stt;
        $row[$i]['advance']=$advance;
        $row[$i]['ready']=$ready;
        $row[$i]['stf']=$stf;
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
  public function Get_Pat_Source($var_array)

    {
 $this->emrdb = $this->load->database('emrdb', TRUE);
        $sql = "select b.name as source from patient_appointment a inner join source b on a.source=b.source_id  where  patient_registration_id=$var_array order by patient_appointment_id desc limit 1";

        $result_row=$this->emrdb->query($sql); 

        $res= $result_row->result_array ();

        $this->logger->save($this->emrdb);

        return $res;

    }
    public function checkValid($array_val)
    {
    
      $new_arr = array_values($array_val);  
      $bool=true;
      foreach($new_arr as $k => $val) {
         if($val == "") 
             unset($new_arr[$k]);    
      }
     
     if(sizeof($new_arr ) == 0) 
        $bool=false; 
     
     return  $bool;
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
    $data['source']='';
    $getmaster_so=$this->Get_Pat_Source($examination_masters->patient_registration_id);
    if($getmaster_so)
    {
      $socurce=$getmaster_so[0]['source'];
      $sc=$socurce;
      $data['source']=$sc;
    }
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
    $usname='';
    $usage_ex_id=$examination_masters->usage_ex_id;
    if($usage_ex_id)
    {
      $usage_name=$this->emrdb->get_where('usage_ex',"usage_ex_id=$usage_ex_id")->row()->name;
      $usname.=' <tr>
                <td style="text-align: left;" class="tabledivideleft">Usage:</td>
                <td style="text-align: left;" class="tabledivideright">'.$usage_name.'</td> 
          </tr>';
    }
    $typeoflength_id=$examination_masters->typeoflength_id;
    if($typeoflength_id)
    {
      $typename_name=$this->emrdb->get_where('typeoflength',"typeoflength_id=$typeoflength_id")->row()->name;
      $usname.=' <tr>
                <td style="text-align: left;" class="tabledivideleft">Type Of Lens:</td>
                <td style="text-align: left;" class="tabledivideright">'.$typename_name.'</td> 
          </tr>';
    }
    $coating_id=$examination_masters->coating_id;
    if($typeoflength_id)
    {
      $coating_name=$this->emrdb->get_where('coating',"coating_id=$coating_id")->row()->name;
      $usname.=' <tr>
                <td style="text-align: left;" class="tabledivideleft">Coating:</td>
                <td style="text-align: left;" class="tabledivideright">'.$coating_name.'</td> 
          </tr>';
    }



 $con_sql="select  con1, con2, con3, con4, con5, con6, con7, con8, con9, con10,con11,con12,con13,con14,con15,con16 from examination where examination_id=? ";
 $con_result=$this->emrdb->query($con_sql,$examinationid);
 $con_reading= $con_result->result_array()[0];
 $con_readings=$this->checkValid($con_reading);  //2
//INR4
 $pmt_sql="select  pmt1, pmt2, pmt3, pmt4, pmt5, pmt6, pmt7, pmt8, pmt9, pmt10,pmt11,pmt12,pmt13,pmt14,pmt15,pmt16 from examination where examination_id=? ";
 $pmt_result=$this->emrdb->query($pmt_sql,$examinationid);
 $pmt_reading= $pmt_result->result_array()[0];
 $pmt_readings=$this->checkValid($pmt_reading);  //3


$spe_sql="select  spe1, spe2, spe3, spe4, spe5, spe6, spe7, spe8, spe9, spe10,spe11,spe12,spe13,spe14,spe15 from examination where examination_id=? ";
 $spe_result=$this->emrdb->query($spe_sql,$examinationid);
 $spe_reading= $spe_result->result_array()[0];
 $spe_readings=$this->checkValid($spe_reading);  ///1

 $fspe_sql="select  fspe1, fspe2, fspe3, fspe4, fspe5, fspe6, fspe7, fspe8, fspe9, fspe10,fspe11,fspe12,fspe13,fspe14,fspe15,fspe16 from examination where examination_id=? ";
 $fspe_result=$this->emrdb->query($fspe_sql,$examinationid);
 $fspe_reading= $fspe_result->result_array()[0];
 $fspe_readings=$this->checkValid($fspe_reading); //4

 if($examination_masters->op_advice_col)
 {
    if($examination_masters->op_advice_col==1)
    {
       $con_readings=$pmt_readings=$fspe_readings='';
    }
    if($examination_masters->op_advice_col==2)
    {
      $spe_readings=$pmt_readings=$fspe_readings='';
    }
    if($examination_masters->op_advice_col==3)
    {
      $spe_readings=$con_readings=$fspe_readings='';
    }
    if($examination_masters->op_advice_col==4)
    {
      $spe_readings=$con_readings=$pmt_readings='';
    }
 }


    $showdata='<table  width="100%" style="line-height:10px;margin-top:0px;font-size: 14;"> 
    <tr>
         <td style="text-align: left;" class="tabledivideleft">Date:</td>
         <td style="text-align: left;" class="tabledivideright">'.$this->date->dateSql2View($examination_masters->examination_date).'</td> 
    </tr>
    '.$usname.'
    ';

  


        if($spe_readings)
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

    if($fspe_readings)
    {
               $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">Final Glass Prescription:</td>
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
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe1.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe2.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe3.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe4.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe9.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe10.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe11.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe12.'</td>
                                          </tr>
                                           <tr>
                                              <td  class="tab_tit">N.V</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe5.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe6.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe7.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe8.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe13.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe14.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe15.'</td>
                                              <td style="padding:5px;" align="center">'.$examination_masters->fspe16.'</td>
                                          </tr>
                                      </table>
                      </td>
                      </tr>';
    }


     if($con_readings)
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



    if($pmt_readings)
    {
               $showdata.='<tr>
                     <td style="text-align: left;"  class="tabledivideleft" valign="top">PMT Correction:</td>
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
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt1.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt2.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt3.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt4.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt9.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt10.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt11.'</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt12.'</td>           </tr>                                              <tr>
                     <td  class="tab_tit">N.V</td>
                     <td style="padding:5px;" align="center">'.$examination_masters->pmt5.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt6.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt7.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt8.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt13.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt14.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt15.'</td>

                     <td style="padding:5px;" align="center">'.$examination_masters->pmt16.'</td>

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

              $sales_id=$this->db->select('max(sales_id) as sales_id')
                         ->from('sales_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->sales_id;
                if($sales_id>0)
                {
                    $sales_id=$sales_id;
                } else {
                    $sales_id= $sales_id;
                }
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'sales_id'=>$sales_id,
                  'error_message' => $this->error_message
                ));
                  exit;
            }
            exit;
          }
  }

  function print_bill($sales_id,$office_id,$supplier_id='')
  {
    $sales=$this->db->get_where('sales_master',"sales_id=$sales_id")->row();
    $data['logo'] = "";
    $office_id=$sales->office_id;
    $office=$this->db->get_where('office',"office_id=$office_id")->row();
    $data['logo']=($office->logo=='')?'':"<img style='width:10%;max-height:100px' src='". base_url('images/profile/')."$office->logo'>";
     $data['rvlogo']=($office->logo=='')?'':"<img style='width:15%;' src='". base_url('images/profile/')."$office->logo'>";
    
    $data['company_name']=$office->printable_company_name;
    $data['regname']=$office->registered_name;
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

    $customer=$this->db->get_where('customer',"customer_id in (select customer_id from sales_master where sales_id=$sales_id)")->row();
    $data['customer_name']=$customer->name;
    $data['customer_address']=$customer->address;
    $data['customer_email']=$customer->email_id;
    
    $data['mrd']=$customer->mrd;

    $sales=$this->db->get_where('sales_master',"sales_id=$sales_id")->row();
    $data['paying_amount']=$sales->advanced_amount;
    $data['balance_amount']=$sales->balance_amount;
    if($sales->description)
    {
      $data['customer_land_phone']=$customer->mobile.'<br/> <b>Description:'.$sales->description.'</b>';
    }
    else {
      $data['customer_land_phone']=$customer->mobile;
    }
  
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
    if($sales->credit_name)
    {
      $data['sales_date']=date_format($sdate,"d/m/Y").'<br/><b>Credit Name:'.$sales->credit_name.'</b>';
    }
    else {
      $data['sales_date']=date_format($sdate,"d/m/Y");
    }
    

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
    $sdate=date_create($sales->expected_del_date);

   $paymentnoss=$this->db->query("select count(payment_details.sales_id) as paymentnos,sales_master.expected_del_date,sales_master.status  from payment_details  inner join sales_master on payment_details.sales_id=sales_master.sales_id where payment_details.sales_id=$sales_id")->row();
   if($paymentnoss->paymentnos==1){
     $new_date ='';
      
      $sdate=date_create($paymentnoss->expected_del_date);
      $dtee=date_format($sdate,"d/m/Y");
      if($sales->status==2){
        $new_date = date('h:i A', strtotime($sales->sales_time));
        $new_date=$new_date;
      }
      $data['expected_del_date']="".$dtee." ". $new_date;
    }
    else
    {
      $new_date ='';
      date_default_timezone_set("Asia/Calcutta"); 
      $sdatess=$this->db->query("select payment_details.payment_time,payment_details.payment_date  from payment_details  inner join sales_master on payment_details.sales_id=sales_master.sales_id where payment_details.sales_id=$sales_id order by payment_details.payment_id DESC limit 1")->row();
     if($sdatess->payment_time){
      $new_date = date('h:i a', strtotime($sdatess->payment_time));
      }
     $sdate=date_create($sdatess->payment_date);
     $dtee=date_format($sdate,"d/m/Y");
      $data['expected_del_date']="".$dtee."  ". $new_date;
    }
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
    $data['sales_details']=$this->db->query("select sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,if(sales_details.product_type=0,item_master.name,lens_master.name) as itemname,(sales_details.cgst+sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from sales_details
       inner join stock on sales_details.stock_id=stock.stock_id
        left join item_master on sales_details.item_id=item_master.item_id and sales_details.product_type=0
        left join lens_master on sales_details.item_id=lens_master.lens_master_id and sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where sales_details.sales_id=$sales_id order by sales_details.sales_details_id ASC")->result();

     $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    if($host_tvm=='abyopticals' || $host_tvm=='sriganapathiopticals')
    {
      $data['sales_details']=$this->db->query("select sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,if(sales_details.product_type=0,item_master.name,lens_master.name) as itemname,(sales_details.cgst+sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from sales_details
       left join stock on sales_details.stock_id=stock.stock_id
        left join item_master on sales_details.item_id=item_master.item_id and sales_details.product_type=0
        left join lens_master on sales_details.item_id=lens_master.lens_master_id and sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where sales_details.sales_id=$sales_id order by sales_details.sales_details_id ASC")->result();
    }
    else
    {
       $data['sales_details']=$this->db->query("select sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,if(sales_details.product_type=0,item_master.name,lens_master.name) as itemname,(sales_details.cgst+sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from sales_details
       inner join stock on sales_details.stock_id=stock.stock_id
        left join item_master on sales_details.item_id=item_master.item_id and sales_details.product_type=0
        left join lens_master on sales_details.item_id=lens_master.lens_master_id and sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where sales_details.sales_id=$sales_id order by sales_details.sales_details_id ASC")->result();
    }

    $advanceamount=$this->db->query("select sum(advanced_amount) as advanced_amount  from payment_details where  sales_id=$sales_id and office_id= $office_id")->row();
    if($advanceamount->advanced_amount>0)
    {
      $addamnt=$advanceamount->advanced_amount;
    }
    else
    {
      $addamnt=0;
    }
    $data['adamount']=$addamnt;

    $lastpaidamount=$this->db->query("select  advanced_amount  from payment_details where  sales_id=$sales_id and office_id= $office_id order by payment_id DESC limit 1")->row();
    
    if($lastpaidamount->advanced_amount>0)
    {
      $paidamnt=$lastpaidamount->advanced_amount;
    }
    else
    {
      $paidamnt=0;
    }
    $data['paidamnt']=$paidamnt;
error_reporting(0);
$this->load->model('Sales_report_model');
    ////new 
    $data['advanced_amount']=0;
            $data['delamt']=0;
            $data['bal']=0;
            if($sales->status==1 || $sales->status==3)
            {
                $getcntval=$this->Sales_report_model->getcountofpayment($sales->sales_id);
                if($getcntval[0]['CNT']==1)
                {
                    if($sales->advanced_amount)
                    {
                        $data['bal']=$sales->netamount-$sales->advanced_amount;
                        $data['advanced_amount']=$sales->advanced_amount;
                        $data['delamt']=0;
                    }
                    else
                    {
                        $data['bal']=$sales->netamount;
                    }
                    
                }
                else
                {
                    $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id   where  payment_details.sales_id=$sales_id  ")->row();

					$pay_amount=$this->db->query("select * from payment_details where sales_id=$sales_id ORDER BY payment_id DESC")->row();

                    if($advancecreditamount->advanced_amount)
                    {
                      $data['bal']=$sales->netamount-$advancecreditamount->advanced_amount;
                      $data['advanced_amount']=$advancecreditamount->advanced_amount-$pay_amount->advanced_amount;  
                       //$data['advanced_amount']=$advancecreditamount->advanced_amount;
                        $data['delamt']=$pay_amount->advanced_amount;
                    }
                    else
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=0;
                        $data['delamt']=$sales->netamount;
                    }
                }
            }
            else
            {
                $getcntval=$this->Sales_report_model->getcountofpayment($sales->sales_id);
                if($getcntval[0]['CNT']==1)
                {
                    if($sales->advanced_amount)
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=$sales->advanced_amount;
                        $data['delamt']=0;
                    }
                    else
                    {
                        $data['bal']=$sales->netamount;

                    }
                    
                }
                else
                {
                    $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id   where payment_details.sales_id=$sales_id  ")->row();

                    if($advancecreditamount->advanced_amount)
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=$sales->advanced_amount;
                        $data['delamt']=$advancecreditamount->advanced_amount-$sales->advanced_amount;
                    }
                    else
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=0;
                        $data['delamt']=$sales->netamount;
                    }
                }
                
            }

    ///end new

    $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    if($host_tvm=='aby' || $host_tvm=='abyopticals')
    {
      $printpage='abyprint';
    }
    elseif ($host_tvm=='panopt' || $host_tvm=='nvc' || $host_tvm=='arul') 
    {

         $printpage='panprint';
         if($getresult[0]['gst']==2)
         {
           $printpage='panprintwogst';
         }
    }
    elseif($host_tvm=='akgopticals' || $host_tvm=='pefkopticals')
    {
      //$printpage='akgopticalsprint';
      $printpage='dehopticalprint';
    }
    elseif($host_tvm=='dehoptical')
    {
      $printpage='dehopticalprint';
    }
    else
    {
        $printpage='dehopticalprint';
    }
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

              $sales_id=$this->db->select('max(sales_id) as sales_id')
                         ->from('sales_master')
                         ->where(array('office_id'=>$this->session->office_id))
                         ->get()->row()->sales_id;
                if($sales_id>0)
                {
                    $sales_id=$sales_id;
                } else {
                    $sales_id= $sales_id;
                }
              $this->error='';
              $this->error_message ='';
                    echo json_encode(array(
                  'msg'           => $this->msg,
                  'error'         => $this->error,
                  'sales_id'=>$sales_id,
                  'error_message' => $this->error_message
                ));
                  exit;
            }
            exit;
          }
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

 public function send_to_fitt_update($sales_id,$stt_date,$status,$remarks,$stt_supplier_id)
    {
	//print_r($sales_id);exit;	
   //$this->db->query("update sales_master set status=$status,stf_date=$stt_date,supplier_id=$stt_supplier_id,stf_remarks=$remarks where sales_id=$sales_id");
   
			 $update_data = [ 
						 'status' => $status,
						 'stf_date' => $stt_date,
						 'supplier_id' => $stt_supplier_id,
						 'stf_remarks' => $remarks,
						];	
            $this->db->set($update_data);
            $this->db->where('sales_id', $sales_id);
            $this->db->update('sales_master');
	return TRUE;
    }

    function cusprint_bill_orderform($sales_id,$office_id,$supplier_id='')
  {
    $sales=$this->db->get_where('sales_master',"sales_id=$sales_id")->row();
    $data['logo'] = "";
    $office_id=$sales->office_id;
    $office=$this->db->get_where('office',"office_id=$office_id")->row();
    $data['logo']=($office->logo=='')?'':"<img style='width:10%;max-height:100px' src='". base_url('images/profile/')."$office->logo'>";
     $data['rvlogo']=($office->logo=='')?'':"<img style='width:15%;' src='". base_url('images/profile/')."$office->logo'>";
    
    $data['company_name']=$office->printable_company_name;
    $data['regname']=$office->registered_name;
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

    $customer=$this->db->get_where('customer',"customer_id in (select customer_id from sales_master where sales_id=$sales_id)")->row();
    $data['customer_name']=$customer->name;
    $data['customer_address']=$customer->address;
    $data['customer_email']=$customer->email_id;
    
    $data['mrd']=$customer->mrd;

    $sales=$this->db->get_where('sales_master',"sales_id=$sales_id")->row();
    $data['paying_amount']=$sales->advanced_amount;
    $data['balance_amount']=$sales->balance_amount;
    if($sales->description)
    {
      $data['customer_land_phone']=$customer->mobile.'<br/> <b>Description:'.$sales->description.'</b>';
    }
    else {
      $data['customer_land_phone']=$customer->mobile;
    }
  
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

    $data['invoice_number']=$sales->order_number;
    $sdate=date_create($sales->order_form_date);
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
    $sdate=date_create($sales->expected_del_date);

   $paymentnoss=$this->db->query("select count(payment_details.sales_id) as paymentnos,sales_master.expected_del_date,sales_master.status  from payment_details  inner join sales_master on payment_details.sales_id=sales_master.sales_id where payment_details.sales_id=$sales_id")->row();
   if($paymentnoss->paymentnos==1){
     $new_date ='';
      
      $sdate=date_create($paymentnoss->expected_del_date);
      $dtee=date_format($sdate,"d/m/Y");
      if($sales->status==2){
        $new_date = date('h:i A', strtotime($sales->sales_time));
        $new_date=$new_date;
      }
      $data['expected_del_date']="".$dtee." ". $new_date;
    }
    else
    {
      $new_date ='';
      date_default_timezone_set("Asia/Calcutta"); 
      $sdatess=$this->db->query("select payment_details.payment_time,payment_details.payment_date  from payment_details  inner join sales_master on payment_details.sales_id=sales_master.sales_id where payment_details.sales_id=$sales_id order by payment_details.payment_id DESC limit 1")->row();
     if($sdatess->payment_time){
      $new_date = date('h:i a', strtotime($sdatess->payment_time));
      }
     $sdate=date_create($sdatess->payment_date);
     $dtee=date_format($sdate,"d/m/Y");
      $data['expected_del_date']="".$dtee."  ". $new_date;
    }
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
    $domeye='NULL';
    if($getresult[0]['of_dominateye']==1)
    {
      $domeye='Right';
    }
    if($getresult[0]['of_dominateye']==2)
    {
      $domeye='Left';
    }
     if($getresult[0]['of_dominateye']==3)
    {
      $domeye='Both';
    }
    $dotsy='.';
    $recyl1=$recyl2=$recyl4=$reaxis1=$reaxis2=$reaxis3=$reaxis4=$of_pd1=$of_pd2=$of_pd3=$of_pd4=$reva1=$reva2=$reva3=$reva4=$of_add_ryt=$of_add_lft=$dotsy;
    if($getresult[0]['recyl1'])
    {
      $recyl1=$getresult[0]['recyl1'];
    }
    if($getresult[0]['recyl2'])
    {
      $recyl2=$getresult[0]['recyl2'];
    }
    if($getresult[0]['recyl3'])
    {
      $recyl3=$getresult[0]['recyl3'];
    }
    if($getresult[0]['recyl4'])
    {
      $recyl4=$getresult[0]['recyl4'];
    }
    if($getresult[0]['reaxis1'])
    {
      $reaxis1=$getresult[0]['reaxis1'];
    }
    if($getresult[0]['reaxis2'])
    {
      $reaxis2=$getresult[0]['reaxis2'];
    }
    if($getresult[0]['reaxis3'])
    {
      $reaxis3=$getresult[0]['reaxis3'];
    }
    if($getresult[0]['reaxis4'])
    {
      $reaxis4=$getresult[0]['reaxis4'];
    }
    if($getresult[0]['of_pd1'])
    {
      $of_pd1=$getresult[0]['of_pd1'];
    }
    if($getresult[0]['of_pd2'])
    {
      $of_pd2=$getresult[0]['of_pd2'];
    }
    if($getresult[0]['of_pd3'])
    {
      $of_pd3=$getresult[0]['of_pd3'];
    }
    if($getresult[0]['of_pd4'])
    {
      $of_pd4=$getresult[0]['of_pd4'];
    }
    if($getresult[0]['reva1'])
    {
      $reva1=$getresult[0]['reva1'];
    }
    if($getresult[0]['reva2'])
    {
      $reva2=$getresult[0]['reva2'];
    }
    if($getresult[0]['reva3'])
    {
      $reva3=$getresult[0]['reva3'];
    }
    if($getresult[0]['reva4'])
    {
      $reva4=$getresult[0]['reva4'];
    }
    if($getresult[0]['of_add_ryt'])
    {
      $of_add_ryt=$getresult[0]['of_add_ryt'];
    }
    if($getresult[0]['of_add_lft'])
    {
      $of_add_lft=$getresult[0]['of_add_lft'];
    }

    $data['customer_eye']=' <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="1">
                                        <tr >
                                            <td align="center" class="tab_tit">&#10004; RIGHT EYE (OD)</td>
                                            <td align="center" class="tab_tit">&#10004; LEFT EYE (OS)</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px;">
                                                <table border="1" width="100%" style="border-collapse: collapse;">
                                                    <tr style="padding: 0px;">
                                                        <td></td>
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">PD</td>
                                                        <td class="tab_tit">VA</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="tab_tit" >D.V</td>
                                                        <td style="padding:5px;'.$clr1.'" align="center">'.$val.'</td>
                                                        <td style="padding:5px;" align="center">'.$recyl1.'</td>
                                                        <td style="padding:5px;" align="center">'.$reaxis1.'</td>
                                                        <td style="padding:5px;" align="center">'.$of_pd1.'</td>
                                                        <td style="padding:5px;" align="center">'.$reva1.'</td>
                                                    </tr>
                                                   
                                                     <tr>
                                                        <td  class="tab_tit">N.V</td>
                                                        <td style="padding:5px;'.$clr2.'" align="center">'.$val2.'</td>
                                                        <td style="padding:5px;" align="center">'.$recyl2.'</td>
                                                        <td style="padding:5px;" align="center">'.$reaxis2.'</td>
                                                        <td style="padding:5px;" align="center">'.$of_pd2.'</td>
                                                        <td style="padding:5px;" align="center">'.$reva2.'</td>
                                                    </tr>
                                                     <tr>
                                                        <td  class="tab_tit">ADD</td>
                                                        <td colspan="5" style="padding:5px;" align="center">'.$of_add_ryt.'</td>
                                                       
                                                    </tr>
                                                   
                                                </table>
                                            </td>
                                            <td style="padding: 0px;">
                                                <table class="" border="1" width="100%" style="border-collapse: collapse;">
                                                    <tr style="padding: 0px;">
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">PD</td>
                                                        <td class="tab_tit">VA</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px;'.$clr3.'" align="center">'.$val3.'</td>
                                                        <td style="padding:5px;" align="center">'.$recyl3.'</td>
                                                        <td style="padding:5px;" align="center">'.$reaxis3.'</td>
                                                        <td style="padding:5px;" align="center">'.$of_pd3.'</td>
                                                        <td style="padding:5px;" align="center">'.$reva3.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px;'.$clr4.'" align="center">'.$val4.'</td>
                                                        <td style="padding:5px;" align="center">'.$recyl4.'</td>
                                                        <td style="padding:5px;" align="center">'.$reaxis4.'</td>
                                                        <td style="padding:5px;" align="center">'.$of_pd4.'</td>
                                                        <td style="padding:5px;" align="center">'.$reva4.'</td>
                                                    </tr>
                                                     <tr>
                                                       
                                                        <td colspan="6" style="padding:5px;" align="center">'.$of_add_lft.'</td>
                                                       
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table> 
                                    <br/> 
                                      <table class="table" style="width:100%;" style="font-size:12px;">
                                        <tr>
                                          <td style="width:33%;">IOP (left): '.$getresult[0]['of_iopleft'].'</td>
                                          <td style="width:33%;">IOP (Right): '.$getresult[0]['iop_right'].'</td>
                                          <td style="width:33%;">Dominant EYE:'.$domeye.'</td>
                                        </tr>
                                      </table>
                                    ';
    $data['sales_details']=$this->db->query("select sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,if(sales_details.product_type=0,item_master.name,lens_master.name) as itemname,(sales_details.cgst+sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from sales_details
       inner join stock on sales_details.stock_id=stock.stock_id
        left join item_master on sales_details.item_id=item_master.item_id and sales_details.product_type=0
        left join lens_master on sales_details.item_id=lens_master.lens_master_id and sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where sales_details.sales_id=$sales_id order by sales_details.sales_details_id ASC")->result();

     $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
    if($host_tvm=='abyopticals' || $host_tvm=='sriganapathiopticals')
    {
      $data['sales_details']=$this->db->query("select sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,if(sales_details.product_type=0,item_master.name,lens_master.name) as itemname,(sales_details.cgst+sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from sales_details
       left join stock on sales_details.stock_id=stock.stock_id
        left join item_master on sales_details.item_id=item_master.item_id and sales_details.product_type=0
        left join lens_master on sales_details.item_id=lens_master.lens_master_id and sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where sales_details.sales_id=$sales_id order by sales_details.sales_details_id ASC")->result();
    }
    else
    {
       $data['sales_details']=$this->db->query("select sales_details.*,stock.mrp as stockmrp,item_master.hsn_code,item_master.category_id,if(sales_details.product_type=0,item_master.name,lens_master.name) as itemname,(sales_details.cgst+sales_details.sgst) as tax_value,if((item_master.tax>0),tax_master.name,0) as taxv ,product_type,stock.frame_model
      from sales_details
       inner join stock on sales_details.stock_id=stock.stock_id
        left join item_master on sales_details.item_id=item_master.item_id and sales_details.product_type=0
        left join lens_master on sales_details.item_id=lens_master.lens_master_id and sales_details.product_type=1
         left join tax_master on item_master.tax=tax_master.tax_id 
         where sales_details.sales_id=$sales_id order by sales_details.sales_details_id ASC")->result();
    }

    $advanceamount=$this->db->query("select sum(advanced_amount) as advanced_amount  from payment_details where  sales_id=$sales_id and office_id= $office_id")->row();
    if($advanceamount->advanced_amount>0)
    {
      $addamnt=$advanceamount->advanced_amount;
    }
    else
    {
      $addamnt=0;
    }
    $data['adamount']=$addamnt;

    $lastpaidamount=$this->db->query("select  advanced_amount  from payment_details where  sales_id=$sales_id and office_id= $office_id order by payment_id DESC limit 1")->row();
    
    if($lastpaidamount->advanced_amount>0)
    {
      $paidamnt=$lastpaidamount->advanced_amount;
    }
    else
    {
      $paidamnt=0;
    }
    $data['paidamnt']=$paidamnt;
error_reporting(0);
$this->load->model('Sales_report_model');
    ////new 
    $data['advanced_amount']=0;
            $data['delamt']=0;
            $data['bal']=0;
            if($sales->status==1 || $sales->status==3)
            {
                $getcntval=$this->Sales_report_model->getcountofpayment($sales->sales_id);
                if($getcntval[0]['CNT']==1)
                {
                    if($sales->advanced_amount)
                    {
                        $data['bal']=$sales->netamount-$sales->advanced_amount;
                        $data['advanced_amount']=$sales->advanced_amount;
                        $data['delamt']=0;
                    }
                    else
                    {
                        $data['bal']=$sales->netamount;
                    }
                    
                }
                else
                {
                    $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id   where  payment_details.sales_id=$sales_id  ")->row();

          $pay_amount=$this->db->query("select * from payment_details where sales_id=$sales_id ORDER BY payment_id DESC")->row();

                    if($advancecreditamount->advanced_amount)
                    {
                      $data['bal']=$sales->netamount-$advancecreditamount->advanced_amount;
                      $data['advanced_amount']=$advancecreditamount->advanced_amount-$pay_amount->advanced_amount;  
                       //$data['advanced_amount']=$advancecreditamount->advanced_amount;
                        $data['delamt']=$pay_amount->advanced_amount;
                    }
                    else
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=0;
                        $data['delamt']=$sales->netamount;
                    }
                }
            }
            else
            {
                $getcntval=$this->Sales_report_model->getcountofpayment($sales->sales_id);
                if($getcntval[0]['CNT']==1)
                {
                    if($sales->advanced_amount)
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=$sales->advanced_amount;
                        $data['delamt']=0;
                    }
                    else
                    {
                        $data['bal']=$sales->netamount;

                    }
                    
                }
                else
                {
                    $advancecreditamount=$this->db->query("select sum(payment_details.advanced_amount) as advanced_amount  from payment_details inner join modeofpay on payment_details.mode_id=modeofpay.modeofpay_id inner join sales_master on payment_details.sales_id=sales_master.sales_id   where payment_details.sales_id=$sales_id  ")->row();

                    if($advancecreditamount->advanced_amount)
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=$sales->advanced_amount;
                        $data['delamt']=$advancecreditamount->advanced_amount-$sales->advanced_amount;
                    }
                    else
                    {
                        $data['bal']=0;
                        $data['advanced_amount']=0;
                        $data['delamt']=$sales->netamount;
                    }
                }
                
            }

    ///end new
            $printpage='orderformprint';

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


            $mpdf = new \Mpdf\Mpdf($print_config);
            $pdfFilePath ="print-".time().".pdf"; 
            $labName=$company_name;
            $mpdf->SetWatermarkText($labName,0.03);
            $mpdf->showWatermarkText = true;
            $mpdf -> SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            exit;
           
          
  }
  
  
 public function saveWithOutMasterData($data=array()){
		$this->db->insert('withoutdata',$data);
		$insert_id=$this->db->insert_id();
		//print_r($insert_id);die;
  }
   
public function loadPendingSalesList(){
	  $sql = "select * from withoutdata";
      $result_row=$this->db->query($sql); 
      $res= $result_row->result_array ();
      return $res;
}   
public function saveProgressData($data=array()){
		$this->db->insert('progress_entry',$data);
		$insert_id=$this->db->insert_id();
		//print_r($insert_id);die;
  }
}