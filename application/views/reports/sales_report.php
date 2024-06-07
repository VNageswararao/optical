<?php 
$path=base_url('template1/modern-admin/');
     $conred='readonly';
     if($this->session->userdata('user_type')==1)
   {
        $conred='';
   } 
?>      
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                     <h4 class="card-title">Sales Entry Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Summary Report</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Detailed Report</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Lens Report</a>
                                            </li>
                                           
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Sales Summary Amount Reducer Report</a>
                                            </li>
                                             <li class="nav-item">
                                                <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Income Report</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false">Product History Report</a>
                                            </li>
                                             <li class="nav-item">
                                                <a class="nav-link" id="base-tab7" data-toggle="tab" aria-controls="tab7" href="#tab7" aria-expanded="false">Profit Report</a>
                                            </li>
                                        </ul>
                   <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                             <form id="summary" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_fromdate" <?php echo $conred; ?> id="sum_fromdate"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_todate" <?php echo $conred; ?> id="sum_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Customer Name: </label>
                                            <select class="form-control select2" name="sum_customer" id="sum_customer">
                                                <option value>Select Customer Name</option>
                                                <?php if($getcustomer)
                                                {
                                                  foreach ($getcustomer as $data) {
                                                    ?>
                                                      <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: </label>
                                            <select class="form-control select2" name="sum_modeofpay" id="sum_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Staff: </label>
                                            <select class="form-control select2" name="staff" id="staff">
                                                <option value>Select Staff</option>
                                                <?php if($getstaff)
                                                {
                                                  foreach ($getstaff as $data) {
                                                    ?>
                                                      <option value="<?php print $data['staff_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Status: </label>
                                            <select class="form-control select2" name="status" id="status">
                                                <option value="0">Select All</option>
                                                 <option value="1">Inprogress</option>
                                                 <option value="2">Delivered</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Supplier: </label>
                                            <select class="form-control select2" name="supplier_id" id="supplier_id">
                                                <option value>Select Supplier</option>
                                                <?php if($getsupp)
                                                {
                                                  foreach ($getsupp as $data) {
                                                    ?>
                                                      <option value="<?php print $data['supplier_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Emergency Order: </label>
                                            <select class="form-control select2" name="emergency_order" id="emergency_order">
                                                <option value="">Select</option>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getsummary();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_sum">
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                           

                                 

                               
                            </form>
                       </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="">
                                                  <form id="detailed" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="det_fromdate" <?php echo $conred; ?> id="det_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="det_todate" <?php echo $conred; ?> id="det_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Customer Name: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_customer" id="det_customer">
                                                <option value>Select Customer Name</option>
                                                <?php if($getcustomer)
                                                {
                                                  foreach ($getcustomer as $data) {
                                                    ?>
                                                      <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_modeofpay" id="det_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Category: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_category" id="det_category">
                                               
                                                <?php if($getcategory)
                                                {
                                                  foreach ($getcategory as $data) {
                                                    ?>
                                                      <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="det_itemm" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_item" id="det_item">
                                                <option value>Select Item</option>
                                                <?php if($getitem)
                                                {
                                                  foreach ($getitem as $data) {
                                                    ?>
                                                      <option value="<?php print $data['item_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                           <div class="col-md-3" id="det_lenss">
                                        <div class="form-group">
                                            <label for="lastname">Lens Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_lens" id="det_lens">
                                                <option value>Select Item</option>
                                                <?php if($getlens)
                                                {
                                                  foreach ($getlens as $data) {
                                                    ?>
                                                      <option value="<?php print $data['lens_master_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getdetailed();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_det">
                                           
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                                                
                                                </div>
                                            </div>


                                              <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                                 <div class="">
                                                  <form id="lensreport" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name2" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="len_fromdate" <?php echo $conred; ?> id="len_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="len_todate" <?php echo $conred; ?> id="len_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Customer Name: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="len_customer" id="len_customer">
                                                <option value>Select Customer Name</option>
                                                <?php if($getcustomer)
                                                {
                                                  foreach ($getcustomer as $data) {
                                                    ?>
                                                      <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="len_modeofpay" id="len_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                      
                                    

                                           <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Lens Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="len_lens" id="len_lens">
                                                <option value>Select Item</option>
                                                <?php if($getlens)
                                                {
                                                  foreach ($getlens as $data) {
                                                    ?>
                                                      <option value="<?php print $data['lens_master_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getlensreport();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_len">
                                           
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                                                
                                                </div>
                                            </div>



                               <div role="tabpanel" class="tab-pane" id="tab4" aria-expanded="true" aria-labelledby="base-tab4">
                             <form id="summaryr" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_fromdater" <?php echo $conred; ?> id="sum_fromdater" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_todater" <?php echo $conred; ?> id="sum_todater" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Percentage: <span class="text-danger">*</span></label>
                                            <input type="text" name="percentage" id="percentage" class="form-control">
                                            <span >Ex:10 (No Need Percentage Symbol)</span>
                                        </div>
                                    </div>
                                    
                                    
                                </div>

                                <div class="alert alert-warning mb-2" role="alert">
                                    Allowed only Delivered Bill
                                </div>
                             

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getsummaryr();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_sumr">
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                           

                                 

                               
                            </form>
                       </div>



                        <div role="tabpanel" class="tab-pane" id="tab5" aria-expanded="true" aria-labelledby="base-tab5">
                             <form id="summaryi" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_fromdatei" <?php echo $conred; ?> id="sum_fromdatei" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_todatei" <?php echo $conred; ?> id="sum_todatei" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getsummaryi();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_sumi">
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                       </div>

                       <div role="tabpanel" class="tab-pane" id="tab6" aria-expanded="true" aria-labelledby="base-tab6">
                             <form id="producthistory" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_fromdateproduct" <?php echo $conred; ?> id="sum_fromdateproduct" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="sum_todateproduct" <?php echo $conred; ?> id="sum_todateproduct" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="lastname">Category: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_categoryp" id="det_categoryp">
                                               
                                                <?php if($getcategory)
                                                {
                                                  foreach ($getcategory as $data) {
                                                    ?>
                                                      <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="det_itemmp" style="display: none;">
                                        <div class="form-group" >
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_itemp" id="det_itemp">
                                                <option value>Select Item</option>
                                                <?php if($getitem)
                                                {
                                                  foreach ($getitem as $data) {
                                                    ?>
                                                      <option value="<?php print $data['item_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                           <div class="col-md-3" id="det_lenssp">
                                        <div class="form-group" >
                                            <label for="lastname">Lens Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_lensp" id="det_lensp">
                                                <option value>Select Item</option>
                                                <?php if($getlens)
                                                {
                                                  foreach ($getlens as $data) {
                                                    ?>
                                                      <option value="<?php print $data['lens_master_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                               

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getproducthistory();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_producthistory">
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                       </div>



                        <div class="tab-pane" id="tab7" aria-labelledby="base-tab7">
                                                 <div class="">
                                                  <form id="profit" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                               <div class="row">
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">From Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="profit_fromdate" <?php echo $conred; ?> id="profit_fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">To Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="profit_todate" <?php echo $conred; ?> id="profit_todate" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Customer Name: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_customer" id="det_customer">
                                                <option value>Select Customer Name</option>
                                                <?php if($getcustomer)
                                                {
                                                  foreach ($getcustomer as $data) {
                                                    ?>
                                                      <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_modeofpay" id="det_modeofpay">
                                                <option value>Select Modeofpay</option>
                                                <?php if($getmodeofpay)
                                                {
                                                  foreach ($getmodeofpay as $data) {
                                                    ?>
                                                      <option value="<?php print $data['modeofpay_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Category: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_category" id="det_category">
                                               
                                                <?php if($getcategory)
                                                {
                                                  foreach ($getcategory as $data) {
                                                    if($data['name']=='FRAME')
                                                    {
                                                    ?>
                                                      <option value="<?php print $data['classification_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                    }
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="det_itemm" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Item Master: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="det_item" id="det_item">
                                                <option value>Select Item</option>
                                                <?php if($getitem)
                                                {
                                                  foreach ($getitem as $data) {
                                                    ?>
                                                      <option value="<?php print $data['item_id']; ?>"><?php print $data['name']; ?></option>
                                                    <?php
                                                  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                          
                                </div>

                                <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="getprofit();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                     <div class="form-group">
                                        <div class="table-responsive" id="showdata_profit">
                                           
                                        </div>
                                     </div>
                                 </div>
                                  </div>
                               
                            </form>
                                                
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
  $( document ).ready(function() {
    cd = (new Date()).toISOString().split('T')[0];
    $('#sum_fromdate').val(cd);
    $('#sum_todate').val(cd);
    $('#profit_fromdate').val(cd);
    $('#profit_todate').val(cd);
    $('#sum_fromdater').val(cd);
    $('#sum_todater').val(cd);
    $('#sum_fromdatei').val(cd);
    $('#sum_todatei').val(cd);
    $('#det_fromdate').val(cd);
    $('#det_todate').val(cd);
    $('#len_fromdate').val(cd);
    $('#len_todate').val(cd);
    $('#sum_fromdateproduct').val(cd);
    $('#sum_todateproduct').val(cd);
});
 var table;


function getsummary()
    { 
        if($("#sum_fromdate").val()=='' || $("#sum_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sum').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getsummary";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#summary').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sum').html(data.getdata);
                 $('#example_sum').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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

function getsummaryr()
    { 
        if($("#sum_fromdater").val()=='' || $("#sum_todater").val()=='' || $("#percentage").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sumr').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getsummaryr";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#summaryr').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sumr').html(data.getdata);
                 $('#example_sumr').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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

function getsummaryi()
    { 
        if($("#sum_fromdatei").val()=='' || $("#sum_todatei").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_sumi').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getsummaryi";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#summaryi').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_sumi').html(data.getdata);
                 $('#example_sumi').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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


function getproducthistory()
    { 
        if($("#sum_fromdateproduct").val()=='' || $("#sum_todateproduct").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_producthistory').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/producthistory";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#producthistory').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_producthistory').html(data.getdata);
                 $('#example_producthostory').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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


function getdetailed()
    { 
        if($("#det_fromdate").val()=='' || $("#det_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_det').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getdetailed";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#detailed').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_det').html(data.getdata);
                 $('#example_det').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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

function getlensreport()
    { 
        if($("#len_fromdate").val()=='' || $("#len_fromdate").val()=='') 
        {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_len').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getlensreport";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#lensreport').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_len').html(data.getdata);
                 $('#example_len').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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

   $(document).ready(function () {   
    $('body').on('change','#det_category', function() {
         cat=$('#det_category').val();
         if(cat>0)
         {
            if(cat==2)
            {
              $('#det_itemm').show();
              $('#det_lenss').hide();
            }
            else if(cat==1)
            {
              $('#det_itemm').hide();
              $('#det_lenss').show();
            }
            else
            {
              $('#det_itemm').show();
              $('#det_lenss').hide();
            }
         }
    });


    $('body').on('change','#det_categoryp', function() {
         cat=$('#det_categoryp').val();
         if(cat>0)
         {
            if(cat==2)
            {
              $('#det_itemmp').show();
              $('#det_lenssp').hide();
            }
            else if(cat==1)
            {
              $('#det_itemmp').hide();
              $('#det_lenssp').show();
            }
            else
            {
              $('#det_itemmp').show();
              $('#det_lenssp').hide();
            }
         }
    });
});

function getprofit()
    { 
        if($("#profit_fromdate").val()=='' || $("#profit_todate").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $('#showdata_profit').html('');
$.fn.dataTable.ext.errMode = 'none';
        $("#overlay").fadeIn(300);
        saveurl="Sales_report/getprofit";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#profit').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                $('#showdata_profit').html(data.getdata);
                 $('#example_profit').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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
          </script>
