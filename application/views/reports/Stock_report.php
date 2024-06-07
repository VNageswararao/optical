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
                                     <h4 class="card-title">Stock Report</h4>
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
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Stock Register</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Sales frame List</a>
                                            </li>
                                           
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Lens Stock</a>
                                            </li>
                                             <li class="nav-item">
                                                <a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false">Lens Stock Adjustment Report</a>
                                            </li>
                                          
                                          
                                            
                                        </ul>
                   <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                             <form id="summary" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Product Name: </label>
                                            <select class="form-control select2" name="sum_productname" id="sum_productname">
                                                <option value>Select All Product Name</option>
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
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Category: </label>
                                            <select class="form-control select2" name="category_id" id="category_id">
                                                <option value>Select Category</option>
                                                <?php if($getcategory)
                                                {
                                                  foreach ($getcategory as $data) {
                                                    ?>
                                                      <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
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
                                      
                                     <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Customer Name: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="det_customer" id="det_customer">
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
                                     <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="det_modeofpay" id="det_modeofpay">
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
                                        <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Category: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="det_category" id="det_category">
                                               
                                                <?php if($getcategory)
                                                {
                                                  foreach ($getcategory as $data) {
                                                    ?>
                                                      <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="det_itemm" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="det_item" id="det_item">
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

                                           <div class="col-md-3" id="det_lenss" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Lens Master: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="det_lens" id="det_lens">
                                                <option value>Select Item</option>
                                                <?php if($getlens)
                                                {
                                                  foreach ($getlens as $data) {
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


                                            <div class="tab-pane" id="tab3" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                  <form id="stock_register" action="#" method="post"> 
													<input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
												   <div class="row">
														  
														  <div class="col-md-3" >
															<div class="form-group">
																<label for="lastname">From Date: <span class="text-danger">*</span></label>
																<input type="date" class="form-control" name="from_date" id="from_date"   >
															</div>
														</div>
														<div class="col-md-3" >
															<div class="form-group">
																<label for="lastname">To Date: <span class="text-danger">*</span></label>
																<input type="date" class="form-control" name="to_date" id="to_date"   >
															</div></div>
															<div class="col-md-3" style="display: none;">
															<div class="form-group">
																<label for="lastname">Category: <span class="text-danger">*</span></label>
																<select class="form-control" name="det_category" id="det_category">
																   
																	<?php if($getcategory)
																	{
																	  foreach ($getcategory as $data) {
																		?>
																		  <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
																		<?php
																	  }
																	} ?>
																</select>
															</div>
														</div>
														<div class="col-md-3" id="det_itemm" >
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

															   <div class="col-md-3" id="det_lenss" style="display: none;">
															<div class="form-group">
																<label for="lastname">Lens Master: <span class="text-danger">*</span></label>
																<select class="form-control" name="det_lens" id="det_lens">
																	<option value>Select Item</option>
																	<?php if($getlens)
																	{
																	  foreach ($getlens as $data) {
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
														<button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getregister();">Submit</button>
														 <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
													</div>
													<hr/>
													<div class="row">
														<div class="col-md-12">
														 <div class="form-group">
															<div class="table-responsive" id="showdata_register">
															   
															</div>
														 </div>
													 </div>
													  </div>
												   
												</form>
                                                
                                                </div>
                                            </div>


                                             <div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
                                                 <div class="card-body collapse show">
                                                  <form id="sales_tock_register" action="#" method="post"> 
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




                                                <div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
                                                 <div class="card-body collapse show">
                                                  <form id="lens_stock" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name2" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                      
                                      
                                        
                                    <div class="col-md-6" id="det_itemm" >
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="lens_item" id="lens_item">
                                                <option value>Select Item</option>
                                               <?php if($getlens)
                                                {
                                                  foreach ($getlens as $data) {
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
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getlens();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_lens">
                                           
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                                                
                                                </div>
                                            </div>



                                                <div class="tab-pane" id="tab6" aria-labelledby="base-tab6">
                                                 <div class="card-body collapse show">
                                                  <form id="le_stock_register" action="#" method="post"> 
                                                    <input type="hidden" name="csrf_test_name"  value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                                   <div class="row">

                                                     <div class="col-md-3" >
                                                            <div class="form-group">
                                                                <label for="lastname">type: <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="lens_stock_type" id="lens_stock_type">
                                                                    <option value="1">Summary</option>
                                                                    <option value="2">Detailed</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                          
                                                          <div class="col-md-3" >
                                                            <div class="form-group">
                                                                <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" name="le_from_date" id="le_from_date"   >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" >
                                                            <div class="form-group">
                                                                <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" name="le_to_date" id="le_to_date"   >
                                                            </div></div>
                                                         
                                                      

                                                            
                                                    </div>

                                                    <div class="card-footer ml-auto">
                                                        <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getlens_adjstment();">Submit</button>
                                                         <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                                    </div>
                                                    <hr/>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                         <div class="form-group">
                                                            <div class="table-responsive" id="le_showdata_sum">
                                                               
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
    $('#from_date').val(cd);
    $('#to_date').val(cd);
     $('#sfrom_date').val(cd);
    $('#sto_date').val(cd);
     $('#le_from_date').val(cd);
    $('#le_to_date').val(cd);
});
 var table;

function getlens_adjstment()
{
    $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Stock_report/getlens_adjstment";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#le_stock_register').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#le_showdata_sum').html(data.getdata);
                 $('#example_sums').DataTable( {
                    dom: 'Bfrtip',

    "aLengthMenu": [[1000, 50, 75, -1], [1000, 50, 75, "All"]],
        "iDisplayLength": 1000,
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
       
        $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Stock_report/getsummary";
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

    "aLengthMenu": [[1000, 50, 75, -1], [1000, 50, 75, "All"]],
        "iDisplayLength": 1000,
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

function getlens()
    { 
       
        $('#showdata_lens').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Stock_report/getsummary_lens";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#lens_stock').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_lens').html(data.getdata);
                 $('#example_lens').DataTable( {
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

function getregister()
    { 
        if($("#from_date").val()=='' || $("#to_date").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_register').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Stock_report/getstockRegister";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#stock_register').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_register').html(data.getdata);
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

function getsalesregister()
    { 
        if($("#sfrom_date").val()=='' || $("#sto_date").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sales_register').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Stock_report/getsalesstockRegister";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#sales_tock_register').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sales_register').html(data.getdata);
                 $('#example_dets').DataTable( {
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
