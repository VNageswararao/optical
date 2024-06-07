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
                                     <h4 class="card-title">Stock Transfer Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Stock Transfer Report</a>
                                            </li>
                                           
                                            
                                        </ul>
                                         <div class="tab-content px-1 pt-1">
                                                   <div class="tab-pane active" id="tab1" aria-labelledby="base-tab1">
                                                 <div class="card-body collapse show">
                                                  <form id="stcok_transfer" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name2" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                      
                                      <div class="col-md-3" >
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="sfrom_date" id="sfrom_date"   >
                                        </div>
                                    </div>
                                    <div class="col-md-3" >
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="sto_date" id="sto_date"   >
                                        </div></div>
                                        
                                    <div class="col-md-3" id="det_itemm" >
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="sdet_item" id="sdet_item">
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
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getsalesregister();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_sales_register">
                                           
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
   
     $('#sfrom_date').val(cd);
    $('#sto_date').val(cd);
});
 var table;



function getsalesregister()
    { 
        if($("#sfrom_date").val()=='' || $("#sto_date").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sales_register').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Stock_transfer_report/getstockRegister_data";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#stcok_transfer').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sales_register').html(data.getdata);
                   var table = $('#example_suma').DataTable( {
       "drawCallback": function( settings ) {

 

// add as many tooltips you want

},
        buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ],
       
        dom: 'Blfrtip',
       "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
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
