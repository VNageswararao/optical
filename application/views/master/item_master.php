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
                                    <h4 class="card-title">Item Master</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Item</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                        <form id="item_master" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Category:<span class="text-danger">*</span></label>
                                          <select class="form-control" name="category_id" id="category_id">
                                                <option value="">Select Category Name</option>
                                                <?php
                                                if($category)
                                                {
                                                    foreach ($category as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Company Name: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="company_id" id="company_id">
                                                <option value="">Select Company Name</option>
                                                 <?php
                                                if($company)
                                                {
                                                    foreach ($company as $data) {
                                                        ?>
                                                        <option value="<?php print $data['company_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Item Code: <span class="text-danger">*</span></label>
                                           <input type="text" name="code" id="code" class="form-control" readonly value="<?php print $codeno; ?>" placeholder="Item Code">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Item Name: <span class="text-danger">*</span></label>
                                           <input type="text" name="name" id="name" class="form-control" placeholder="Item Name">
                                        </div>
                                    </div>
                                   
                                </div>
                                  <div class="row">
                                   
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">HSN Code: </label>
										    <select class="form-control" name="hsn_master_id" id="hsn_master_id">
												<option value="">Select HSN Code</option>
												<?php if ($hsncode) {
													foreach ($hsncode as $data) { ?>
														<option value="<?php print $data['hsn_master_id']; ?>"><?php print $data['hsn_code']; ?></option>
												<?php }
												} ?>
											</select>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Gst: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="gst_type" id="gst_type" onchange="changeVat($(this).val())">
                                               <option value="">NonTax</option>
                                               <option value="1">Inclusive</option>
                                               <option value="2">Exclusive</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="row col-md-6" id="tax_gst" style="display: none;">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Tax: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="tax" id="tax" onchange="changeTaxval($(this).val())">
                                            <option value="">Select Tax</option>
                                               <?php
                                               if($tax)
                                               {
                                                foreach ($tax as $data) 
                                                {
                                                   ?>
                                                   <option value="<?php print $data['tax_id'] ?>"><?php print $data['name'] ?></option>
                                                   <?php
                                                }
                                               }
                                               ?>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">CGST%: </label>
                                           <input type="text" readonly name="cgst" id="cgst" class="form-control" placeholder="CGST">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">SGST%: </label>
                                           <input type="text" readonly name="sgst" id="sgst" class="form-control" placeholder="SGST">
                                        </div>
                                    </div>
                                </div>
                                    
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Brand:</label>
                                          <select class="form-control" name="brand_id" id="brand_id">
                                                <option value="0">Select Brand Name</option>
                                                 <?php
                                                if($brand)
                                                {
                                                    foreach ($brand as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="description" name="description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group mt-1">
                                        <label for="switcheryColor2" class="card-title ml-1">De-Active</label>
                                          <input type="checkbox" value="1" id="switcheryColor2" class="switchery" name="status" data-color="info" checked />
                                          <label for="switcheryColor2" class="card-title ml-1">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="saveitem();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                      <form id="edit_item" action="#" method="post"> 
 <div id="item_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="div_modal">
                               <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Category:</label>
                                             <input type="hidden" name="edit_itemid" id="edit_itemid">
                                           <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                          <select class="form-control" name="edit_category_id" id="edit_category_id">
                                                <option value="">Select Category Name</option>
                                                <?php
                                                if($category)
                                                {
                                                    foreach ($category as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Company Name: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="edit_company_id" id="edit_company_id">
                                                <option value="">Select Company Name</option>
                                                 <?php
                                                if($company)
                                                {
                                                    foreach ($company as $data) {
                                                        ?>
                                                        <option value="<?php print $data['company_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Item Code: <span class="text-danger">*</span></label>
                                           <input type="text" readonly name="edit_code" id="edit_code" class="form-control" placeholder="Item Code">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Item Name: <span class="text-danger">*</span></label>
                                           <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Item Name">
                                        </div>
                                    </div>
                                   
                                </div>
                                       <div class="row">
                                   
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">HSN Code: </label>
											 <select class="form-control" name="hsn_master_id" id="edit_hsn_master_id" onchange="changehsncode($(this).val(),1)">
													<option value="">Select HSN Code</option>
													<?php if ($hsncode) {
														foreach ($hsncode as $data) { ?>
															<option value="<?php print $data['hsn_master_id']; ?>"><?php print $data['hsn_code']; ?></option>
													<?php }
													} ?>
												</select>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Gst: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="edit_gst_type" id="edit_gst_type" onchange="changeeditVat($(this).val())">
                                               <option value="">NonTax</option>
                                               <option value="1">Inclusive</option>
                                               <option value="2">Exclusive</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="row col-md-6" id="edittax_gst">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Tax: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="edit_tax" id="edit_tax" onchange="changeTaxval($(this).val(),1)">
                                            <option value="">Select Tax</option>
                                               <?php
                                               if($tax)
                                               {
                                                foreach ($tax as $data) {
                                                   ?>
                                                   <option value="<?php print $data['tax_id'] ?>"><?php print $data['name'] ?></option>
                                                   <?php
                                                }
                                               }
                                               ?>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">CGST%: </label>
                                           <input type="text" readonly name="edit_cgst" id="edit_cgst" class="form-control" placeholder="CGST">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">SGST%: </label>
                                           <input type="text" readonly name="edit_sgst" id="edit_sgst" class="form-control" placeholder="SGST">
                                        </div>
                                    </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Brand:</label>
                                          <select class="form-control" name="edit_brand_id" id="edit_brand_id">
                                                <option value="0">Select Brand Name</option>
                                                 <?php
                                                if($brand)
                                                {
                                                    foreach ($brand as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                </div>
                                  <div class="row">
                                     <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="edit_description" name="edit_description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                       <div class="col-md-4">
                                         <div class="form-group">
                                             <label for="lastname">Status: </label>
                                         <select class="form-control" name="edit_status" id="edit_status">
                                            <option value="1">Active</option>
                                            <option value="0">De-Active</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                              
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updateitem();"><i class="fas fa-plus-square"></i>Update</button>

                    <button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
                                                <div class="table-responsive">
                                         <table id="tableid" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                            <th>Sl No</th>
                                                            <th>Code</th>
                                                            <th>Name</th>
                                                            <th>HSN Code</th>
                                                            <th>Status</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Code</th>
                                                                <th>Name</th>
                                                                <th>HSN Code</th>
                                                                <th>Status</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </tfoot>
                                                      </table>
                                    </div>
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
                function changeVat(vat)
                {
                    if(vat==0)
                    {
                      $('#tax_gst').hide();
                      $('#cgst').val('');
                      $('#sgst').val('');
                      $('#tax').val('');
                    }else{
                      $('#tax_gst').show();  
                    }
                }
                 function changeeditVat(vat)
                {
                    if(vat==0)
                    {
                      $('#edittax_gst').hide();
                      $('#edit_cgst').val('');
                      $('#edit_sgst').val('');
                      $('#edit_tax').val('');
                    }else{
                      $('#edittax_gst').show();  
                    }
                }

           
 var table;
$( document ).ready(function() {
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>master/Item_master/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'code' },
             { data: 'name' },
             { data: 'hsn_code' },
             { data: 'status' },
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
          </script>

          