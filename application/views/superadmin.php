<?php
$path=base_url('template1/modern-admin/');
$host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="PHARMACY">
    <meta name="keywords" content="PHARMACY">
    <meta name="author" content="PHARMACY">
    <title>PHARMACY LOGIN</title>
    <link rel="apple-touch-icon" href="<?=$path?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$path?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/fonts/material-icons/material-icons.css">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/material-vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/extensions/sweetalert2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/material.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/material-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/material-colors.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/colors.min.css">


    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/core/colors/palette-gradient.min.css">
   
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/core/menu/menu-types/material-vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/pages/login-register.css">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->
<style type="text/css">
    input.form-control, select.form-control {
          border-bottom: 1px solid rgba(0, 0, 0, 0.3);
          border: 1px solid #dadada;
  }
  .swal2-popup #swal2-content {
    text-align: center;
    font-weight: 600;
}
#button{
  display:block;
  margin:20px auto;
  padding:10px 30px;
  background-color:#eee;
  border:solid #ccc 1px;
  cursor: pointer;
}
#overlay{   
  position: fixed;
  top: 0;
  z-index: 100;
  width: 100%;
  height:100%;
  display: none;
  background: rgba(0,0,0,0.6);
}
.cv-spinner {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;  
}
.spinner {
  width: 40px;
  height: 40px;
  border: 4px #ddd solid;
  border-top: 4px #2e93e6 solid;
  border-radius: 50%;
  animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
  100% { 
    transform: rotate(360deg); 
  }
}
.is-hide{
  display:none;
}
.swal2-popup .swal2-title {
    font-size: 20px;
}
</style>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout 1-column  bg-full-screen-image blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <div id="overlay">
      <div class="cv-spinner">
        <span class="spinner"></span>
      </div>
    </div>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-header row">
        </div>
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <?php if($host_tvm=='pefpharmacy'){ ?>
                                            <h3 style="color: red"><b>PHARMACY LOGIN</b></h3>
                                        <?php } else {  ?>
                                        <h3 style="color: red"><b>ARG TECH</b></h3>
                                    <?php } ?>
                                    </div>
                                   
                                </div>
                                <div class="card-content">
                                  
                                   
                                    <div class="card-body">
                                         <form id="form_login" action="#" method="post"> 
                                             <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>">      
                                             <fieldset class="form-group position-relative has-icon-left">
                                             
                                                <select class="form-control" name="select_login_type" id="select_login_type">
                                                    <option value="">Select Type</option>
                                                    <option value="0" <?php if(isset($_COOKIE["utype"])) { if($_COOKIE["utype"]==1) echo 'selected'; } ?>>Super Admin</option>
                                                   
                                                </select>
                                                <div class="form-control-position">
                                                    <i class="la la-lock"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" id="text_login_username" name="text_login_username" maxlength="30" placeholder="Your Username" value="<?php if(isset($_COOKIE["name"])) { echo $_COOKIE["name"]; } ?>">
                                                <div class="form-control-position">
                                                    <i class="la la-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control" id="text_login_password" name="text_login_password" maxlength="20" placeholder="Enter Password"  value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-sm-6 col-12 text-center text-sm-left pr-0">
                                                    <fieldset>
                                                        <input type="checkbox" name="remember" id="remember-me" class="chk-remember" value="1" checked>
                                                        <label for="remember-me"> Remember Me</label>
                                                    </fieldset>
                                                </div>
                                            
                                            </div>
                                            <button type="button" class="btn btn-outline-info btn-block" onClick="opticallogin();"><i class="ft-unlock"></i> Login</button>
                                            <?php
                                                $salt_str=$salt ?? '';  
                                                echo '<input type="hidden" id="salt_string" name="salt_string" value="'.$salt_str.'">';
                                            ?> 
                                            <br/>
                             <div class="alert bg-danger alert-dismissible mb-2" role="alert" id="error" style="display: none;">
                               
                            </div>
                            <div class="alert bg-success alert-dismissible mb-22" role="alert" id="success" style="display: none;">
                                    
                            </div> 
                                        </form>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?=$path?>app-assets/vendors/js/material-vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?=$path?>app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
     <script src="<?=$path?>app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?=$path?>app-assets/js/core/app-menu.js"></script>
    <script src="<?=$path?>app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=$path?>app-assets/js/scripts/pages/material-app.js"></script>
    <script src="<?=$path?>app-assets/js/scripts/forms/form-login-register.js"></script>
    <script src="<?=$path?>app-assets/js/scripts/common1.js"></script>
    <!-- END: Page JS-->
   
</body>
<!-- END: Body-->

</html>