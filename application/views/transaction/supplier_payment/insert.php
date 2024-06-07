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
                                    <h4 class="card-title">Supplier Payment</h4>
                                    <div id="edit_data"></div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Payment</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                            <form id="supplierpayment" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="supplier_id" id="supplier_id" onchange="getallpurchase(this.value)">
                                                <option value="0">Select Supplier</option>
                                                <?php if($getsupplier){ foreach ($getsupplier as $data) { ?>
                                                  <option value="<?php echo $data['supplier_id']; ?>"><?php echo $data['name']; ?></option>
                                               <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="showdata">
                                            
                                        </div>
                                    </div>
                                </div>

                                 <div class="row" id="totalview" style="display: none;">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <label>Total <span class="text-danger">*</span></label>
                                        <input type="text" name="total_sum" id="total_sum" class="form-control">
                                    </div>
                                </div>
                               
                               
                                

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="save_payment('1');">Submit</button>
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
                                                                        <th>Supplier Name</th>
                                                                        <th>Date</th>
                                                                        <th>Total Amount</th>
                                                                        <th>View</th>
                                                                        <th>Delete</th>
                                                                      </tr>
                                                                    </thead>
                                                                     <tfoot>
                                                                        <tr>
                                                                            <th>Sl No</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Date</th>
                                                                            <th>Total Amount</th>
                                                                            <th>View</th>
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
     $('#supplier_id').select2('open');
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'Supplier_payment/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'name' },
             { data: 'payment_date' },
             { data: 'total_paid_amount' },
             { data: 'view' },
             { data: 'delete' }
                     ],
       
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
}); 


function viewsupplierpayment(val)
{
    if(val>0)
    {
         $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Supplier_payment/viewdata',
            dataType: "json",
            data: {getid: val,csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                 $('#edit_data').html(data.msg);
                 $('#div_modal').modal('show');
                 $('.modal-title').html('View  Data');
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

           function getallpurchase(val)
           {
             //$('#totalview').hide();
             $('#showdata').html('');
              if(val>0)
              {
                $("#overlay").fadeIn(300);  
                $.ajax({
                    type: "POST",
                    url: 'Supplier_payment/getpurchasedetails',
                    dataType: "json",
                    data: {getid: val,csrf_test_name:$('#csrf_test_name').val()},
                    success: function(data){
                        $("#overlay").fadeOut(300);
                       if(data.msg == 'success')
                       {
                        //$('#totalview').show();
                          $('#showdata').html(data.getdata);
                             var table = $('#example_sum').DataTable( {
                                   scrollX: false,
                                   scrollY:"300px",
                                paging: false,
                                dom: 'Bfrtip',
                                buttons: [
                                    
                                    'pdfHtml5',

                                ],
                                 "order": [[ 0, "desc" ]]
                            } );
                              new $.fn.dataTable.FixedHeader( table );


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
           }
            function save_payment()
            {

                $("#overlay").fadeIn(300);
                saveurl="Supplier_payment/savesupplierpayment";
                 $.ajax({
                    type: "POST",
                    url: saveurl,
                    dataType: "json",
                    data: $('#supplierpayment').serialize(),
                    success: function(data){
                        $("#overlay").fadeOut(300);
                       if(data.msg != ''){
                       Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
                        $('#showdata').html('');
                        $("#supplier_id").select2("val", "0");
                        table.draw();
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


            function deletesupplierpayment(val)
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
             delurl="Supplier_payment/deletedata";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: {getid: val,csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
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
