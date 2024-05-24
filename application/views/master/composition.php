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
                                <h4 class="card-title">Composition</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="edit_data"></div>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Composition</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                            <form id="Composition" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"  id="name" name="name" >
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
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savedata();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                <div class="table-responsive">
                                                     <table id="tableid" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                            <th>Sl No</th>
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
          'ajax':'<?=base_url()?>master/Composition/ajax_call',
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

function savedata()
{
    if( $("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Composition/savedata',
            dataType: "json",
            data: $('#Composition').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#Composition")[0].reset();
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

function editdata(val)
{
    if(val>0)
    {
         $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Composition/editdata',
            dataType: "json",
            data: {getid: val,csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                 $('#edit_data').html(data.msg);
                 $('#div_modal').modal('show');
                 $('.modal-title').html('Edit Composition');
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
}

function updatedataval()
{
        if($("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Composition/updatedata',
            dataType: "json",
            data: $('#edit_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_form")[0].reset();
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
function deletedata(val)
{
    if(val>0)
    {
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
             $("#overlay").fadeIn(300);
                   $.ajax({
            type: "POST",
            url: 'Composition/deletedata',
            dataType: "json",
            data: {getid: val,csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
               
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
}
          </script>
