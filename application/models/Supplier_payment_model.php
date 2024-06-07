<?php
/**
 * Description of hsn_master_id_model
 *
 * @author Prabhu @25/02/2022
 */
class Supplier_payment_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}

	
    public function getallsupplierpurchase($var_array)
	{
		$sql = "select purchase_id,DATE_FORMAT(purchase_date,'%d/%m/%Y') AS purchase_date,invoice_no,modeofpay.name as mode,total_amount,total_qty from purchase  inner join modeofpay on modeofpay.modeofpay_id=purchase.modeofpay_id  where  purchase.supplier_id = ? and purchase.office_id= ? and purchase_id not in (select purchase_id from supplier_payment_details)";
	    $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
        $this->logger->save($this->db);
		return $res;
	}

    public function savedata($data)
        {
           error_reporting(0);
           $this->db->trans_begin();
           $supmaster=$data['supplier_payment_master'];
           $this->db->insert('supplier_payment',$supmaster);
           $supplier_payment_id=$this->db->insert_id();

           $supplier_payment_detailss=$data['supplier_payment_details'];
           $purchase_ids=$supplier_payment_detailss['purchase_id'];
           $checksups=$supplier_payment_detailss['checksup'];
           $purchase_amounts=$supplier_payment_detailss['purchase_amount'];
           $indtots=$supplier_payment_detailss['indtot'];
           $i=0;
           foreach ($purchase_ids as $complaints_if) 
           {
              $coml=0;
              if(in_array($complaints_if,$checksups)){
                $coml=1;
            }
             if(($coml>0))
             {
               $this->db->insert('supplier_payment_details',array("purchase_id"=>$purchase_ids[$i],"supplier_payment_id"=>$supplier_payment_id,"purchase_amount"=>$purchase_amounts[$i],"paid_amount"=>$indtots[$i]));
             }
             
              $i++;
           }

            $sql = "select sum(paid_amount) as amt from supplier_payment_details where supplier_payment_id=$supplier_payment_id";
            $result_row=$this->db->query($sql); 
            $res= $result_row->result_array ();
            if($res)
            {
                $totalpaid=number_format((float)$res[0]['amt'], 2, '.', '');
                $upsql = "update supplier_payment set total_paid_amount='$totalpaid' where supplier_payment_id=$supplier_payment_id";
                $result_row=$this->db->query($upsql); 
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
    $columns = array(
      0 =>'supplier_payment_id'
    );
 
    $this->db->select('supplier_payment_id');//s.photo_no,s.photo_name'
    $this->db->from('supplier_payment');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT total_paid_amount,supplier_payment_id,supplier.name,DATE_FORMAT(payment_date,'%d/%m/%Y') AS payment_date";
    $sql.=" FROM supplier_payment inner join supplier on supplier_payment.supplier_id=supplier.supplier_id where supplier_payment.office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
        $sql.="  and ( payment_date LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR supplier_payment_id LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR supplier_payment_id LIKE '".$requestData['search']['value']."%') ";
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
            $supplier_payment_id=$row[$i]['supplier_payment_id'];
            

         $view="<button type='button'  onclick=\"viewsupplierpayment('$supplier_payment_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-eye'></i></button>";

        // $edit='<button  onclick="editclassification('.$classification_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

        $delete='<button onclick="deletesupplierpayment('.$supplier_payment_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';

       
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

   public function getviewdata($var_array)
    {
        $sql = "select paid_amount,total_paid_amount,supplier.name,DATE_FORMAT(payment_date,'%d/%m/%Y') AS payment_date from supplier_payment_details inner join supplier_payment on supplier_payment.supplier_payment_id=supplier_payment_details.supplier_payment_id inner join supplier on supplier_payment.supplier_id=supplier.supplier_id where supplier_payment_details.supplier_payment_id=? and supplier_payment.office_id=?";
        $result_row=$this->db->query($sql, $var_array); 
        $res= $result_row->result_array ();
        $this->logger->save($this->db);
        return $res;
    }

    public function deletedata($id) 
    {
            $this->db->trans_begin();
            $this->db->where('supplier_payment_id',"$id");
            $this->db->delete('supplier_payment_details');
            $this->db->where('supplier_payment_id',"$id");
            $this->db->delete('supplier_payment');
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