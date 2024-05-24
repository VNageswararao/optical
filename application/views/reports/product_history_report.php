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
                                     <h4 class="card-title">Product History Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View Report</a>
                                            </li>
                                            
                                        </ul>
                 
                                            <div class="tab-pane active" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                  <form id="detailed" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="det_fromdate" id="det_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="det_todate" id="det_todate" class="form-control">
                                        </div>
                                    </div>
                                  

                                    <div class="col-md-4">
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
});
 var table;



function getdetailed()
    { 
        if($("#det_fromdate").val()=='' || $("#det_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_det').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Product_history_report/getdetailed";
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
                     buttons: [ 'excel' ],
       
        dom: 'Blfrtip',
        columnDefs: [ {
               
                lengthMenu: [[10, 25, 50, 100, 500, 5000, -1], [10, 25, 50, 100, 500, 5000, "All"]]
        }]
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
