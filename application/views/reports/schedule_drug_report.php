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
                                     <h4 class="card-title">Schedule Drug Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Schedule Drug Report</a>
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
                                    
                                        <div class="col-md-3"  >
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_item" id="det_item">
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
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Schedule Drug: </label>
                                            <select class="form-control" name="schedule_drug" id="schedule_drug">
                                                <?php if($getschedule)
                                                {
                                                  foreach ($getschedule as $data) {
                                                    ?>
                                                      <option value="<?php print $data['schedule_drug_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                   
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getdetailed();">Submit</button>
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
   
});
 var table;


function getdetailed()
    { 
        if($("#sum_fromdate").val()=='' || $("#sum_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Schedule_drug_report/getdetailed";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#summary').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sum').html(data.getdata);
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
