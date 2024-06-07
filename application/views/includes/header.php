<?php $host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];  ?>
<style type="text/css">
    table .btn {
    padding: 0.35rem 0.4rem;
}
.btn.btn-icon i {
    font-size: 1.4rem;
}
.select2-container--classic .select2-results__options .select2-results__option[aria-selected=true], .select2-container--default .select2-results__options .select2-results__option[aria-selected=true] {
    background-color: #1e9ff2 !important;
    color: #fff !important;
}
  .grid_table{
        height: 30px;
        width: 80px;
}
.exceldes
{
 font-size: 25px;   
}
 .grid_tablewindow{
        width: 100%;
        height: 30px;
    }
    .lookuphead{
           background: #1e9ff2;
           color: #fff;
    }
    .form-control{
        height: 30px;
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
#tableid
{
    width: 100%;
}
<?php
 $current_url = $this->uri->uri_string();
 $explodeurl = explode("/",$current_url);
 ?>


 </style> 

<?php if($this->session->userdata('user_type')==2 && $explodeurl[0]!='reports') { ?>
 <style>
/* .table th:last-child  {
    display: none;
}
.table td:last-child  {
    display: none;
}
th:nth-last-child(1) {  
     display: none;

} 
th:nth-last-child(2) {  
     display: none;

} 
td:nth-last-child(2) {
     display: none;
} */
 </style>
        <?php } ?>

<!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="#"><img class="brand-logo" alt="modern admin logo" src="<?=$path?>app-assets/images/logo/logo.png">
                            <h3 class="brand-text">ARG TECH</h3>
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                          <?php if($this->session->userdata('user_type')==1) { ?>
                        <li class="dropdown nav-item mega-dropdown d-none d-lg-block"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Quick Menu</a>
                            <ul class="mega-dropdown-menu dropdown-menu row p-1">
                             
                                <li class="col-md-5 px-2">
                                    <h6 class="font-weight-bold font-medium-2 ml-1">Admin Panel</h6>
                                    <ul class="row mt-2">
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3" href="<?php echo base_url(); ?>transaction/Sales" ><i class="la la-shopping-cart font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Sales</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3" href="<?php echo base_url(); ?>transaction/Purchase_entry" ><i class="la la-tree font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Purchase</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3 mt-75 mt-xl-0" href="" target="_blank"><i class="ft-book font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">GST</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0" href="" target="_blank"><i class="ft-layers font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Item Master</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0" href="" target="_blank"><i class="ft-users font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Customers</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0" href="" target="_blank"><i class="ft-user-plus font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Suppliers</p>
                                            </a></li>
                                    </ul>
                                </li>
                              
                            </ul>
                        </li>
                    <?php } ?>
                        
                    </ul>
                    <ul class="nav navbar-nav float-right">
                      
                        <li style="display: none;" class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-danger badge-up badge-glow">5</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6><span class="notification-tag badge badge-danger float-right m-0">5 New</span>
                                </li>
                                <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">You have new order!</h6>
                                                <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1 mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading red darken-1">99% Server load</h6>
                                                <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3 mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                                                <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Complete the task</h6><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Generate monthly report</h6><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                            </ul>
                        </li>
                        <li style="display: none;" class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span></h6><span class="notification-tag badge badge-warning float-right m-0">4 New</span>
                                </li>
                                <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?=$path?>app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Margaret Govan</h6>
                                                <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="<?=$path?>app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Bret Lezama</h6>
                                                <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?=$path?>app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Carie Berra</h6>
                                                <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="<?=$path?>app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Eric Alsobrook</h6>
                                                <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time></small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?=strtoupper($this->session->userdata('username'));?></span><span class="avatar avatar-online"><img src="<?=$path?>app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
  <?php if($this->session->userdata('user_type')==1) { ?>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>master/Profile">
                                <i class="ft-user"></i> Edit Profile</a>
                            <?php } ?>

                                <a class="dropdown-item" href="#">

                                <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url(); ?>Login/logout"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
    

    <!-- BEGIN: Main Menu-->

    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                  <?php if($this->session->userdata('user_type')==1) { ?>
                <li <?php if($activecls=='Dashboard') { ?> class="active"  <?php  } ?>><a href="<?php echo base_url(); ?>master/Dashboard"><i class="la la-home"></i><span class="menu-title" data-i18n="Dashboard Hospital">Dashboard</span></a>
                </li>
                <li class=" navigation-header"><span data-i18n="Professional">Professional</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Professional"></i>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-edit"></i><span class="menu-title" data-i18n="Appointment">Master</span></a>
                    <ul class="menu-content">
                        <li <?php if($activecls=='Profile') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Profile"><i></i><span>Profile</span></a>
                        </li>
                        <li <?php if($activecls=='Category') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Category"><i></i><span>Category</span></a>
                        </li>
                        <li <?php if($activecls=='Brand') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Brand"><i></i><span>Brand</span></a>
                        </li>
                        
                        <li <?php if($activecls=='Tax') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Tax"><i></i><span>Tax</span></a>
                        </li>
                        <li <?php if($activecls=='modeofpay') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Modeofpay"><i></i><span>Mode of Pay</span></a>
                        </li>
                        <li <?php if($activecls=='company') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Company"><i></i><span>Company</span></a>
                        </li>
						 <li <?php if ($activecls == 'Hsn_master') { ?> class="active" <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Hsn_master"><i></i><span>HSN Master</span></a>
                        </li>
                         <li <?php if($activecls=='item_master') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Item_master"><i></i><span>Item Master</span></a>
                        </li>
                         <li <?php if($activecls=='staff_registration') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Staff_registration"><i></i><span>Staff Registration</span></a>
                        </li>
                         <li <?php if($activecls=='Createuser') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Create_user"><i></i><span>Create User</span></a>
                        </li>
                         <li <?php if($activecls=='Branch') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Branch"><i></i><span>Create Branch</span></a>
                        </li>
                       
                    </ul>
                </li>
                  <li class=" nav-item"><a href="#"><i class="fa ft-aperture"></i><span class="menu-title" data-i18n="Doctors">Lens</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='lens_type') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Lens_type"><i></i><span>Lens Type</span></a>
                        </li>
                        <li <?php if($activecls=='coating') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Coating"><i></i><span>Coating</span></a>
                        </li>
                        <li <?php if($activecls=='Lens') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Lens"><i></i><span>Lens Master</span></a>
                        </li>
                    </ul>
                </li>
                   <li class=" nav-item"><a href="#"><i class="la la-film"></i><span class="menu-title" data-i18n="Doctors">Frame</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='frame_type') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Frame_type"><i></i><span>Frame Type</span></a>
                        </li>
                        <li <?php if($activecls=='Colour') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Colour"><i></i><span>Colour</span></a>
                        </li>
                        <li <?php if($activecls=='Model') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Model"><i></i><span>Model</span></a>
                        </li>
                        <li <?php if($activecls=='Size') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Size"><i></i><span>Size</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="Doctors">Customers</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='customers') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Customers"><i></i><span>Add Customers</span></a>
                        </li>
                    </ul>
                </li>
                  <li class=" nav-item"><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="Doctors">Suppliers</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='suppliers') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Suppliers"><i></i><span>Add Suppliers</span></a>
                        </li>
                        </li>
                    </ul>
                </li>
                
                <li class=" navigation-header"><span data-i18n="Apps">Transaction</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Apps"></i>
                </li>
                   <li class=" nav-item"><a href="#"><i class="la la-tree"></i><span class="menu-title" data-i18n="Doctors">Purchase</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Purchase_order') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Purchase_order"><i></i><span>Purchase Order</span></a>
                            <li <?php if($activecls=='Purchase_entry') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Purchase_entry"><i></i><span>Purchase Entry</span></a></li>
                            <li <?php if($activecls=='Lens_purchase') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Lens_purchase"><i></i><span>Lens Purchase Entry</span></a></li>
                                <li  <?php if($activecls=='Purchase_return') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Purchase_return"><i></i><span>Purchase Return</span></a>
                        </li>
                        <li  <?php if($activecls=='Barcode') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Barcode"><i></i><span>Barcode</span></a>
                        </li>
                        <li  <?php if($activecls=='Stock_adjustment') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Stock_adjustment"><i></i><span>Stock Adjustment</span></a>
                        </li>
                         <li  <?php if($activecls=='Lens_stock_adjustment') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Lens_stock_adjustment"><i></i><span>Lens Stock Adjustment</span></a>
                        </li>
                         <li  <?php if($activecls=='Stock_transfer') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Stock_transfer"><i></i><span>Stock Transfer</span></a>
                        </li>
                    </ul>
                </li>
                 <li class=" nav-item"><a href="#"><i class="la la-money"></i><span class="menu-title" data-i18n="Doctors">Sales</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Sales') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Sales"><i></i><span>Sales Entry</span></a></li>
                              <?php if($host_tvm=='testopt' || $host_tvm=='dehoptical' || $host_tvm=='pefoptical' || $host_tvm=='dehaoptical' || $host_tvm=='dehtoptical' || $host_tvm=='sriganapathiopticals' || $host_tvm=='peftoptical' || $host_tvm=='akgopticals' || $host_tvm=='pefkopticals'){ ?>   
                              <li <?php if($activecls=='Optical_advice') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Optical_advice"><i></i><span>Optical Advice</span></a>
                            </li>
                        <?php } ?>
                             <li <?php if($activecls=='Counter_sales') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Counter_sales"><i></i><span>Counter Sales</span></a></li>
                            <li <?php if($activecls=='Sales_return') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Sales_return"><i></i><span>Sales Return</span></a></li> 
							<li <?php if($activecls=='Order_duration') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Order_duration"><i></i><span>Order Duration</span></a></li>
							<li <?php if($activecls=='Order_tracking') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Order_tracking"><i></i><span>Order Tracking</span></a></li>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span data-i18n="Apps">Reports</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Apps"></i>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-dollar"></i><span class="menu-title" data-i18n="Doctors">Purchase</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Purchase_entry_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Purchase_entry_report"><i></i><span>Purchase Entry</span></a></li>
                             <li <?php if($activecls=='Lens_purchase_entry_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Lens_purchase_entry_report"><i></i><span>Lens Purchase Entry</span></a></li>
                            <li><a class="menu-item" href="#"><i></i><span>Purchase Return</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-shopping-cart"></i><span class="menu-title" data-i18n="Doctors">Sales</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Sales_entry_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Sales_report"><i></i><span>Sales Report</span></a></li>
 <?php if($host_tvm=='testopt' || $host_tvm=='dehoptical' || $host_tvm=='pefoptical' || $host_tvm=='dehaoptical' || $host_tvm=='dehtoptical' || $host_tvm=='peftoptical' || $host_tvm=='pefkopticals'){ ?> 
                             <li <?php if($activecls=='Optical_advice_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Optical_advice_report"><i></i><span>Optical Advice Report</span></a></li>
                         <?php } ?>

                            <li <?php if($activecls=='Bill_order_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Bill_order_report"><i></i><span>Bill Order/Due Report</span></a></li>
                            <li <?php if($activecls=='Sales_return_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Sales_return_report"><i></i><span>Sales Return Report</span></a></li>
                        <li  <?php if($activecls=='Gst_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Gst_report"><i></i><span>GST Report</span></a>
                        </li>
						<li <?php if ($activecls == 'Order_duration_report') { ?> class="active" <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Order_duration_report"><i></i><span>Order Duration Report</span></a>
                </li>
                    </ul>
                </li>
                  <li class=" nav-item"><a href="#"><i class="la la-cube"></i><span class="menu-title" data-i18n="Doctors">Stock</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Stock_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Stock_report"><i></i><span>Stock Report</span></a>
                        </li>
                         <li <?php if($activecls=='Stock_transfer_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Stock_transfer_report"><i></i><span>Stock Transfer Report</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span data-i18n="Apps">Support</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Apps"></i>
                </li>
                 <li class=" nav-item"><a href="#"><i class="la la-phone"></i><span class="menu-title" data-i18n="Doctors">Support</span></a>
                 <ul class="menu-content">
                            <li <?php if($activecls=='Help desk') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Help_desk"><i></i><span>Help Desk</span></a>
                            </li>
                        
                    </ul>
                 </li>
             <?php  } elseif ($this->session->userdata('user_type')==2) { ?>

                  <li <?php if($activecls=='Dashboard') { ?> class="active"  <?php  } ?>><a href="<?php echo base_url(); ?>master/Dashboard"><i class="la la-home"></i><span class="menu-title" data-i18n="Dashboard Hospital">Dashboard</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-edit"></i><span class="menu-title" data-i18n="Appointment">Master</span></a>
                    <ul class="menu-content">
                        <li <?php if($activecls=='Profile') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Profile"><i></i><span>Profile</span></a>
                        </li>
                        <li <?php if($activecls=='Category') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Category"><i></i><span>Category</span></a>
                        </li>
                        <li <?php if($activecls=='Brand') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Brand"><i></i><span>Brand</span></a>
                        </li>
                        
                        <li <?php if($activecls=='Tax') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Tax"><i></i><span>Tax</span></a>
                        </li>
                        <li <?php if($activecls=='modeofpay') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Modeofpay"><i></i><span>Mode of Pay</span></a>
                        </li>
                        <li <?php if($activecls=='company') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Company"><i></i><span>Company</span></a>
                        </li>
						 <li <?php if ($activecls == 'Hsn_master') { ?> class="active" <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Hsn_master"><i></i><span>HSN Master</span></a>
                        </li>
                         <li <?php if($activecls=='item_master') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Item_master"><i></i><span>Item Master</span></a>
                        </li>
                         <li <?php if($activecls=='staff_registration') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Staff_registration"><i></i><span>Staff Registration</span></a>
                        </li>
                         <li <?php if($activecls=='Createuser') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Create_user"><i></i><span>Create User</span></a>
                        </li>
                           <li <?php if($activecls=='Branch') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Branch"><i></i><span>Create Branch</span></a>
                        </li>
                       
                    </ul>
                </li>
                  <li class=" nav-item"><a href="#"><i class="fa ft-aperture"></i><span class="menu-title" data-i18n="Doctors">Lens</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='lens_type') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Lens_type"><i></i><span>Lens Type</span></a>
                        </li>
                        <li <?php if($activecls=='coating') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Coating"><i></i><span>Coating</span></a>
                        </li>
                        <li <?php if($activecls=='Lens') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Lens"><i></i><span>Lens Master</span></a>
                        </li>
                    </ul>
                </li>
                   <li class=" nav-item"><a href="#"><i class="la la-film"></i><span class="menu-title" data-i18n="Doctors">Frame</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='frame_type') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Frame_type"><i></i><span>Frame Type</span></a>
                        </li>
                        <li <?php if($activecls=='Colour') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Colour"><i></i><span>Colour</span></a>
                        </li>
                        <li <?php if($activecls=='Model') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Model"><i></i><span>Model</span></a>
                        </li>
                        <li <?php if($activecls=='Size') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Size"><i></i><span>Size</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="Doctors">Customers</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='customers') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Customers"><i></i><span>Add Customers</span></a>
                        </li>
                    </ul>
                </li>
                  <li class=" nav-item"><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="Doctors">Suppliers</span></a>
                    <ul class="menu-content">
                         <li <?php if($activecls=='suppliers') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Suppliers"><i></i><span>Add Suppliers</span></a>
                        </li>
                        </li>
                    </ul>
                </li>

                  <li class=" navigation-header"><span data-i18n="Apps">Transaction</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Apps"></i>
                </li>
                   <li class=" nav-item"><a href="#"><i class="la la-tree"></i><span class="menu-title" data-i18n="Doctors">Purchase</span></a>
                    <ul class="menu-content">
                           
                        <li <?php if($activecls=='Purchase_entry') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Purchase_entry"><i></i><span>Purchase Entry</span></a></li>
                          <li <?php if($activecls=='Lens_purchase') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Lens_purchase"><i></i><span>Lens Purchase Entry</span></a></li>
                      
                        <li  <?php if($activecls=='Stock_adjustment') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Stock_adjustment"><i></i><span>Stock Adjustment</span></a>
                        </li>
                          <li  <?php if($activecls=='Lens_stock_adjustment') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Lens_stock_adjustment"><i></i><span>Lens Stock Adjustment</span></a>
                        </li>
                         <li  <?php if($activecls=='Stock_transfer') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Stock_transfer"><i></i><span>Stock Transfer</span></a>
                        </li>
                    </ul>
                </li>
                 <li class=" nav-item"><a href="#"><i class="la la-money"></i><span class="menu-title" data-i18n="Doctors">Sales</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Sales') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>transaction/Sales"><i></i><span>Sales Entry</span></a>
                        </li>
                          <?php if($host_tvm=='testopt' || $host_tvm=='dehoptical' || $host_tvm=='pefoptical' || $host_tvm=='dehaoptical' || $host_tvm=='dehtoptical' || $host_tvm=='peftoptical' || $host_tvm=='akgopticals' || $host_tvm=='pefkopticals'){ ?>   
                              <li <?php if($activecls=='Optical_advice') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Optical_advice"><i></i><span>Optical Advice</span></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class=" navigation-header"><span data-i18n="Apps">Reports</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Apps"></i>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-dollar"></i><span class="menu-title" data-i18n="Doctors">Purchase</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Purchase_entry_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Purchase_entry_report"><i></i><span>Purchase Entry</span></a></li>
                                <li <?php if($activecls=='Lens_purchase_entry_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Lens_purchase_entry_report"><i></i><span>Lens Purchase Entry</span></a></li>
                            <li><a class="menu-item" href="#"><i></i><span>Purchase Return</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-shopping-cart"></i><span class="menu-title" data-i18n="Doctors">Sales</span></a>
                    <ul class="menu-content">
                            <li <?php if($activecls=='Sales_entry_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Sales_report"><i></i><span>Sales Report</span></a></li>
                        <?php if($host_tvm=='testopt' || $host_tvm=='dehoptical' || $host_tvm=='pefoptical' || $host_tvm=='dehaoptical' || $host_tvm=='dehtoptical' || $host_tvm=='peftoptical' || $host_tvm=='akgopticals'){ ?> 
                             <li <?php if($activecls=='Optical_advice_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Optical_advice_report"><i></i><span>Optical Advice Report</span></a></li>
                         <?php } ?>
                            <li <?php if($activecls=='Bill_order_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Bill_order_report"><i></i><span>Bill Order/Due Report</span></a></li>
                            <li <?php if($activecls=='Sales_return_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Sales_return_report"><i></i><span>Sales Return Report</span></a></li>
                        <li  <?php if($activecls=='Gst_report') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Gst_report"><i></i><span>GST Report</span></a>
                        </li>
						<li <?php if ($activecls == 'Order_duration_report') { ?> class="active" <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>reports/Order_duration_report"><i></i><span>Order Duration Report</span></a>
                </li>
                    </ul>
                </li>
              

              
           <?php  }
          
            ?>

              <li class=" navigation-header"><span data-i18n="Apps">Settings</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Settings"></i>
                </li>
                 <li class=" nav-item"><a href="#"><i class="la la-cog"></i><span class="menu-title" data-i18n="Doctors">Settings</span></a>
                    <ul class="menu-content">
                        <li <?php if($activecls=='Change Password') { ?> class="active"  <?php  } ?>><a class="menu-item" href="<?php echo base_url(); ?>master/Change_password"><i></i><span>Change Password</span></a>
                        </li>
                    </ul>
                 </li>
           
            </ul>
        </div>
    </div>

    <!-- END: Main Menu-->