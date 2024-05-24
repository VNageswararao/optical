<?php
$sql_off = "select billprint_gst from office limit 1";
$result_rows=$this->db->query($sql_off); 
$ress= $result_rows->result_array ();
if($ress[0]['billprint_gst']==1)
{
    $gstcond=1;
}
?>
<div style="border: 0px Solid  #000000;padding:5px 5px 5px 5px;">
 <table width="100%" style="font-size:14px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black" border="0">
    <tr>
     
    
     <td style="width:100%;text-align:center;padding:8px;" valign="top">
        <b style="font-size:18px;font-family:TIMES NEW ROMAN;"><?=$company_name?></b> <br>
        <b style="font-size:14px;font-family:TIMES NEW ROMAN;"><?=$regname?></b>
        <p style="font-size:12px"><?=$company_address?><br/>
       Pho: <?=$company_land_phone?>  Mob: <?=$company_mobile?>
        Email: <?=$company_email?><br/><b>GSTIN NO:<?=$gstin_no?></b></p> 
         <b style="margin-top:12px;font-size:14px;"><br>
     </td>
    </tr>
</table>

 <table width="100%" style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="0">
    <tr>
        <td style="width:100%;text-align:center;padding:2px;border:0.6px solid black;">
          <h3>  ORDER FORM  </h3>
        </td>
  </tr>
</table>
<table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="0">

    <tr>
        <td style="width:70%;text-align:left;border:0.6px solid black;padding:5px;">
         <h4>Customer Name : <?=$customer_name?></h4>
       

         <p><b>MR Number:<?=$mrd?><br/>Address: </b><?=$customer_address?><br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br/> <b>Phone</b> :  <?=$customer_land_phone?><br/></p>
         
        </td>
        <td style="width:30%;border:0.6px solid black;padding:5px;" valign="top">
              <p><b>Order Number:</b> <?=$invoice_number?></p>
              <hr/>
             
              <p><b>Date of Order:</b><?=$sales_date?></p>
        </td>
       
  </tr>

</table>



<div style="margin-top:0%;">
  <div style="font-family:Verdana, Arial, Helvetica, sans-serif;border:1px solid black;" >
     <table   style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border-left: none;
  border-right: none;width:100%;">
        <tr style="border:0.6px solid black;background: #f5f5f5;">
           <th style="width:5%;border-right:0.6px solid black;">Sl No </th>
           <th style="width:75%;border-right:0.6px solid black;">Product Details</th>
           <th style="width:20%;border-right:0.6px solid black;">Price</th>
        </tr>

        <?php
       $i=1;
       $total_amount_before_tax=0;
       foreach ($sales_details as $sales_detail){ 
        if($sales_detail->product_type==0)
        {
          $ct='Frame';
          $model=$sales_detail->frame_model;
        }
        else
        {
          $ct='Lens';
          $model='';
        }

        if($sales_detail->tax_type==1)
        {
          $rate=($sales_detail->rate * $sales_detail->quantity)-($sales_detail->cgst+$sales_detail->sgst);
        }
        else
        {
          $rate=$sales_detail->rate * $sales_detail->quantity;
        }

        if($sales_detail->cgst>0 || $sales_detail->sgst>0)
        {
          $gstt=$sales_detail->cgst+$sales_detail->sgst;
        }
        else
        {
          $gstt=0;
        }
         ?>
        
        
        
        
        
        
      <tr>
         <td style="border-right:0.6px solid black;" ><?=$i?></td>
         <td  style="padding-left:1%;text-align:left;border-right:0.6px solid black;"><?=$ct?>-<?=$sales_detail->itemname?></td>
        <td style="border-right:0.6px solid black;" align="right"> RS: <?=number_format((float)$sales_detail->total_amount,2,'.', '')?></td>
         </tr>
       <?php 
         $total_amount_before_tax+=$sales_detail->total_amount;  
         $i++; 
       }
       ?>
       <tr>
           <td style="padding-left:1%;text-align:left;border-right:0.6px solid black;"></td>
           <td  style="padding-right:5%;padding-left:5%;text-align:left;border-right:0.6px solid black;">
            <p>
                <br/>
               <?php echo $customer_eye; ?>
           </p>
          </td>
           <td  style="padding-left:1%;text-align:left;border-right:0.6px solid black;"></td>
       </tr>
       <?php
       while($i<10)
       {
 ?>
      <tr>
          <td style="border-right: 1px solid black;"></td>
          <td style="border-right: 1px solid black;"></td>
          <td style="border-right: 1px solid black;"></td>
         
        
         </tr>
       <?php 
           $i++;
       }
        ?>

         </table>
     </div>

 <table   style="font-size:10px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border-left: none;
  border-right: none;width:100%;">
  <tr>
      <td style="width:60%;"></td>
      <td><h3 style="font-size: 17px;">Advance amount: RS <?=number_format((float)$advanced_amount+$delamt,2,'.', '')?></h3></td>
  </tr>
  <tr>
      <td style="width:60%;"></td>
      <td><h3 style="font-size: 17px;">Net Total Amount:RS <?=number_format((float)$net_amount,2,'.', '')?></h3></td>
  </tr>
</table>



  
   
        

</div>

