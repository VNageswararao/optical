<html>
    <body>
         <div style="height:auto;font-family:Verdana, Arial, Helvetica, sans-serif;border:0px solid #000;margin-top:0%;" >
            <div style="text-align:center;border:0px solid #000;margin-top:0%;position:fixed;width:100%;">
         <table style="font-family:Verdana, Arial, Helvetica, sans-serif;border:0px solid #000;border-collapse: collapse;text-align:center;width:100%;" border="0">
            <tbody>
                <tr>
        <?php
        $i=1;
        foreach ($barcode_details as $row)
        {
            $k=0;
           $qtyy= $row->quantity*2;
            while ($qtyy>$k)
            {
        ?>
                       <td style="padding-bottom: 10px;width:20%">
                    <div style="text-align: center;">
                            <span style="font-size:8px;"><b><?=$row->printable_company_name?><b/></span>
                    <barcode code="<?=$row->barcode?>" type="C128A" height="1.0" size="0.7" text="1" />
                    <span style="font-size:10px;letter-spacing: 1px;">*<b><?=$row->barcode?></b>*</span><br>
                    <span style="font-size:8px;"><b><?php print substr($row->name,0,26); ?></b></span><br>

                      <span style="font-size:10px;font-weight:900;">
                        <b>MRP:<?=$row->mrp?></b> <b>SP:<?=$row->selling_price?></b></span>
                      
                 
                     </div>
                    </td>
        <?php
        if($i%5==0)
        {
            ?>
            </tr><tr>
            <?php
        }
        $i++;
        $k++;
        }
        }
        while($i%5!=1)
        {
            ?>
            <td></td>
            <?php
            $i++;
        }
        ?>
               </tr>
           </tbody>
        </table>
    </div>
</div>
    </body>
</html>