<?php 
$path=base_url('template1/modern-admin/');
?>  
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Purchase Order</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true"><l id="tab_tit">Add Purchase Order<l></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Excel Upload</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                               <form id="savepurchaseorder_form" action="#" method="post"> 
                                                <input type="hidden" id="demo_frametype">
                                                <input type="hidden" id="demo_framecolor">
                                                <input type="hidden" id="demo_framesize">
                                                <input type="hidden" id="demo_framemodel">
                                                <input type="hidden" name="edit_purchase_order_id" id="edit_purchase_order_id">
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
                              </div>
                          </div>
                          <div id="pop-error"></div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div style="text-align: center;font-weight: bold;" id="heading-popuptitle"></div>
                              </div>
                          </div>
                            <div class="row">
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
                                <div class="col-md-3">
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

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">PO NO: <span class="text-danger">*</span></label>
                                            <input type="text" readonly class="form-control" name="po_no"  id="po_no" value="<?php if(isset($getbillno[0]['last_order_no'])) echo $getbillno[0]['last_order_no']+1; else echo 1; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Supplier: <span class="text-danger">*</span></label>
                                            <select class="form-control select2-diacritics" name="supplier_id" id="supplier_id">
                                                <option value="0">Select supplier</option>
                                                <?php
                                                if($getsupplier)
                                                {
                                                    foreach($getsupplier as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['supplier_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">PO Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="po_date" id="po_date" class="form-control" value="<?php echo date('d/m/Y'); ?>">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">PO Time: <span class="text-danger">*</span></label>
                                            <input type="time" name="po_time" id="po_time" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Item: <span class="text-danger">*</span></label>
                                            <select class="form-control select2-diacritics" name="product"  id="product" onchange="changeproduct($(this).val());">
                                                <option value="0">select item</option>
                                                <?php
                                                if($getitem)
                                                {
                                                    foreach($getitem as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['item_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">GST(Y/N): <span class="text-danger">*</span></label>
                                            <select class="form-control" id="gst_selection" name="gst_selection">
                                                <option value="0">N</option>
                                                <option value="1">Y</option>
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
                                                        <th>Order Qty</th>
                                                        <th>CP</th>
                                                        <th>Tot Amt</th>
                                                        <th>Mul type?</th>
                                                        <th>Frame Type</th>
                                                        <th>Colour</th>
                                                        <th>Size</th>
                                                        <th>Model</th>
                                                        <th>GST(Y/N)</th>
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
                                     <div class="col-md-6"></div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Total Qty: <span class="text-danger">*</span></label>
                                            <input readonly="" type="text" name="total_qty" class="form-control" id="total_qty">
                                        </div>
                                    </div>

                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Invoice Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="total_amount" readonly="" class="form-control" id="total_amount">
                                        </div>
                                    </div>
                                 </div>
                               
                         

                          

                                <div class="card-footer ml-auto">
                                    <button id="save" type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savepurchaseorder();">Submit</button>
                                    <button style="display: none;" id="update" type="button" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1" onclick="updatepurchaseorder();">Update</button>
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
                                                            <th>Purchase Order No</th>
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
                                                                <th>Purchase Order No</th>
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


                                                <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                                 <div class="card-body collapse show">
                                                    <div class="row">
                                                         <div class="col-md-12">
                                                            <a download style="float: right;" href="<?php echo base_url(); ?>documents/sampleformat.csv"><i  class="la la-file-excel-o exceldes"></i>Sample Format</a>
                                                         </div>
                                                    </div>
                                                    <div class="row">
                                                     <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lastname">Excel Uplod: <span class="text-danger">*</span></label>
                                                                <input type="file" >
                                                            </div>
                                                        </div>
                                                    </div>

                                                      <div class="card-footer ml-auto">
                                                            <button type="submit" class="btn btn-outline-success mr-1">Submit</button> <button type="submit" class="btn btn-outline-danger">Reset</button>
                                                        </div>

                                                 </div>
                                              </div>

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
          'ajax':'<?=base_url()?>transaction/Purchase_order/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'purchase_order_no' },
             { data: 'name' },
             { data: 'purchase_order_date' },
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

    function savepurchaseorder()
    {    
        if($("#po_no").val()=='' || $("#supplier_id").val()=='' || $("#po_date").val()=='' || $("#po_time").val()=='' || $("#total_qty").val()==''|| $("#total_amount").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Purchase_order/savepurchaseorder";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#savepurchaseorder_form').serialize(),
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

function editpurchaseorder(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Purchase_order/getsavedata';
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
                  $('#tab_tit').html('Edit Purchase Order');
                  $('#po_no').val(data.getmasterdata[0]['purchase_order_no']);
                  $("#supplier_id").val(data.getmasterdata[0]['supplier_id']).trigger("change");
                  $('#po_date').val(data.getmasterdata[0]['purchase_order_date']);
                  $('#po_time').val(data.getmasterdata[0]['purchase_order_time']);
                  $('#gst_selection').val(data.getmasterdata[0]['gst_selection']);
                  $('#total_qty').val(data.getmasterdata[0]['total_qty']);
                  $('#total_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  $('#demo_frametype').val(data.demoframetype);
                  $('#demo_framecolor').val(data.demoframecolor);
                  $('#demo_framemodel').val(data.demoframemodel);
                  $('#demo_framesize').val(data.demoframesize);
                  $('#edit_purchase_order_id').val(data.getmasterdata[0]['purchase_order_id']);
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

function updatepurchaseorder()
{
        
        if($("#edit_purchase_order_id").val()=='' || $("#po_no").val()=='' || $("#supplier_id").val()=='' || $("#po_date").val()=='' || $("#po_time").val()=='' || $("#total_qty").val()==''|| $("#total_amount").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Purchase_order/editpurchaseorder";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#savepurchaseorder_form').serialize(),
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

function deletepurchaseorder(val)
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
            delurl="Purchase_order/deletepurchaseorder";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#savepurchaseorder_form').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#savepurchaseorder_form")[0].reset();
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
<script src="<?=$path?>app-assets/js/scripts/transaction.js"></script>
          
          