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
                                    <h4 class="card-title">Generate Barcode</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Generate Barcode</a>
                                            </li>
                                           
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                            <form id="classification" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname"> Supplier/Invoice No: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="inv_no" id="inv_no">
                                            	<option value="">Select Supplier/Invoice No</option>
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
                                 
                                </div>
                               
                            

                                

                                <div class="card-footer ml-auto">
                            <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="Generatebarcode();">Generate</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
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
        	      function Generatebarcode(){

        	if($('#inv_no').val()=='') {
          			 Swal.fire({title:"Info!",text:"Please Select Supplier/Invoice No!",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
         			  return false;
       			 }
               $('<form target="_blank" method="post" action="<?php echo base_url('transaction/Barcode/Generatebarcode'); ?>"><input name="barcode_id" value="'+$('#inv_no').val()+'"/><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();
           }
			
			
        </script>
