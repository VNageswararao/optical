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
                                    <h4 class="card-title">Sales Return</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true"><l id="tab_tit">Add Sales Return<l></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                          
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                                <form id="savesalesreturn_form" action="#" method="post"> 
                                                    <input type="hidden" name="edit_sales_return_id" id="edit_sales_return_id">
                                                 <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                  
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="lastname">Sales No/Customer Name: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="sales_id" id="sales_id" onchange="loadsalesdetails($(this).val());">
                                                <option value="0">Select Sales No/Customer Name</option>
                                                <?php if($getinvoiceno)
                                                {
                                                    foreach ($getinvoiceno as $data) {
                                                       ?>
                                                       <option value="<?php print $data['sales_id'] ?>"><?php print $data['invoice_number'] ?>- <?php print $data['name'] ?></option>
                                                       <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sales_return_date" id="sales_return_date" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Time: <span class="text-danger">*</span></label>
                                            <input type="time" name="sales_return_time" id="sales_return_time" class="form-control">
                                        </div>
                                    </div>
                                </div>

                               

                                  <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive">
                                           <table class="table table-hover" id="productdetails" bquotation="0">
                                                <thead>
                                                    <tr>
                                                        <th>Remove</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Rate</th>
                                                        <th>Sales Qty</th>
                                                        <th>Qty</th>
                                                        <th>Frame Type</th>
                                                        <th>Colour</th>
                                                        <th>Size</th>
                                                        <th>Model</th>
                                                        <th>Lens Type</th>
                                                        <th>Coating</th>
                                                        <th>Dtype</th>
                                                        <th>Discnt</th>
                                                        <th>Total Amount</th>
                                                        <th style="display: none;">Tax Type</th>
                                                        <th style="display: none;">Tax</th>
                                                        <th style="display: none;">CGST</th>
                                                        <th style="display: none;">SGST</th>
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
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Total Qty: <span class="text-danger">*</span></label>
                                            <input type="text" name="total_qty" id="total_qty" class="form-control" style="text-align:right" readonly="">
                                        </div>
                                    </div>
                                       <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Cgst:</label>
                                            <input type="text" name="total_cgst" id="total_cgst"  class="form-control" readonly="" style="text-align:right">
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Sgst:</label>
                                            <input type="text" name="total_sgst" id="total_sgst" class="form-control" readonly="" style="text-align:right">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Tot Amnt:</label>
                                           <input type="hidden" name="net_amount" id="net_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 25px;background: gold;">
                                            <input type="text" name="total_amount" id="total_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 25px;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Discount Percentage:</label>
                                             <input type="text" name="total_discount_percentage" id="total_discount_percentage" style="text-align:right" value=""  class="form-control"  onkeyup="find_discount_amount();calcnet();" onkeypress="isFloat(event)">
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Discount Amount: </label>
                                            <input type="text" name="total_discount_amount" id="total_discount_amount" class="form-control" style="text-align:right"  onkeyup="find_discount_percentage();calcnet();" value="" >
                                        </div>
                                    </div>
                                 </div>
                               
                                 <div class="row">
                                     
                                     <div class="col-md-2">
                                     <label>Other charge</label>
                                     <input type="text" name="other_charge" id="other_charge" class="form-control" style="text-align:right" onkeyup="calcnet()" value="" onkeypress="isFloat(event)">
                                  </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Advance Amount: <span class="text-danger">*</span></label>
                                            <input type="text" readonly name="paying_amount" class="form-control" id="input_amount" onkeyup="balance_calculate($(this).val())" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Balance Amount: <span class="text-danger">*</span></label>
                                           <input type="text" name="balance_amount" class="form-control" readonly="" id="output_amount" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Round off: <span class="text-danger">*</span></label>
                                           <input type="text" name="roundoff" id="roundoff" class="form-control" readonly="" style="text-align:right;">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Net Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="invoice_amount" id="invoice_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 30px;">
                                        </div>
                                    </div>
                                 </div>
                                  <div class="row" style="display: none;">
                                      <div class="col-md-3">
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Status: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="bill_status" id="bill_status">
                                                <option>Select status</option>
                                                <option value="1">Inprogress</option>
                                                <option value="2">Delivered</option>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Expected Delivered Date: <span class="text-danger">*</span></label>
                                            <input  type="date" name="edate" id="edate" class="form-control">
                                        </div>
                                    </div>
                                 </div>
                               
                         

                          

                              <div class="card-footer ml-auto">
                                    <button id="save" type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savesalesreturn();">Submit</button>
                                    <button style="display: none;" id="update" type="button" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1" onclick="updatesalesreturn();">Update</button>
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
                                                            <th>Bill No</th>
                                                            <th>Customer Name</th>
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
                                                                <th>Bill No</th>
                                                                <th>Customer Name</th>
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
          'ajax':'<?=base_url()?>transaction/Sales_return/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'bill_number' },
             { data: 'name' },
             { data: 'sales_return_date' },
             { data: 'total_qty' },
             { data: 'netamount' },
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
    $('#sales_return_date').val(cd);
    

    timee="<?php Echo date('H:i'); ?>";
    $('#sales_return_time').val(timee);
});

function editsalesreturn(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Sales_return/getsavedata';
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
                  $('#tab_tit').html('Edit Sales Return');
                  $("#sales_id").val(data.getmasterdata[0]['sales_id']);
                  $('#sales_return_date').val(data.getmasterdata[0]['sales_return_date']);
                  $('#sales_return_time').val(data.getmasterdata[0]['sales_return_time']);
                  $('#total_qty').val(data.getmasterdata[0]['total_qty']);
                  $('#total_cgst').val(data.getmasterdata[0]['total_cgst']);
                  $('#total_sgst').val(data.getmasterdata[0]['total_sgst']);
                  $('#total_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#net_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#total_discount_amount').val(data.getmasterdata[0]['discount_amount']);
                  $('#total_discount_percentage').val(data.getmasterdata[0]['discount_percentage']);
                  $('#other_charge').val(data.getmasterdata[0]['other_charge']);
                  $('#input_amount').val(data.getmasterdata[0]['advanced_amount']);
                  $('#output_amount').val(data.getmasterdata[0]['balance_amount']);
                  $('#roundoff').val(data.getmasterdata[0]['roundoff']);
                  $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']);
                  $('#invoice_amount').val(data.getmasterdata[0]['netamount']);
                  $('#bill_status').val(data.getmasterdata[0]['status']);
                  $('#edate').val(data.getmasterdata[0]['expected_del_date']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  $('#edit_sales_return_id').val(data.getmasterdata[0]['sales_return_id']);
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
function updatesalesreturn()
{ 
        if($("#sales_id").val()=='' || $("#sales_return_date").val()=='' || $("#sales_return_time").val()=='' || $("#total_qty").val()=='' || $("#bill_status").val()==''|| $("#modeofpay_id").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       
         upurl="Sales_return/editsalesreturn";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#savesalesreturn_form').serialize(),
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
    function loadsalesdetails(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Sales_return/getsalessaveddata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  $("#sales_id").val(data.getmasterdata[0]['sales_id']);
                  $('#sales_return_date').val(data.getmasterdata[0]['sales_date']);
                  $('#sales_return_time').val(data.getmasterdata[0]['sales_time']);
                  $('#total_qty').val(data.getmasterdata[0]['total_qty']);
                  $('#total_cgst').val(data.getmasterdata[0]['total_cgst']);
                  $('#total_sgst').val(data.getmasterdata[0]['total_sgst']);
                  $('#total_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#net_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#total_discount_amount').val(data.getmasterdata[0]['discount_amount']);
                  $('#total_discount_percentage').val(data.getmasterdata[0]['discount_percentage']);
                  $('#other_charge').val(data.getmasterdata[0]['other_charge']);
                  $('#input_amount').val(data.getmasterdata[0]['advanced_amount']);
                  $('#output_amount').val(data.getmasterdata[0]['balance_amount']);
                  $('#roundoff').val(data.getmasterdata[0]['roundoff']);
                  $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']);
                  $('#invoice_amount').val(data.getmasterdata[0]['netamount']);
                  $('#bill_status').val(data.getmasterdata[0]['status']);
                  $('#edate').val(data.getmasterdata[0]['expected_del_date']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  //$('#edit_sales_id').val(data.getmasterdata[0]['sales_id']);
                  //$('#save').hide();
                  //$('#update').show();

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
function deletesalesreturn(val)
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
            delurl="Sales_return/deletesalesreturn";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#savesalesreturn_form').serialize()+"&id="+val,
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
function savesalesreturn()
    {    
        if($("#customer_id").val()=='' || $("#sales_date").val()=='' || $("#sales_time").val()=='' || $("#total_qty").val()=='' || $("#bill_status").val()==''|| $("#modeofpay_id").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Sales_return/savesalesreturn";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#savesalesreturn_form').serialize(),
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
function find_discount_percentage()
   {
      var discount= $('#total_discount_amount').val();
      var total_amount=$('#total_amount').val();
         discount=parseFloat(discount);
         total_amount=parseFloat(total_amount);
        if(discount>0&&(total_amount>=discount))
        {
            var percentage=(discount*100)/total_amount;
            $('#total_discount_percentage').val(percentage.toFixed(2));
        }else{
            $('#total_discount_amount').val('');
            $('#total_discount_percentage').val(0);
        }
   }
        function changefocus(event,ref)
   {
      var ref_id= ref.attr('id');
      var index=ref_id.split("_")[1];
      index=parseInt(index);
     
    var keycode = (event.keyCode ? event.keyCode : event.which);
    
    if(keycode == '13'){
        event.preventDefault();
        $('#pro_name').val('');
        $('#pro_name').focus();
    }else if(keycode == '38')
    {
        while(index>0)
        {
            index--;
            if($('#quantity_'+index).length>0)
            {
            $('#quantity_'+index).focus();
            break;
            }
        }
    }else if(keycode == '40')
    {
        while(index<row_num)
        {
         index++;
            if($('#quantity_'+index).length>0)
            {
            $('#quantity_'+index).focus();
            break;
            }
        }
    }
   }
     function find_discount_amount()
   {
       var percentage=$('#total_discount_percentage').val();
       var total_amount=$('#total_amount').val();
       percentage=parseFloat(percentage);
       total_amount=parseFloat(total_amount);
        if(percentage>0)
        {
            var amount=(percentage*total_amount)/100;
            $('#total_discount_amount').val(amount.toFixed(2));
        }else{
            $('#total_discount_amount').val(0);
            $('#total_discount_percentage').val('');
        }
   }
     function changeActive(ref,event)
  {
      $('.product_select').removeClass('product_select');
      if(event.keyCode==40)
      {
          ref.next().addClass('product_select');
          $('.product_select').focus();
      }
      if(event.keyCode==38)
      {
          ref.prev().addClass('product_select');
          $('.product_select').focus();
      }
      if(event.keyCode==13)
      {
          var index=ref.attr('tabindex');
          if($('#category_id').val()==2)
          {
            addProduct(index);
          }
          else if($('#category_id').val()==1)
          {
            addlensProduct(index);
          }
          return;
      }
      
  }
function add_focus_to_first(event)
{
    if((event.keyCode==13)||(event.keyCode==40))
    {
        event.preventDefault();
        $('#sugession').children('tr:first').addClass('product_select');
        $('.product_select').focus();
    }
}
var timeout = 500;
var timer;
function findInclusive_taxamount(price,tax)
 {
   if((have_cess==1)&&(have_gst==2)&&(tax>=12))
     {
         var taxable_amount=price*100/(100+tax+1);
          return taxable_amount*tax/100;
     }
     var taxable_amount=price*100/(100+tax);
    return taxable_amount*tax/100;
 }
 function findExclusive_taxamount(price,tax)
 {
     return price*tax/100;
 }
 function get_cess_exclusive(amount,tax)
 {
     if((have_cess==1)&&(have_gst==2)&&(tax>=12))
     {
       return  amount*1/100;
     }
    return 0;  
 }
function findIntValue(id)
{
    
    var value=$("#"+id).val();
       value=parseInt(value);
    if(isNaN(value))
    {
        return 0;
    }else{
        return value;
    }
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
function setActive(ref)
  {
      $('.product_select').removeClass('product_select');
      ref.addClass('product_select');
  }
    function get_cess_inclusive(amount,tax)
 {
   
     if((have_cess==1)&&(have_gst==2)&&(tax>=12))
     {
      var taxable_amount=amount*100/(100+tax+1);
       var  cess=taxable_amount/100;
       return cess.toFixed(4);
     }
    return 0;  
 }
 function calcrow(eid)
{
   
   var quantity=findFloatValue('quantity_'+eid);
   var selling_price=findFloatValue('selling_price_'+eid);
   var price=quantity*selling_price;
   if($('#discount_type_'+eid).val()==0)
   {
       $('#discount_amount_'+eid).val(findIntValue('discount_input_'+eid));
   }else{
      var discount_percentage= findIntValue('discount_input_'+eid);
      var discount_amount=price*discount_percentage/100;
       $('#discount_amount_'+eid).val(discount_amount);
   }
   var price_reduced_discount=price-findFloatValue('discount_amount_'+eid);
   
   var gst_type=findIntValue('tax_type_'+eid);
   var customer_type=2;
   
   switch(gst_type)
   {
       case 0:$('#cgst_'+eid).val('0');
              $('#sgst_'+eid).val('0');
              $('#amount_'+eid).val(price_reduced_discount.toFixed(2));
              break;
       case 1:var taxamount=findInclusive_taxamount(price_reduced_discount,findFloatValue('gst_'+eid));
            
              var cess=get_cess_inclusive(price_reduced_discount,findFloatValue('gst_'+eid));
              $('#tax_amount_'+eid).val(taxamount);
              if(customer_type==1)
              {
                   $('#cgst_'+eid).val('0');
                   $('#sgst_'+eid).val('0');
              }else
              {
                
                  var cgst=taxamount/2;
                  var sgst=taxamount/2;
                   $('#cgst_'+eid).val(cgst.toFixed(2));
                   $('#sgst_'+eid).val(sgst.toFixed(2));
                   $('#igst_'+eid).val('0');
               }
               $('#cess_'+eid).val(cess);
               $('#amount_'+eid).val(price_reduced_discount.toFixed(2));
              break;
       case 2:var taxamount=findExclusive_taxamount(price_reduced_discount,findFloatValue('gst_'+eid));
              var cess=get_cess_exclusive(price_reduced_discount,findFloatValue('gst_'+eid))
                $('#tax_amount_'+eid).val(taxamount);
              if(customer_type==1)
              {
                  
                   $('#cgst_'+eid).val('0');
                   $('#sgst_'+eid).val('0');
                   
              }else
              {
                  var cgst=taxamount/2;
                  var sgst=taxamount/2;
                   $('#cgst_'+eid).val(cgst.toFixed(2));
                   $('#sgst_'+eid).val(sgst.toFixed(2));
                   
               }
               $('#cess_'+eid).val(cess.toFixed(4));
               var amount=price_reduced_discount+taxamount+cess;
               $('#amount_'+eid).val(amount.toFixed(2));
              break;
   }

   calcnet();
   $("#total_discount_percentage").keyup();
}
function calcnet()
  { 
      var total_qty=0;
      var total_cgst=0;
      var total_sgst=0;
      var total_igst=0;
      var total_amount=0;
      var total_cess=0;
      var i=1;
      var row_num = $('#productdetails tr').length;
    while(i<row_num)
    {
        
        total_qty+=findFloatValue('quantity_'+i);
        total_cgst+=findFloatValue('cgst_'+i);
        total_sgst+=findFloatValue('sgst_'+i);
        total_amount+=findFloatValue('amount_'+i);
        i++;
    };
    $('#total_qty').val(total_qty.toFixed(2));
    $('#total_cgst').val(total_cgst.toFixed(2));
    $('#total_sgst').val(total_sgst.toFixed(2));
    $('#total_amount').val(total_amount.toFixed(2));
    var total_discount=findFloatValue('total_discount_amount');
    var other_charge=findFloatValue('other_charge');
    var returnamnt=findFloatValue('returnamnt');
    if(returnamnt)
    {
        returnamnt=returnamnt;
    }
    else
    {
        returnamnt=0;
    }
    var net_amount=total_amount-total_discount+other_charge-returnamnt;
    $('#net_amount').val(net_amount.toFixed(2));
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
    $('#roundoff').val(round.toFixed(2));
    $('#invoice_amount').val(invoice_amount+'.00');
     $('#topshow').html(invoice_amount+'.00');
    if($('#modeofpay_id').val()==11)
    {
    //$('#cash_payment').val(net_amount.toFixed(2));
    }
    $('#submit').show();
      if($('#if_crlimit').val()==1)
    {
     
    if($('#modeofpay_id').val()==9)
    {
       var crlimit= parseFloat($('#crlimit').val());
        if(invoice_amount>crlimit)
        {
            errorMessage("Credit Limit Over");
            $('#submit').hide();
        }else
        {
           $('#submit').show();
        }
    }
  }
  $("#input_amount").val('');
  balance_calculate('');
}
    function balance_calculate(input_amount)
 {
    if(input_amount>0){
     var input_amount=parseFloat(input_amount);
     if(isNaN(input_amount))
     {
         input_amount=0;
     }
     var invoice_amount=parseFloat($('#invoice_amount').val());
     if(isNaN(invoice_amount))
     {
         invoice_amount=0;
     }
     var output_amount=parseFloat(invoice_amount)-parseFloat(input_amount);
     // if(output_amount>0)
     // {
     //     //errorMessage("amount could not less than bill amount");
     //     $('#output_amount').val('');
     //     return;
     // }
     $('#output_amount').val(output_amount);
   }
 }
</script>

          