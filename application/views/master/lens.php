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
                                    <h4 class="card-title">Lens Master</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Lens</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                               <form id="lens" action="#" method="post"> 
                                                 <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Code: </label>
                                            <input type="text" class="form-control" name="code" placeholder="Code" id="code" required readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Lens Type: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="lens_type_id" id="lens_type_id">
                                                <option value="">Select Lens Type</option>
                                                <?php if($lenstype){
                                                    foreach ($lenstype as $data) {
                                                       ?>
                                                       <option value="<?php print $data['lens_classification_id'] ?>"><?php print $data['name'] ?></option>
                                                       <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Coating: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="lens_coating_id" id="lens_coating_id">
                                                <option value="">Select Coating</option>
                                                     <?php if($lenscoating){
                                                    foreach ($lenscoating as $data) {
                                                       ?>
                                                       <option value="<?php print $data['lens_classification_id'] ?>"><?php print $data['name'] ?></option>
                                                       <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" required>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Purchase Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Purchase Date" id="purchase_date" name="purchase_date" pattern="\d{4}-\d{2}-\d{2}" >
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">MRP: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="MRP" id="purchase_amount" name="purchase_amount" required>
                                        </div>
                                    </div>
                                      <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="firstname">Gst: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="gst_type" id="gst_type" onchange="changeVat($(this).val())">
                                               <option value="0">NonTax</option>
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
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                          <select class="form-control select2" name="supplier_id" id="supplier_id">
                                                <option value="">Select supplier</option>
                                                <?php
                                                if($getsupplier)
                                                {
                                                    foreach($getsupplier as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['supplier_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Purchase Amount:</label>
                                            <input type="text" class="form-control" placeholder="Purchase Amount" id="amount" name="amount" required>
                                        </div>
                                    </div>

                                   
                                </div>
                                <div class="row">
                                   <div class="col-md-6">
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
                                          <input type="checkbox" id="switcheryColor2" name="status" class="switchery" data-color="info" checked value="1" />
                                          <label for="switcheryColor2" class="card-title ml-1">Active</label>
                                        </div>
                                    </div>
                                </div>

                                 <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="lensclassification('3');">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                    <form id="edit_lens" action="#" method="post"> 
 <div id="lens_modal" class="modal fade" role="dialog">
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
                                            <label for="lastname">Code: <span class="text-danger">*</span></label>
                                            <input type="hidden" name="edit_lensid" id="edit_lensid">
                                             <input type="hidden" name="edit_type" id="edit_type" value="3">
                                             <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                            <input readonly type="text" class="form-control" name="edit_code" placeholder="Code" id="edit_code" required>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Lens Type: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="edit_lens_type_id" id="edit_lens_type_id">
                                                <option value="">Select Lens Type</option>
                                                <?php if($lenstype){
                                                    foreach ($lenstype as $data) {
                                                       ?>
                                                       <option value="<?php print $data['lens_classification_id'] ?>"><?php print $data['name'] ?></option>
                                                       <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Coating: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="edit_lens_coating_id" id="edit_lens_coating_id">
                                                <option value="">Select Coating</option>
                                                     <?php if($lenscoating){
                                                    foreach ($lenscoating as $data) {
                                                       ?>
                                                       <option value="<?php print $data['lens_classification_id'] ?>"><?php print $data['name'] ?></option>
                                                       <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Name" id="edit_name" name="edit_name" required>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Purchase Date: <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Purchase Date" id="edit_purchase_date" name="edit_purchase_date" required>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">MRP: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="MRP" id="edit_purchase_amount" name="edit_purchase_amount" required>
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
									 <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Purchase Amount: </label>
                                            <input type="text" class="form-control" placeholder="Purchase Amount" id="edit_amount" name="edit_amount" required>
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="edit_description" name="edit_description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                     <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                          <select class="form-control select2" name="supplier_id" id="edit_supplier_id">
                                                <option value="">Select supplier</option>
                                                <?php
                                                if($getsupplier)
                                                {
                                                    foreach($getsupplier as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['supplier_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3 form-group">
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
                <div class="modal-footer">
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updatelens();"><i class="fas fa-plus-square"></i>Update</button>

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
                                                            <th>Lens Name</th>
                                                            <th>Description</th>
                                                             <th>Status</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Code</th>
                                                                <th>Lens Name</th>
                                                                <th>Description</th>
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
     cd = (new Date()).toISOString().split('T')[0];
    $('#purchase_date').val(cd);
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>master/Lens/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'code' },
             { data: 'name' },
             { data: 'description' },
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
  function editlensmasternew(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        csrf=$('#csrf_test_name').val();
        getdata='Lens/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  tit='Edit Lens Master';
                  $('#lens_modal').modal('show');
                  $('.modal-title').html(tit);
                  $('#edit_lensid').val(data.getdata[0]['lens_master_id']);
                  $('#edit_code').val(data.getdata[0]['code']);
                  $('#edit_name').val(data.getdata[0]['name']);
                  $('#edit_lens_type_id').val(data.getdata[0]['lens_type_id']);
                  $('#edit_lens_coating_id').val(data.getdata[0]['lens_coating_id']);
                  $('#edit_purchase_date').val(data.getdata[0]['purchase_date']);
                  $('#edit_purchase_amount').val(data.getdata[0]['purchase_amount']);
                  $('#edit_amount').val(data.getdata[0]['amount']);
                  $('#edit_description').val(data.getdata[0]['description']);
                  $('#edit_status').val(data.getdata[0]['status']);
                  $('#edit_gst_type').val(data.getdata[0]['gst_type']);
                  $('#edit_tax').val(data.getdata[0]['tax']);
                  $('#edit_cgst').val(data.getdata[0]['cgst']);
                  $('#edit_sgst').val(data.getdata[0]['sgst']);
                  $("#edit_supplier_id").val(data.getdata[0]['supplier_id']).trigger("change");
               } 
              else if(data.error != '')
              {
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              } 
              else if(data.error_message) 
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


          