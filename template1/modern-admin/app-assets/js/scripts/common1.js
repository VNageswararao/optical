function opticallogin()
{
     var selected_login = $("#select_login_type").val();
      if(selected_login==""){
           //Swal.fire({title:"Info!",text:"Select Login Type!",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           $('#error').delay(300).fadeIn('slow');
           $('#error').html('Select Login Type!');
           $('#error').delay(2000).fadeOut('slow');
           return false;
        }
        if(selected_login=='1' || selected_login=='2' || selected_login=='0'){ 
             $('#form_login').attr("action", "CitizenLogin/login");
            opticaladminlogin(); 
            opticalsuperadminlogin();
        }
}
function opticaladminlogin()
{
        if($("#text_login_username").val()=='' ||  $("#text_login_password").val()=='') {
           // Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
            $('#error').delay(300).fadeIn('slow');
            $('#error').html("Please enter all fields !");
            $('#error').delay(2000).fadeOut('slow');
            return false;
        }   
        var saltstr=$("#salt_string").val(); 
        if(saltstr==''){
            Swal.fire({title:"Info!",text:"Security Violation Occured !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
            return false;
        }
        var username=$("#text_login_username").val();
        var pass=$("#text_login_password").val(); 
        var form = $("#form_login");
        var urlchk = "Login/checklogin";    
        var secret_key="<?php echo $this->session->userdata('secret_key'); ?>";
         $("#overlay").fadeIn(300);
          $.ajax({
            url: urlchk,
            type: "post",
            dataType: 'json',
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                   $("#overlay").fadeOut(300);  
                  
                   if(data.msg)
                    {
                    $('#success').delay(300).fadeIn('slow');
                    $('#success').html("Login Successfully");
                    $('#success').delay(2000).fadeOut('slow');
                      window.location =data.url; 
                    }
                    else if(data.error)
                    {
                       var error = data.error;
                      var err_str = '';
                      for (var key in error) {
                      err_str += error[key];
                      }
                        $('#error').delay(300).fadeIn('slow');
                        $('#error').html(err_str);
                        $('#error').delay(2000).fadeOut('slow');
                    }
                      else if(data.error_message) {
                        var error = data.error_message;
                        var err_str = '';
                        for (var key in error) {
                          err_str += error[key];
                        }
                       // swal(err_str,{icon:"error"});
                        $('#error').delay(300).fadeIn('slow');
                        $('#error').html(err_str);
                        $('#error').delay(2000).fadeOut('slow');
                      }      
            },
            error: function (error) {
               // Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                $('#error').delay(300).fadeIn('slow');
                $('#error').html("Network Busy");
                $('#error').delay(2000).fadeOut('slow');
                $("#overlay").fadeOut(300);          
            }

        });

       
}
function opticalsuperadminlogin() {
  if ($("#text_login_username").val() == "" || $("#text_login_password").val() == "") {
    // Swal.fire({title:"Info!",text:"Please enter all fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
    $("#error").delay(300).fadeIn("slow");
    $("#error").html("Please enter all fields !");
    $("#error").delay(2000).fadeOut("slow");
    return false;
  }
  var saltstr = $("#salt_string").val();
  if (saltstr == "") {
    Swal.fire({
      title: "Info!",
      text: "Security Violation Occured !",
      type: "info",
      confirmButtonClass: "btn btn-primary",
      buttonsStyling: !1,
    });
    return false;
  }
  var username = $("#text_login_username").val();
  var pass = $("#text_login_password").val();
  var form = $("#form_login");
  var urlchk = "SuperAdmin/checklogin";
  var secret_key = "<?php echo $this->session->userdata('secret_key'); ?>";
  $("#overlay").fadeIn(300);
  $.ajax({
    url: urlchk,
    type: "post",
    dataType: "json",
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      $("#overlay").fadeOut(300);

      if (data.msg) {
        $("#success").delay(300).fadeIn("slow");
        $("#success").html("Login Successfully");
        $("#success").delay(2000).fadeOut("slow");
        window.location = data.url;
      } else if (data.error) {
        var error = data.error;
        var err_str = "";
        for (var key in error) {
          err_str += error[key];
        }
        $("#error").delay(300).fadeIn("slow");
        $("#error").html(err_str);
        $("#error").delay(2000).fadeOut("slow");
      } else if (data.error_message) {
        var error = data.error_message;
        var err_str = "";
        for (var key in error) {
          err_str += error[key];
        }
        // swal(err_str,{icon:"error"});
        $("#error").delay(300).fadeIn("slow");
        $("#error").html(err_str);
        $("#error").delay(2000).fadeOut("slow");
      }
    },
    error: function (error) {
      // Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
      $("#error").delay(300).fadeIn("slow");
      $("#error").html("Network Busy");
      $("#error").delay(2000).fadeOut("slow");
      $("#overlay").fadeOut(300);
    },
  });
}
