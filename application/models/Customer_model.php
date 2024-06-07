<?php
/**
 * Description of customer_model
 *
 * @author Prabhu @20/12/2020
 */
class Customer_model extends CI_Model{
 public function __construct()
	{
		parent::__construct();
	}
    public function checkcustomer($var_array)
	{
		$sql = "select count(*) as cnt from customer where   code = ? or  (name = ?  and mobile=?  and office_id= ?)";
	  $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
     function getUsers($searchTerm=""){

     // Fetch users
     $this->db->select('*');
     $this->db->where("name like '%".$searchTerm."%'  or mobile like '%".$searchTerm."%'");
      $this->db->limit(10);  
     $fetched_records = $this->db->get('customer');
     $users = $fetched_records->result_array();
   

     // Initialize Array with fetched data
     $data = array();
     foreach($users as $user){
     $det=$user['name'].' / '.$user['mobile'];
        $data[] = array("id"=>$user['customer_id'], "text"=>$det);
     }
     return $data;
  }
	public function editcheckcustomer($var_array)
	{
		$sql = "select count(*) as cnt from customer where    customer_id!=? and    code = ?  and   name = ? and mobile=?  and office_id= ?";
	  $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
		return $res;
	}
  public function GetData($var_array)
  {
    $sql = "select * from customer where    customer_id=? and  office_id= ?";
    $result_row=$this->db->query($sql, $var_array); 
    $res= $result_row->result_array ();
    return $res;
  }
   public function Get_order_form($sales_id)
  {
    $sql = "select count(*) as cnt from sales_master where    order_form_flag=1 and  sales_id=$sales_id";
    $result_row=$this->db->query($sql); 
    $res= $result_row->result_array ();
    return $res;
  }
	public function deletecheckcustomer($var_array)
	{
		$sql = "select count(*) as cnt from customer where customer_id=?  and office_id= ?";
	   $result_row=$this->db->query($sql, $var_array); 
		$res= $result_row->result_array ();
    $this->logger->save($this->db);
		return $res;
	}
	public function savedata($data)
    {
        if($this->db->insert('customer',$data))
        {
             $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function updatedata($data,$id)
    {
        $this->db->set($data);
        $this->db->where('customer_id', $id);
        if($this->db->update('customer'))
        {
            $this->logger->save($this->db);
            return TRUE;
        }
    }
    public function deletedata($id) 
    {
        $this->db->where('customer_id', $id);
        if($this->db->delete('customer'))
        {
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
      0 =>'customer_id'
      
     
    );
 
    $this->db->select('name');//s.photo_no,s.photo_name'
    $this->db->from('customer');
    $whrcon = array('office_id' => $office_id);
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
   
 
    $sql = "SELECT customer_id,code,name,mobile,if(status=1,'Active','Deactive') as status";
    $sql.=" FROM customer where office_id=$office_id";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ){   //name
      $sql.="  and ( code LIKE '%".$requestData['search']['value']."%' ";
        $sql.="  OR name LIKE '".$requestData['search']['value']."%'  ";
        $sql.="  OR mobile LIKE '".$requestData['search']['value']."%') ";
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
			$customer_id=$row[$i]['customer_id'];
			$code=$row[$i]['code'];
			$name=$row[$i]['name'];
			$mobile=$row[$i]['mobile'];
			$status=$row[$i]['status'];

       $print='<button onclick="printcustomer('.$customer_id.')" type="button" class="btn btn-info btn-info mr-1 mb-1"><i class="la la-print"></i></button>';


	     $edit="<button type='button'  onclick=\"editcustomer('$customer_id');\" class='btn btn-icon btn-warning mr-1 mb-1'><i class='la la-edit'></i></button>";

      	// $edit='<button  onclick="editcustomer('.$frame_id.',1,$(this),'.$code.','.$name.','.$description.','.$status.')" type="button" class="btn btn-icon btn-warning mr-1 mb-1"><i class="la la-edit"></i></button>';

      	$delete='<button onclick="deletecustomer('.$customer_id.')" type="button" class="btn btn-icon btn-danger mr-1 mb-1"><i class="la la-trash"></i></button>';


        if(($this->auth->lock_up('sales_master',"customer_id='$customer_id'")))
          {
              $delete='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
              // $edit='<button type="button" class="btn btn-icon btn-primary mr-1 mb-1"><i class="la la-lock"></i></button>';
          }
         
     
        $row[$i]['slno']=$i+1;
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
  function print_bill($customer_id,$office_id)
  {
    error_reporting(0);
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

    $customer=$this->db->get_where('customer',"customer_id=$customer_id")->row();
    $data['customer_name']=$customer->name;
    $data['customer_date']=$customer->created_date;

    $oDate = new DateTime($customer->created_date);
    $data['customer_date'] = $oDate->format("d-m-Y");

    $data['customer_address']=$customer->address;
    $data['customer_email']=$customer->email_id;
    $data['customer_land_phone']=$customer->mobile;
    $data['mrd']=$customer->mrd;

   
    $var_array=array($customer_id,$this->session->userdata('office_id'));
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
                                        <tr style="background: #1e9ff24f">
                                            <td align="center" class="tab_tit">RE</td>
                                            <td align="center" class="tab_tit">LE</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px;">
                                                <table border="1" width="100%">
                                                    <tr style="padding: 0px;background: #1e9ff24f;">
                                                        <td style="background: #1e9ff24f;"></td>
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">V/A</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="tab_tit" style="background: #1e9ff24f;">D.V</td>
                                                        <td style="padding:5px;'.$clr1.'" align="center">'.$val.'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['recyl1'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reaxis1'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reva1'].'</td>
                                                    </tr>
                                                     <tr>
                                                        <td style="background: #1e9ff24f;" class="tab_tit">N.V</td>
                                                        <td style="padding:5px;'.$clr2.'" align="center">'.$val2.'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['recyl2'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reaxis2'].'</td>
                                                        <td style="padding:5px;" align="center">'.$getresult[0]['reva2'].'</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="padding: 0px;">
                                                <table class="" border="1" width="100%">
                                                    <tr style="padding: 0px;background: #1e9ff24f">
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
  

    $html=$this->load->view("master/customerprint",$data, true); 
                   $print_config=[
                                    'format' => 'A5',
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
}