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
                                    <h4 class="card-title">Staff Registration</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Staff</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                            <form id="staff_form" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Staff Code: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="code" placeholder="Code" id="code" readonly value="<?php print $codeno; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Staff Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Staff Mobile: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Mobile" id="mobile" name="mobile" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Staff Email ID: </label>
                                            <input type="text" class="form-control" placeholder="Email ID" id="email" name="email" >
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Address:</label>
                                            <textarea cols="3" rows="3" id="description" name="address" class="form-control" placeholder="Address"></textarea>
                                        </div>
                                    </div>
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
                                          <input type="checkbox" value="1" id="switcheryColor2" class="switchery" name="status" data-color="info" checked />
                                          <label for="switcheryColor2" class="card-title ml-1">Active</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savestaff();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
 <form id="edit_staff" action="#" method="post"> 
 <div id="staff_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row form-group" id="div_modal">
                          <div class="col-md-6">
                             <label for="lastname">Code: <span class="text-danger">*</span></label>
                               <input type="hidden" name="edit_staffid" id="edit_staffid">
                               <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <input type="text" readonly name="edit_code" id="edit_code" class="form-control">
                          </div>
                          <div class="col-md-6">
                              <label for="lastname">Name: <span class="text-danger">*</span></label>
                              <input type="text" name="edit_name" id="edit_name" class="form-control">
                         </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                           <label for="lastname">Mobile: <span class="text-danger">*</span></label>
                           <input type="text" name="edit_mobile" id="edit_mobile" class="form-control">
                        </div>
                        <div class="col-md-6">
                           <label for="lastname">Email: </label>
                            <input type="text" name="edit_email" id="edit_email" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="lastname">Address: </label>
                            <textarea class="form-control" name="edit_address" id="edit_address"></textarea>
                        </div>
                         <div class="col-md-6">
                             <label for="lastname">Description: </label>
                             <textarea class="form-control" name="edit_description" id="edit_description"></textarea>
                        </div>
                    </div>
                     <div class="row form-group">
                           <div class="col-md-6 ">
                               <label for="lastname">Status: </label>
                              <select class="form-control" name="edit_status" id="edit_status">
                                  <option value="1">Active</option>
                                  <option value="0">De-Active</option>
                              </select>
                              </div>
                      </div>

                </div>
                <div class="modal-footer">
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updatestaffdata();"><i class="fas fa-plus-square"></i>Update</button>

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
                                                                <th>Name</th>
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
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>master/Staff_registration/ajax_call',
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

function savestaff()
{
        
        if($("#name").val()=='' || $("#code").val()=='' || $("#mobile").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all required fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Staff_registration/savestaff";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#staff_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#staff_form")[0].reset();
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

function editstaff(staff_id,code,name,mobile,email,address,des,status)
{
        if(staff_id=='') {
           Swal.fire({title:"Info!",text:"staff_id ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        tit='Edit Staff';
        $('#staff_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_code').val(code);
        $('#edit_name').val(name);
        $('#edit_mobile').val(mobile);
        $('#edit_email').val(email);
        $('#edit_address').val(address);
        $('#edit_description').val(des);
        $('#edit_staffid').val(staff_id);
        if(status=='Deactive')
        {
          st=0;
        }
        else
        {
          st=1;
        }
        $('#edit_status').val(st);
        
}

function updatestaffdata()
    {   
        if($("#edit_code").val()=='' ||  $("#edit_name").val()=='' ||  $("#edit_mobile").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all required fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        upurl="Staff_registration/editstaff";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_staff').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_staff")[0].reset();
                $(".close").click();
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

function deletestaff(val)
{
      if(val=='') {
           Swal.fire({title:"Info!",text:"Delete ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
          Swal.fire({title:"Are you sure?",
            text:"You won't be able to revert this!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Delete it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
           delurl="Staff_registration/deletestaff";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_staff').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_category")[0].reset();
                 return false;
              } else if(data.error != ''){
                Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
               return false;
              } else if(data.error_message) 
              {
                var error = data.error_message;
                var err_str = '';
                for (var key in error) {
                  err_str += error[key] +'\n';
                }
                Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                 return false;
              }
                
            },
            error: function (error) {
                Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        });
               
                }
                }))
            

        
        
}
          </script>
