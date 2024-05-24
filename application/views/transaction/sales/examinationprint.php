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
          <h3>  Glass Prescription  </h3>
        </td>
  </tr>
</table>

<table  width="100%" style="line-height:10px;margin-top:0px;font-size: 13;border: 1px solid black"> 
                <tr>
                    <td style="line-height:15px;text-align: left;width:15%;">MRD No</td>
                    <td style="line-height:15px;text-align: left;width:45%">: <strong><?=$mrdno?></strong></td> 
                    <td style="line-height:15px;text-align: center;width:17%;">Contact Number</td>
                    <td style="line-height:15px;text-align: left;width:23%;font-size: 12px">: <?=$mobileno?>  </td>
                </tr>
         
                <tr>
                    <td style="line-height:15px;text-align: left;width:15%;">Patient Name</td>
                    <td style="line-height:15px;text-align: left;width:45%">: <strong><?=$titlename;  ?> <?=$fname;  ?> <?=$lname;  ?>  Age/Sex: <?php if($ageyy) echo $ageyy.'Y'; ?>  <?php if($agemm) echo $agemm.'M'; ?> / <?=$gender;  ?></strong></td> 
                    <td style="line-height:15px;text-align: center;width:17%;">Patient Address</td>
                    <td style="line-height:15px;text-align: left;width:23%;font-size: 12px">: <?=$address?> </td>
                </tr>
                 <tr>
                    <td style="line-height:15px;text-align: left;width:15%;">Source</td>
                    <td style="line-height:15px;text-align: left;width:45%">: <strong><?=$source?></strong></td> 
                   
                   
                </tr>
         </table>
              <table  width="100%" style="line-height:10px;margin-top:0px;font-size: 13;border:  1px solid black"> 
                  <tr>
                    <td style="line-height:15px;text-align: left;width:15%;">Consultant</td>
                    <td colspan="3" style="line-height:15px;text-align: left;width:85%">: Dr: <?=$doctorname;  ?></td> 
                </tr>
               </table>
               <br/> 

               <?=$conddata;  ?>

               <style>
            .tabledivideleft
            {
                width: 30%;
                line-height: 25px;
                font-weight: bold;
            }
             .tabledivideright
            {
                width: 70%;
                line-height: 25px;
            }
        </style>

