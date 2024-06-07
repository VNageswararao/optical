<?php 
$path=base_url('template1/modern-admin/');
?>
<style type="text/css">
    .disabled_select {
    pointer-events: none;
    cursor: not-allowed;
}
</style>
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Purchase Return</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true"><l id="tab_tit">Add Purchase Return<l></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                          
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                        <form id="purchasereturn_form" action="#" method="post"> 
                            <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                            <div class="modal fade" id="myModalframe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-body">
                         <div id="save_frame">
                            <div class="row">
                              <div class="col-md-12">
                                <input type="hidden" id="frame_details_id">
                                  <div style="text-align: center;font-weight: bold;" id="heading-popup"></div>
                                  <div style="text-align: center;font-weight: bold;color:red">All Frames Disabled Only Allow Checkbox</div>
                              </div>
                          </div>
                          <div id="pop-error"></div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div style="text-align: center;font-weight: bold;" id="heading-popuptitle"></div>
                              </div>
                          </div>
                            <div class="row">
                                 <div class="col-md-1">
                                    <label><b>Ret</b></label>
                                    <div class="form-group">
                                        <div class="input-groupp"  id="showreturntype">
                                          
                                        </div>
                                    </div>
                               </div>
                                <div class="col-md-3">
                                    <label><b>Frame Type</b></label>
                                    <div class="form-group">
                                        <div class="input-groupp"  id="showframetype">
                                          
                                        </div>
                                    </div>
                               </div>
                                <div class="col-md-3">
                                    <label><b>Frame Color</b></label>
                                    <div class="form-group">
                                        <div class="input-groupp"  id="showframecolor">
                                          
                                        </div>
                                    </div>
                               </div>
                                <div class="col-md-3">
                                    <label><b>Frame Size</b></label>
                                    <div class="form-group">
                                        <div class="input-groupp"  id="showframesize">
                                          
                                        </div>
                                    </div>
                               </div>
                                <div class="col-md-2">
                                    <label><b>Frame Model</b></label>
                                    <div class="form-group">
                                        <div class="input-groupp"  id="showframemodel">
                                          
                                        </div>
                                    </div>
                               </div>
                           </div>
                         </div>
                       

                    
                   <div class="modal-footer">
                   <button type="button" class="btn btn-success" name="update_serial_no" id="update_serial_no" onclick="saveframetype()">save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="popupclose">Close</button>
                     <!-- <input type="submit" name="update" id="update" value="Update" class="btn btn-success" />   -->
                   </div>
                 </div>
                 <!-- /.modal-content -->
                 </div>
               <!-- /.modal-dialog -->
             </div>
             <!-- /.modal -->
           </div>
                                    <input type="hidden" id="demo_frametype">
                                    <input type="hidden" id="demo_framecolor">
                                    <input type="hidden" id="demo_framesize">
                                    <input type="hidden" id="demo_framemodel">
                                    <input type="hidden" name="purchase_entry_id" id="purchase_entry_id">
                                    <input type="hidden" name="edit_purchase_return_id" id="edit_purchase_return_id">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="lastname">Puechase Supp/Invoice No: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="purchase_id" id="purchase_id" onchange="loadpurchasedetails($(this).val());">
                                                <option value="0">Select Supp/Invoice No</option>
                                                <?php if($getinvoiceno){
                                                    foreach ($getinvoiceno as $data) {
                                                        ?>
                                                        <option value="<?php print $data['purchase_id']; ?>"><?php print $data['name']; ?>/<?php print $data['invoice_no']; ?></option>
                                                        <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="pur_ret_date" id="pur_ret_date" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Time: <span class="text-danger">*</span></label>
                                            <input type="time" name="pur_ret_time" id="pur_ret_time" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Tax Type: <span class="text-danger">*</span></label>
                                            <select class="form-control" id="gst_type" name="gst_type">
                                                <option value="2">Exclusive</option>
                                                <option value="0">Non Tax</option>
                                                <option value="1">Inclusive</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">GST(Y/N): <span class="text-danger">*</span></label>
                                            <select class="form-control" id="gst_selection" name="gst_selection">
                                               <option value="1">Y</option>
                                                <option value="0">N</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>

                               

                                  <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="productdetails">
                                                <thead>
                                                    <tr>
                                                        <th>Sl No</th>
                                                        <th>Remove</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Purchase Qty</th>
                                                        <th>Return Qty</th>
                                                        <th style="display: none;">Free</th>
                                                        <th>CP</th>
                                                        <th style="display: none;">LC</th>
                                                        <th>MRP</th>
                                                        <th>SP</th>
                                                        <th>D.Type</th>
                                                        <th>Amount</th>
                                                        <th style="display: none;">GST(Y/N)</th>
                                                        <th style="display: none;">TAX</th>
                                                        <th style="display: none;">CGST</th>
                                                        <th style="display: none;">SGST</th>
                                                        <th>Tot Amt</th>
                                                        <th style="display: none;">Mul type?</th>
                                                        <th>Frame Type</th>
                                                        <th>Colour</th>
                                                        <th>Size</th>
                                                        <th>Model</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                     </div>
                                 </div>
                                  </div>

                                    <div class="row">
                                      <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Total Qty: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total_qty" name="total_qty" readonly="" value="0" style="text-align:center;">
                                        </div>
                                    </div>
                                     <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Total Free Qty: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total_free_qty" name="total_free_qty" readonly="" value="0" style="text-align:center">
                                        </div>
                                    </div>
                                       <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Total CGST: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total_cgst" name="total_cgst" readonly="" value="0" style="text-align:right;font-weight:bold">
                                        </div>
                                    </div>
                                       <div class="col-md-2" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Total SGST: <span class="text-danger">*</span></label>
                                             <input type="text" class="form-control" id="total_sgst" name="total_sgst" readonly="" value="0" style="text-align:right;font-weight:bold">
                                        </div>
                                    </div>
                                      <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Total Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" readonly="" value="0" style="text-align:right;font-weight:bold">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">D.Amt: <span class="text-danger">*</span></label>
                                             <input type="text" class="form-control" id="total_discount_input" name="discount" style="text-align:right"  onkeyup="find_discount_percentage();calcnet();" onkeypress="return isFloat(event)" >
                                        </div>
                                    </div>
                                     <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="lastname">Dis %: <span class="text-danger">*</span></label>
                                             <input type="text" class="form-control" id="discount_percentage" name="discount_percentage" style="text-align:right"  onkeyup="find_discount_amount();calcnet();" onkeypress="return isFloat(event)">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Other Charge: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="charge_amount" name="charge_amount" onkeyup="calcnet();"  style="text-align:right" onkeypress="return isFloat(event)">
                                        </div>
                                    </div>
                                     <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="modeofpay_id" id="modeofpay_id">
                                               <option value="">Select Modeofpay</option>
                                                <?php
                                                if($getmodeofpay)
                                                {
                                                    foreach($getmodeofpay as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['modeofpay_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Net Amount: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="net_amount" name="net_amount" style="text-align:right;font-size: 20px;" readonly="" value="0">
                                        </div>
                                    </div>
                                 </div>
                               
                         

                          

                                 <div class="card-footer ml-auto">
                                    <button id="save" type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savepurchasereturn();">Submit</button>
                                    <button style="display: none;" id="update" type="button" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1" onclick="updatepurchasereturn();">Update</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onClick="window.location.reload();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <!-- Tab 1 finsih -->
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                <div class="table-responsive">
                                       <table id="tableid" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                            <th>Sl No</th>
                                                            <th>Invoice No</th>
                                                            <th>Supplier Name</th>
                                                            <th>Date</th>
                                                            <th>Total Qty</th>
                                                            <th>Total Amount</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Invoice No</th>
                                                                <th>Supplier Name</th>
                                                                <th>Date</th>
                                                                <th>Total Qty</th>
                                                                <th>Total Amount</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </tfoot>
                                           </table>
                                    </div>
                                </div>
                                            </div>
                                            <!-- Tab 2 finsh -->


                                              

                                             <!-- Tab 3 finsh -->
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Justified With Top Border end -->
            </div>
            <script type="text/javascript">
                 var table;
$( document ).ready(function() {
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Purchase_return/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'bill_no' },
             { data: 'name' },
             { data: 'purchase_return_date' },
             { data: 'total_qty' },
             { data: 'total_amount' },
             { data: 'edit' },
             { data: 'delete' }
                     ],
       
    
        //            buttons: [
        // {
        //     extend: 'pdf',
        //     footer: true,
        //     attr:  {
        //         id: 'buttonpdf'
        //     },
        //     exportOptions: {
        //   columns: [0,1,2,3,4]
        //     }
        // },
        // {
        //     // extend: 'excel',
        //     //  footer: true,
        //     //  attr:  {
        //     //       id: 'buttonxl'
        //     //   },
        //     // exportOptions: {
        //     // columns: [0,1,2,3,4]
        //     //  }
        // }
        //  ],
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
}); 
 $( document ).ready(function() {
         have_cess=2;
         row_num=1;
    cd = (new Date()).toISOString().split('T')[0];
    $('#pur_ret_date').val(cd);
    

    timee="<?php Echo date('H:i'); ?>";
    $('#pur_ret_time').val(timee);
});

 function editpurchasereturn(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Purchase_return/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  $('#base-tab1').click(); 
                  $('#tab_tit').html('Edit Purchase Return');
                  $("#purchase_id").val(data.getmasterdata[0]['purchase_id']);
                  $("#purchase_entry_id").val(data.getmasterdata[0]['purchase_id']);
                  $('#purchase_ret_date').val(data.getmasterdata[0]['purchase_return_date']);
                  $('#purchase_ret_time').val(data.getmasterdata[0]['purchase_return_time']);
                  $('#gst_selection').val(data.getmasterdata[0]['gstyesno']);
                  $('#gst_type').val(data.getmasterdata[0]['tax_type']);
                  $('#total_qty').val(data.getmasterdata[0]['total_qty']);
                  $('#total_free_qty').val(data.getmasterdata[0]['total_free_qty']);
                  $('#total_cgst').val(data.getmasterdata[0]['total_cgst']);
                  $('#total_sgst').val(data.getmasterdata[0]['total_sgst']);
                  $('#total_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#total_discount_input').val(data.getmasterdata[0]['discount_amount']);
                  $('#discount_percentage').val(data.getmasterdata[0]['discount_percentage']);
                  $('#charge_amount').val(data.getmasterdata[0]['other_charge']);
                  $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']);
                  $('#net_amount').val(data.getmasterdata[0]['net_amount']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  $('#demo_frametype').val(data.demoframetype);
                  $('#demo_framecolor').val(data.demoframecolor);
                  $('#demo_framemodel').val(data.demoframemodel);
                  $('#demo_framesize').val(data.demoframesize);
                  $('#edit_purchase_return_id').val(data.getmasterdata[0]['purchase_return_id']);
                  $('#save').hide();
                  $('#update').show();

               } 
              else if(data.error != '')
              {
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              } 
              else if(data.error_message) 
              {
                var error = data.error_message;
                var err_str = '';
                for (var key in error) {
                  err_str += error[key] +'\n';
                }
                Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              }
                
            },
            error: function (error) {
                Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        }); 
        
        
}
function updatepurchasereturn()
{
        
        if($("#edit_purchase_return_id").val()=='' ||  $("#purchase_id").val()=='' || $("#pur_ret_date").val()=='' || $("#pur_ret_time").val()=='' || $("#total_qty").val()==''|| $("#total_amount").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Purchase_return/editpurchasereturn";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#purchasereturn_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               location.reload();
              } else if(data.error != ''){
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              } else if(data.error_message) 
              {
                var error = data.error_message;
                var err_str = '';
                for (var key in error) {
                  err_str += error[key] +'\n';
                }
                Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              }
                
            },
            error: function (error) {
                Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        }); 
}
 function loadpurchasedetails(id)  //get customer details
{
    if($("#purchase_id").val()=='') {
           Swal.fire({title:"Info!",text:"Please choose  Supp/Invoice No fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Purchase_return/getpurchasedetails";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data:{purchase_id:$("#purchase_id").val(),csrf_test_name:$("#csrf_test_name").val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                  $('#gst_selection').val(data.getmasterdata[0]['gstyesno']);
                  $('#gst_type').val(data.getmasterdata[0]['tax_type']);
                  $('#total_qty').val(data.getmasterdata[0]['total_qty']);
                  $('#total_free_qty').val(data.getmasterdata[0]['total_free_qty']);
                  $('#total_cgst').val(data.getmasterdata[0]['total_cgst']);
                  $('#total_sgst').val(data.getmasterdata[0]['total_sgst']);
                  $('#total_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#total_discount_input').val(data.getmasterdata[0]['discount_amount']);
                  $('#discount_percentage').val(data.getmasterdata[0]['discount_percentage']);
                  $('#charge_amount').val(data.getmasterdata[0]['other_charge']);
                  $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']);
                  $('#net_amount').val(data.getmasterdata[0]['net_amount']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  $('#demo_frametype').val(data.demoframetype);
                  $('#demo_framecolor').val(data.demoframecolor);
                  $('#demo_framemodel').val(data.demoframemodel);
                  $('#demo_framesize').val(data.demoframesize);
                  $('#purchase_entry_id').val(data.getmasterdata[0]['purchase_id']);
                  
              } else if(data.error != ''){
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              } else if(data.error_message) 
              {
                var error = data.error_message;
                var err_str = '';
                for (var key in error) {
                  err_str += error[key] +'\n';
                }
                Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              }
                
            },
            error: function (error) {
                Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        }); 
}

function pop(val)
            {
                res='';
                showval='';
                selframetype='';
                selframecolor='';
                selframemodel='';
                selframesize='';
                addframetype='';
                addreturntype='';
                addframecolor='';
                addframesize='';
                addframemodel='';
                showstockval='';
                
                var frametype = $('#demo_frametype').val();
                var framecolor = $('#demo_framecolor').val();
                var framesize = $('#demo_framesize').val();
                var framemodel = $('#demo_framemodel').val();
                $('#frame_details_id').val('');
                $('#frame_details_id').val(val);
                var qty = $('#purchase_quantity_'+val).val();
                $('#heading-popup').html('<b>Frame Details</b>');
                if(qty>0){
                if (isNaN(qty) || qty=="" ) { qty=0; }
                lng=qty;
                if (isNaN(lng) || lng=="" ) { lng=0; }
                var text = ""
                var i = 0;

                do {
                var slno=0;
                if(qty.length>i){slno=qty[i];}
                if(slno==0) {slno=""};
                  addreturntype += "<input type='checkbox' class='form-control' name='mreturntype[]' id='mreturntype_"+i+"'><br>";
                  addframetype += "<select class='form-control disabled_select' name='mframetype[]' id='mframetype_"+i+"'><option value>Select Frame Type</option>"+frametype+"</select><br>" ;
                  addframecolor += "<select class='form-control disabled_select' name='mframcolor[]' id='mframecolor_"+i+"'><option value=''>Select Frame Colour</option>"+framecolor+"</select><br>" ;
                  addframesize += "<select class='form-control disabled_select' name='mframesize[]' id='mframesize_"+i+"'><option value=''>Select Frame Size</option>'"+framesize+"'</select><br>" ;
                  addframemodel += "<input type='text' class='form-control' readonly name='mframemodel[]' id='mframemodel_"+i+"'><br>" ;
                  
                i++;
                }
                while (i < lng);
                    document.getElementById("showreturntype").innerHTML = addreturntype;
                    document.getElementById("showframetype").innerHTML = addframetype;
                    document.getElementById("showframecolor").innerHTML = addframecolor;
                    document.getElementById("showframesize").innerHTML = addframesize;
                    document.getElementById("showframemodel").innerHTML = addframemodel;

                }
                else
                {
                    //$('#heading-popuptitle').html('<p class="text-danger">Please Check Qty</p>');
                    $('#showframetype').html('');
                }
                   selstock=$('#stock_id_'+val).val();
                   selretstock=$('#return_stock_id_'+val).val();
                   selframetype=$('#mulframetype_'+val).val();
                   selframecolor=$('#mulframecolor_'+val).val();
                   selframesize=$('#mulframesize_'+val).val();
                   selframemodel=$('#mulframemodel_'+val).val();
                   showframetypeval='';
                   if(selframetype){
                     var j = 0;
                     while (j < qty) {
                        showretstockval='';
                            var resstock = selstock.split(",");
                            showstockval=resstock[j];
                            $('#mreturntype_'+j+'').val(showstockval);
                              // var resretstock = selretstock.split(",");
                              // showretstockval=resretstock[j];
                           
                            var resframetype = selframetype.split(",");
                            showframetypeval=resframetype[j];
                             $('#mframetype_'+j+'  option[value="'+showframetypeval+'"]').prop("selected", true);

                             var resframecolor = selframecolor.split(",");
                             showframecolorval=resframecolor[j];
                             $('#mframecolor_'+j+'  option[value="'+showframecolorval+'"]').prop("selected", true);

                             var resframesize = selframesize.split(",");
                             showframesizeval=resframesize[j];
                             $('#mframesize_'+j+'  option[value="'+showframesizeval+'"]').prop("selected", true);

                             var resframemodel = selframemodel.split(",");
                             showframemodelval=resframemodel[j];
                             //$('#mframemodel_'+j+'  option[value="'+showframemodelval+'"]').prop("selected", true);
                             $('#mframemodel_'+j).val(showframemodelval);

                             j++;
                        }
                   }

            }

function saveframetype()
{
          Swal.fire({title:"Are you sure?",
            text:"once you Save Cant Able to Edit Qty!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Save it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
                        var getproductid = $('#frame_details_id').val();
                        var qty = $('#purchase_quantity_'+getproductid).val();
                        var valueframetype='';
                        var valueframecolor='';
                        var valueframesize='';
                        var valueframemodel='';
                        var valuereturnstock='';
                        var valuereturntype='';
                        for(var i=0;i<qty;i++){

                          $('#mreturntype_'+i+':checked').each(function(){
                               getreturntype= $('#mreturntype_'+i).val();
                               valuereturntype+=getreturntype+',';
                           });

                           getframetype= $('#mframetype_'+i).val();
                           valueframetype+=getframetype+',';

                           getframecolor= $('#mframecolor_'+i).val();
                           valueframecolor+=getframecolor+',';

                           getframesize= $('#mframesize_'+i).val();
                           valueframesize+=getframesize+',';

                           getframemodel= $('#mframemodel_'+i).val();
                           valueframemodel+=getframemodel+',';
                      }
                      $('#return_stock_id_'+getproductid).val(valuereturntype);
                      $('#mulframetype_'+getproductid).val(valueframetype);
                      $('#mulframecolor_'+getproductid).val(valueframecolor);
                      $('#mulframemodel_'+getproductid).val(valueframemodel);
                      $('#mulframesize_'+getproductid).val(valueframesize);
                      $('#popupclose').click();
                      $("#quantity_"+getproductid).prop("readonly", true);
               
                }
                }))
            

        
        
}

function findFloatValue(id)
{
    var value=$("#"+id).val();
       value=parseFloat(value);
    if(isNaN(value))
    {
        return 0;
    }else{
        return value;
    }
 }
  function findInclusive_taxamount(price,tax)
 {
    var taxable_amount=price*100/(100+tax);
    return taxable_amount*tax/100;
 }
  function findExclusive_taxamount(price,tax)
 {
     return price*tax/100;
 }
 function find_discount_percentage()
   {
      var discount= $('#total_discount_input').val();
      var total_amount=$('#total_amount').val();
         discount=parseFloat(discount);
         total_amount=parseFloat(total_amount);
        if(discount>0&&(total_amount>=discount))
        {
            var percentage=(discount*100)/total_amount;
            $('#discount_percentage').val(percentage.toFixed(2));
        }else{
            $('#total_discount_input').val('');
            $('#discount_percentage').val(0);
        }
   }
   function find_discount_amount()
   {
       var percentage=$('#discount_percentage').val();
       var total_amount=$('#total_amount').val();
       percentage=parseFloat(percentage);
       total_amount=parseFloat(total_amount);
        if(percentage>0)
        {
            var amount=(percentage*total_amount)/100;
            $('#total_discount_input').val(amount.toFixed(2));
        }else{
            $('#total_discount_input').val(0);
            $('#discount_percentage').val('');
        }
   }
   function calcrow(eid)
{
   var indamount=0;
   var quantity=findFloatValue('quantity_'+eid);
   var free=findFloatValue('free_'+eid);
   var total_quantity=quantity+free;
   var cost_price=findFloatValue('cost_price_'+eid);
   var price=total_quantity*cost_price;
   $('#landing_cost_'+eid).val(cost_price);
   if($('#discount_type_'+eid).val()==0)
   {
       $('#discount_amount_'+eid).val(findFloatValue('discount_input_'+eid));
   }else{
      var discount_percentage= findFloatValue('discount_input_'+eid);
      var discount_amount=price*discount_percentage/100;
       $('#discount_amount_'+eid).val(discount_amount);
   }
   var price_reduced_discount=price-findFloatValue('discount_amount_'+eid);
   if($('#gstselind_'+eid).val()==0)
   {
     $('#tax_type_'+eid).val('0');
   }
   else
   {
      $('#tax_type_'+eid).val($("#gst_type").val());
   }
   var gst_type=findFloatValue('tax_type_'+eid);
   
   var supplier_type=0;
   switch(gst_type)
   {
       case 0:$('#cgst_'+eid).val('0');
              $('#sgst_'+eid).val('0');
              //$('#igst_'+eid).val('0');
              $('#amount_'+eid).val(price_reduced_discount.toFixed(2));
               var indamount=parseFloat(price_reduced_discount)/parseFloat(quantity);
               if (isNaN(indamount)) indamount = 0;
               $('#landing_cost_'+eid).val(indamount.toFixed(2));
              break;
       case 1:var taxamount=findInclusive_taxamount(price_reduced_discount,findFloatValue('tax_'+eid));
             // var taxable_amountcal=taxableamountcal(price_reduced_discount,findFloatValue('gst_'+eid));
              //$('#taxable_'+eid).val(taxable_amountcal.toFixed(2));
              $('#tax_amount_'+eid).val(taxamount);
              if(supplier_type==1)
              {
                  // $('#igst_'+eid).val(taxamount.toFixed(2));
                   $('#cgst_'+eid).val('0');
                   $('#sgst_'+eid).val('0');
              }else
              {
                  var cgst=taxamount/2;
                  var sgst=taxamount/2;
                   $('#cgst_'+eid).val(cgst.toFixed(2));
                   $('#sgst_'+eid).val(sgst.toFixed(2));
                   //$('#igst_'+eid).val('0');
               }
               $('#amount_'+eid).val(price_reduced_discount.toFixed(2));
                var indamount=parseFloat(price_reduced_discount)/parseFloat(quantity);
                 if (isNaN(indamount)) indamount = 0;
               $('#landing_cost_'+eid).val(indamount.toFixed(2));
              break;
       case 2:var taxamount=findExclusive_taxamount(price_reduced_discount,findFloatValue('tax_'+eid));
              // var taxable_amountcal=taxableamountexcal(price_reduced_discount,findFloatValue('quantity_'+eid));
                // if (isNaN(taxable_amountcal)) taxable_amountcal = 0;
             // $('#taxable_'+eid).val(taxable_amountcal.toFixed(2));
              $('#tax_amount_'+eid).val(taxamount);
              if(supplier_type==1)
              {
                   //$('#igst_'+eid).val(taxamount.toFixed(2));
                   $('#cgst_'+eid).val('0');
                   $('#sgst_'+eid).val('0');
              }else
              {
                  var cgst=taxamount/2;
                  var sgst=taxamount/2;
                   $('#cgst_'+eid).val(cgst.toFixed(2));
                   $('#sgst_'+eid).val(sgst.toFixed(2));
                  // $('#igst_'+eid).val('0');
               }
               var amount=price_reduced_discount+taxamount;
               $('#amount_'+eid).val(amount.toFixed(2));
                var indamount=parseFloat(amount)/parseFloat(quantity);
                 if (isNaN(indamount)) indamount = 0;
               $('#landing_cost_'+eid).val(indamount.toFixed(2));
              break;
   }
   calcnet();
}
function calcnet()
  {
      var total_qty=0;
      var total_free=0;
      var total_cgst=0;
      var total_sgst=0;
      var total_amount=0;
    $('input[name="product_id[]"]').each(function(){
        var product_id=$(this).val();
        total_qty+=findFloatValue('quantity_'+product_id);
        total_free+=findFloatValue('free_'+product_id);
        total_cgst+=findFloatValue('cgst_'+product_id);
        total_sgst+=findFloatValue('sgst_'+product_id);
        total_amount+=findFloatValue('amount_'+product_id);
    });
    $('#total_qty').val(total_qty.toFixed(2));
    $('#total_free_qty').val(total_free.toFixed(2));
    $('#total_cgst').val(total_cgst.toFixed(2));
    $('#total_sgst').val(total_sgst.toFixed(2));
    $('#total_amount').val(total_amount.toFixed(2));
    
    var discount=findFloatValue('total_discount_input');
    var other_charge=findFloatValue('charge_amount');
    var net_amount=total_amount-discount+other_charge;
    $('#invoice_amount').val(net_amount.toFixed(2));
    $('#inamount').val(net_amount.toFixed(2));
    
    var invoice_amount=Math.round(net_amount);
    var removed_decimal=parseInt(net_amount);
    var round=0;
    if(invoice_amount>removed_decimal)
    {
        round=net_amount.toFixed(2)-removed_decimal;
    }else
    {
        round=removed_decimal-net_amount.toFixed(2);
    }
   
    $('#net_amount').val(invoice_amount+'.00');
    
}


function savepurchasereturn()
    {    
        if($("#purchase_id").val()=='' || $("#purchase_entry_id").val()=='' || $("#pur_ret_date").val()=='' || $("#pur_ret_time").val()=='' || $("#total_qty").val()==''|| $("#total_amount").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Purchase_return/savepurchasereturn";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#purchasereturn_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
                location.reload();
              } else if(data.error != ''){
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              } else if(data.error_message) 
              {
                var error = data.error_message;
                var err_str = '';
                for (var key in error) {
                  err_str += error[key] +'\n';
                }
                Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              }
                
            },
            error: function (error) {
                Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        }); 

    
} 

function deletepurchasereturn(val)
{
      if(val=='') {
           Swal.fire({title:"Info!",text:"Delete ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
          Swal.fire({title:"Are you sure?",
            text:"You won't be able to revert this!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Delete it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
            delurl="Purchase_return/deletepurchasereturn";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#purchasereturn_form').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                // $("#savepurchaseorder_form")[0].reset();
                 return false;
              } else if(data.error != ''){
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
               return false;
              } else if(data.error_message) 
              {
                var error = data.error_message;
                var err_str = '';
                for (var key in error) {
                  err_str += error[key] +'\n';
                }
                Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                 return false;
              }
                
            },
            error: function (error) {
                Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        });
               
                }
                }))
            

        
        
}
            </script>

          