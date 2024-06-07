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
                                    <h4 class="card-title">Branch Master</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Branch</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                             <form id="Branchmaster" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname">Branch: <span class="text-danger">*</span></label>
                                           <input type="text" name="name" id="name" class="form-control" placeholder="Branch">
                                        </div>
                                    </div>
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
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="saveBranchmaster();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                     <form id="edit_Branch" action="#" method="post"> 
 <div id="Branch_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="div_modal">
                                
                                  <div class="row col-md-12">
                                   <div class="col-md-12 form-group">
                                        <input type="hidden" name="edit_Branchid" id="edit_Branchid">
                                         <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                         <label for="lastname">Name: <span class="text-danger">*</span></label>
                                         <input type="text" name="edit_name" id="edit_name" class="form-control">
                                    </div>
                                </div>
                                  <div class="row col-md-12">
                                    <div class="col-md-12 form-group">
                                         <label for="lastname">Description: </label>
                                         <textarea class="form-control" name="edit_description" id="edit_description"></textarea>
                                    </div>
                                </div>
                                 <div class="row col-md-12">
                                     <div class="col-md-12 form-group">
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
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updateBranchdata();"><i class="fas fa-plus-square"></i>Update</button>

                    <button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
                                                <div class="table-responsive">
                                        <table class="table table-striped table-bordered opticaltable-list" id="tableid" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Branch</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                         
                                            <tfoot>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Branch</th>
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
          'ajax':'<?=base_url()?>master/Branch/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'name' },
             { data: 'description' },
             { data: 'status' },
             { data: 'edit' },
             { data: 'delete' }
                     ],
       
    
      
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
}); 


function saveBranchmaster()
{
        
        if($("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter Branch fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Branch/saveBranchmaster";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#Branchmaster').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#Branchmaster")[0].reset();
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

function editBranch(val,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        tit='Edit Branch';
        $('#Branch_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_Branchid').val(val);
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

function updateBranchdata()
{
        
        if($("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter Branch fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Branch/editBranch";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_Branch').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_Branch")[0].reset();
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

function deleteBranch(val)
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
            delurl="Branch/deleteBranch";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_Branch').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_Branch")[0].reset();
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

          