<html>
    <body>
        <br/><br/><br/><br/><br/><br/>
        <table border="1" style="font-family:Verdana, Arial, Helvetica, sans-serif;border-collapse: collapse;text-align:center;width:100%;">
            <tbody>
               
        <?php
        $i=1;
        foreach ($barcode_details as $row)
        {
            
            
        ?>
             
                        <tr style="margin-top: 10px;">

                            <td style="width: 50%;"><barcode code="<?=$row->barcode?>" type="C128A" height="0.9" text="2" /><?=$row->barcode?></td>
                            <td style="width: 50%;">
                                 <span style="font-size:10px;"><b><?=$row->printable_company_code?><b/></span><br/>
                                 <span style="font-size:10px;"><b><?=substr($row->name,0,13)?></b></span><br>
                                 <span style="font-size:10px;font-weight:900;">
                                 <b>MRP:<?=$row->mrp?></b> <b>SP:<?=$row->selling_price?></b></span>
                            </td>
                        </tr>
             
            <?php
       
        }
        
        ?>
             
           </tbody>
       </table>
 
    
    </body>
</html>