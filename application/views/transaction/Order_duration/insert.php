<?php 
$path=base_url('template1/modern-admin/');
$cff='';
$host_tvm = explode('.',$_SERVER['HTTP_HOST'])[0];
if($host_tvm=='dehoptical')
{
    $cff=1;
}
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
                                    <h4 class="card-title">Order Duration</h4>
                                    <div id="edit_data"></div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="false">4 Month Duration</a>
                                            </li>
											<li class="nav-item">
                                                <a class="nav-link " id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false" onclick="eight_month()">8 Month Duration</a>
                                            </li>
											<li class="nav-item">
                                                <a class="nav-link " id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false" onclick="twelve_months()">12 Month Duration</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                           <div class="tab-pane active" id="tab1" aria-labelledby="base-tab1">
                                                 <div class="card-body collapse show">
                                                <div class="table-responsive">
													<table id="four_month" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                             <th>Sl No</th>
                                                            <th>Order Number</th>
                                                            <th>Patient Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Order Date</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                            <th>Sl No</th>
                                                            <th>Order Number</th>
                                                            <th>Patient Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Order Date</th>
                                                            </tr>
                                                        </tfoot>
													</table>
												</div>
											</div>
                                            </div>
                                            <!-- Tab 1 finsh -->
												<div class="tab-pane " id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                <div class="table-responsive">
													<table id="eight_month_table" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                             <th>Sl No</th>
                                                            <th>Order Number</th>
                                                            <th>Patient Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Order Date</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                            <th>Sl No</th>
                                                            <th>Order Number</th>
                                                            <th>Patient Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Order Date</th>
                                                          		
                                                            </tr>
                                                        </tfoot>
													</table>
												</div>
											</div>
                                            </div>
                                            <!-- Tab 1 finsh -->  
												<!-- Tab 1 finsh -->
												<div class="tab-pane " id="tab3" aria-labelledby="base-tab3">
                                                 <div class="card-body collapse show">
                                                <div class="table-responsive">
													<table id="twelve_months_table" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                             <th>Sl No</th>
                                                            <th>Order Number</th>
                                                            <th>Patient Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Order Date</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                            <th>Sl No</th>
                                                            <th>Order Number</th>
                                                            <th>Patient Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Order Date</th>
                                                            </tr>
                                                        </tfoot>
													</table>
												</div>
											</div>
                                            </div>
                                            <!-- Tab 1 finsh -->

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
	
   table= $('#four_month').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Order_duration/fore_month_data',
          'columns': [
             { data: 'slno' },
             { data: 'invoice_number' },
             { data: 'name' },
             { data: 'mobile' },
             { data: 'address' },
			 { data: 'netamount' },
	         { data: 'sales_date' },
              
                     ],
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
});

  function eight_month() {
 table= $('#eight_month_table').DataTable( {
			'bDestroy': true,
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Order_duration/eight_month_data',
          'columns': [
             { data: 'slno' },
             { data: 'invoice_number' },
             { data: 'name' },
             { data: 'mobile' },
             { data: 'address' },
			 { data: 'netamount' },
	         { data: 'sales_date' },
              
                     ],
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
}
 function twelve_months() {
 table= $('#twelve_months_table').DataTable( {

		  'bDestroy': true,
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Order_duration/twelve_months_data',
          'columns': [
             { data: 'slno' },
             { data: 'invoice_number' },
             { data: 'name' },
             { data: 'mobile' },
             { data: 'address' },
			 { data: 'netamount' },
	         { data: 'sales_date' },
                     ],
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
}
</script>

          