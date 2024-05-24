<?php
/**
 * Description of Classification_model
 *
 * @author Prabhu @13/02/2021
 */
class Barcode_model extends CI_Model{
 public function __construct()
  {
    parent::__construct();
  }

   function generatemoderate_bill($barcode_id,$office_id)
  {
    if($barcode_id>0)
    {
    	$data['barcode_details']=$this->db->query("select purchase_details.mul_type,purchase_details.framemodel as selling_price ,purchase_details.quantity as qty,stock_barcode.quantity,purchase_details.mrp,purchase_details.selling_price as sp,printable_company_name,printable_company_code,item_master.name, barcode from stock_barcode  INNER JOIN purchase_details on stock_barcode.purchase_details_id=purchase_details.purchase_details_id inner join item_master on purchase_details.item_id=item_master.item_id inner join office on office.office_id=stock_barcode.office_id WHERE purchase_details.purchase_id=$barcode_id")->result();

    	 $html=$this->load->view("transaction/barcode/print_thermal",$data, true); 
    	// echo $html;exit;
                   $print_config=[
                                    'format' => [86,25],
                                    'margin_left' => 2,
                                    'margin_right' => 12,
                                    'margin_top' => 8,
                                    'margin_bottom' => 0,
                                    'margin_header' => 0,
                                    'margin_footer' => 0,
                                ];

            $mpdf = new \Mpdf\Mpdf($print_config);
            $pdfFilePath ="print-".time().".pdf"; 
            //$labName=$company_name;
            //$mpdf->SetWatermarkText($labName,0.03);
           // $mpdf->showWatermarkText = true;
            //$mpdf -> SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            exit;
    }
  }
}