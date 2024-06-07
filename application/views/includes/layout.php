<?php
$path=base_url('template1/modern-admin/');
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="optical">
    <meta name="keywords" content="optical">
    <meta name="author" content="optical">
    <title><?php print $title; ?></title>
    <link rel="apple-touch-icon" href="<?=$path?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$path?>app-assets/images/logo/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/forms/toggle/switchery.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/forms/selects/selectivity-full.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/vendors/css/extensions/sweetalert2.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/pages/hospital.css">
      <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/plugins/forms/switch.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/core/colors/palette-switch.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>app-assets/css/plugins/forms/selectivity/selectivity.min.css">
   
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$path?>assets/css/style.css">
    <!-- END: Custom CSS-->


  <script src="<?=$path?>app-assets/vendors/js/vendors.min.js"></script>
   <script src="<?=$path?>app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>


      <script src="<?=$path?>app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
    <script src="<?=$path?>app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
    <!-- END: Theme JS-->
   
    <!-- BEGIN: Page JS-->
    
    <script src="<?=$path?>app-assets/js/scripts/pages/hospital-patients-list.js"></script>
    
    

    
   
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
<div id="overlay">
      <div class="cv-spinner">
        <span class="spinner"></span>
      </div>
    </div>
<?php
$this->load->view("includes/header",['path'=>$path]);
        ?>
  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <?=$content?>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

<?php
$this->load->view("includes/footer");
        ?>



    <!-- END: Page JS-->

</body>
<!-- END: Body-->
<style type="text/css">
    .swal2-popup .swal2-title {
    font-size: 1.175em;
}
.swal2-popup #swal2-content {
    
    font-family: sans-serif;
}
.btn-min-width {
    min-width: 3.5rem;
}

</style>
     <!-- BEGIN: Vendor JS-->
  
    <!-- BEGIN Vendor JS-->
<script src="<?=$path?>app-assets/js/scripts/forms/select/form-select2.min.js"></script>
    <!-- BEGIN: Page Vendor JS-->
     
    <script src="<?=$path?>app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- END: Page Vendor JS-->
   <script src="<?=$path?>app-assets/vendors/js/charts/chart.min.js"></script>
    <!-- BEGIN: Theme JS-->
    <script src="<?=$path?>app-assets/js/core/app-menu.js"></script>
    <script src="<?=$path?>app-assets/js/core/app.js"></script>
  

      <script src="<?=$path?>app-assets/js/scripts/master.js"></script>

<script src="<?=$path?>app-assets/js/scripts/forms/switch.min.js"></script>
</html>