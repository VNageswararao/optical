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
                                    <h4 class="card-title">Optical Advice</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Optical Advice</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Converted</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Not Converted</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                              <form id="lens" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               
                               <div class="row">
                                     <div class="col-md-3">
                                          <label>Optical Advice From Date</label>
                                          <input type="date" class="form-control" name="opticaladvicefrom_date0" id="opticaladvicefrom_date0">
                                      </div>
                                      <div class="col-md-3">
                                          <label>Optical Advice to Date</label>
                                          <input type="date" class="form-control" name="opticaladviceto_date0" id="opticaladviceto_date0">
                                      </div>
                                      <div class="col-md-3">
                                          <br/>
                                          <button type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1" onclick="serachopticaladvice(0)">search</button>
                                      </div>
                                
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                    <div  id="opticaladvicepat0">
                                    </div>
                              </div>
                          </div>
                              

                                

                               
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                  <div class="row">
                                     <div class="col-md-3">
                                          <label>Optical Advice From Date</label>
                                          <input type="date" class="form-control" name="opticaladvicefrom_date1" id="opticaladvicefrom_date1">
                                      </div>
                                      <div class="col-md-3">
                                          <label>Optical Advice to Date</label>
                                          <input type="date" class="form-control" name="opticaladviceto_date1" id="opticaladviceto_date1">
                                      </div>
                                      <div class="col-md-3">
                                          <br/>
                                          <button type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1" onclick="serachopticaladvice(1)">search</button>
                                      </div>
                                
                            </div>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                            <div  id="opticaladvicepat1">
                                                            </div>
                                                      </div>
                                                  </div>
                                            </div>

                                              <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">

                                                <div class="row">
                                     <div class="col-md-3">
                                          <label>Optical Advice From Date</label>
                                          <input type="date" class="form-control" name="opticaladvicefrom_date2" id="opticaladvicefrom_date2">
                                      </div>
                                      <div class="col-md-3">
                                          <label>Optical Advice to Date</label>
                                          <input type="date" class="form-control" name="opticaladviceto_date2" id="opticaladviceto_date2">
                                      </div>
                                      <div class="col-md-3">
                                          <br/>
                                          <button type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1" onclick="serachopticaladvice(2)">search</button>
                                      </div>
                                
                            </div>

                                                    <div class="row">
                                                      <div class="col-md-12">
                                                            <div  id="opticaladvicepat2">
                                                            </div>
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

                <form id="edit_Vendor" action="#" method="post"> 
 <div id="Vendor_modal" class="modal fade" role="dialog">
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
                            <input type="hidden" name="ex_id" id="ex_id">
                              <div class="form-group">
                                   <div class="col-md-12">
                                       <label>Type</label>
                                       <select class="form-control" name="sel_type" id="sel_type">
                                           <option value="1">Converted</option>
                                           <option value="2">Not Converted</option>
                                       </select>
                                   </div>
                              </div>
                               <div class="form-group">
                                   <div class="col-md-12">
                                       <label>Reason</label>
                                      <textarea class="form-control" rows="4" id="reason" name="reason"></textarea>
                                   </div>
                              </div>
                              
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updatetype($('#ex_id').val(),$('#sel_type').val(),$('#reason').val());"><i class="fas fa-plus-square"></i>Update</button>
                <button type="button" id="mclose" class="btn btn-danger btn-sm cls" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

            </div>
           <script type="text/javascript">
     cd = (new Date()).toISOString().split('T')[0];
     $('#opticaladvicefrom_date0').val(cd);
     $('#opticaladviceto_date0').val(cd);
      $('#opticaladvicefrom_date1').val(cd);
     $('#opticaladviceto_date1').val(cd);
      $('#opticaladvicefrom_date2').val(cd);
     $('#opticaladviceto_date2').val(cd);
     $( document ).ready(function() {
     serachopticaladvice(0);
    
});
     function updatetype(exid,type,reason)
     {

         upurl="Optical_advice/updatetype";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data:{exid:exid,advicetype:type,reason:reason,csrf_test_name:$("#csrf_test_name").val()},
            success: function(data){
                $("#overlay").fadeOut(300);

               if(data.msg != ''){
                Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
              
               location.reload();
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
     function getaction(exid)
     {
         tit='Action';
        $('#Vendor_modal').modal('show');
        $('.modal-title').html(tit);
        $('#ex_id').val(exid);
     }
function examinationprint(examinationid)
{
    
   $('<form target="_blank"  method="post" action="<?php echo base_url(); ?>/transaction/Sales/examinationprint"><input name="examinationid" value="'+examinationid+'"/><input name="chkcomplaintsout" value="'+$('#chkcomplaints').is(':checked')+'"><input name="chkopthalmicsout" value="'+$('#chkophthalmic').is(':checked')+'"><input name="chkmedicalout" value="'+$('#chkmedical').is(':checked')+'"><input name="chkeyepartout" value="'+$('#chkeyepart').is(':checked')+'"><input name="addmedicinessout" value="'+$('#addmediciness').is(':checked')+'"><input name="investigationchkout" value="'+$('#investigationchk').is(':checked')+'"><input name="preliminary_exout" value="'+$('#preliminary_ex').is(':checked')+'"><input name="vsisonreadingsout" value="'+$('#vsisonreadings').is(':checked')+'"><input name="curspecout" value="'+$('#curspec').is(':checked')+'"><input name="objectchkout" value="'+$('#objectchk').is(':checked')+'"><input name="arkkchkout" value="'+$('#arkkchk').is(':checked')+'"><input name="manchkout" value="'+$('#manchk').is(':checked')+'"><input name="specchkout" checked><input name="conlchkout" value="'+$('#conlchk').is(':checked')+'"><input name="pmtchkout" value="'+$('#pmtchk').is(':checked')+'"><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();

}
     function serachopticaladvice(val)  //get customer details
{

    $('#opticaladvicepat'+val).html('');
   
         upurl="Optical_advice/getopticaladvice";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data:{val:val,csrf_test_name:$("#csrf_test_name").val(),opticaladvice_date1:$("#opticaladvicefrom_date"+val).val(),opticaladvice_date2:$("#opticaladviceto_date"+val).val()},
            success: function(data){
                $("#overlay").fadeOut(300);

               if(data.msg != ''){
                    $('#opticaladvicepat'+val).html(data.msg);
                  
                    $('#opadv'+val).DataTable( {
       "drawCallback": function( settings ) {



// add as many tooltips you want

},
        buttons: [  'excelHtml5' ],
       
        dom: 'Blfrtip',
      
       "lengthMenu": [[100, 1000], [100, 1000]]
    } );

                   
              } else if(data.error != ''){
               // Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              } else if(data.error_message) 
              {
                // var error = data.error_message;
                // var err_str = '';
                // for (var key in error) {
                //   err_str += error[key] +'\n';
                // }
                // Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
              }
                
            },
            error: function (error) {
                //Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $("#overlay").fadeOut(300);  
            }
        }); 
}
          </script>
