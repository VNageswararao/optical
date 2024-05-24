<?php 
$path=base_url('template1/modern-admin/');
$host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
?>      
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                     <h4 class="card-title">Credit Bill</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Credit Bill</a>
                                            </li>
                                        </ul>
                   <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                              <form id="summary" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_fromdate" id="sum_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_todate" id="sum_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Customer Name: </label>
                                            <select class="form-control" name="sum_customer" id="sum_customer">
                                                <option value>Select Customer Name</option>
                                                <?php if($getcustomer)
                                                {
                                                  foreach ($getcustomer as $data) {
                                                    ?>
                                                      <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: </label>
                                            <select class="form-control" name="sum_modeofpay" id="sum_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    $sel='';
                                                    if($data['modeofpay_id']==3)
                                                    {
                                                        $sel='selected';
                                                    }
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>" <?php echo $sel; ?>><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" style="display:none;">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Staff: </label>
                                            <select class="form-control" name="staff" id="staff">
                                                <option value>Select Staff</option>
                                                <?php if($getstaff)
                                                {
                                                  foreach ($getstaff as $data) {
                                                    ?>
                                                      <option value="<?php print $data['staff_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Status: </label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="0">Select All</option>
                                                 <option value="1">Inprogress</option>
                                                 <option value="2">Delivered</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-5" style="display:none;">
                                        <div class="form-group">
                                            <label for="lastname">Supplier: </label>
                                            <select class="form-control" name="supplier_id" id="supplier_id">
                                                <option value>Select Supplier</option>
                                                <?php if($getsupp)
                                                {
                                                  foreach ($getsupp as $data) {
                                                    ?>
                                                      <option value="<?php print $data['supplier_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getsummary();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_sum">
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                           

                                 

                               
                            </form>
                       </div>
                                        


                                           



                                            <div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
                                                 <div class="card-body collapse show">
                                                 <form id="producthistory" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name"  value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="pro_fromdate" id="pro_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="pro_todate" id="pro_todate" class="form-control">
                                        </div>
                                    </div>
                              
                                 
                                      
                                    <div class="col-md-3" id="det_itemm" >
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="pro_item" id="pro_item">
                                                <option value>Select Item</option>
                                                <?php if($getitem)
                                                {
                                                  foreach ($getitem as $data) {
                                                    ?>
                                                      <option value="<?php print $data['item_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                       
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getproducthistory();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_producthistory">
                                           
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                                                
                                                </div>
                                            </div>






                                          
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
  $( document ).ready(function() {
    cd = (new Date()).toISOString().split('T')[0];
    $('#sum_fromdate').val(cd);
    $('#sum_todate').val(cd);
    $('#det_fromdate').val(cd);
    $('#det_todate').val(cd);
    $('#col_fromdate').val(cd);
    $('#col_todate').val(cd);
    $('#mon_fromdate').val(cd);
    $('#mon_todate').val(cd);
    $('#pro_fromdate').val(cd);
    $('#pro_todate').val(cd);
});
 var table;



 
function getproducthistory()
    { 
        if($("#pro_fromdate").val()=='' || $("#pro_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_producthistory').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/producthistory";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#producthistory').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_producthistory').html(data.getdata);
                 $('#example_producthostory').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
                } );
                
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


function getsummary()
    { 
        if($("#sum_fromdate").val()=='' || $("#sum_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Creditbill/getsummary";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#summary').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sum').html(data.getdata);
                 $('#example_sum').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
                } );
                
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
function creditbilpayment(val)
{
      if(val=='') {
           Swal.fire({title:"Info!",text:"Sales ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
          Swal.fire({title:"Are you sure to Payment Done?",
            text:"You won't be able to revert this!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Sure it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
            delurl="Creditbill/paymentdone";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#summary').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
              location.reload();
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
function getdetailed()
    { 
        if($("#det_fromdate").val()=='' || $("#det_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_det').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getdetailed";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#detailed').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_det').html(data.getdata);
                 $('#example_det').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
                } );
                
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

function getmonthlywise()
    { 
        if($("#mon_fromdate").val()=='' || $("#mon_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_mon').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getmonthly";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#monthly').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_mon').html(data.getdata);
                 $('#example_mon').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
                } );
                
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

function getcollection()
    { 
        if($("#col_fromdate").val()=='' || $("#col_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_col').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getcollection";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#collection').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_col').html(data.getdata);
                 $('#example_col').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
                } );
                
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

   $(document).ready(function () {   
    $('body').on('change','#det_category', function() {
         cat=$('#det_category').val();
         if(cat>0)
         {
            if(cat==2)
            {
              $('#det_itemm').show();
              $('#det_lenss').hide();
            }
            else if(cat==1)
            {
              $('#det_itemm').hide();
              $('#det_lenss').show();
            }
            else
            {
              $('#det_itemm').show();
              $('#det_lenss').hide();
            }
         }
    });
});        
          </script>
