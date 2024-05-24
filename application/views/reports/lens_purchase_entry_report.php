<?php 
$path=base_url('template1/modern-admin/');
$conred='readonly';
     if($this->session->userdata('user_type')==1)
   {
        $conred='';
   }
?>      
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                     <h4 class="card-title">Lens Purchase Entry Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Summary Report</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Detailed Report</a>
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
                                            <input type="date" <?php echo $conred; ?> name="sum_fromdate" id="sum_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" <?php echo $conred; ?> name="sum_todate" id="sum_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: </label>
                                            <select class="form-control select2" name="sum_supplier" id="sum_supplier">
                                                <option value>Select Supplier Name</option>
                                                <?php if($getsupplier)
                                                {
                                                  foreach ($getsupplier as $data) {
                                                    ?>
                                                      <option value="<?php print $data['supplier_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: </label>
                                            <select class="form-control select2" name="sum_modeofpay" id="sum_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>"><?php print $data['name']; ?></option>
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
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                  <form id="detailed" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" <?php echo $conred; ?> name="det_fromdate" id="det_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" <?php echo $conred; ?> name="det_todate" id="det_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_supplier" id="det_supplier">
                                                <option value>Select Supplier Name</option>
                                                <?php if($getsupplier)
                                                {
                                                  foreach ($getsupplier as $data) {
                                                    ?>
                                                      <option value="<?php print $data['supplier_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_modeofpay" id="det_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_item" id="det_item">
                                                <option value>Select Item</option>
                                                <?php if($getitem)
                                                {
                                                  foreach ($getitem as $data) {
                                                    ?>
                                                      <option value="<?php print $data['lens_master_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getdetailed();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_det">
                                           
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                                                
                                                </div>
                                            </div>


                                                  <div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
                                                 <div class="card-body collapse show">
                                                  <form id="detailed1" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="det_fromdate1" id="det_fromdate1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="det_todate1" id="det_todate1" class="form-control">
                                        </div>
                                    </div>
                                    
                                     

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_item1" id="det_item1">
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
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getdetailed1();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_det1">
                                           
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
     $('#det_fromdate1').val(cd);
    $('#det_todate1').val(cd);
});
 var table;


function getsummary()
    { 
        if($("#sum_fromdate").val()=='' || $("#sum_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Lens_purchase_entry_report/getsummary";
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
function getdetailed()
    { 
        if($("#det_fromdate").val()=='' || $("#det_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_det').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Lens_purchase_entry_report/getdetailed";
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

function getdetailed1()
    { 
        if($("#det_fromdate1").val()=='' || $("#det_todate1").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_det1').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Purchase_entry_report/getdetailed1";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#detailed1').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_det1').html(data.getdata);
                 $('#example_det1').DataTable( {
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

          
          </script>
