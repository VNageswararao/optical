<?php 
$path=base_url('template1/modern-admin/');
?>
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Hospital Info cards -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="la la-user-md font-large-2 success"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h5 class="text-muted text-bold-500">Today's Sales</h5>
                                            <h3 class="text-bold-600"><?php if(isset($getsalesamount[0]['amount'])) 
                                            print number_format((float)$getsalesamount[0]['amount']
            ,2,'.', ''); else echo '0.00'; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="la la-calendar-check-o font-large-2 info"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h5 class="text-muted text-bold-500">Pending Due Bill</h5>
                                            <h3 class="text-bold-600"><?php if(isset($pendingduebill[0]['cnt'])) print $pendingduebill[0]['cnt']; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="la la-server font-large-2 warning"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h5 class="text-muted text-bold-500">Total Items</h5>
                                            <h3 class="text-bold-600"><?php if(isset($gettotalitem[0]['cnt'])) print $gettotalitem[0]['cnt']; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="la la-users font-large-2 danger"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h5 class="text-muted text-bold-500">Total Customer</h5>
                                            <h3 class="text-bold-600"><?php if(isset($gettotalcustomer[0]['cnt'])) print $gettotalcustomer[0]['cnt']; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hospital Info cards Ends -->

                <!-- Appointment Bar Line Chart -->
           
                <!-- Appointment Bar Line Chart Ends -->
                <?php $path=base_url(); ?>
 <script src="<?=$path?>vendor/assets/plugins/chart-am4/js/core.js"></script>
<script src="<?=$path?>vendor/assets/plugins/chart-am4/js/charts.js"></script>
<script src="<?=$path?>vendor/assets/plugins/chart-am4/js/animated.js"></script>
<script src="<?=$path?>vendor/assets/plugins/chart-am4/js/maps.js"></script>
<script src="<?=$path?>vendor/assets/plugins/chart-am4/js/worldLow.js"></script>
<script src="<?=$path?>vendor/assets/plugins/chart-am4/js/continentsLow.js"></script>
                <!-- Appointment Table -->
                     <div class="row" >
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Chart</h4>
                            </div>
                             <div class="card-content">
                                 <canvas id="myChart" style="height:500px"></canvas>
                             </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                              <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="card pull-up">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="la la-money font-large-2 danger"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <h5 class="text-muted text-bold-500">Today's Purchase</h5>
                                                        <h3 class="text-bold-600"><?php if(isset($getpuramt[0]['cnt'])) print number_format($getpuramt[0]['cnt'],2); else { print "0.00"; } ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="card pull-up">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="icon-call-in danger font-large-2 danger"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <h5 class="text-muted text-bold-500">Total Due Amount</h5>
                                                        <h3 class="text-bold-600"><?php if(isset($getdueamt[0]['dueamount'])) print number_format($getdueamt[0]['dueamount'],2);else print "0.00"; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="card pull-up">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="ft-align-center danger font-large-2 danger"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <h5 class="text-muted text-bold-500">Total Stock</h5>
                                                        <h3 class="text-bold-600"><?php   $stockqty=$this->db->query("select sum(quantity) as qtys  from stock where quantity>0")->row(); echo number_format((float)$stockqty->qtys
            ,2,'.', ''); ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="card pull-up">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="la la-bitcoin danger font-large-2 danger"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <h5 class="text-muted text-bold-500">Today's Collection Amount</h5>
                                                        <h3 class="text-bold-600"><?php if(isset($todayscollection[0]['amount'])) print number_format((float)$todayscollection[0]['amount']
            ,2,'.', ''); else echo '0.00'; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="card pull-up">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="la la-bitcoin danger font-large-2 danger"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <h5 class="text-muted text-bold-500">Today's Counter Sales</h5>
                                                        <h3 class="text-bold-600"><?php if(isset($todayscollection_COUNTER[0]['amount'])) print number_format((float)$todayscollection_COUNTER[0]['amount']
            ,2,'.', ''); else echo '0.00'; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-12" style="text-align:center;">
                                    
                                        <br/>
                                           <button onclick="emrdashboard()"  type="button" class="btn btn-primary  btn-lg" ><i class="la la-dashboard"></i>
                                            EMR DASHBOARD</button>
                                        
                                   
                                </div>


                        </div>
                    </div>
                </div>
                <div class="row match-height" style="display: none;">
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Doctors Available</h4>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="text-truncate p-1 border-top-0">
                                                    <div class="avatar avatar-md">
                                                        <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-4.png" alt="Avatar">
                                                    </div>
                                                </td>
                                                <td class="text-truncate pl-0 border-top-0">
                                                    <div class="name">Jane Andre</div>
                                                    <div class="designation text-light font-small-2">Dentist</div>
                                                </td>
                                                <td class="text-right border-top-0">
                                                    <a href="hospital-book-appointment.html" class="btn btn-sm btn-outline-success">Book Appointment</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-truncate p-1">
                                                    <div class="avatar avatar-md">
                                                        <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-7.png" alt="Avatar">
                                                    </div>
                                                </td>
                                                <td class="text-truncate pl-0 border-top-0">
                                                    <div class="name">Kail Reack</div>
                                                    <div class="designation text-light font-small-2">Dentist</div>
                                                </td>
                                                <td class="text-right border-top-0 ">
                                                    <a href="hospital-book-appointment.html" class="btn btn-sm btn-outline-success">Book Appointment</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-truncate p-1">
                                                    <div class="avatar avatar-md">
                                                        <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-1.png" alt="Avatar">
                                                    </div>
                                                </td>
                                                <td class="text-truncate pl-0 border-top-0 border-top-0 ">
                                                    <div class="name">Shail Black</div>
                                                    <div class="designation text-light font-small-2">Dentist</div>
                                                </td>
                                                <td class="text-right">
                                                    <a href="hospital-book-appointment.html" class="btn btn-sm btn-outline-success">Book Appointment</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-truncate p-1">
                                                    <div class="avatar avatar-md">
                                                        <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-11.png" alt="Avatar">
                                                    </div>
                                                </td>
                                                <td class="text-truncate pl-0 border-top-0">
                                                    <div class="name">Zena wall</div>
                                                    <div class="designation text-light font-small-2">Dentist</div>
                                                </td>
                                                <td class="text-right">
                                                    <a href="hospital-book-appointment.html" class="btn btn-sm btn-outline-success">Book Appointment</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-truncate p-1 border-bottom-0 ">
                                                    <div class="avatar avatar-md">
                                                        <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-6.png" alt="Avatar">
                                                    </div>
                                                </td>
                                                <td class="text-truncate pl-0 border-top-0 border-bottom-0 ">
                                                    <div class="name">Colin Welch</div>
                                                    <div class="designation text-light font-small-2">Dentist</div>
                                                </td>
                                                <td class="text-right border-bottom-0 ">
                                                    <a href="hospital-book-appointment.html" class="btn btn-sm btn-outline-success">Book Appointment</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="recent-appointments" class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent Appointments</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="hospital-book-appointment.html" target="_blank">View all</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content mt-1">
                                <div class="table-responsive">
                                    <table id="recent-orders-doctors" class="table table-hover table-xl mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Doctor</th>
                                                <th class="border-top-0">Patients</th>
                                                <th class="border-top-0">Specialities</th>
                                                <th class="border-top-0">Timings</th>
                                                <th class="border-top-0">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="pull-up">
                                                <td class="text-truncate">Jane Andre</td>
                                                <td class="text-truncate p-1">
                                                    <ul class="list-unstyled users-list m-0">
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Kimberly Simmons" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-4.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Willie Torres" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-5.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Rebecca Jones" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-6.png" alt="Avatar">
                                                        </li>
                                                        <li class="avatar avatar-sm">
                                                            <span class="badge badge-info">+8 more</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger round">Dentist</button>
                                                </td>
                                                <td class="text-truncate">8:00 A.M. - 12:00 P.M.</td>
                                                <td class="text-truncate">$ 1200.00</td>
                                            </tr>
                                            <tr class="pull-up">
                                                <td class="text-truncate">Kail Reack</td>
                                                <td class="text-truncate p-1">
                                                    <ul class="list-unstyled users-list m-0">
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Kimberly Simmons" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-7.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Willie Torres" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-8.png" alt="Avatar">
                                                        </li>
                                                        <li class="avatar avatar-sm">
                                                            <span class="badge badge-info">+5 more</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-success round">Dermatologist</button>
                                                </td>
                                                <td class="text-truncate">10:00 A.M. - 1:00 P.M.</td>
                                                <td class="text-truncate">$ 1190.00</td>
                                            </tr>
                                            <tr class="pull-up">
                                                <td class="text-truncate">Shail Black</td>
                                                <td class="text-truncate p-1">
                                                    <ul class="list-unstyled users-list m-0">
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Kimberly Simmons" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-1.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Willie Torres" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-2.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Rebecca Jones" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-3.png" alt="Avatar">
                                                        </li>
                                                        <li class="avatar avatar-sm">
                                                            <span class="badge badge-info">+3 more</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger round">Psychiatrist</button>
                                                </td>
                                                <td class="text-truncate">11:00 A.M. - 2:00 P.M.</td>
                                                <td class="text-truncate">$ 999.00</td>
                                            </tr>
                                            <tr class="pull-up">
                                                <td class="text-truncate">Zena wall</td>
                                                <td class="text-truncate p-1">
                                                    <ul class="list-unstyled users-list m-0">
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Kimberly Simmons" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-11.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Willie Torres" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-12.png" alt="Avatar">
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-success round">Gastroenterologist</button>
                                                </td>
                                                <td class="text-truncate">11:30 A.M. - 3:00 P.M.</td>
                                                <td class="text-truncate">$ 1150.00</td>
                                            </tr>
                                            <tr class="pull-up">
                                                <td class="text-truncate">Colin Welch</td>
                                                <td class="text-truncate p-1">
                                                    <ul class="list-unstyled users-list m-0">
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Kimberly Simmons" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-6.png" alt="Avatar">
                                                        </li>
                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Willie Torres" class="avatar avatar-sm pull-up">
                                                            <img class="media-object rounded-circle" src="<?=$path?>app-assets/images/portrait/small/avatar-s-4.png" alt="Avatar">
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger round">Pediatrician</button>
                                                </td>
                                                <td class="text-truncate">5:00 P.M. - 8:00 P.M.</td>
                                                <td class="text-truncate">$ 1180.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Appointment Table Ends -->
                <div id="emr_sec_div"></div>

              
            </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
 crd='<?php echo $this->security->get_csrf_hash(); ?>';
function emrdashboard()
{
   
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Dashboard/EMR_Dashboard',
            dataType: "json",
            data: {csrf_test_name:crd},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                 $('#emr_sec_div').html(data.htmldata);
                 $('#emr_dashboard_pop').modal('show');
                 $('.modal-title').html('EMR Dashboard');
cd = (new Date()).toISOString().split('T')[0];
$('.date_pic_class').val(cd);
                 $('[data-toggle="tooltip"]').tooltip();

      $('#emr_tab_das').DataTable( {
       "drawCallback": function( settings ) {



// add as many tooltips you want

},
        buttons: [  ],
       
        dom: 'Blfrtip',
        "aaSorting": [[ 2, "desc" ]] ,
       "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
    } );

                    
                
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

function pat_view(docid)
{
    if(docid>0)
    {
         $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Dashboard/pat_view',
            dataType: "json",
            data: {docid: docid,csrf_test_name:crd},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                //alert(data.msg);
                $('#front_emr_screen').hide();
                $('#doc_emr_screen').show();
                $('#app_emr_screen').hide();
                 $('#cross_emr_screen').hide();
                 $('#doc_emr_screen').html(data.msg);

                
                
                
                 var table = $('#pp_pat').DataTable( {
       
       buttons: [  ],
      
       dom: 'Blfrtip',
      "lengthMenu": [[1000], [1000]]
   } );
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
function showallpatient_details(val=0)
{
    <?php
    $doctor_id_new_cond=0;
        if($this->session->userdata('user_type')==2)
          {
             $ll=$this->session->userdata('login_id');
             $doctor_id_new_cond=$this->db->get_where('user',"user_id=$ll")->row()->doctor_id;
          } 
       ?>
  if(val==0)
  {
    docid=$('#all_cons').val();
    curdate=$('#date_pic').val();

    if ( $.fn.DataTable.isDataTable('#pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4') ) {
  $('#pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4').DataTable().destroy();
}
  }
  else
  {
    docid=$('#all_cons').val();
    curdate=$('#date_pic').val();

    if ( $.fn.DataTable.isDataTable('#pat_st_av'+val) ) {
  $('#pat_st_av'+val).DataTable().destroy();
}

$('#show_all_pat_st_av'+val).empty();
  }
  $('#All_Pat_Det').modal('show');
  $('.modal-title').html('Appointment Status');

        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Dashboard/patview_status',
            dataType: "json",
            data: {doc_id:docid,curdate:curdate,type:val,csrf_test_name:crd},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                 $('#front_emr_screen').hide();
                $('#doc_emr_screen').hide();
                $('#app_emr_screen').show();
                $('#cross_emr_screen').hide();

                

                if(val==0)
                {
                  $('#show_all_pat_st_av1').html(data.dataview1);
                  $('#st_cnt1').html(data.cnt1);
                  $('#show_all_pat_st_av2').html(data.dataview2);
                  $('#st_cnt2').html(data.cnt2);
                  $('#show_all_pat_st_av3').html(data.dataview3);
                  $('#st_cnt3').html(data.cnt3);
                  $('#show_all_pat_st_av4').html(data.dataview4);
                  $('#st_cnt41').html(data.cnt4);
                  $('#pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4').DataTable({
                    buttons: [  ],
                    dom: 'Blfrtip',
                     
                    "lengthMenu": [[1000], [1000]],
                  });
                  
                }
                else
                {
                  $('#show_all_pat_st_av'+val).html(data.dataview1);
                  $('#st_cnt'+val).html(data.cnt1);
                  $('#pat_st_av'+val).DataTable({
                    buttons: [  ],
                    dom: 'Blfrtip',
                   "lengthMenu": [[1000], [1000]]
                  });
                }
                 $('.modal-title').html('Appointment Details');
                
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
function getallcrossdoctorstatus()
{
  $('#cross_cnt_contr').html(0);
 
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: 'Dashboard/Get_cross_data',
            dataType: "json",
            data: {doc_id:$('#cross_all_cons').val(),cross_date_pic:$('#cross_date_pic').val(),csrf_test_name:crd},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#front_emr_screen').hide();
                $('#doc_emr_screen').hide();
                $('#app_emr_screen').hide();
                $('#cross_emr_screen').show();

                $('#cross_cnt_contr').html(data.crosscnt);
                   $('#cross_ref_data').html(data.msg);
                   var table = $('#data_cross').DataTable( {
       
                    buttons: [  ],
                    
                    dom: 'Blfrtip',
                    columnDefs: [ {
                            
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
                    }]
                } );
                
                 } else if(data.error != ''){
                  var table = $('#data_cross').DataTable();

//clear datatable
table.clear().draw();
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
function emrback()
{
        $('#front_emr_screen').show();
        $('#doc_emr_screen').hide();
        $('#app_emr_screen').hide();
         $('#cross_emr_screen').hide();
}
var ctx = document.getElementById('myChart').getContext('2d');
var title_label=<?= json_encode($chart_dates)?>;
var patient_flow=<?= json_encode($patient_count)?>;

var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'line',

                        // The data for our dataset
                        data: {
                            labels: title_label,
                            datasets: [{
                                label: 'Sales',
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                fill: false,
                                data: patient_flow
                            }]
                        },

                        // Configuration options go here
                        options: {}
                    });

</script>


  



