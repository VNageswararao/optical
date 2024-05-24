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
                                    <h4 class="card-title">Add Suppliers</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Suppliers</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                            <form id="supplier" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">Supplier Code: </label>
                                           <input type="text" name="code" id="code" class="form-control" placeholder="Supplier Code" readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Name: <span class="text-danger">*</span></label>
                                           <input type="text" name="name" id="name" class="form-control" placeholder="Supplier Name">
                                        </div>
                                    </div>
                                     <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="firstname">Gender: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="gender" id="gender">
                                               <option value="1">Male</option>
                                               <option value="2">Female</option>
                                               <option value="3">Transgender</option>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Mobile: <span class="text-danger">*</span></label>
                                           <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Supplier Mobile">
                                        </div>
                                    </div>
                                   
                                </div>
                                  <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Alternate Mobile:</label>
                                           <input type="text" name="alter_mobile" id="alter_mobile" class="form-control" placeholder="Supplier Alternate Mobile">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Email ID: </label>
                                           <input type="text" name="email_id" id="email_id" class="form-control" placeholder="Supplier Email ID">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Address:</label>
                                            <textarea cols="3" rows="3" id="address" name="address" class="form-control" placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                
                                   
                                </div>
                                 <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Contact Person Name:</label>
                                           <input type="text" name="contact_person_name" id="contact_person_name" class="form-control" placeholder="Contact Person Name">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Contact Person Mobile: </label>
                                           <input type="text" name="contact_person_mobile" id="contact_person_mobile" class="form-control" placeholder="Contact Person Mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="symptoms">GSTIN:</label>
                                            <select class="form-control" name="gstin_type" id="gstin_type">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="gstno">
                                        <div class="form-group">
                                            <label for="firstname">GSTIN No: </label>
                                           <input type="text" name="gst_no" id="gst_no" class="form-control" placeholder="GSTIN No">
                                        </div>
                                    </div>
                                
                                   
                                </div>
                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Category:<span class="text-danger">*</span></label>
                                          <select class="form-control" name="category_id" id="category_id">
                                                <option value="0">Select Category Name</option>
                                                <?php if($category){
                                                    foreach ($category as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
                                                        <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-9">
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
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savesupplier();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
  <form id="edit_supplier" action="#" method="post"> 
 <div id="supplier_modal" class="modal fade" role="dialog">
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
                                            <label for="firstname">Supplier Code: <span class="text-danger">*</span></label>
                                             <input type="hidden" name="edit_supplierid" id="edit_supplierid">
                                           <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                           <input readonly type="text" name="edit_code" id="edit_code" class="form-control" placeholder="Supplier Code">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Name: <span class="text-danger">*</span></label>
                                           <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Supplier Name">
                                        </div>
                                    </div>
                                     <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="firstname">Gender: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="edit_gender" id="edit_gender">
                                               <option value="1">Male</option>
                                               <option value="2">Female</option>
                                               <option value="3">Transgender</option>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Mobile: <span class="text-danger">*</span></label>
                                           <input type="text" name="edit_mobile" id="edit_mobile" class="form-control" placeholder="Supplier Mobile">
                                        </div>
                                    </div>
                                   
                                </div>
                                   <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Alternate Mobile:</label>
                                           <input type="text" name="edit_alter_mobile" id="edit_alter_mobile" class="form-control" placeholder="Supplier Alternate Mobile">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Supplier Email ID: </label>
                                           <input type="text" name="edit_email_id" id="edit_email_id" class="form-control" placeholder="Supplier Email ID">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Address:</label>
                                            <textarea cols="3" rows="3" id="edit_address" name="edit_address" class="form-control" placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                
                                   
                                </div>
                                    <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Contact Person Name:</label>
                                           <input type="text" name="edit_contact_person_name" id="edit_contact_person_name" class="form-control" placeholder="Contact Person Name">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Contact Person Mobile: </label>
                                           <input type="text" name="edit_contact_person_mobile" id="edit_contact_person_mobile" class="form-control" placeholder="Contact Person Mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="symptoms">GSTIN:</label>
                                            <select class="form-control" name="edit_gstin_type" id="edit_gstin_type">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="edit_gstno">
                                        <div class="form-group">
                                            <label for="firstname">GSTIN No: </label>
                                           <input type="text" name="edit_gst_no" id="edit_gst_no" class="form-control" placeholder="GSTIN No">
                                        </div>
                                    </div>
                                
                                   
                                </div>
                                    <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Category:<span class="text-danger">*</span></label>
                                          <select class="form-control" name="edit_category_id" id="edit_category_id">
                                                <option value="0">Select Category Name</option>
                                                <?php if($category){
                                                    foreach ($category as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
                                                        <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="edit_description" name="edit_description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
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
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updatesupplier();"><i class="fas fa-plus-square"></i>Update</button>
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
                                                            <th>Mobile</th>
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
                                                                <th>Mobile</th>
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
           
 var table;
$( document ).ready(function() {
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>master/Suppliers/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'code' },
             { data: 'name' },
             { data: 'mobile' },
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