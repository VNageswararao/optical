<div style="border: 0px Solid  #000000;padding:5px 5px 5px 5px;">
 <table width="100%" style="font-size:14px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black" border="0">
    <tr>
     
    
     <td style="width:100%;text-align:center;padding:10px;" valign="top">
        <b style="font-size:18px;font-family:TIMES NEW ROMAN;"><?=$company_name?></b> <br>
        <p style="font-size:12px"><?=$company_address?><br/>
       Pho: <?=$company_land_phone?>  Mob: <?=$company_mobile?>
        Email: <?=$company_email?><br/><b>GSTIN NO:<?=$gstin_no?></b></p> 
         <b style="margin-top:12px;font-size:14px;"><br>
     </td>
    </tr>
</table>

 <table width="100%" style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="0">
    <tr>
        <td style="width:100%;text-align:center;padding:10px;border:0.6px solid black;">
          <h3>  INVOICE BILLre  </h3>
        </td>
  </tr>
</table>
<table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="0">

    <tr>
        <td style="width:25%;text-align:left;border:0.6px solid black;padding:10px;">
         <h4>Customer Name : <?=$customer_name?></h4>
       

         <p><b>MR Number:<?=$mrd?><br/>Address: </b><?=$customer_address?><br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br/> <b>Phone</b> :  <?=$customer_land_phone?><br/></p>
          <br/>
           <br/>
        </td>
         <td style="width:50%;text-align:left;border:0.6px solid black;padding:10px;">
               <?=$customer_eye?>           
        </td>
        <td style="width:25%;border:0.6px solid black;padding:10px;" valign="top">
              <p><b>Invoice no:</b> <?=$invoice_number?></p>
              <hr/>
             
              <p><b>Invoice Date:</b><?=$sales_date?><br/><b>Supplier Name:</b><?=$suppliername?></p>
        </td>
       
  </tr>

</table>



<div style="margin-top:0%;">
  <div style="font-family:Verdana, Arial, Helvetica, sans-serif;border:1px solid black;" >
     <table   style="font-size:13px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border-left: none;
  border-right: none;width:100%;">
        <tr style="border:0.6px solid black;background: #f5f5f5;">
           <th style="width:10%;border-right:0.6px solid black;">Sl No </th>
           <th style="width:10%;border-right:0.6px solid black;">Item</th>
           <th style="width:30%;border-right:0.6px solid black;">Product</th>
           <th style="width:15%;border-right:0.6px solid black;" align="center">Model</th>
           <th style="width:10%;border-right:0.6px solid black;" align="center">Rate</th>
           <th style="width:10%;border-right:0.6px solid black;" align="center">Qty</th>
        
           <th style="width:15%;border-right:0.6px solid black;"  align="center">Total Amount</th>
        </tr>

        <?php
       $i=1;
       $total_amount_before_tax=0;
       foreach ($sales_details as $sales_detail){ 
        if($sales_detail->product_type==0)
        {
          
           $ct = $this -> db
       -> select('name')
       -> where('classification_id', $sales_detail->category_id)
       -> limit(1)
       -> get('classification')
       -> row()
       ->name;
          $model=$sales_detail->frame_model;
        }
        else
        {
          $ct='Lens';
          $model='';
        }

        if($sales_detail->tax_type==1)
        {
          $rate=$sales_detail->rate-($sales_detail->cgst+$sales_detail->sgst);
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
         ?>
        
        
        
        
        
        
      <tr>
        <!--  <td style="border-right:0.6px solid black;" ><?=$i?></td>
         <td  style="padding-left:1%;text-align:left;border-right:0.6px solid black;"><?=$ct?></td>
         <td  style="padding-left:1%;text-align:left;border-right:0.6px solid black;"><?=$sales_detail->itemname?></td>
        <td style="text-align:center;border-right:0.6px solid black;"><?=$model;?> </td>
         
        <td style="border-right:0.6px solid black;" align="right"><?=number_format((float)$rate,2,'.', '')?></td>
        <td style="text-align:right;border-right:0.6px solid black;"><?=$sales_detail->quantity?>  </td> -->
      
         
        <td  align="right"> <?=number_format((float)$sales_detail->total_amount,2,'.', '')?></td>
        
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
     <?php if($description){?>
         <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
   <tr>
       <td align="center"><?=$description?></td>
   </tr>

</table>
<?php } ?>
     

    <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;" border="1">
    <tr>
        <th style="width:10%;text-align:center;">
          Discount
        </th>
       
         <th style="width:30%;text-align:center;">
           Advanced Amount 
        </th>
       
          <th style="width:20%;text-align:center;">
          Balanced Amount
        </th>
        
       
        <th style="width:40%;text-align:center;">
         <b>Net Total</b>
        </th>
       
  </tr>
  <tr >

 <td style="text-align:center;"><?=number_format((float)$total_discount,2,'.', '')?></td>

 <td style="text-align:center;"><?=number_format((float)$paidamnt,2,'.', '')?></td>
 
   <td style="text-align:center;"><?=number_format((float)$net_amount-$adamount,2,'.', '')?></td>
    
      <td style="text-align:center;"><b><?=number_format((float)$net_amount,2,'.', '')?></b></td>
  </tr>

</table>
  <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0px solid black;" border="1">

    <tr>
          
         <td style="width:50%;text-align:center;border-right:1px solid black;">
           <p>Attented By:<?=$staffname?><br/><b>Delivery Date:<?=$expected_del_date?></b></p>
        </td>   
        <td style="width:50%;text-align:center;border-right:1px solid black;">
           <p>Total Amount In Words</p><br/>
            <?=$net_amount_in_words?>
        </td>
       

  </tr>

</table>

  <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0px solid black;" border="1">

    <tr>
        <td style="width:30%;text-align:center;" valign="top">
           <p><b>Terms & Conditions</b></p> <br/>
            <p  style="text-align:left;"><?=nl2br($print_declaration)?></p>
        </td>
        <td style="width:20%;text-align:center;" valign="bottom">
           <p>(Common Seal)</p><br/>
           
        </td>
        <td style="width:40%;text-align:center;">
           <p>Certified the particular given above are true and correct</p>
           <h4>For <b><?=$company_name?></b></h4>
           <br/> <br/> <br/>
           <p>Authorized Signatory</p>
           
        </td>
       

  </tr>

</table>
     
   
     <script>

     </script>   

</div>

