function classification(val)
{
    if(val>0)
    {
        code=$('#code').val();
        name=$('#name').val();
        if($("#code").val()=='' ||  $("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        if(val==1)
        {
          saveurl="Category/saveclassification";
        }
        else if(val==2)
        {
          saveurl="Brand/saveclassification";
        }

         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#classification').serialize()+"&type="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#classification")[0].reset();
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

function editclassification(val,type,code,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        if(type==1)
        {
          tit='Edit Category';
        }
        else if(type==2)
        {
          tit="Edit Brand";
        }
        $('#classification_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_code').val(code);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_classificationid').val(val);
        $('#edit_type').val(type);
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
function updatedata()
{
        type=$('#edit_type').val();
        if($("#edit_code").val()=='' ||  $("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        if(type==1)
        {
          upurl="Category/editclassification";
        }
        else if(type==2)
        {
          upurl="Brand/editclassification";
        }
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_category').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#category")[0].reset();
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

function deleteclassification(val,type)
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
            if(type==1)
            {
              delurl="Category/deleteclassification";
            }
            else if(type==2)
            {
              delurl="Brand/deleteclassification";
            }
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_category').serialize()+"&id="+val+"&type="+type,
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

///////////////////tax//////////
function savetaxmaster()
{
        
        if($("#tax").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter tax fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Tax/savetaxmaster";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#taxmaster').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#taxmaster")[0].reset();
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

function edittax(val,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        tit='Edit Tax';
        $('#tax_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_taxid').val(val);
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

function updatetaxdata()
{
        
        if($("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter Tax fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Tax/edittax";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_tax').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_tax")[0].reset();
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

function deletetax(val)
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
            delurl="Tax/deletetax";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_tax').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_tax")[0].reset();
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
/////////////////////////modeofpay/////////////////
function savemodeofpay()
{
        
        if($("#tax").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter Mode Name fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Modeofpay/savemodeofpay";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#modeofpay').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#modeofpay")[0].reset();
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

function editmodeofpay(val,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        tit='Edit Modeofpay';
        $('#mode_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_modeofpayid').val(val);
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

function updatemodeofpay()
{
        
        if($("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter Mode Name fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Modeofpay/editmodeofpay";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_modeofpay').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_modeofpay")[0].reset();
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

function deletemodeofpay(val)
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
            delurl="Modeofpay/deletemodeofpay";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_modeofpay').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_modeofpay")[0].reset();
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
//////////////////company////////////////
function savecompany()
{
        
        if($("#code").val()=='' ||  $("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Company/savecompany";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#company').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#company")[0].reset();
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

function editcompany(val,code,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        tit='Edit Company';
        $('#company_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_code').val(code);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_companyid').val(val);
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

function updatecompany()
{
        
        if($("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Company/editcompany";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_company').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_company")[0].reset();
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

function deletecompany(val)
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
            delurl="Company/deletecompany";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_company').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_company")[0].reset();
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

///////frame ///////////////////
function frameclassification(val)
{
    if(val>0)
    {
        code=$('#code').val();
        name=$('#name').val();
        if($("#code").val()=='' ||  $("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        if(val==1)
        {
          saveurl="Frame_type/saveframe";
        }
        else if(val==2)
        {
          saveurl="Colour/saveframe";
        }
        else if(val==3)
        {
          saveurl="Model/saveframe";
        }
        else if(val==4)
        {
          saveurl="Size/saveframe";
        }

         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#frame').serialize()+"&type="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#frame")[0].reset();
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

function editframe(val,type,code,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        if(type==1)
        {
          tit='Edit Frame type';
        }
        else if(type==2)
        {
          tit="Edit Frame colour";
        }
        else if(type==3)
        {
          tit="Edit Model colour";
        }
        else if(type==4)
        {
          tit="Edit Size";
        }
        $('#frame_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_code').val(code);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_frameid').val(val);
        $('#edit_type').val(type);
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
function updateframe()
{
        type=$('#edit_type').val();
        if($("#edit_code").val()=='' ||  $("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        if(type==1)
        {
          upurl="Frame_type/editframe";
        }
        else if(type==2)
        {
          upurl="Colour/editframe";
        }
        else if(type==3)
        {
          upurl="Model/editframe";
        }
        else if(type==4)
        {
          upurl="Size/editframe";
        }
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_frame').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_frame")[0].reset();
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

function deleteframe(val,type)
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
            if(type==1)
            {
              delurl="Frame_type/deleteframe";
            }
            else if(type==2)
            {
              delurl="Colour/deleteframe";
            }
            else if(type==3)
            {
              delurl="Model/deleteframe";
            }
            else if(type==4)
            {
              delurl="Size/deleteframe";
            }
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_frame').serialize()+"&id="+val+"&type="+type,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_frame")[0].reset();
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

///////////////////customer///////////
function savecustomer()
{    
        if($("#code").val()=='' || $("#name").val()=='' || $("#mobile").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Customers/savecustomer";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#customer').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#customer")[0].reset();
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

function editcustomer(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        csrf=$('#csrf_test_name').val();
        getdata='Customers/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: { getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  tit='Edit Customer';
                  $('#customer_modal').modal('show');
                  $('.modal-title').html(tit);
                  $('#edit_code').val(data.getdata[0]['code']);
                  $('#edit_name').val(data.getdata[0]['name']);
                  $('#edit_mobile').val(data.getdata[0]['mobile']);
                  $('#edit_gender').val(data.getdata[0]['gender']);
                  $('#edit_customer_alter_mobile').val(data.getdata[0]['alter_mobile']);
                  $('#edit_email_id').val(data.getdata[0]['email_id']);
                  $('#edit_mrd').val(data.getdata[0]['mrd']);
                  $('#edit_address').val(data.getdata[0]['address']);
                  $('#edit_description').val(data.getdata[0]['description']);
                  $('#edit_resph1').val(data.getdata[0]['resph1']);
                  $('#edit_resph2').val(data.getdata[0]['resph2']);
                  $('#edit_resph3').val(data.getdata[0]['resph3']);
                  $('#edit_resph4').val(data.getdata[0]['resph4']);
                  $('#edit_recyl1').val(data.getdata[0]['recyl1']);
                  $('#edit_recyl2').val(data.getdata[0]['recyl2']);
                  $('#edit_recyl3').val(data.getdata[0]['recyl3']);
                  $('#edit_recyl4').val(data.getdata[0]['recyl4']);
                  $('#edit_reaxis1').val(data.getdata[0]['reaxis1']);
                  $('#edit_reaxis2').val(data.getdata[0]['reaxis2']);
                  $('#edit_reaxis3').val(data.getdata[0]['reaxis3']);
                  $('#edit_reaxis4').val(data.getdata[0]['reaxis4']);
                  $('#edit_reva1').val(data.getdata[0]['reva1']);
                  $('#edit_reva2').val(data.getdata[0]['reva2']);
                  $('#edit_reva3').val(data.getdata[0]['reva3']);
                  $('#edit_reva4').val(data.getdata[0]['reva4']);
                  $('#edit_material').val(data.getdata[0]['material']);
                  $('#edit_cr').val(data.getdata[0]['cr']);
                  $('#edit_usage').val(data.getdata[0]['usage']);
                  $('#edit_type').val(data.getdata[0]['type']);
                  $('#edit_ipd').val(data.getdata[0]['ipd']);
                  $('#edit_pdre').val(data.getdata[0]['pdre']);
                  $('#edit_le').val(data.getdata[0]['le']);
                  $('#edit_segment').val(data.getdata[0]['segment']);
                  $('#edit_lle').val(data.getdata[0]['lle']);
                  $('#edit_prestype').val(data.getdata[0]['prestype']);
                  $('#edit_customerid').val(data.getdata[0]['customer_id']);
                  if(status==data.getdata[0]['status'])
                  {
                    st=0;
                  }
                  else
                  {
                    st=1;
                  }
                  $('#edit_status').val(st);
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

function updatecustomer()
{
        
        if($("#edit_code").val()=='' || $("#edit_name").val()=='' || $("#edit_mobile").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Customers/editcustomer";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_customer').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_customer")[0].reset();
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

function deletecustomer(val)
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
            delurl="Customers/deletecustomer";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_customer').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_customer")[0].reset();
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

///////////////////supplier///////////
function savesupplier()
{    
        if($("#code").val()=='' || $("#name").val()=='' || $("#mobile").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Suppliers/savesupplier";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#supplier').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#supplier")[0].reset();
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

function editsupplier(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        csrf=$('#csrf_test_name').val();
        getdata='Suppliers/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  tit='Edit Supplier';
                  $('#supplier_modal').modal('show');
                  $('.modal-title').html(tit);
                  $('#edit_code').val(data.getdata[0]['code']);
                  $('#edit_name').val(data.getdata[0]['name']);
                  $('#edit_mobile').val(data.getdata[0]['mobile']);
                  $('#edit_gender').val(data.getdata[0]['gender']);
                  $('#edit_alter_mobile').val(data.getdata[0]['alter_mobile']);
                  $('#edit_email_id').val(data.getdata[0]['email_id']);
                  $('#edit_address').val(data.getdata[0]['address']);
                  $('#edit_description').val(data.getdata[0]['description']);
                  $('#edit_contact_person_name').val(data.getdata[0]['contact_person_name']);
                  $('#edit_contact_person_mobile').val(data.getdata[0]['contact_person_mobile']);
                  $('#edit_gstin_type').val(data.getdata[0]['gstin_type']);
                  $('#edit_gst_no').val(data.getdata[0]['gst_no']);
                  $('#edit_category_id').val(data.getdata[0]['category_id']);
                  $('#edit_supplierid').val(data.getdata[0]['supplier_id']);
                  $('#edit_status').val(data.getdata[0]['status']);
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

function updatesupplier()
{
        
        if($("#edit_code").val()=='' || $("#edit_name").val()=='' || $("#edit_mobile").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Suppliers/editsupplier";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_supplier').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_supplier")[0].reset();
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

function deletesupplier(val)
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
            delurl="Suppliers/deletesupplier";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_supplier').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_supplier")[0].reset();
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


//////////////////////Item master//////////////////

function saveitem()
{    
        if($("#code").val()=='' || $("#name").val()=='' || $("#company_id").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Item_master/saveitem";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#item_master').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#item_master")[0].reset();
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

function edititem(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        csrf=$('#csrf_test_name').val();
        getdata='Item_master/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  tit='Edit Item Master';
                  $('#item_modal').modal('show');
                  $('.modal-title').html(tit);
                  $('#edit_code').val(data.getdata[0]['code']);
                  $('#edit_name').val(data.getdata[0]['name']);
                  $('#edit_category_id').val(data.getdata[0]['category_id']);
                  $('#edit_brand_id').val(data.getdata[0]['brand_id']);
                  $('#edit_company_id').val(data.getdata[0]['company_id']);
                  $('#edit_hsn_code').val(data.getdata[0]['hsn_code']);
                  $('#edit_gst_type').val(data.getdata[0]['gst_type']);
                  $('#edit_tax').val(data.getdata[0]['tax']);
                  $('#edit_cgst').val(data.getdata[0]['cgst']);
                  $('#edit_sgst').val(data.getdata[0]['sgst']);
                  $('#edit_description').val(data.getdata[0]['description']);
                  $('#edit_itemid').val(data.getdata[0]['item_id']);
                  if(status==data.getdata[0]['status'])
                  {
                    st=0;
                  }
                  else
                  {
                    st=1;
                  }
                  $('#edit_status').val(st);
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

function updateitem()
{
        
        if($("#edit_code").val()=='' || $("#edit_name").val()=='' || $("#edit_companyid").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       upurl="Item_master/edititem";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_item').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
               $(".close").click();
                $("#edit_item")[0].reset();
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

function deleteitem_master(val)
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
            delurl="Item_master/deleteitem_master";
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_item').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_item")[0].reset();
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


///////Lens ///////////////////
function lensclassification(val)
{
    if(val>0)
    {
        if($("#code").val()=='' ||  $("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        if(val==1)
        {
          saveurl="Lens_type/savelens";
        }
        else if(val==2)
        {
          saveurl="Coating/savelens";
        }
        else if(val==3)
        {
          saveurl="Lens/savelens";
        }
       

         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#lens').serialize()+"&type="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#lens")[0].reset();
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

function editlens(val,type,code,name,des,status)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        if(type==1)
        {
          tit='Edit Lens type';
        }
        else if(type==2)
        {
          tit="Edit Lens Coating";
        }
        else if(type==3)
        {
          tit="Edit Model colour";
        }
        else if(type==4)
        {
          tit="Edit Size";
        }
        $('#lens_modal').modal('show');
        $('.modal-title').html(tit);
        $('#edit_code').val(code);
        $('#edit_name').val(name);
        $('#edit_description').val(des);
        $('#edit_lensid').val(val);
        $('#edit_type').val(type);
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
function updatelens()
{
        type=$('#edit_type').val();
        if($("#edit_code").val()=='' ||  $("#edit_name").val()=='') {
           Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        if(type==1)
        {
          upurl="Lens_type/editlens";
        }
        else if(type==2)
        {
          upurl="Coating/editlens";
        }
        else if(type==3)
        {
          upurl="Lens/editlens";
        }
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#edit_lens').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $(".close").click();
                $("#edit_lens")[0].reset();
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



function deletelens(val,type)
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
            if(type==1)
            {
              delurl="Lens_type/deletelens";
            }
            else if(type==2)
            {
              delurl="Coating/deletelens";
            }
            else if(type==3)
            {
              delurl="Lens/deletelens";
            }
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#edit_lens').serialize()+"&id="+val+"&type="+type,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();
                $("#edit_lens")[0].reset();
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
//////////////////////save profile/////////////
function saveprofile()
{    
        if($("#company_name").val()=='' || $("#company_mobile").val()=='' || $("#printable_company_name").val()=='' || $("#printable_company_mobile").val()=='' || $("#printable_emailid").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        let data = new FormData($("#profilesave")[0]);
        $("#overlay").fadeIn(300);
        saveurl="Profile/saveprofile";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: data,
            contentType: false,       
            cache: false,             
            processData:false, 
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

function removelogo(val)
{
      if(val=='') {
           Swal.fire({title:"Info!",text:"Remove Logo ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
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
              delurl="Profile/removelogo";
            
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#profilesave').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               location.reload();
               
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

function changeTaxval(val,sel=0)
{
  if(val){
        if(val=='') {
           Swal.fire({title:"Info!",text:"Tax ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        csrf=$('#csrf_test_name').val();
        getdata='Item_master/gettaxdetails';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                 if(sel==0){
                    $('#cgst').val(data.getdata[0]['name']/2);
                    $('#sgst').val(data.getdata[0]['name']/2);
                   }
                   else
                   {
                    $('#edit_cgst').val(data.getdata[0]['name']/2);
                    $('#edit_sgst').val(data.getdata[0]['name']/2);
                   }
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
        else
        {
           if(sel==0){
            $('#cgst').val('');
            $('#sgst').val('');
            }
            else
            {
              $('#edit_cgst').val('');
              $('#edit_sgst').val('');
            }
        }
        
}






