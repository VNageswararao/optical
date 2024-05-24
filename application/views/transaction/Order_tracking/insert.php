
<style type="text/css">
    .product_select{
        background-color:#E9ECED;
    }
 
    
    .disabled_select {
    pointer-events: none;
    cursor: not-allowed;
}

  .order{
          .order-number{
            font-size: 20px;
            font-weight: bold;
            color: #0A0A0A;
          }
          .order-status{
            color: #F29702;
            font-weight: 600;
          }
        }

     .order-tracking{
	text-align: center;
	width: 25%;
	position: relative;
	display: block;
}
.order-tracking .is-complete{
	display: block;
	position: relative;
	border-radius: 50%;
	height: 30px;
	width: 30px;
	border: 0px solid #AFAFAF;
	background-color: #f7be16;
	margin: 0 auto;
	transition: background 0.25s linear;
	-webkit-transition: background 0.25s linear;
	z-index: 2;
}
.order-tracking .is-complete:after {
	display: block;
	position: absolute;
	content: '';
	height: 14px;
	width: 7px;
	top: -2px;
	bottom: 0;
	left: 5px;
	margin: auto 0;
	border: 0px solid #AFAFAF;
	border-width: 0px 2px 2px 0;
	transform: rotate(45deg);
	opacity: 0;
}
.order-tracking.completed .is-complete{
	border-color: #27aa80;
	border-width: 0px;
	background-color: #27aa80;
}
.order-tracking.completed .is-complete:after {
	border-color: #fff;
	border-width: 0px 3px 3px 0;
	width: 7px;
	left: 11px;
	opacity: 1;
}
.order-tracking p {
	color: #A4A4A4;
	font-size: 16px;
	margin-top: 8px;
	margin-bottom: 0;
	line-height: 20px;
}
.order-tracking p span{font-size: 14px;}
.order-tracking.completed p{color: #000;}
.order-tracking::before {
	content: '';
	display: block;
	height: 3px;
	width: calc(100% - 40px);
	background-color: #f7be16;
	top: 13px;
	position: absolute;
	left: calc(-50% + 20px);
	z-index: 0;
}
.order-tracking:first-child:before{display: none;}
.order-tracking.completed:before{background-color: #27aa80;}


            
</style>
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Order Tracking</h4>
                                    <div id="edit_data"></div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="false">Order Tracking
											</a>
                                            </li> 
										</ul>
										 <div class="tab-content px-1 pt-1">
											<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
											 <form id="summary" action="#" method="post"> 
												<input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
												<div class="row">
													   <div class="col-md-4">
														   <div class="form-group">
															   <label>Customer Name or mobile no or Invoice No<span class="text-danger">*</span></label>
															  <select class="form-control select2" name="status_customer" id="status_customer">
																   <option value=" ">Select Customer Name</option>
																<?php
																	if($getcustomersales)
																	{
																		foreach ($getcustomersales as $data) {
																			?>
																	<option value="<?php print $data['sales_id']; ?>"><?php print $data['name']; ?>-<?php print $data['mrd']; ?>-<?php print $data['mobile']; ?>-<?php print $data['invoice_number']; ?></option>
																			<?php
																		}
																	}
																 ?>
															  </select>
														   </div>
														 </div>
														<div class="col-md-2">
															<button type="button" style="margin-top: 30px;padding: 9px 15px;" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getsummary();">Show</button>
														</div>
												 </div>
												
												<hr/>
												<div class="row">
													<div class="col-md-12">
													 <div class="form-group">
														<div class="table-responsive" id="showdata_sum" style="overflow: hidden;">
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

function getsummary()
    { 
        if($('#status_customer').val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Order_tracking/tracking";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: {getid: $('#status_customer').val(),csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
              $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sum').html(data.getdata);
                 
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

          