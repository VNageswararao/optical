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
          <h3>   PRESCRIPTION  </h3>
        </td>
  </tr>
</table>
<table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0.6px solid black;height:100px;" border="0">

    <tr>
        <td style="width:100%;text-align:left;border:0.6px solid black;padding:10px;">
         <h4>Customer Name : <?=$customer_name?></h4>
       

         <p><b>Date:<?=$customer_date?><br/>MR Number:<?=$mrd?>Address: </b><?=$customer_address?>  <b>Phone</b> :  <?=$customer_land_phone?></p>
         
        </td>
        
        
       
  </tr>

</table>



<div style="margin-top:0%;">
  <div style="font-family:Verdana, Arial, Helvetica, sans-serif;border:1px solid black;" >
   
     

  
  <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0px solid black;" border="1">

  <tr>
      <td style="width:100%;"><?php echo $customer_eye; ?></td>
  </tr>

</table>




</div>
<br/>
 <table width="100%" style="font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;margin-top:0%;border-collapse: collapse;border:0px solid black;" border="0">

  <tr>
      <td style="width:70%;color:red">Doctor Signature</td>
       <td style="width:30%;color:red;float:right;">Optometric  Signature</td>
  </tr>

 
</table>
</div>

