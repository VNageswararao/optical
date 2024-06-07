<div style="border: 0px Solid  #000000;padding:5px 5px 5px 5px;">
 <table width="100%" style="font-size:10px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black" border="0">
    <tr>
     
    
     <td style="width:100%;text-align:center;padding:10px;" valign="top">
        <b style="font-size:15px;font-family:TIMES NEW ROMAN;"><?=$company_name?></b> <br>
       Pho: <?=$company_land_phone?>  Mob: <?=$company_mobile?>
        Email: <?=$company_email?><br/>
            Drug licence 1 :<?=$drug_license_no1?>  Drug licence 2 :<?=$drug_license_no2?><br/>
       
         <b style="margin-top:10px;font-size:14px;"><br>
     </td>
    </tr>
</table>


<table width="100%" style="font-size:10px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="0">

    <tr>
        <td style="width:50%;text-align:left;border:0.6px solid black;padding:10px;">
         <h4>Customer Name : <?=$customer_name?> <p><b>MR Number:<?=$mrd?></h4>
       
        </td>
        
        <td style="width:50%;border:0.6px solid black;padding:10px;" valign="top">
              <p><b>Invoice no:</b> <?=$invoice_number?>  <b>Date:</b><?=$sales_date?></p>
              <p><b>Doctor Name:</b>Dr. <?=$doctorname?> </p>
              <p><b>Payment Mode:</b> <?=$mode?> </p>
             
            
        </td>
       
  </tr>

</table>



<div style="margin-top:0%;">
  <div style="font-family:Verdana, Arial, Helvetica, sans-serif;border:1px solid black;" >
     <table   style="font-size:10px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border-left: none;
  border-right: none;width:100%;">
        <tr style="border:0.6px solid black;background: #f5f5f5;">
           <th style="width:5%;border-right:0.6px solid black;">Sl No </th>
           <th style="width:30%;border-right:0.6px solid black;">Product</th>
         
           <th style="width:30%;border-right:0.6px solid black;" align="center">Batch && Exp</th>
           <th style="width:10%;border-right:0.6px solid black;" align="center">Rate</th>
           <th style="width:10%;border-right:0.6px solid black;" align="center">Qty</th>
      
           <th style="width:15%;border-right:0.6px solid black;"  align="center">Total Amount</th>
        </tr>

        <?php
       $i=1;
       $total_amount_before_tax=0;
       foreach ($sales_details as $sales_detail){ 
        if($sales_detail->tax_type==1)
        {
          //$rate=$sales_detail->rate-($sales_detail->cgst+$sales_detail->sgst);
          $rate=$sales_detail->rate;
        }
        else
        {
          $rate=$sales_detail->rate;
        }

        if($sales_detail->cgst>0 || $sales_detail->sgst>0)
        {
          $gstt=$sales_detail->cgst+$sales_detail->sgst;
        }
        else
        {
          $gstt=0;
        }
         if($sales_detail->hsn_master_id)
        {
           $hsn = $this -> db
           -> select('hsn_code')
           -> where('hsn_master_id', $sales_detail->hsn_master_id)
           -> limit(1)
           -> get('hsn_master')
           -> row()
           ->hsn_code;
         
        }
        else
        {
            $hsn='';
        }
         ?>
        
        
      <tr>
         <td style="border-right:0.6px solid black;" ><?=$i?></td>
      
         <td  style="padding-left:1%;text-align:left;border-right:0.6px solid black;"><?=$sales_detail->itemname?></td>
      
        <td style="text-align:center;border-right:0.6px solid black;"><?=$sales_detail->batchno?> && <?=$sales_detail->expirydate?> </td>
         
        <td style="border-right:0.6px solid black;" align="right"><?=number_format((float)abs($rate),2,'.', '')?></td>
        <td style="text-align:right;border-right:0.6px solid black;"><?=$sales_detail->quantity?>  </td>
       
         
        <td style="border-right:0.6px solid black;" align="right"> <?=number_format((float)$sales_detail->total_amount,2,'.', '')?></td>
        
         </tr>
       <?php 
         $total_amount_before_tax+=$sales_detail->total_amount;  
         $i++; 
       }
       while($i<10)
       {
 ?>
      <tr>
          <td style="border-right: 1px solid black;"></td>
          <td style="border-right: 1px solid black;"></td>
         
        
          <td style="border-right: 1px solid black;"></td>
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
     

    <table width="100%" style="font-size:10px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
    <tr>
        <th style="width:60%;text-align:center;">
          Discount
        </th>
       
       
        
       
        <th style="width:60%;text-align:center;">
         <b>Net Total</b>
        </th>
       
  </tr>
  <tr >

 <td style="text-align:center;"><?=number_format((float)$total_discount,2,'.', '')?></td>


    
      <td style="text-align:center;"><b><?=number_format((float)$net_amount,2,'.', '')?></b></td>
  </tr>

</table>
  <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0px solid black;" border="1">

    <tr>
          
         <td style="width:50%;text-align:center;border-right:1px solid black;">
           <p>Attented By:<?=$staffname?><br/></b></p>
        </td>   
        <td style="width:50%;text-align:center;border-right:1px solid black;">
           <p>Total Amount In Words</p><br/>
            <?=$net_amount_in_words?>
        </td>
       

  </tr>

</table>

     
   
     <script>

     </script>   

</div>

