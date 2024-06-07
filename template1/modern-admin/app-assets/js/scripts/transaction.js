   function changeproduct(id) {
                    if((id=='')||(id==0))
                    {
                        return false;
                    }
                    if(id=='') {
                       Swal.fire({title:"Info!",text:"Product ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
                       return false;
                    }
                    if($('#product_'+id).length){
                        Swal.fire({title:"Info!",text:"Already Added This product in the products list",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
                       return false;
                    }
                    $("#overlay").fadeIn(300);
                    csrf=$('#csrf_test_name').val();
                    getdata='Purchase_order/getproductdetails';
                     $.ajax({
                        type: "POST",
                        url: getdata,
                        dataType: "json",
                        data: {getid: id,csrf_test_name:csrf},
                        success: function(data){
                            $("#overlay").fadeOut(300);
                            frametype='';
                            framecolor='';
                            framemodel='';
                            framesize='';
                           if(data.msg == 'success')
                           {
                           // alert(data.getcpdata);

                               data.getframetypedata.forEach(function(item){ 
                                    frametype+='<option value='+item.frame_id+'>'+item.name+'</option>';
                                 });
                               $('#demo_frametype').val('');
                               $('#demo_frametype').val(frametype)
                               data.getframecolordata.forEach(function(item){ 
                                    framecolor+='<option value="'+item.frame_id+'">'+item.name+'</option>';
                                 });
                                $('#demo_framecolor').val('');
                               $('#demo_framecolor').val(framecolor)
                               data.getframemodeldata.forEach(function(item){ 
                                    framemodel+='<option value="'+item.frame_id+'">'+item.name+'</option>';
                                 });
                                $('#demo_framemodel').val('');
                               $('#demo_framemodel').val(framemodel)
                               data.getframesizedata.forEach(function(item){ 
                                    framesize+='<option value="'+item.frame_id+'">'+item.name+'</option>';
                                 });
                               $('#demo_framesize').val('');
                               $('#demo_framesize').val(framesize)
                               gstno='';
                               gstyes='';
                              var gst_selection=$("#gst_selection").val();
                              if(gst_selection==0)
                              {
                                gstno='selected';
                              }
                              else
                              {
                                gstyes='selected';
                              }
                              $("#product").select2("val", "0");
                              var lenrow=0;
                              var rowLen =  $('#productdetails > tbody >tr').length;
                              var lenrow=rowLen+1;
                              $('#productdetails').children('tbody').append('<tr>\n\
                                       <td>'+lenrow+'</td>\n\
                                       <td><a href="#" onclick="$(this).parent().parent().remove();calcnet()"><button class="btn btn-danger btnDelete btn-sm"><i class="la la-trash"></i></button></a></td>\n\
                                       <td><input type="hidden" id="producttid_'+id+'" name="product_id[]" value="'+id+'" >'+data.getdata[0]['code']+'</td>\n\
                                        <td>'+data.getdata[0]['name']+'<input  type="hidden"  name="product[]" value="'+data.getdata[0]['name']+'"  class="form-control grid_table" id="product_'+id+'" readonly></td>\n\
                                        <td><input type="number"  name="quantity[]" value="0" class="form-control grid_table"  onKeyUp="calcrow('+id+')" id="quantity_'+id+'" autocomplete="off"></td>\n\
                                        <td><input type="text" name="cost_price[]" id="cost_price_'+id+'" value="'+data.getcpdata+'" class="form-control grid_table"   onKeyUp="calcrow('+id+')" ></td>\n\
                                         <td><input type="text"  name="amount[]" id="amount_'+id+'" value="0" class="form-control grid_table" readonly onKeyUp="calcrow('+id+')"></td>\n\
                                         <td><select class="form-control grid_table" onchange="getchangetype('+id+');" name="mul_type[]" id="ismultype_'+id+'"><option value="1">N</option><option value="2">Y</option></select></td>\n\
                                        <td>\n\
                                         <div class="single_'+id+'">\n\
                                           <select name="frametype[]" class="form-control grid_table">'+frametype+'</select>\n\
                                        </div>\n\
                                        <div  class="multiple_'+id+'" style="display:none;">\n\
                                          <a href="#" id="mult_'+id+'" class="table-link danger serial_number_setting" data-target="#myModalframe" data-toggle="modal" onclick="pop('+id+')"><button class="btn btn-sm btn-danger">TCSM</button></a>\n\
                                          <input type="hidden" name="mulframetype[]" id="mulframetype_'+id+'" class="form-control span2">\n\
                                          <input type="hidden" name="mulframecolor[]" id="mulframecolor_'+id+'" class="form-control span2">\n\
                                          <input type="hidden" name="mulframesize[]" id="mulframesize_'+id+'" class="form-control span2">\n\
                                          <input type="hidden" name="mulframemodel[]" id="mulframemodel_'+id+'" class="form-control span2">\n\
                                        </div>\n\
                                        </td>\n\
                                        <td><select name="framecolor[]" class="form-control grid_table individual_'+id+'">'+framecolor+'</select></td>\n\
                                        <td><select name="framesize[]" class="form-control grid_table individual_'+id+'">'+framesize+'</select></td>\n\
                                        <td><select name="framemodel[]" class="form-control grid_table individual_'+id+'">'+framemodel+'</select></td>\n\
                                        <td><select name="gstselind[]" class="form-control grid_table"><option value="0" '+gstno+'>N</option><option value="1" '+gstyes+'>Y</option></select></td>\n\
                                       </tr>'); 
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

                function getchangetype(id)
                {
                  var value=$("#ismultype_"+id).val();
                   if(value==2)
                   {
                      $('.single_'+id).hide();
                      $('.multiple_'+id).show();
                      $('.individual_'+id).hide();
                   }
                   else
                   {
                      $('.single_'+id).show();
                      $('.multiple_'+id).hide();
                      $('.individual_'+id).show();
                   }

                }

            $("#productdetails").on('click', '.btnDelete', function () {   // product grid delete
              $(this).closest('tr').remove();
              calcnet();
              });

            function pop(val)
            {
                res='';
                showval='';
                selframetype='';
                selframecolor='';
                selframemodel='';
                selframesize='';
                addframetype='';
                addframecolor='';
                addframesize='';
                addframemodel='';
                var frametype = $('#demo_frametype').val();
                var framecolor = $('#demo_framecolor').val();
                var framesize = $('#demo_framesize').val();
                var framemodel = $('#demo_framemodel').val();
                $('#frame_details_id').val('');
                $('#frame_details_id').val(val);
                var qty = $('#quantity_'+val).val();
                $('#heading-popup').html('<b>Frame Details</b>');
                if(qty>0){
                if (isNaN(qty) || qty=="" ) { qty=0; }
                lng=qty;
                if (isNaN(lng) || lng=="" ) { lng=0; }
                var text = ""
                var i = 0;

                do {
                var slno=0;
                if(qty.length>i){slno=qty[i];}
                if(slno==0) {slno=""};
                  addframetype += "<select class='form-control' name='mframetype[]' id='mframetype_"+i+"'><option value>Select Frame Type</option>"+frametype+"</select><br>" ;
                  addframecolor += "<select class='form-control' name='mframcolor[]' id='mframecolor_"+i+"'><option value=''>Select Frame Colour</option>"+framecolor+"</select><br>" ;
                  addframesize += "<select class='form-control' name='mframesize[]' id='mframesize_"+i+"'><option value=''>Select Frame Size</option>'"+framesize+"'</select><br>" ;
                  addframemodel += "<select class='form-control' name='mframemodel[]' id='mframemodel_"+i+"'><option value=''>Select Frame Model</option>'"+framemodel+"'</select><br>" ;
                  
                i++;
                }
                while (i < lng);
                    document.getElementById("showframetype").innerHTML = addframetype;
                    document.getElementById("showframecolor").innerHTML = addframecolor;
                    document.getElementById("showframesize").innerHTML = addframesize;
                    document.getElementById("showframemodel").innerHTML = addframemodel;

                }
                else
                {
                    //$('#heading-popuptitle').html('<p class="text-danger">Please Check Qty</p>');
                    $('#showframetype').html('');
                }
                   selframetype=$('#mulframetype_'+val).val();
                   selframecolor=$('#mulframecolor_'+val).val();
                   selframesize=$('#mulframesize_'+val).val();
                   selframemodel=$('#mulframemodel_'+val).val();
                   showframetypeval='';
                   if(selframetype){
                     var j = 0;
                     while (j < qty) {
                            var resframetype = selframetype.split(",");
                            showframetypeval=resframetype[j];
                             $('#mframetype_'+j+'  option[value="'+showframetypeval+'"]').prop("selected", true);

                             var resframecolor = selframecolor.split(",");
                             showframecolorval=resframecolor[j];
                             $('#mframecolor_'+j+'  option[value="'+showframecolorval+'"]').prop("selected", true);

                             var resframesize = selframesize.split(",");
                             showframesizeval=resframesize[j];
                             $('#mframesize_'+j+'  option[value="'+showframesizeval+'"]').prop("selected", true);

                             var resframemodel = selframemodel.split(",");
                             showframemodelval=resframemodel[j];
                             $('#mframemodel_'+j+'  option[value="'+showframemodelval+'"]').prop("selected", true);
                             j++;
                        }
                   }

            }

function saveframetype()
{
          Swal.fire({title:"Are you sure?",
            text:"once you Save Cant Able to Edit Qty!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Save it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
                        var getproductid = $('#frame_details_id').val();
                        var qty = $('#quantity_'+getproductid).val();
                        var valueframetype='';
                        var valueframecolor='';
                        var valueframesize='';
                        var valueframemodel='';
                        for(var i=0;i<qty;i++){
                           getframetype= $('#mframetype_'+i).val();
                           valueframetype+=getframetype+',';

                           getframecolor= $('#mframecolor_'+i).val();
                           valueframecolor+=getframecolor+',';

                           getframesize= $('#mframesize_'+i).val();
                           valueframesize+=getframesize+',';

                           getframemodel= $('#mframemodel_'+i).val();
                           valueframemodel+=getframemodel+',';
                      }
                      $('#mulframetype_'+getproductid).val(valueframetype);
                      $('#mulframecolor_'+getproductid).val(valueframecolor);
                      $('#mulframemodel_'+getproductid).val(valueframemodel);
                      $('#mulframesize_'+getproductid).val(valueframesize);
                      $('#popupclose').click();
                      $("#quantity_"+getproductid).prop("readonly", true);
               
                }
                }))
            

        
        
}
function findFloatValue(id)
{
    var value=$("#"+id).val();
       value=parseFloat(value);
    if(isNaN(value))
    {
        return 0;
    }else{
        return value;
    }
 }
function calcrow(eid)
{
   var quantity=findFloatValue('quantity_'+eid);
   var cost_price=findFloatValue('cost_price_'+eid);
   var price=quantity*cost_price;
   $('#amount_'+eid).val(price.toFixed(2));
   calcnet();
}
function calcnet()
  {
      var total_qty=0;
      var total_amount=0;
    $('input[name="product_id[]"]').each(function(){
        var product_id=$(this).val();
        total_qty+=findFloatValue('quantity_'+product_id);
        total_amount+=findFloatValue('amount_'+product_id);
    });
    $('#total_qty').val(total_qty.toFixed(2));
    $('#total_amount').val(total_amount.toFixed(2));
  }