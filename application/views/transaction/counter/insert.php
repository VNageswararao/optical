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
                                    <h4 class="card-title">Counter sales</h4>
                                    <div id="edit_data"></div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true"><l id="tab_tit">Add Counter sales Entry<l></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                            
                                        </ul>
                                        <form id="savenewcus_form" action="#" method="post"> 
                            <div id="customer_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="div_modal">
                              <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">Customer Code: <span class="text-danger">*</span></label>
                                            <input type="hidden" name="customerid" id="customerid">
                                           <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                           <input type="text" name="code" id="code" class="form-control" placeholder="Customer Code">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Customer Name: <span class="text-danger">*</span></label>
                                           <input type="text" name="name" id="name" class="form-control" placeholder="Customer Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Gender: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="gender" id="gender">
                                               <option value="1">Male</option>
                                               <option value="2">Female</option>
                                               <option value="3">Transgender</option>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Customer Mobile:</label>
                                           <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Customer Mobile">
                                        </div>
                                    </div>
                                   
                                </div>
                                  <div class="row">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Customer Alternate Mobile:</label>
                                           <input type="text" name="customer_alter_mobile" id="customer_alter_mobile" class="form-control" placeholder="Customer Alternate Mobile">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Customer Email ID: </label>
                                           <input type="text" name="email_id" id="email_id" class="form-control" placeholder="Customer Email ID">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Customer MRD NO: <span class="text-danger">*</span></label>
                                           <input type="text" name="mrd" id="mrd" class="form-control" placeholder="Customer MRD NO">
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Address:</label>
                                            <textarea cols="3" rows="3" id="address" name="address" class="form-control" placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="description" name="description" class="form-control" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 style="background: #c50922;color: #fff;padding: 6px;text-align: center;font-weight: bold;">Prescription</h3>
                                    </div>
                                    <div class="table-responsive" style="padding: 15px;margin-top: -18px;">
                                    <table class="table table-bordered">
                                        <tr style="background: #1e9ff24f">
                                            <td align="center" class="tab_tit">RE</td>
                                            <td align="center" class="tab_tit">LE</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px;">
                                                <table class="">
                                                    <tr style="padding: 0px;background: #1e9ff24f;">
                                                        <td style="background: #1e9ff24f;"></td>
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">V/A</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="tab_tit" style="background: #1e9ff24f;">D.V</td>
                                                        <td style="padding:10px;"><input type="text" name="resph1" id="resph1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="recyl1" id="recyl1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reaxis1" id="reaxis1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reva1" id="reva1" class="form-control"></td>
                                                    </tr>
                                                     <tr>
                                                        <td style="background: #1e9ff24f;" class="tab_tit">N.V</td>
                                                        <td style="padding:10px;"><input type="text" name="resph2" id="resph2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="recyl2" id="recyl2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reaxis2" id="reaxis2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reva2" id="reva2" class="form-control"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="padding: 0px;">
                                                <table class="">
                                                    <tr style="padding: 0px;background: #1e9ff24f">
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">V/A</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:10px;"><input type="text" name="resph3" id="resph3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="recyl3" id="recyl3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reaxis3" id="reaxis3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reva3" id="reva3" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:10px;"><input type="text" name="resph4" id="resph4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="recyl4" id="recyl4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reaxis4" id="reaxis4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="reva4" id="reva4" class="form-control"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div> 
                                </div>
                                   <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">Material:</label>
                                           <input type="text" name="material" id="material" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">CR: </label>
                                           <input type="text" name="cr" id="cr" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Usage:</label>
                                           <input type="text" name="usage" id="usage" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Type:</label>
                                           <input type="text" name="type" id="type" class="form-control" >
                                        </div>
                                    </div>
                                   
                                </div>
                                    <div class="row">
                                    <div class="col-md-2">
                                         <div class="form-group">
                                            <label for="firstname">IPD:</label>
                                           <input type="text" name="ipd" id="ipd" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">PD RE: </label>
                                           <input type="text" name="pdre" id="pdre" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">LE:</label>
                                           <input type="text" name="le" id="le" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Segment RE:</label>
                                           <input type="text" name="segment" id="segment" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="firstname">LE:</label>
                                           <input type="text" name="lle" id="lle" class="form-control">
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">Type:</label>
                                           <select class="form-control" name="prestype" id="prestype">
                                               <option value="1">Undilatated</option>
                                               <option value="2">Cycloplegic</option>
                                               <option value="3">PMT</option>
                                               <option value="4">Final prescription</option>
                                           </select>
                                        </div>
                                    </div>
                                      <div class="col-md-3 gstcls">
                                         <div class="form-group">
                                            <label for="firstname">GST:</label>
                                           <select class="form-control" name="gst" id="gstcus">
                                               <option value="1">Yes</option>
                                               <option value="2">No</option>
                                              
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3" style="display: none;">
                                         <div class="form-group">
                                             <label for="lastname">Status: </label>
                                         <select class="form-control" name="status" id="status">
                                            <option value="1">Active</option>
                                            <option value="0">De-Active</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                   
                                 
                                  
                               
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button id="savecus" class="btn btn-primary btn-sm" type="button" onclick="addnewcussave();"><i class="fas fa-plus-square"></i>Save</button>

                    <button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                               <form id="saveCounter_sales_form" action="#" method="post"> 
                                                 <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="edit_Counter_sales_id" id="edit_Counter_sales_id">
                                            <label for="lastname">Customer Name: <span class="text-danger">*</span><button type="button" class="btn btn-success btn-sm" onclick="addnewcus();">Add New cus</button><button type="button" onclick="showdescription();" class="btn btn-danger btn-sm">Show Det</button></label>
                                            <select class="form-control select2" name="customer_id" id="customer_id" onchange="loadcustomerdetails($(this).val());">
                                                <option value="0">Select Customer Name</option>
                                                <?php
                                                    if($getcustomer)
                                                    {
                                                        foreach ($getcustomer as $data) {
                                                            ?>
                                                                <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?>  <?php print $data['mobile']; ?> <?php print $data['mrd']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Mobile No: <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_mbl" id="customer_mbl" class="form-control" placeholder="mobile no" readonly>
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="Counter_sales_date" id="Counter_sales_date" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Time: </label>
                                            <input type="time" name="Counter_sales_time" id="Counter_sales_time" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                    <div class="row" style="display:none;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Category: <span class="text-danger">*</span></label>
                                             <select class="form-control" name="category_id" id="category_id">
                                                <option value="">Select Category Name</option>
                                                <?php
                                                if($category)
                                                {
                                                    foreach ($category as $data) {
                                                        ?>
                                                        <option value="<?php print $data['classification_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
                                          <select class="form-control select2" name="supplier_id" id="supplier_id">
                                                <option value="">Select supplier</option>
                                                <?php
                                                if($getsupplier)
                                                {
                                                    foreach($getsupplier as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['supplier_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Supplier Mobile No: <span class="text-danger">*</span></label>
                                            <input type="text" name="" class="form-control" placeholder="Mobile No" readonly>
                                        </div>
                                    </div>
                                    
                                </div>

                                   <div class="row">
                                  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">Item list: <span class="text-danger">*</span></label>
                                           <input type="text" style="background: #0abdef;" name="" class="form-control" id="pro_name" onkeyup="loadautocomplete($(this).val(),1)" onkeydown="add_focus_to_first(event)" autocomplete="off">
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
                                                 <thead class="lookuphead" id="lens_section" style="display: none;">
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th>Lens Type</th>
                                                        <th>Coating</th>
                                                        <th>Purchase Amount</th>
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
                                                        <th>Rate</th>
                                                        <th>Qty</th>
                                                        <th>Dtype</th>
                                                        <th>Discnt</th>
                                                        <th>Total Amount</th>
                                                        <th style="display: none;">Tax Type</th>
                                                        <th style="display: none;">Tax</th>
                                                        <th style="display: none;">CGST</th>
                                                        <th style="display: none;">SGST</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                     </div>
                                 </div>
                                  </div>

                                   <div class="row">
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Total Qty: <span class="text-danger">*</span></label>
                                            <input type="text" name="total_qty" id="total_qty" class="form-control" style="text-align:right" readonly="">
                                        </div>
                                    </div>
                                       <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Cgst:</label>
                                            <input type="text" name="total_cgst" id="total_cgst"  class="form-control" readonly="" style="text-align:right">
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Sgst:</label>
                                            <input type="text" name="total_sgst" id="total_sgst" class="form-control" readonly="" style="text-align:right">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Tot Amnt:</label>
                                           <input type="hidden" name="net_amount" id="net_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 25px;background: gold;">
                                            <input type="text" name="total_amount" id="total_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 25px;background: gold;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Discount Percentage:</label>
                                             <input type="text" name="total_discount_percentage" id="total_discount_percentage" style="text-align:right" value=""  class="form-control"  onkeyup="find_discount_amount();calcnet();" onkeypress="isFloat(event)">
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Discount Amount: </label>
                                            <input type="text" name="total_discount_amount" id="total_discount_amount" class="form-control" style="text-align:right"  onkeyup="find_discount_percentage();calcnet();" value="" >
                                        </div>
                                    </div>
                                 </div>
                               
                                 <div class="row">
                                     
                                     <div class="col-md-2">
                                     <label>Other charge</label>
                                     <input type="text" name="other_charge" id="other_charge" class="form-control" style="text-align:right" onkeyup="calcnet()" value="" onkeypress="isFloat(event)">
                                  </div>
                                    <div class="col-md-3"  style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Advance Amount: </label>
                                            <input type="text" name="paying_amount" class="form-control" id="input_amount" onkeyup="balance_calculate($(this).val())" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2"  style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Balance Amount: <span class="text-danger">*</span></label>
                                           <input type="text" name="balance_amount" class="form-control" readonly="" id="output_amount" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Round off: <span class="text-danger">*</span></label>
                                           <input type="text" name="roundoff" id="roundoff" class="form-control" readonly="" style="text-align:right;">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Net Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="invoice_amount" id="invoice_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 30px;background: wheat;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="modeofpay_id" id="modeofpay_id">
                                               <option value="">Select Modeofpay</option>
                                                <?php
                                                if($getmodeofpay)
                                                {
                                                    foreach($getmodeofpay as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['modeofpay_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
 <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Staff: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="staff_id" id="staff_id">
                                               <option value="">Select Staff</option>
                                                <?php
                                                if($getstaff)
                                                {
                                                    foreach($getstaff as $data)
                                                    {
                                                        ?>
                                                        <option value="<?php print $data['staff_id'] ?>"><?php print $data['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                              
                                 <div class="row">
                                      
                                    <div class="col-md-3"  style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Status: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="bill_status" id="bill_status">
                                              
                                                <option value="2">Delivered</option>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-3"  style="display: none;">
                                        <div class="form-group">
                                            <label for="lastname">Expected Delivered Date: <span class="text-danger">*</span></label>
                                            <input  type="date" name="edate" id="edate" class="form-control">
                                        </div>
                                    </div>

                                     
                                    
                                 </div>

                                 <div class="row">
                                             <div class="col-md-3">
                                                 <label>Cash</label>
                                                 <input type="text" name="cash_billing" id="cash_billing" class="form-control">
                                             </div>
                                             <div class="col-md-3">
                                                 <label>Card</label>
                                                 <input type="text" name="card_billing" id="card_billing" class="form-control">
                                             </div>
                                             <div class="col-md-3">
                                                 <label>Paytm</label>
                                                 <input type="text" name="paytm_billing" id="paytm_billing" class="form-control">
                                             </div>
                                             <div class="col-md-3">
                                                 <label>Others</label>
                                                 <input type="text" name="others_billing" id="others_billing" class="form-control">
                                             </div>
                                     </div>

                                   <div class="row">
                                  <div class="col-md-12">
                                     <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="sdescription" id="sdescription"></textarea>
                                        </div>
                                     </div>
                                 </div>
                               

                                  
                         

                          

                                <div class="card-footer ml-auto">
                                    <button id="save" type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="saveCounter_salesentry();">Submit</button>
                                    <button style="display: none;" id="update" type="button" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1" onclick="updateCounter_salesentry();">Update</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onClick="window.location.reload();">Reset</button>
                                </div>
                            </form>
                             

                                            </div>
                                            <!-- Tab 1 finsih -->
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                <div class="table-responsive">
                                         <table id="tableid" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                            <th>Sl No</th>
                                                            <th>Bill No</th>
                                                            <th>Customer Name</th>
                                                            <th>Date</th>
                                                            <th>Total Qty</th>
                                                            <th>Total Amount</th>
                                                           
                                                            <th>Print</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Bill No</th>
                                                                <th>Customer Name</th>
                                                                <th>Date</th>
                                                                <th>Total Qty</th>
                                                                <th>Total Amount</th>
                                                              
                                                                <th>Print</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </tfoot>
                                           </table>
                                    </div>
                                </div>
                                            </div>
                                            <!-- Tab 2 finsh -->

                                            <div class="tab-pane" id="tab4" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                    <div class="row">
                                                             <div class="col-md-3">
                                                                  <label>Optical Advice From Date</label>
                                                                  <input type="date" class="form-control" name="opticaladvice_date1" id="opticaladvice_date1">
                                                              </div>
                                                              <div class="col-md-3">
                                                                  <label>Optical Advice to Date</label>
                                                                  <input type="date" class="form-control" name="opticaladvice_date2" id="opticaladvice_date2">
                                                              </div>
                                                              <div class="col-md-3">
                                                                  <br/>
                                                                  <button type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1" onclick="serachopticaladvice()">search</button>
                                                              </div>
                                                        
                                                    </div>
                                                <div  id="opticaladvicepat">
                                               </div>
                                              </div>
                                            </div>

                                            <!-- Tab 2 finsh --> 

                                               <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                                 <div class="card-body collapse show">
                                                   <div class="row">
                                                       <div class="col-md-2">
                                                           <label>Status</label>
                                                           <select class="form-control" name="status_show" id="status_show" onchange="loadstatus($(this).val());">
                                                               <option value="0">All</option>
                                                               <option value="1">Inprogress</option>
                                                               <option value="2">Delivered</option>
                                                               <option value="3">Ready</option>
                                                           </select>
                                                       </div>
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                               <label>Customer Name or mobile no or Invoice No<span class="text-danger">*</span></label>
                                                              <select class="form-control select2" name="status_customer" id="status_customer">
                                                                   <option value="0">Select Customer Name</option>
                                                                <?php
                                                                    if($getcustomerCounter_sales)
                                                                    {
                                                                        foreach ($getcustomerCounter_sales as $data) {
                                                                            ?>
                                                                    <option value="<?php print $data['Counter_sales_id']; ?>"><?php print $data['name']; ?>-<?php print $data['mrd']; ?>-<?php print $data['mobile']; ?>-<?php print $data['invoice_number']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                 ?>
                                                              </select>
                                                           </div>
                                                       </div>
                                                        <div class="col-md-1">
                                                            <br/>
                                                            <button style="margin-top: 3px;padding: 7px 12px;" id="show" type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1" onclick="showcustomerstatus();">Show</button>
                                                        </div>
                                                         <div class="col-md-3" id="st_status" style="display: none;">
                                                            <br/>
                                                            <button style="margin-top: 3px;padding: 7px 12px;" id="show" type="button" class="btn btn-danger btn-min-width btn-glow mr-1 mb-1" onclick="showdescription(1);">Show Customer Details</button>
                                                         </div>
                                                   </div>
                   <div class="row">

                         <div id="invoice-template" class="card-body p-4" style="display: none;">
                            
                                <!-- Invoice Company Details -->
                                    

                                 <!-- Invoice Customer Details -->
                                      
                                        <!-- Invoice Customer Details -->

                                        <!-- Invoice Items Details -->
    

    <!-- Invoice Footer -->
  
    <!-- Invoice Footer -->

                            </div>
                   </div>
                                                </div>
                                            </div>
                                              

                                             <!-- Tab 3 finsh -->
                                          
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
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Counter_sales/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'invoice_number' },
             { data: 'name' },
             { data: 'sales_date' },
             { data: 'total_qty' },
             { data: 'netamount' },
           
             { data: 'print' },
             { data: 'edit' },
             { data: 'delete' }
                     ],
       
    
        //            buttons: [
        // {
        //     extend: 'pdf',
        //     footer: true,
        //     attr:  {
        //         id: 'buttonpdf'
        //     },
        //     exportOptions: {
        //   columns: [0,1,2,3,4]
        //     }
        // },
        // {
        //     // extend: 'excel',
        //     //  footer: true,
        //     //  attr:  {
        //     //       id: 'buttonxl'
        //     //   },
        //     // exportOptions: {
        //     // columns: [0,1,2,3,4]
        //     //  }
        // }
        //  ],
         key: {
           enterkey: false

                },
     "order": [[ 0, "desc" ]],
     "lengthMenu": [[5,10,25, 50, 100, 1000], [5,10,25, 50, 100, 1000]]
     } );
}); 
     $( document ).ready(function() {
         have_cess=2;
         row_num=1;
        $('#sugession').parent().hide();
    cd = (new Date()).toISOString().split('T')[0];
    $('#Counter_sales_date').val(cd);
     $('#edate').val(cd);
     $('#opticaladvice_date1').val(cd);
     $('#opticaladvice_date2').val(cd);

    timee="<?php Echo date('H:i'); ?>";
    $('#Counter_sales_time').val(timee);

    <?php if($host_tvm=='testopt' || $host_tvm=='dehoptical'){ ?>   
        opticaladvice();
        <?php } ?>
});

      function printsale(Counter_sales_id){
        $('<form target="_blank" method="post" action="<?php echo base_url('transaction/Counter_sales/print_Counter_sales'); ?>"><input name="data_generatebill" value="'+Counter_sales_id+'"/><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();

    }
    function payamount()
{
     if($('#Counter_sales_idcus').val()=='') {
           Swal.fire({title:"Info!",text:"Counter_sales ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
      
          Swal.fire({title:"Are you sure to Pay Amount?",
            text:"You won't be able to revert this!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Confirm it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
                        
       
         upurl="Counter_sales/payamount";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
             data: {Counter_sales_id:$('#Counter_sales_idcus').val() ,customer_id:$('#customer_idcus').val(),netamount:$('#netamount_idcus').val(),payamount:$('#pay').val(),status:$('#status_cus').val(),pay_mode:$('#pay_mode').val(),olddisamt:$('#olddisamt').val(),olddisper:$('#olddisper').val(),disper:$('#disper').val(),disamt:$('#disamt').val(),csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
              // printsale(data.Counter_sales_id);
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
                }))
            

        
        
}

//           function payamount()
// { 
 
       
// }
     function updateCounter_salesentry()
{ 
        if($("#edit_Counter_sales_id").val()=='' || $("#customer_id").val()=='' || $("#Counter_sales_date").val()=='' || $("#Counter_sales_time").val()=='' || $("#total_qty").val()=='' || $("#bill_status").val()==''|| $("#modeofpay_id").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       
         upurl="Counter_sales/editCounter_salesentry";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#saveCounter_sales_form').serialize(),
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
function showcustomerstatus(val)
{
        if($('#status_customer').val()=='') {
           Swal.fire({title:"Info!",text:"Customer ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Counter_sales/getcustomerdata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: $('#status_customer').val(),csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                    $('#invoice-template').html(data.getdata);
                    $('#invoice-template').show();
                    $('#st_status').show();
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

function editsales(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Counter_sales/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  $('#base-tab1').click(); 
                  $('#tab_tit').html('Edit Counter_sales Entry');
                  $("#customer_id").val(data.getmasterdata[0]['customer_id']).trigger("change");
                  $('#staff_id').val(data.getmasterdata[0]['staff_id']);
                  $('#Counter_sales_date').val(data.getmasterdata[0]['sales_date']);
                  $('#Counter_sales_time').val(data.getmasterdata[0]['sales_time']);
                  $('#total_qty').val(data.getmasterdata[0]['total_qty']);
                  $('#total_cgst').val(data.getmasterdata[0]['total_cgst']);
                  $('#total_sgst').val(data.getmasterdata[0]['total_sgst']);
                  $('#total_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#net_amount').val(data.getmasterdata[0]['total_amount']);
                  $('#total_discount_amount').val(data.getmasterdata[0]['discount_amount']);
                  $('#total_discount_percentage').val(data.getmasterdata[0]['discount_percentage']);
                  $('#other_charge').val(data.getmasterdata[0]['other_charge']);
                  $('#input_amount').val(data.getmasterdata[0]['advanced_amount']);
                  $('#output_amount').val(data.getmasterdata[0]['balance_amount']);
                  $('#roundoff').val(data.getmasterdata[0]['roundoff']);
                  $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']);
                  $('#invoice_amount').val(data.getmasterdata[0]['netamount']);
                  $('#bill_status').val(data.getmasterdata[0]['status']);
                  $('#sdescription').val(data.getmasterdata[0]['description']);
                  $('#cash_billing').val(data.getmasterdata[0]['cash']);
                  $('#card_billing').val(data.getmasterdata[0]['card']);
                  $('#paytm_billing').val(data.getmasterdata[0]['paytm']);
                  $('#others_billing').val(data.getmasterdata[0]['others']);
                  $('#edate').val(data.getmasterdata[0]['expected_del_date']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  $('#edit_Counter_sales_id').val(data.getmasterdata[0]['counter_sales_id']);
                  $('#save').hide();
                  $('#update').show();
                  row_num=data.numrows;

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
function saveCounter_salesentry()
    {    
        if($("#customer_id").val()=='' || $("#Counter_sales_date").val()=='' || $("#Counter_sales_time").val()=='' || $("#total_qty").val()=='' || $("#bill_status").val()==''|| $("#modeofpay_id").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Counter_sales/saveCounter_salesentry";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#saveCounter_sales_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
                 printsale(data.Counter_sales_id);
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
     function addnewcussave()
{    
        if($("#code").val()=='' || $("#name").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="../master/Customers/savecustomer";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#savenewcus_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
              
                $("#savenewcus_form")[0].reset();
                getlastidcustomer();
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
function createlens()
{
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>master/Lens/createCounter_saleslens',
            dataType: "json",
            data: {csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
                 $('#edit_data').html(data.msg);
                 $('#div_modallens').modal('show');
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

function changeVat(vat)
                {
                    if(vat==0)
                    {
                      $('#tax_gstt').hide();
                      $('#cgstt').val('');
                      $('#sgstt').val('');
                      $('#taxt').val('');
                    }else{
                      $('#tax_gstt').show();  
                    }
                }
                function changeTaxvall(val,sel=0)
{
  if(val){
        if(val=='') {
           Swal.fire({title:"Info!",text:"Tax ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        csrf=$('#csrf_test_name').val();
        getdata='<?php echo base_url() ?>master/Item_master/gettaxdetails';
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
                    $('#cgstt').val(data.getdata[0]['name']/2);
                    $('#sgstt').val(data.getdata[0]['name']/2);
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
      
        
}

function lensclassificationn(val)
{
    if(val>0)
    {
        
        $("#overlay").fadeIn(300);
       saveurl="<?php echo base_url() ?>master/Lens/savelens";
       

         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#lens_form').serialize()+"&type="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
              $('.modal-backdrop').css('position', 'unset');
                 $('#edit_data').html('');
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

     function addnewcus()
    {  
         tit='Add New Customer';
         $("#savenewcus_form")[0].reset();
        

        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Counter_sales/getlastidcustomercountno';
        output='';
       // $('#customer_id').html('');
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                   $('#code').val(data.getdata);
                    $('#code').attr('readonly', true);
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

         $('#customer_modal').modal('show'); 
        $('#savecus').show();  
        $('.modal-title').html(tit); 

    }
     function showdescription(sel=0)
{
     if(sel==1)
     {
        cusid=$('#st_customer').val()
     }
     else
     {
        cusid=$('#customer_id').val();
     }

        if(cusid=='') {
           Swal.fire({title:"Info!",text:"Customer ID Not found.please select Customer",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='../master/Customers/getsavedata';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: { getid: cusid,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  tit='Customer';
                  $('#customer_modal').modal('show');
                  $('.modal-title').html(tit);
                  $('#code').val(data.getdata[0]['code']);
                  $('#name').val(data.getdata[0]['name']);
                  $('#mobile').val(data.getdata[0]['mobile']);
                  $('#gender').val(data.getdata[0]['gender']);
                  $('#customer_alter_mobile').val(data.getdata[0]['alter_mobile']);
                  $('#email_id').val(data.getdata[0]['email_id']);
                  $('#mrd').val(data.getdata[0]['mrd']);
                  $('#address').val(data.getdata[0]['address']);
                  $('#description').val(data.getdata[0]['description']);
                  $('#resph1').val(data.getdata[0]['resph1']);
                  $('#resph2').val(data.getdata[0]['resph2']);
                  $('#resph3').val(data.getdata[0]['resph3']);
                  $('#resph4').val(data.getdata[0]['resph4']);
                  $('#recyl1').val(data.getdata[0]['recyl1']);
                  $('#recyl2').val(data.getdata[0]['recyl2']);
                  $('#recyl3').val(data.getdata[0]['recyl3']);
                  $('#recyl4').val(data.getdata[0]['recyl4']);
                  $('#reaxis1').val(data.getdata[0]['reaxis1']);
                  $('#reaxis2').val(data.getdata[0]['reaxis2']);
                  $('#reaxis3').val(data.getdata[0]['reaxis3']);
                  $('#reaxis4').val(data.getdata[0]['reaxis4']);
                  $('#reva1').val(data.getdata[0]['reva1']);
                  $('#reva2').val(data.getdata[0]['reva2']);
                  $('#reva3').val(data.getdata[0]['reva3']);
                  $('#reva4').val(data.getdata[0]['reva4']);
                  $('#material').val(data.getdata[0]['material']);
                  $('#cr').val(data.getdata[0]['cr']);
                  $('#usage').val(data.getdata[0]['usage']);
                  $('#type').val(data.getdata[0]['type']);
                  $('#ipd').val(data.getdata[0]['ipd']);
                  $('#pdre').val(data.getdata[0]['pdre']);
                  $('#le').val(data.getdata[0]['le']);
                  $('#segment').val(data.getdata[0]['segment']);
                  $('#lle').val(data.getdata[0]['lle']);
                  $('#prestype').val(data.getdata[0]['prestype']);
                  $('#customerid').val(data.getdata[0]['customer_id']);
                  $('#gstcus').val(data.getdata[0]['gst']);
                  $('#savecus').hide();
                  if(status==data.getdata[0]['status'])
                  {
                    st=0;
                  }
                  else
                  {
                    st=1;
                  }
                  $('#status').val(st);
               } 
              else if(data.error != '')
              {
                Swal.fire({title:"Warning!",text:"Please Select Customer",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
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
function getlastidcustomer()
{
       
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Counter_sales/getlastidcustomer';
        output='';
        $('#customer_id').html('');
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                   showcustomer(data.getdata[0]['customer_id']);
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
 function showcustomer(val)
{
      // alert(val);
         $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Counter_sales/Showcustomername';
        output='';
        $('#customer_id').html('');
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: { getid: $('#customer_id').val(),csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                    data.getdata.forEach(function(item){ 
                        sel='';
                        if(val==item.customer_id)
                        {
                            sel="selected";
                        }
                           output += '<option value="'+item.customer_id+'"  '+sel+'>'+item.name+'</option>';
                        
                   });
                    $('#customer_id').html(output);
                    $('#mclose').click();
                    loadcustomerdetails(val);
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
function ffind_discount_percentage()
   {
      var discount= $('#disamt').val();
      var total_amount=$('#payhide').val();
         discount=parseFloat(discount);
         total_amount=parseFloat(total_amount);
        if(discount>0&&(total_amount>=discount))
        {
            var percentage=(discount*100)/total_amount;
            $('#disper').val(percentage.toFixed(2));
        }else{
            $('#disamt').val('');
            $('#disper').val(0);
        }
   }

      function find_discount_percentage()
   {
      var discount= $('#total_discount_amount').val();
      var total_amount=$('#total_amount').val();
         discount=parseFloat(discount);
         total_amount=parseFloat(total_amount);
        if(discount>0&&(total_amount>=discount))
        {
            var percentage=(discount*100)/total_amount;
            $('#total_discount_percentage').val(percentage.toFixed(2));
        }else{
            $('#total_discount_amount').val('');
            $('#total_discount_percentage').val(0);
        }
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
     function find_discount_amount()
   {
       var percentage=$('#total_discount_percentage').val();
       var total_amount=$('#total_amount').val();
       percentage=parseFloat(percentage);
       total_amount=parseFloat(total_amount);
        if(percentage>0)
        {
            var amount=(percentage*total_amount)/100;
            $('#total_discount_amount').val(amount.toFixed(2));
        }else{
            $('#total_discount_amount').val(0);
            $('#total_discount_percentage').val('');
        }
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
          if($('#category_id').val()==2)
          {
            addProduct(index);
          }
          else if($('#category_id').val()==1)
          {
            addlensProduct(index);
          }
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
var timeout = 500;
var timer;
function findInclusive_taxamount(price,tax)
 {
   if((have_cess==1)&&(have_gst==2)&&(tax>=12))
     {
         var taxable_amount=price*100/(100+tax+1);
          return taxable_amount*tax/100;
     }
     var taxable_amount=price*100/(100+tax);
    return taxable_amount*tax/100;
 }
 function findExclusive_taxamount(price,tax)
 {
     return price*tax/100;
 }
 function get_cess_exclusive(amount,tax)
 {
     if((have_cess==1)&&(have_gst==2)&&(tax>=12))
     {
       return  amount*1/100;
     }
    return 0;  
 }
function findIntValue(id)
{
    
    var value=$("#"+id).val();
       value=parseInt(value);
    if(isNaN(value))
    {
        return 0;
    }else{
        return value;
    }
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
function setActive(ref)
  {
      $('.product_select').removeClass('product_select');
      ref.addClass('product_select');
  }
    function get_cess_inclusive(amount,tax)
 {
   
     if((have_cess==1)&&(have_gst==2)&&(tax>=12))
     {
      var taxable_amount=amount*100/(100+tax+1);
       var  cess=taxable_amount/100;
       return cess.toFixed(4);
     }
    return 0;  
 }
  function loadautocomplete(product,val)
{
    //alert(product);
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
         $('#lens_section').hide();
            product_result=[];
        $.ajax({
            url:'Counter_sales/Counter_sales_search_stock',
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
               calcrow(k);
               $('#quantity_'+k).focus();
              }else{
            Swal.fire({title:"Info!",text:"already added",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                 
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
                   <td><input type="text" name="selling_price[]" id="selling_price_'+row_num+'" class="form-control grid_table" value="'+row['selling_price']+'" onKeyUp="calcrow('+row_num+')" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))" ></td>\n\
                   <td><input type="number" step="any" name="quantity[]" id="quantity_'+row_num+'" class="form-control grid_table" value="0"  onKeyUp="calcrow('+row_num+')"  onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)" required  autocomplete="off"></td>\n\
                   <td class="mbl_view">\n\
                       <select name="discount_type[]" id="discount_type_'+row_num+'" class="form-control grid_table" onchange="calcrow('+row_num+')">\n\
                         <option value="0">Amount</option>\n\
                         <option value="1">Percentage</option>\n\
                       </select>\n\
                   </td>\n\
                   <td class="mbl_view">\n\
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onKeyUp="calcrow('+row_num+')" id="discount_input_'+row_num+'" value="" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))">\n\
                      <input type="hidden" name="discount_amount[]" value="0" id="discount_amount_'+row_num+'" value=""></td>\n\
                   </td>\n\
                   <td>\n\
                      <input name="amount[]" id="amount_'+row_num+'" class="form-control grid_table" value="0" readonly="">\n\
                   </td>\n\
                   <td style="display: none;" class="mbl_view">\n\
                     <select name="tax_type[]" id="tax_type_'+row_num+'" style="font-size:12px" class="form-control grid_table disabled_select">\n\
                       <option value="0">Non Tax</option>\n\
                       <option value="1">Inclusive</option>\n\
                       <option value="2">Exclusive</option>\n\
                     </select>\n\
                   </td>\n\
                   <td style="display: none;" class="mbl_view"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'+row_num+'" readonly="" value="'+row['taxval']+'"></td>\n\
                   <td style="display: none;" class="vat mbl_view"><input type="text" class="form-control grid_table" name="cgst[]" id="cgst_'+row_num+'" readonly="" value="0" ></td>\n\
                   <td style="display: none;" class="vat mbl_view"><input type="text" class="form-control grid_table" name="sgst[]" id="sgst_'+row_num+'" readonly="" value="0" ></td>\n\
                   <td style="display:none" class="mbl_view">\n\
                     <input type="hidden" name="stock_id[]" id="stock_id_'+row_num+'" value="'+row['stock_id']+'">\n\
                     <input type="hidden" name="product_id[]" id="product_id_'+row_num+'" value="'+row['item_id']+'">\n\
                     <input type="hidden" name="tax_amount[]" id="tax_amount_'+row_num+'" value="0">\n\
                     <input type="hidden" name="product_type[]" id="product_type_'+row_num+'" value="0">\n\
                   </td>\n\
                </tr>';
              $('#productdetails').children('tbody').append(html);
              $('#quantity_'+row_num).val('');
              if(from==1)
              {
                $('#quantity_'+row_num).val(1);  
                
              }
              $('#tax_type_'+row_num).val(row['gst_type']);
              if(qty>0)
              {
                  $('#quantity_'+row_num).val(qty);  
              }
              if(rate>0)
              {
                 $('#selling_price_'+row_num).val(rate);   
              }
              setTimeout(function(){ 
                      $('#quantity_'+row_num).focus();
                  calcrow(row_num);
                  row_num++;
                  calcnet();
              $("#overlay").fadeOut(300);
    }, 500);
            }


  }
function deletesales(val)
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
            delurl="Counter_sales/deleteCounter_salesentry";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#saveCounter_sales_form').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Deleted",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();

                // $("#savepurchaseorder_form")[0].reset();
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

function changereadytodelivery(val)
{
      if(val=='') {
           Swal.fire({title:"Info!",text:"Ready to delivery ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
          Swal.fire({title:"Are you sure?",
            text:"You won't be able to revert this!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#3085d6",
            cancelButtonColor:"#d33",
            confirmButtonText:"Yes, Ready to Delivery it!",
            confirmButtonClass:"btn btn-warning",
            cancelButtonClass:"btn btn-danger ml-1",
            buttonsStyling:!1}).then((function(t){
              if(t.value)
                {
            delurl="Counter_sales/readytodelivery";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#saveCounter_sales_form').serialize()+"&id="+val,
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"Ready to Delivery",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               table.draw();

                // $("#savepurchaseorder_form")[0].reset();
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
  function addlensProduct(index,from,qty,rate)
  {
      $("#overlay").fadeIn(300);
      $('.product_select').removeClass('product_select');
      $('#sugession').html('');
      $('#sugession').parent().hide();
      var row=product_result[index];
 for(var k=1;k<row_num;k++)
      {
        // if($('#stock_id_'+k).val()==row['lens_master_id'])
        //   {
        //       if(from==1)
        //       {
        //        var qty=$('#quantity_'+k).val();
        //        qty=parseFloat(qty);
        //        qty++;
        //        $('#quantity_'+k).val(qty);
        //        calcrow(k);
        //        $('#quantity_'+k).focus();
        //       }else{
        //     //  Swal.fire({title:"Info!",text:"already added",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                 
        //       }
        //       $("#overlay").fadeOut(300);
        //         return;  
        //   }
      }
     
            chk=0;
            chk=1;
            
            if(chk==1)
            {
              var html='<tr style="background:#ffedb8;">\n\
                  <td>\n\
                        <a href="#" onclick="$(this).parent().parent().remove();calcnet();checkgridcount();" class="input_column">\n\
                        <button class="btn btn-danger btnDelete btn-sm">\n\
                           <i class="la la-trash"></i>\n\
                        </button>\n\
                        </a>\n\
                   </td>\n\
                   <td>'+row['code']+'</td>\n\
                   <td><b>'+row['name']+'</b><input type="hidden" value="'+row['name']+'" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_'+row_num+'" value="'+row['purchase_amount']+'"></td>\n\
                   <td></td>\n\
                   <td><input type="text" name="selling_price[]" id="selling_price_'+row_num+'" class="form-control grid_table" value="'+row['purchase_amount']+'" onKeyUp="calcrow('+row_num+')" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))" ></td>\n\
                   <td><input type="number" step="any" name="quantity[]" id="quantity_'+row_num+'" class="form-control grid_table" value="0"  onKeyUp="calcrow('+row_num+')"  onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)" required  autocomplete="off"></td>\n\
                   <td></td>\n\
                   <td></td>\n\
                   <td></td>\n\
                   <td></td>\n\
                   <td>'+row['lens_type']+'</td>\n\
                   <td>'+row['lens_coating']+'</td>\n\
                   <td class="mbl_view">\n\
                       <select name="discount_type[]" id="discount_type_'+row_num+'" class="form-control grid_table" onchange="calcrow('+row_num+')">\n\
                         <option value="0">Amount</option>\n\
                         <option value="1">Percentage</option>\n\
                       </select>\n\
                   </td>\n\
                   <td class="mbl_view">\n\
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onKeyUp="calcrow('+row_num+')" id="discount_input_'+row_num+'" value="" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))">\n\
                      <input type="hidden" name="discount_amount[]" value="0" id="discount_amount_'+row_num+'" value=""></td>\n\
                   </td>\n\
                   <td>\n\
                      <input name="amount[]" id="amount_'+row_num+'" class="form-control grid_table" value="0" readonly="">\n\
                   </td>\n\
                   <td style="display: none;" class="mbl_view">\n\
                     <select name="tax_type[]" id="tax_type_'+row_num+'" style="font-size:12px" class="form-control grid_table disabled_select">\n\
                       <option value="0">Non Tax</option>\n\
                       <option value="1">Inclusive</option>\n\
                       <option value="2">Exclusive</option>\n\
                     </select>\n\
                   </td>\n\
                   <td style="display: none;" class="mbl_view"><input type="text" class="form-control grid_table" name="gst[]" id="gst_'+row_num+'" readonly="" value="'+row['taxval']+'"></td>\n\
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="cgst[]" id="cgst_'+row_num+'" readonly="" value="0" ></td>\n\
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="sgst[]" id="sgst_'+row_num+'" readonly="" value="0" ></td>\n\
                   <td style="display:none" class="mbl_view">\n\
                     <input type="hidden" name="stock_id[]" id="stock_id_'+row_num+'" value="'+row['lens_master_id']+'">\n\
                     <input type="hidden" name="product_id[]" id="product_id_'+row_num+'" value="'+row['lens_master_id']+'">\n\
                     <input type="hidden" name="tax_amount[]" id="tax_amount_'+row_num+'" value="0">\n\
                     <input type="hidden" name="product_type[]" id="product_type_'+row_num+'" value="1">\n\
                   </td>\n\
                </tr>';
              $('#productdetails').children('tbody').append(html);
              $('#quantity_'+row_num).val('');
               $('#tax_type_'+row_num).val(row['gst_type']);
              if(from==1)
              {
                $('#quantity_'+row_num).val(1);  
                
              }
             
              if(qty>0)
              {
                  $('#quantity_'+row_num).val(qty);  
              }
              if(rate>0)
              {
                 $('#selling_price_'+row_num).val(rate);   
              }
              setTimeout(function(){ 
                      $('#quantity_'+row_num).focus();
                  calcrow(row_num);
                  row_num++;
                  calcnet();
              $("#overlay").fadeOut(300);
    }, 500);
            }


  }

  function calcrow(eid)
{
   
   var quantity=findFloatValue('quantity_'+eid);
   var stock=findFloatValue('stock_'+eid);
   var selling_price=findFloatValue('selling_price_'+eid);
   var price=quantity*selling_price;
   if($('#discount_type_'+eid).val()==0)
   {
       $('#discount_amount_'+eid).val(findIntValue('discount_input_'+eid));
   }else{
      var discount_percentage= findIntValue('discount_input_'+eid);
      var discount_amount=price*discount_percentage/100;
       $('#discount_amount_'+eid).val(discount_amount);
   }
   var price_reduced_discount=price-findFloatValue('discount_amount_'+eid);
   
   var gst_type=findIntValue('tax_type_'+eid);
   var customer_type=2;
   if($('#category_id').val()==2){
   if(parseFloat(quantity)>parseFloat(stock))
   {
      Swal.fire({title:"Info!",text:"Available Stock " +stock+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});

      $('#quantity_'+eid).val(0);
      price_reduced_discount=0;

   }
   }
   
   switch(gst_type)
   {
       case 0:$('#cgst_'+eid).val('0');
              $('#sgst_'+eid).val('0');
              $('#amount_'+eid).val(price_reduced_discount.toFixed(2));
              break;
       case 1:var taxamount=findInclusive_taxamount(price_reduced_discount,findFloatValue('gst_'+eid));
            
              var cess=get_cess_inclusive(price_reduced_discount,findFloatValue('gst_'+eid));
              $('#tax_amount_'+eid).val(taxamount);
              if(customer_type==1)
              {
                   $('#cgst_'+eid).val('0');
                   $('#sgst_'+eid).val('0');
              }else
              {
                
                  var cgst=taxamount/2;
                  var sgst=taxamount/2;
                   $('#cgst_'+eid).val(cgst.toFixed(2));
                   $('#sgst_'+eid).val(sgst.toFixed(2));
                   $('#igst_'+eid).val('0');
               }
               $('#cess_'+eid).val(cess);
               $('#amount_'+eid).val(price_reduced_discount.toFixed(2));
              break;
       case 2:var taxamount=findExclusive_taxamount(price_reduced_discount,findFloatValue('gst_'+eid));
              var cess=get_cess_exclusive(price_reduced_discount,findFloatValue('gst_'+eid))
                $('#tax_amount_'+eid).val(taxamount);
              if(customer_type==1)
              {
                  
                   $('#cgst_'+eid).val('0');
                   $('#sgst_'+eid).val('0');
                   
              }else
              {
                  var cgst=taxamount/2;
                  var sgst=taxamount/2;
                   $('#cgst_'+eid).val(cgst.toFixed(2));
                   $('#sgst_'+eid).val(sgst.toFixed(2));
                   
               }
               $('#cess_'+eid).val(cess.toFixed(4));
               var amount=price_reduced_discount+taxamount+cess;
               $('#amount_'+eid).val(amount.toFixed(2));
              break;
   }

   calcnet();
   $("#total_discount_percentage").keyup();
}
function stcalcnet()
{
    if($('#disamt').val()>0)
    {
        total_amount=$('#payhide').val();
        total_discount=$('#disamt').val();
        var net_amount=total_amount-total_discount;
        $('#pay').val(net_amount.toFixed(2));
    }
    else
    {
        $('#pay').val($('#payhide').val());
    }
}
function calcnet()
  { 
      var total_qty=0;
      var total_cgst=0;
      var total_sgst=0;
      var total_igst=0;
      var total_amount=0;
      var total_cess=0;
      var i=1;
      getrow= row_num+1;
      
    while(i<getrow)
    {
        
        total_qty+=findIntValue('quantity_'+i);
        total_cgst+=findFloatValue('cgst_'+i);
        total_sgst+=findFloatValue('sgst_'+i);
        total_amount+=findFloatValue('amount_'+i);
        i++;
    };
    $('#total_qty').val(total_qty.toFixed(2));
    $('#total_cgst').val(total_cgst.toFixed(2));
    $('#total_sgst').val(total_sgst.toFixed(2));
    $('#total_amount').val(total_amount.toFixed(2));
    var total_discount=findFloatValue('total_discount_amount');
    var other_charge=findFloatValue('other_charge');
    var returnamnt=findFloatValue('returnamnt');
    if(returnamnt)
    {
        returnamnt=returnamnt;
    }
    else
    {
        returnamnt=0;
    }
    var net_amount=total_amount-total_discount+other_charge-returnamnt;
    $('#net_amount').val(net_amount.toFixed(2));
    var invoice_amount=Math.round(net_amount);
    var removed_decimal=parseInt(net_amount);
    var round=0;
    if(invoice_amount>removed_decimal)
    {
        round=net_amount.toFixed(2)-removed_decimal;
    }else
    {
        round=removed_decimal-net_amount.toFixed(2);
    }
    $('#roundoff').val(round.toFixed(2));
    $('#invoice_amount').val(invoice_amount+'.00');
     $('#topshow').html(invoice_amount+'.00');
    if($('#modeofpay_id').val()==11)
    {
    //$('#cash_payment').val(net_amount.toFixed(2));
    }
    $('#submit').show();
      if($('#if_crlimit').val()==1)
    {
     
    if($('#modeofpay_id').val()==9)
    {
       var crlimit= parseFloat($('#crlimit').val());
        if(invoice_amount>crlimit)
        {
            errorMessage("Credit Limit Over");
            $('#submit').hide();
        }else
        {
           $('#submit').show();
        }
    }
  }
  $("#input_amount").val('');
  balance_calculate('');
}
    function balance_calculate(input_amount)
 {
    if(input_amount>0){
     var input_amount=parseFloat(input_amount);
     if(isNaN(input_amount))
     {
         input_amount=0;
     }
     var invoice_amount=parseFloat($('#invoice_amount').val());
     if(isNaN(invoice_amount))
     {
         invoice_amount=0;
     }
     var output_amount=parseFloat(invoice_amount)-parseFloat(input_amount);
     // if(output_amount>0)
     // {
     //     //errorMessage("amount could not less than bill amount");
     //     $('#output_amount').val('');
     //     return;
     // }
     $('#output_amount').val(output_amount);
   }
 }
  function loadstatus(id)  //get customer details
{
    if($("#status_show").val()=='') {
           Swal.fire({title:"Info!",text:"Please choose  Status fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Counter_sales/getstatuscon";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data:{status:$("#status_show").val(),csrf_test_name:$("#csrf_test_name").val()},
            success: function(data){
                $("#overlay").fadeOut(300);

               if(data.msg != ''){
                output='<option>select</option>';
                 $('#status_customer').html('');
                     data.getdata.forEach(function(item){ 
                           output += '<option value="'+item.Counter_sales_id+'">'+item.name+' - '+item.mobile+' - '+item.invoice_number+'</option>';
                   });
                    $('#status_customer').html(output);
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
    function loadcustomerdetails(id)  //get customer details
{
    if($("#customer_id").val()=='') {
           Swal.fire({title:"Info!",text:"Please choose  Customer fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Counter_sales/getcustomer";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data:{customer_id:$("#customer_id").val(),csrf_test_name:$("#csrf_test_name").val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               $('#customer_mbl').val(data.getdata[0]['mobile']);
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
function examinationprint(examinationid)
{
    
   $('<form target="_blank"  method="post" action="<?php echo base_url(); ?>/transaction/Counter_sales/examinationprint"><input name="examinationid" value="'+examinationid+'"/><input name="chkcomplaintsout" value="'+$('#chkcomplaints').is(':checked')+'"><input name="chkopthalmicsout" value="'+$('#chkophthalmic').is(':checked')+'"><input name="chkmedicalout" value="'+$('#chkmedical').is(':checked')+'"><input name="chkeyepartout" value="'+$('#chkeyepart').is(':checked')+'"><input name="addmedicinessout" value="'+$('#addmediciness').is(':checked')+'"><input name="investigationchkout" value="'+$('#investigationchk').is(':checked')+'"><input name="preliminary_exout" value="'+$('#preliminary_ex').is(':checked')+'"><input name="vsisonreadingsout" value="'+$('#vsisonreadings').is(':checked')+'"><input name="curspecout" value="'+$('#curspec').is(':checked')+'"><input name="objectchkout" value="'+$('#objectchk').is(':checked')+'"><input name="arkkchkout" value="'+$('#arkkchk').is(':checked')+'"><input name="manchkout" value="'+$('#manchk').is(':checked')+'"><input name="specchkout" checked><input name="conlchkout" value="'+$('#conlchk').is(':checked')+'"><input name="pmtchkout" value="'+$('#pmtchk').is(':checked')+'"><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();

}

function serachopticaladvice()
{
    opticaladvice();
}
function opticaladvice()  //get customer details
{
    $('#opticaladvicepat').html('');
   
         upurl="Counter_sales/getopticaladvice";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data:{csrf_test_name:$("#csrf_test_name").val(),opticaladvice_date1:$("#opticaladvice_date1").val(),opticaladvice_date2:$("#opticaladvice_date2").val()},
            success: function(data){
                $("#overlay").fadeOut(300);

               if(data.msg != ''){
                    $('#opticaladvicepat').html(data.msg);
                  
                    $('#opadv').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
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

<?php if($host_tvm=='arul'){ ?>
   
  
    $('#gstcus option[value=2]').attr('selected','selected');
    <?php } ?>

    function loadautocomplete_barcode(barcode,event)
{
     if(event!=undefined)
     {
         if(event.keyCode == 13) {
          event.preventDefault();
          //return false;
        }
        
      
       var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode != '13'){
           
            return; 
        }
     }
    
    
   
        $.ajax({
            url:'Counter_sales/Counter_sales_search_stock_by_barcode',
            type:'post',
            dataType:'json',
            data:{barcode:barcode,csrf_test_name:$('#csrf_test_name').val()},
            success:function(response){
                loadautocomplete_barcode_ajax(response.getdata,barcode);
            }
        });
}
function loadautocomplete_framemodel(framemodel,event)
{
     if(event!=undefined)
     {
         if(event.keyCode == 13) {
          event.preventDefault();
          //return false;
        }
        
      
       var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode != '13'){
           
            return; 
        }
     }
    
    
   
        $.ajax({
            url:'Counter_sales/Counter_sales_search_stock_by_framemodel',
            type:'post',
            dataType:'json',
            data:{framemodel:framemodel,csrf_test_name:$('#csrf_test_name').val()},
            success:function(response){
                loadautocomplete_framemodel_ajax(response.getdata,framemodel);
            }
        });
}

function loadautocomplete_barcode_ajax(product,barcode)
{
    //alert(product);
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
         $('#lens_section').hide();
            product_result=[];
        $.ajax({
            url:'Counter_sales/Counter_sales_search_stock_barcode',
            type:'post',
            dataType:'json',
            data:{product:product,barcode:barcode,csrf_test_name:$('#csrf_test_name').val()},
            success:function(data){
                $('#sugession').html('');
                  if(data.msg != ''){
                product_result=data.getdata;
                data.getdata.forEach(function(item,index){
                    var name=item['name'];
                    var mrp=item['mrp'];
                    var selling_price=item['selling_price'];
                    var stock=item['quantity'];
                    var frame_type=item['frametype'];
                    var frame_color=item['framecolor'];
                    var frame_model=item['framemodel'];
                    var frame_size=item['framesize'];
                                                             
                    var html='<tr ondblclick="addProduct('+index+')" onclick="setActive($(this))" onkeydown="changeActive($(this),event)" tabindex="'+index+'"><td style="color: #6f42c1;font-weight: 600;">'+name+'</td><td>'+frame_type+'</td><td>'+frame_color+'</td><td>'+frame_model+'</td><td>'+frame_size+'</td><td>'+mrp+'</td><td>'+selling_price+'</td><td>'+stock+'</td></tr>';
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
function loadautocomplete_framemodeddl(product,framemodel)
{
    //alert(product);
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
         $('#lens_section').hide();
            product_result=[];
        $.ajax({
            url:'Counter_sales/Counter_sales_search_stock_framemodel',
            type:'post',
            dataType:'json',
            data:{product:product,framemodel:framemodel,csrf_test_name:$('#csrf_test_name').val()},
            success:function(data){
                $('#sugession').html('');
                  if(data.msg != ''){
                product_result=data.getdata;
                data.getdata.forEach(function(item,index){
                    var name=item['name'];
                    var mrp=item['mrp'];
                    var selling_price=item['selling_price'];
                    var stock=item['quantity'];
                    var frame_type=item['frametype'];
                    var frame_color=item['framecolor'];
                    var frame_model=item['framemodel'];
                    var frame_size=item['framesize'];
                                                             
                    var html='<tr ondblclick="addProduct('+index+')" onclick="setActive($(this))" onkeydown="changeActive($(this),event)" tabindex="'+index+'"><td style="color: #6f42c1;font-weight: 600;">'+name+'</td><td>'+frame_type+'</td><td>'+frame_color+'</td><td>'+frame_model+'</td><td>'+frame_size+'</td><td>'+mrp+'</td><td>'+selling_price+'</td><td>'+stock+'</td></tr>';
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
function loadautocomplete_framemodel_ajax(product,framemodel)
{
    //alert(product);
     $('#sugession').empty();
    if(product.length<3)
    {
        $('#sugession').parent().hide();
        return;
    }
    clearTimeout(timer);
    timer = setTimeout(function() {
       
       if($('#category_id').val()==1)
      {
        <?php
       
         if($host_tvm=='aby')
        { ?>
        if($('#supplier_id').val()=='')
        {
            Swal.fire({title:"Info!",text:"Please Select Supplier",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
            return false;
        }
    <?php } ?>
          $('#sugession').parent().show();
          $('#frame_section').hide();
          $('#lens_section').show();
            product_result=[];
       $.ajax({
            url:'Counter_sales/Counter_sales_search_lens',
            type:'post',
            dataType:'json',
            data:{product:product,supplier_id:$('#supplier_id').val(),csrf_test_name:$('#csrf_test_name').val()},
            success:function(data){
                $('#sugession').html('');
                 if(data.msg != ''){
                product_result=data.getdata;
                data.getdata.forEach(function(item,index){
                    var name=item['name'];
                    var purchase_amount=item['purchase_amount'];
                    var lens_type=item['lens_type'];
                    var lens_coating=item['lens_coating'];
                   
                                                             
                    var html='<tr ondblclick="addlensProduct('+index+')" onclick="setActive($(this))" onkeydown="changeActive($(this),event)" tabindex="'+index+'"><td style="color: #6f42c1;font-weight: 600;">'+name+'</td><td>'+lens_type+'</td><td>'+lens_coating+'</td><td>'+purchase_amount+'</td></tr>';
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
      else
      {
        
         $('#sugession').parent().show();
         $('#frame_section').show();
         $('#lens_section').hide();
            product_result=[];
        $.ajax({
            url:'Counter_sales/Counter_sales_search_stock_framemodel',
            type:'post',
            dataType:'json',
            data:{product:product,framemodel:framemodel,csrf_test_name:$('#csrf_test_name').val()},
            success:function(data){
                $('#sugession').html('');
                  if(data.msg != ''){
                product_result=data.getdata;
                data.getdata.forEach(function(item,index){
                    var name=item['name'];
                    var mrp=item['mrp'];
                    var selling_price=item['selling_price'];
                    var stock=item['quantity'];
                    var frame_type=item['frametype'];
                    var frame_color=item['framecolor'];
                    var frame_model=item['framemodel'];
                    var frame_size=item['framesize'];
                                                             
                    var html='<tr ondblclick="addProduct('+index+')" onclick="setActive($(this))" onkeydown="changeActive($(this),event)" tabindex="'+index+'"><td style="color: #6f42c1;font-weight: 600;">'+name+'</td><td>'+frame_type+'</td><td>'+frame_color+'</td><td>'+frame_model+'</td><td>'+frame_size+'</td><td>'+mrp+'</td><td>'+selling_price+'</td><td>'+stock+'</td></tr>';
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
      }, timeout);
}
</script>

          