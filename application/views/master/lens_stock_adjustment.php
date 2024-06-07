<?php 
$path=base_url('template1/modern-admin/');
?>   
<style type="text/css">
    .product_select{
        background-color:#E9ECED;
    }
    
    .disabled_select {
    pointer-events: none;
    cursor: not-allowed;
}
</style>   
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Lens Stock Adjustment</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="edit_data"></div>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Lens Stock Adjustment</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                            <form id="savedata" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Item Name: <span class="text-danger">*</span></label>
                            <input type="text" style="background: #0abdef;" name="" class="form-control" id="pro_name" onkeyup="loadautocomplete($(this).val(),1)" onkeydown="add_focus_to_first(event)" autocomplete="off">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Item Name: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="sales_id" name="sales_id" onchange="loadsalesbill($(this).val())">
                                                <option value="">Select Bill</option>
                                                <?php
                                                if($getsalesbill)
                                                {
                                                    foreach ($getsalesbill as $databill) {
                                                      ?>
                                                      <option value="<?php echo $databill['sales_id']; ?>"><?php echo $databill['cuname']; ?>/<?php echo $databill['invoice_number']; ?></option>
                                                      <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                </div>

                                   <div class="row">
                                    <div class="col-md-12">
    
                                     <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table table-bquotationed">
                                                <thead class="lookuphead" id="frame_section" style="display: none;">
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th>MRP</th>
                                                        <th>SP</th>
                                                        <th>Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sugession">
                              
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="productdetails" bquotation="0">
                                                <thead>
                                                    <tr>
                                                        <th>Remove</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Stock</th>
                                                        <th>Action</th>
                                                        <th>Qty</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody id="sdata">
                                                </tbody>
                                            </table>
                                        </div>
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

                              

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savedata('1');">Submit</button>
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
                                                            <th>Stock Adjustment No</th>
                                                            <th>Date</th>
                                                            <th>Description</th>
                                                            <th>View</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Stock Adjustment No</th>
                                                                <th>Date</th>
                                                                <th>Description</th>
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
            row_num=1;
 var table;
$( document ).ready(function() {
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Lens_stock_adjustment/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'number' },
             { data: 'adjustment_date' },
             { data: 'description' },
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

var timeout = 500;
var timer;
function setActive(ref)
  {
      $('.product_select').removeClass('product_select');
      ref.addClass('product_select');
  }
function changeActive(ref,event)
  {
      $('.product_select').removeClass('product_select');
      if(event.keyCode==40)
      {
          ref.next().addClass('product_select');
          $('.product_select').focus();
      }
      if(event.keyCode==38)
      {
          ref.prev().addClass('product_select');
          $('.product_select').focus();
      }
      if(event.keyCode==13)
      {
          var index=ref.attr('tabindex');
          addProduct(index);
          return;
      }
      
  }
function add_focus_to_first(event)
{
    if((event.keyCode==13)||(event.keyCode==40))
    {
        event.preventDefault();
        $('#sugession').children('tr:first').addClass('product_select');
        $('.product_select').focus();
    }
}
function loadsalesbill(product)
{
    if(product>0)
    {
        $('#sugession').empty();
        $('#sugession').parent().show();
        $('#frame_section').show();
        product_result=[];
        $.ajax({
            url:'Lens_stock_adjustment/sales_search_stock_Lens',
            type:'post',
            dataType:'json',
            data:{product:product,csrf_test_name:$('#csrf_test_name').val()},
            success:function(data){
                $('#sugession').html('');
                  if(data.msg != ''){
                product_result=data.getdata;
                data.getdata.forEach(function(item,index){
                    var name=item['name'];
                    var mrp=item['mrp'];
                    var selling_price=item['selling_price'];
                    var stock=item['quantity'];
                  
                                                             
                    var html='<tr ondblclick="addProduct('+index+')" onclick="setActive($(this))" onkeydown="changeActive($(this),event)" tabindex="'+index+'"><td style="color: #6f42c1;font-weight: 600;">'+name+'</td><td>'+mrp+'</td><td>'+selling_price+'</td><td>'+stock+'</td></tr>';
                        $('#sugession').append(html);
                });
                }
               else if(data.error != ''){
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

            }
        });
      
     }
    
}
function loadautocomplete(product,val)
{
     $('#sugession').empty();
    if(product.length<3)
    {
        $('#sugession').parent().hide();
        return;
    }
    clearTimeout(timer);
    timer = setTimeout(function() {
      
 $('#sugession').parent().show();
 $('#frame_section').show();
    product_result=[];
        $.ajax({
            url:'Lens_stock_adjustment/sales_search_stock',
            type:'post',
            dataType:'json',
            data:{product:product,csrf_test_name:$('#csrf_test_name').val()},
            success:function(data){
                $('#sugession').html('');
                  if(data.msg != ''){
                product_result=data.getdata;
                data.getdata.forEach(function(item,index){
                    var name=item['name'];
                    var mrp=item['mrp'];
                    var selling_price=item['selling_price'];
                    var stock=item['quantity'];
                  
                                                             
                    var html='<tr ondblclick="addProduct('+index+')" onclick="setActive($(this))" onkeydown="changeActive($(this),event)" tabindex="'+index+'"><td style="color: #6f42c1;font-weight: 600;">'+name+'</td><td>'+mrp+'</td><td>'+selling_price+'</td><td>'+stock+'</td></tr>';
                        $('#sugession').append(html);
                });
                }
               else if(data.error != ''){
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

            }
        });
      
     
      }, timeout);
}

 function changefocus(event,ref)
   {
      var ref_id= ref.attr('id');
      var index=ref_id.split("_")[1];
      index=parseInt(index);
     
    var keycode = (event.keyCode ? event.keyCode : event.which);
    
    if(keycode == '13'){
        event.preventDefault();
        $('#pro_name').val('');
        $('#pro_name').focus();
    }else if(keycode == '38')
    {
        while(index>0)
        {
            index--;
            if($('#quantity_'+index).length>0)
            {
            $('#quantity_'+index).focus();
            break;
            }
        }
    }else if(keycode == '40')
    {
        while(index<row_num)
        {
         index++;
            if($('#quantity_'+index).length>0)
            {
            $('#quantity_'+index).focus();
            break;
            }
        }
    }
   }
function addProduct(index,from,qty,rate)
  {
     
      $("#overlay").fadeIn(300);
      $('.product_select').removeClass('product_select');
      $('#sugession').html('');
      $('#sugession').parent().hide();
      var row=product_result[index];
 for(var k=1;k<row_num;k++)
      {
        if($('#stock_id_'+k).val()==row['stock_id'])
          {
              if(from==1)
              {
               var qty=$('#quantity_'+k).val();
               qty=parseFloat(qty);
               qty++;
               $('#quantity_'+k).val(qty);
              
               $('#quantity_'+k).focus();
              }else{
                 Swal.fire({title:"Info!",text:"already added",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                  $("#overlay").fadeOut(300);
                 return false;
              }
              $("#overlay").fadeOut(300);
                return;  
          }
      }
     
            chk=0;
            chk=1;
            
            if(chk==1)
            {
              var html='<tr style="background:#a4ffde;">\n\
                  <td>\n\
                        <a href="#" onclick="$(this).parent().parent().remove();calcnet();checkgridcount();" class="input_column">\n\
                        <button class="btn btn-danger btnDelete btn-sm">\n\
                           <i class="la la-trash"></i>\n\
                        </button>\n\
                        </a>\n\
                   </td>\n\
                   <td>'+row['code']+'</td>\n\
                   <td><b>'+row['name']+'</b><input type="hidden" value="'+row['name']+'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'+row_num+'" value="'+row['selling_price']+'"></td>\n\
                   <td><input type="text" name="stock[]" id="stock_'+row_num+'" readonly="" class="form-control grid_table"  value="'+row['quantity']+'"></td>\n\
                     <td>\n\
                       <select name="action[]" id="action_'+row_num+'" class="form-control" style="width:90px;font-size:12px;" >\n\
                         <option value="1">Add</option>\n\
                         <option value="2">Minus</option>\n\
                       </select>\n\
                   </td>\n\
                   <td><input type="number" step="any" name="quantity[]" id="quantity_'+row_num+'" class="form-control grid_table" value="0"    onkeydown="changefocus(event,$(this))" required  autocomplete="off"></td>\n\
                   <td style="display:none" class="mbl_view">\n\
                     <input type="hidden" name="stock_id[]" id="stock_id_'+row_num+'" value="'+row['stock_id']+'">\n\
                     <input type="hidden" name="product_id[]" id="product_id_'+row_num+'" value="'+row['item_id']+'">\n\
                     <input type="hidden" name="product_type[]" id="product_type_'+row_num+'" value="0">\n\
                   </td>\n\
                </tr>';
              $('#productdetails').children('tbody').append(html);
              $('#quantity_'+row_num).val('');
              if(from==1)
              {
                $('#quantity_'+row_num).val(1);  
                
              }
              if(qty>0)
              {
                  $('#quantity_'+row_num).val(qty);  
              }
            
              setTimeout(function(){ 
                      $('#quantity_'+row_num).focus();
                 
                  row_num++;
                
              $("#overlay").fadeOut(300);
    }, 500);
            }


  }

function viewdata(val)
{
    if(val>0)
    {
         $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: '<?=base_url()?>transaction/Lens_stock_adjustment/viewdata',
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

function savedata()
{
   
        $("#overlay").fadeIn(300);
        saveurl="<?php echo base_url(); ?>transaction/Lens_stock_adjustment/savedata";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#savedata').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
                $('#sdata').empty();
                $("#savedata")[0].reset();
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


function deletedata(val)
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
             delurl="<?php echo base_url(); ?>transaction/Lens_stock_adjustment/deletedata";
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
                $("#savedata")[0].reset();
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
