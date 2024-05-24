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
                                    <h4 class="card-title">Change Password</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Change Password</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                       <form id="changepassword" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">Old Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control"  id="oldpwd" name="oldpwd" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">New Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control"  id="newpwd" name="newpwd" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">Confirm Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control"  id="cpwd" name="cpwd" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                               

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="changepassword();">Submit</button>
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
                function changepassword()
        {
        
            Swal.fire({title:"Are you sure?",
                text:"Change Password",
                type:"warning",
                showCancelButton:!0,
                confirmButtonColor:"#3085d6",
                cancelButtonColor:"#d33",
                confirmButtonText:"Yes, Proceed it!",
                confirmButtonClass:"btn btn-warning",
                cancelButtonClass:"btn btn-danger ml-1",
                buttonsStyling:!1}).then((function(t){
                  if(t.value)
                    {
                 $("#overlay").fadeIn(300);
                        $.ajax({
                type: "POST",
                url: 'Change_password/Change_password_action',
                dataType: "json",
                data: $('#changepassword').serialize(),
                success: function(data){
                    $("#overlay").fadeOut(300);
                   if(data.msg != ''){
                   Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
                  
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
                    })) 
}

            </script>
            
          