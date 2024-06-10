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
option:nth-child(n+11) {
  display: none;
}

</style>
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Sales</h4>
                                    <div id="edit_data"></div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true"><l id="tab_tit">Add Sales Entry<l></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                             <li class="nav-item">
                                                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Status</a>
                                            </li> 
											<li class="nav-item">
                                                <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Emergency Order</a>
                                            </li>
                                        </ul>
            <form id="orderform_form" action="#" method="post"> 
        <div id="orderform_form_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="div_modal">
                             <div class="row" id="or_print">
                               
                             </div>
                             
                              
                                <div class="row">
                                    
                                    <div class="table-responsive" style="padding: 15px;margin-top: -18px;">
                                    <table class="table table-bordered" style="font-weight: bold;">
                                        <tr>
                                            <input type="hidden" name="of_customerid" id="of_customerid" class="form-control">
                                             <input type="hidden" name="of_salesid" id="of_salesid" class="form-control">
                                            <td align="center" class="tab_tit"><i class="la la-check"></i> RIGHT EYE (OD)</td>
                                            <td align="center" class="tab_tit"><i class="la la-check"></i> LEFT EYE (OS)</td>
                                             <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px;">
                                                <table class="">
                                                    <tr >
                                                        <td ></td>
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">PD</td>
                                                        <td class="tab_tit">VA</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="tab_tit" >D.V</td>
                                                        <td style="padding:10px;"><input type="text" name="of_resph1" id="of_resph1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_recyl1" id="of_recyl1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reaxis1" id="of_reaxis1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_pd1" id="of_pd1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reva1" id="of_reva1" class="form-control"></td>
                                                    </tr>
                                                     <tr>
                                                        <td  class="tab_tit">N.V</td>
                                                        <td style="padding:10px;"><input type="text" name="of_resph2" id="of_resph2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_recyl2" id="of_recyl2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reaxis2" id="of_reaxis2" class="form-control"></td>
                                                         <td style="padding:10px;"><input type="text" name="of_pd2" id="of_pd2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reva2" id="of_reva2" class="form-control"></td>
                                                    </tr>
                                                      <tr>
                                                        <td  class="tab_tit">ADD</td>
                                                        <td style="padding:10px;" colspan="5"><input type="text" name="of_add_ryt" id="of_add_ryt" class="form-control"></td>
                                                       
                                                    </tr>

                                                </table>
                                            </td>
                                            <td style="padding: 0px;">
                                                <table class="">
                                                    <tr style="padding: 0px;">
                                                        <td class="tab_tit">SPH</td>
                                                        <td class="tab_tit">CYL</td>
                                                        <td class="tab_tit">AXIS</td>
                                                        <td class="tab_tit">PD</td>
                                                        <td class="tab_tit">VA</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:10px;"><input type="text" name="of_resph3" id="of_resph3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_recyl3" id="of_recyl3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reaxis3" id="of_reaxis3" class="form-control"></td>
                                                         <td style="padding:10px;"><input type="text" name="of_pd3" id="of_pd3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reva3" id="of_reva3" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:10px;"><input type="text" name="of_resph4" id="of_resph4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_recyl4" id="of_recyl4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reaxis4" id="of_reaxis4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_pd4" id="of_pd4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="of_reva4" id="of_reva4" class="form-control"></td>
                                                    </tr>
                                                     <tr>
                                                        
                                                        <td style="padding:10px;" colspan="6"><input type="text" name="of_add_lft" id="of_add_lft" class="form-control"></td>
                                                       
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
                                            <label for="firstname">IOP (Left):</label>
                                           <input type="text" name="of_iopleft" id="of_iopleft" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">IOP (Right): </label>
                                           <input type="text" name="iop_right" id="iop_right" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Dominant Eye:</label>
                                           <select class="form-control" name="of_dominateye" id="of_dominateye">
                                               <option value="">Select</option>
                                               <option value="1">Right</option>
                                                <option value="2">Left</option>
                                                <option value="3">Both</option>
                                           </select>
                                        </div>
                                    </div>
                                  
                                   
                                </div>
                              
                                   
                                 
                                  
                               
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button id="savecus" class="btn btn-primary btn-sm" type="button" onclick="saveorderform();"><i class="fas fa-plus-square"></i>Save</button>

                    <button type="button" id="mclose" class="btn btn-danger btn-sm stmlns" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form> 

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

                    <button type="button" id="mclose" class="btn btn-danger btn-sm stmlns" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>       
		<form id="secend_advance_form" action="#" method="post"> 
        <div id="secend_advance_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> 2 nd Advaance</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="div_modal">
                              <div class="row">
									<div class="col-md-3">
                                        <div class="form-group">
											<input type="hidden" name="sec_ad_sales_id" id="sec_ad_sales_id">
											<input type="hidden" name="sec_ad_customer_id" id="sec_ad_customer_id">
											<input type="hidden" name="sec_ad_status" id="sec_ad_status">
											<input type="hidden" name="sec_ad_olddisamt" id="sec_ad_olddisamt">
											<input type="hidden" name="sec_ad_olddisper" id="sec_ad_olddisper">
											<input type="hidden" name="sec_ad_total_qty" id="sec_ad_total_qty">
											<input type="hidden" name="get_balance_amount" id="get_balance_amount">
											<input type="hidden" name="sec_ad_disamt" id="sec_ad_disamt" value="">
											<input type="hidden" name="sec_ad_disper" id="sec_ad_disper" value="">
											<input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                           
											<label for="lastname">Tot Amnt:</label>
                                           <input type="hidden" name="net_amount" id="net_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 25px;background: gold;">
                                            <input type="text" name="sec_ad_total_amount" id="sec_ad_total_amount" class="form-control" readonly="" style="text-align:right;font-weight:600;font-size: 25px;background: gold;">
                                        </div>
                                    </div>
                                   <div class="col-md-3">
                                        <div class="form-group">
                                             <label for="lastname">Already Paid Amount: <span class="text-danger">*</span></label>
                                           <input type="text" name="get_advanced_amount" class="form-control" id="get_advanced_amount" value="" readonly>
                                        </div>
                                    </div>
									<div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname"> 2 nd Advaance Amount: </label>
                                            <input type="text" name="sec_ad_payid_amount" class="form-control" id="sec_ad_payid_amount" onkeyup="sec_ad_balance_calculate($(this).val())" onkeydown="sec_ad_balance_calculate($(this).val())">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Balance Amount: <span class="text-danger">*</span></label>
                                           <input type="text" name="sec_ad_balance_amount" class="form-control" id="sec_ad_balance_amount" value="" readonly>
                                        </div>
                                    </div>
                                   
                                </div>
                               
                                 <div class="row">
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="sec_ad_modeofpay_id" id="sec_ad_modeofpay_id">
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
                                     
                                    
                                 </div>
                          </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button class="btn btn-primary btn-sm" type="button" onclick="add_sec_advance();"><i class="fas fa-plus-square"></i>Save</button>
				<button type="button" id="mclose" class="btn btn-danger btn-sm stmlns" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	</form>
		<form id="send_to_fit_form" action="#" method="post"> 
        <div id="send_to_fit_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send To Fitting</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="div_modal">
                              <div class="row">
									<div class="col-md-6">
                                        <div class="form-group">
											<input type="hidden" name="stt_sales_id" id="stt_sales_id">
											<input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
											<label for="lastname"> Date: </label>
                                            <input type="text" name="stt_date" class="form-control" id="stt_date" readonly>
                                         </div>
                                    </div>
                                  
									<div class="col-md-6">
                                        <div class="form-group">
                                           <label for="lastname">Supplier Name: <span class="text-danger">*</span></label>
											<select class="form-control" name="stt_supplier_id" id="stt_supplier_id">
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
                                   
                                </div>
                               
								<div class="row">
									<div class="col-md-12">
                                        <div class="form-group">
											<label for="symptoms">Remarks:</label>
											<textarea cols="2" rows="2" id="stt_remarks" name="stt_remarks" class="form-control" placeholder="Remarks"></textarea>
										</div>
									</div>
								</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button class="btn btn-primary btn-sm" type="button" onclick="add_send_to_fitt();"><i class="fas fa-plus-square"></i>Save</button>
				<button type="button" id="mclose" class="btn btn-danger btn-sm stmlns" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
			
		
                                <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                               <form id="savesales_form" action="#" method="post"> 
                                                 <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="edit_sales_id" id="edit_sales_id">
                                            <label for="lastname">Customer Name: <span class="text-danger">*</span><button type="button" class="btn btn-success btn-sm" onclick="addnewcus();">Add New cus</button><button type="button" onclick="showdescription();" class="btn btn-danger btn-sm">Show Det</button></label>
                                            <select class="form-control select2" name="customer_id" id="customer_id" onchange="loadcustomerdetails($(this).val());">
                                                <option value="0">Select Customer Name</option>
                                                <!-- <?php
                                                    if($getcustomer)
                                                    {
                                                        foreach ($getcustomer as $data) {
                                                            ?>
                                                                <option value="<?php print $data['customer_id']; ?>"><?php print $data['name']; ?>  <?php print $data['mobile']; ?> <?php print $data['mrd']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                 ?> -->
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
                                            <input type="date" name="sales_date" id="sales_date" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="lastname">Time: <span class="text-danger">*</span><span style="cursor:pointer;" class="notification-tag badge badge-danger float-right m-0" onclick="createlens();">Create Lens</span></label>
                                            <input type="time" name="sales_time" id="sales_time" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Category: <span class="text-danger">*</span></label>
											
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="Category" id="withcat" value="withcat">
												<label class="form-check-label" for="withcat">With Cat</label>
											</div>
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="Category" id="withoutcat" value="withoutcat">
											  <label class="form-check-label" for="withoutcat">Without Cat
											  &nbsp;&nbsp;&nbsp;&nbsp;
											<span id="additem"></span>
											  </label>
											</div>
									
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
                                     <div class="col-md-3">
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
							<div id="CagegoryTypeDiv"></div>
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
																		<th>Qty</th>
																		<th> Amount</th>
																		<th>Status</th>
                                                                        <th><abbr title="Order Form">OF</abbr></th>
																		<th><abbr title="2nd Advance">2nd ADV</abbr></th>
																		<th>Send</th>
																		<th>Ready</th>
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
																			<th>Qty</th>
																			<th>Amount</th>
																			<th>Status</th>
                                                                            <th><abbr title="Order Form">OF</abbr></th>
																			<th><abbr title="2nd Advance">2nd ADV</abbr></th>
																			<th>Send</th>
																			<th>Ready</th>
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
                                                               <option value="4">Send To Fitting</option>
                                                           </select>
                                                       </div>
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                               <label>Customer Name or mobile no or Invoice No<span class="text-danger">*</span></label>
                                                              <select class="form-control select2" name="status_customer" id="status_customer">
                                                                   <option value="0">Select Customer Name</option>
                                                                <?php
                                                                    if($getcustomersales)
                                                                    {
                                                                        foreach ($getcustomersales as $data) {
                                                                            ?>
                                                                    <option value="<?php print $data['sales_id']; ?>"><?php print $data['name']; ?>-<?php print $data['mrd']; ?>-<?php print $data['mobile']; ?>-<?php print $data['invoice_number']; ?></option>
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
											 <div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
                                                <div class="card-body collapse show">
                                                <div class="table-responsive">
													<table id="emorder_table" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                       <thead>
														  <tr>
															<th>Sl No</th>
															<th>Bill No</th>
															<th>Customer Name</th>
															<th>Date</th>
															<th>Total Qty</th>
															<th>Total Amount</th>
															<th>Status</th>
															<th>2nd Advance</th>
															<th>Send</th>
															<th>Ready</th>
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
																<th>Status</th>
																<th>2nd Advance</th>
																<th>Send</th>
																<th>Ready</th>
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
          'ajax':'<?=base_url()?>transaction/Sales/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'invoice_number' },
             { data: 'name' },
             { data: 'sales_date' },
             { data: 'total_qty' },
             { data: 'netamount' },
             { data: 'statuss' },
             { data: 'of' },
             { data: 'advance' },
             { data: 'stf' },
             { data: 'ready' },
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
	 
   table= $('#emorder_table').DataTable( {
		  'bDestroy': true,
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>transaction/Sales/emorder',
          'columns': [
               { data: 'slno' },
             { data: 'invoice_number' },
             { data: 'name' },
             { data: 'sales_date' },
             { data: 'total_qty' },
             { data: 'netamount' },
             { data: 'statuss' },
             { data: 'advance' },
             { data: 'stf' },
             { data: 'ready' },
             { data: 'print' },
             { data: 'edit' },
             { data: 'delete' }
                     ],
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
	 $('#sales_date').val(cd);
     $('#edate').val(cd);
     $('#opticaladvice_date1').val(cd);
     $('#opticaladvice_date2').val(cd);

    timee="<?php Echo date('H:i'); ?>";
    $('#sales_time').val(timee);

    <?php if($host_tvm=='testopt' || $host_tvm=='dehoptical'){ ?>   
        opticaladvice();
        <?php } ?>
		

	$("#customer_id").select2({
		
                ajax: {
                    url: "Sales/serchcustomer",
                    dataType: 'json',
					type: "POST",
					delay: 250,
					data: function (params) {
                        return {
                            searchTerm: params.term, // search term
							csrf_test_name:$("#csrf_test_name").val()
							
                        };
                    },
				  processResults: function (response) {
                        return {
                            results: response
                        };
                    },
					
                    cache: true
                }
            });

});

      function printsale(sales_id){
        $('<form target="_blank" method="post" action="<?php echo base_url('transaction/Sales/print_sales'); ?>"><input name="data_generatebill" value="'+sales_id+'"/><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();

    }
    function payamount()
{
     if($('#sales_idcus').val()=='') {
           Swal.fire({title:"Info!",text:"Sales ID Not Found !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
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
                        
       
         upurl="Sales/payamount";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
             data: {sales_id:$('#sales_idcus').val() ,customer_id:$('#customer_idcus').val(),netamount:$('#netamount_idcus').val(),cash_bill:$('#cash_bill').val(),card_bill:$('#card_bill').val(),paytm_bill:$('#paytm_bill').val(),payamount:$('#pay').val(),status:$('#status_cus').val(),pay_mode:$('#pay_mode').val(),olddisamt:$('#olddisamt').val(),olddisper:$('#olddisper').val(),disper:$('#disper').val(),disamt:$('#disamt').val(),csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               printsale(data.sales_id);
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
     function updatesalesentry()
{ 
        if($("#edit_sales_id").val()=='' || $("#customer_id").val()=='' || $("#sales_date").val()=='' || $("#sales_time").val()=='' || $("#total_qty").val()=='' || $("#bill_status").val()==''|| $("#modeofpay_id").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
       
         upurl="Sales/editsalesentry";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
            data: $('#savesales_form').serialize(),
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
        getdata='Sales/getcustomerdata';
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
					 $('#pay_mode').html();
					 
				if($('#pay_mode').val()!='12') {
					
					$('#mpayment').hide();  
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

function editsales(val)
{
        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Sales/getsavedata';
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
                  $('#tab_tit').html('Edit Sales Entry');
				  $('#staff_id').val(data.getmasterdata[0]['staff_id']);
                  $('#sales_date').val(data.getmasterdata[0]['sales_date']);
                  $('#sales_time').val(data.getmasterdata[0]['sales_time']);
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
                 // $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']);
                  $('#modeofpay_id').val(data.getmasterdata[0]['modeofpay_id']).trigger('change');
                  $('#invoice_amount').val(data.getmasterdata[0]['netamount']);
                  $('#bill_status').val(data.getmasterdata[0]['status']);
                  $('#sdescription').val(data.getmasterdata[0]['description']);
                  $('#cash_billing').val(data.getmasterdata[0]['cash']);
                  $('#card_billing').val(data.getmasterdata[0]['card']);
                  $('#paytm_billing').val(data.getmasterdata[0]['paytm']);
                  $('#others_billing').val(data.getmasterdata[0]['others']);
                  $('#emergency_order').val(data.getmasterdata[0]['emergency_order']);
                  $('#credit_name').val(data.getmasterdata[0]['credit_name']);
                  $('#edate').val(data.getmasterdata[0]['expected_del_date']);
                  $('#productdetails').children('tbody').html(data.getchilddata);
                  $('#edit_sales_id').val(data.getmasterdata[0]['sales_id']);
				  $("#customer_id").html("<option value='"+data.getresult[0]['customer_id']+"'>"+data.getresult[0]['name']+" "+data.getresult[0]['mobile']+" "+data.getresult[0]['mrd']+"</option>"); 
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
function savesalesentry()
    {    
/* 	$siva=$("#credit_name").val();
	  $('#sdescription').html($siva); */
        if($("#customer_id").val()=='' || $("#sales_date").val()=='' || $("#sales_time").val()=='' || $("#total_qty").val()=='' || $("#bill_status").val()==''|| $("#modeofpay_id").val()=='' ) {
           Swal.fire({title:"Info!",text:"Please Enter  All Mandatory fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        saveurl="Sales/savesalesentry";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#savesales_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
                 printsale(data.sales_id);
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
     function add_sec_advance()
{    
        if($("#add_sec_advance").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
		upurl="Sales/sec_ad_payamount";
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
             data: {sales_id:$('#sec_ad_sales_id').val() ,customer_id:$('#sec_ad_customer_id').val(),netamount:$('#sec_ad_total_amount').val(),cash_bill:$('#cash_billing').val(),card_bill:$('#card_billing').val(),paytm_bill:$('#paytm_billing').val(),payamount:$('#sec_ad_payid_amount').val(),status:$('#sec_ad_status').val(),pay_mode:$('#sec_ad_modeofpay_id').val(),olddisamt:$('#sec_ad_olddisamt').val(),olddisper:$('#sec_ad_olddisper').val(),disper:$('#sec_ad_disper').val(),disamt:$('#sec_ad_disamt').val(),csrf_test_name:$('#csrf_test_name').val()},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
               printsale(data.sales_id);
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
function createlens()
{
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>master/Lens/createsaleslens',
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
function secend_advance(val)
{

        if(val=='') {
           Swal.fire({title:"Info!",text:"Edit ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Sales/getcustomerdata_sec_ad';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: {getid: val,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
				
				 $("#secend_advance_form")[0].reset();
                $('#secend_advance_modal').modal('show');
				$('#sec_ad_sales_id').val(data.customerdata[0]['sales_id']);
				$('#sec_ad_customer_id').val(data.customerdata[0]['customer_id']);
				$('#sec_ad_status').val(data.customerdata[0]['status']);
				$('#sec_ad_olddisamt').val(data.customerdata[0]['discount_amount']);
				$('#sec_ad_olddisper').val(data.customerdata[0]['discount_percentage']);
				$('#sec_ad_total_qty').val(data.customerdata[0]['total_qty']);
				$('#sec_ad_total_amount').val(data.customerdata[0]['netamount']);
				$('#get_balance_amount').val(Math.abs(data.paid_pay1['advanced_amount']- data.customerdata[0]['netamount']));
				$('#get_advanced_amount').val(data.paid_pay['advanced_amount']);
                
                
               
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
function send_to_fitt(val)
{
  	 $("#send_to_fit_form")[0].reset();
	 cd = (new Date()).toISOString().split('T')[0];
	 $('#stt_date').val(cd);
     $('#send_to_fit_modal').modal('show');	
	 $('#stt_sales_id').val(val);
}
function add_send_to_fitt()
{    
       if($("#stt_date").val()=='' || $("#stt_supplier_id").val()=='') {
           Swal.fire({title:"Info!",text:"Please Enter  All fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
		
		upurl="Sales/send_to_fitt_update";
		
        $("#overlay").fadeIn(300);
         $.ajax({
            type: "POST",
            url: upurl,
            dataType: "json",
			 data: $('#send_to_fit_form').serialize(),
            // data: {sales_id:$('#stt_sales_id').val(),stt_date:$('#stt_date').val(),stt_remarks:$('#stt_remarks').val(),stt_supplier_id:$('#stt_supplier_id').val()},
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
        
        
        $('#div_modallens').modal('toggle');
$('body').removeClass('modal-open');
$('body').css('padding-right', '0px');
$('.modal-backdrop').remove();

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
             // $('.modal-backdrop').css('position', 'unset');
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
        getdata='Sales/getlastidcustomercountno';
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
 function getorderform(sales_id,cusid)
{
    
        if(cusid=='') {
           Swal.fire({title:"Info!",text:"Customer ID Not found",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='../master/Customers/getorderform_cus_data';
         $.ajax({
            type: "POST",
            url: getdata,
            dataType: "json",
            data: { sales_id: sales_id,getid: cusid,csrf_test_name:csrf},
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg == 'success')
               {
                  tit='Order Form';
                  $('#orderform_form_modal').modal('show');
                  $('.modal-title').html(tit);
                  $('#of_iopleft').val(data.getdata[0]['of_iopleft']);
                  $('#iop_right').val(data.getdata[0]['iop_right']);
                  $('#of_dominateye').val(data.getdata[0]['of_dominateye']);
                  $('#of_add_lft').val(data.getdata[0]['of_add_lft']);
                  $('#of_pd4').val(data.getdata[0]['of_pd4']);
                  $('#of_pd3').val(data.getdata[0]['of_pd3']);
                  $('#of_pd2').val(data.getdata[0]['of_pd2']);
                  $('#of_pd1').val(data.getdata[0]['of_pd1']);
                  $('#of_add_ryt').val(data.getdata[0]['of_add_ryt']);
                  $('#of_resph1').val(data.getdata[0]['resph1']);
                  $('#of_resph2').val(data.getdata[0]['resph2']);
                  $('#of_resph3').val(data.getdata[0]['resph3']);
                  $('#of_resph4').val(data.getdata[0]['resph4']);
                  $('#of_recyl1').val(data.getdata[0]['recyl1']);
                  $('#of_recyl2').val(data.getdata[0]['recyl2']);
                  $('#of_recyl3').val(data.getdata[0]['recyl3']);
                  $('#of_recyl4').val(data.getdata[0]['recyl4']);
                  $('#of_reaxis1').val(data.getdata[0]['reaxis1']);
                  $('#of_reaxis2').val(data.getdata[0]['reaxis2']);
                  $('#of_reaxis3').val(data.getdata[0]['reaxis3']);
                  $('#of_reaxis4').val(data.getdata[0]['reaxis4']);
                  $('#of_reva1').val(data.getdata[0]['reva1']);
                  $('#of_reva2').val(data.getdata[0]['reva2']);
                  $('#of_reva3').val(data.getdata[0]['reva3']);
                  $('#of_reva4').val(data.getdata[0]['reva4']);
                   $('#or_print').html(data.orderf);
                  $('#of_customerid').val(data.getdata[0]['customer_id']);
                   $('#of_salesid').val(sales_id);
                
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
     function printcustomer_orderform(customer_id){
        $('<form target="_blank" method="post" action="<?php echo base_url('transaction/Sales/printcustomer_orderform'); ?>"><input name="data_generatebill" value="'+customer_id+'"/><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();
    }  
 function saveorderform()
{   
        $("#overlay").fadeIn(300);
        saveurl="../master/Customers/orderformsave";
         $.ajax({
            type: "POST",
            url: saveurl,
            dataType: "json",
            data: $('#orderform_form').serialize(),
            success: function(data){
                $("#overlay").fadeOut(300);
               if(data.msg != ''){
               Swal.fire({title:"",text:""+data.msg+"",type:"success",confirmButtonClass:"btn btn-success",buttonsStyling:!1});
              
               // $("#orderform_form")[0].reset();
               printcustomer_orderform($('#of_salesid').val());
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
function getlastidcustomer()
{
       
        $("#overlay").fadeIn(300);
        csrf=$('#csrf_test_name').val();
        getdata='Sales/getlastidcustomer';
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
        getdata='Sales/Showcustomername';
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
            url:'Sales/sales_search_lens',
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
            url:'Sales/sales_search_stock',
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
                   <td>'+row['frametype']+'</td>\n\
                   <td>'+row['framecolor']+'</td>\n\
                   <td>'+row['framesize']+'</td>\n\
                   <td>'+row['framemodel']+'</td>\n\
                   <td></td>\n\
                   <td></td>\n\
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
            delurl="Sales/deletesalesentry";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#savesales_form').serialize()+"&id="+val,
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
            delurl="Sales/readytodelivery";
           
                   $.ajax({
            type: "POST",
            url: delurl,
            dataType: "json",
            data: $('#savesales_form').serialize()+"&id="+val,
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
  $("#sec_ad_payid_amount").val('');
 sec_ad_balance_calculate('');

    function sec_ad_balance_calculate(sec_ad_payid_amount)
 {
    if(sec_ad_payid_amount>0){
     var sec_ad_payid_amount=parseFloat(sec_ad_payid_amount);
     if(isNaN(sec_ad_payid_amount))
     {
         sec_ad_payid_amount=0;
     }
     
	 var get_balance_amount=parseFloat($('#get_balance_amount').val());
     if(isNaN(get_balance_amount))
     {
         get_balance_amount=0;
     }
     var balence_amount=parseFloat(get_balance_amount)-parseFloat(sec_ad_payid_amount);
      $('#sec_ad_balance_amount').val(balence_amount);
   }
 }
  function loadstatus(id)  //get customer details
{
    if($("#status_show").val()=='') {
           Swal.fire({title:"Info!",text:"Please choose  Status fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Sales/getstatuscon";
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
                           output += '<option value="'+item.sales_id+'">'+item.name+' - '+item.mobile+' - '+item.invoice_number+'</option>';
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
     $('#soc_db').html('');
    if($("#customer_id").val()=='') {
           Swal.fire({title:"Info!",text:"Please choose  Customer fields !",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1})
           return false;
        }
         upurl="Sales/getcustomer";
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
               if(data.source)
               {
                  $('#soc_db').html(data.source);
               }
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
    
   $('<form target="_blank"  method="post" action="<?php echo base_url(); ?>/transaction/Sales/examinationprint"><input name="examinationid" value="'+examinationid+'"/><input name="chkcomplaintsout" value="'+$('#chkcomplaints').is(':checked')+'"><input name="chkopthalmicsout" value="'+$('#chkophthalmic').is(':checked')+'"><input name="chkmedicalout" value="'+$('#chkmedical').is(':checked')+'"><input name="chkeyepartout" value="'+$('#chkeyepart').is(':checked')+'"><input name="addmedicinessout" value="'+$('#addmediciness').is(':checked')+'"><input name="investigationchkout" value="'+$('#investigationchk').is(':checked')+'"><input name="preliminary_exout" value="'+$('#preliminary_ex').is(':checked')+'"><input name="vsisonreadingsout" value="'+$('#vsisonreadings').is(':checked')+'"><input name="curspecout" value="'+$('#curspec').is(':checked')+'"><input name="objectchkout" value="'+$('#objectchk').is(':checked')+'"><input name="arkkchkout" value="'+$('#arkkchk').is(':checked')+'"><input name="manchkout" value="'+$('#manchk').is(':checked')+'"><input name="specchkout" checked><input name="conlchkout" value="'+$('#conlchk').is(':checked')+'"><input name="pmtchkout" value="'+$('#pmtchk').is(':checked')+'"><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();

}

function serachopticaladvice()
{
    opticaladvice();
}
function opticaladvice()  //get customer details
{
    // $('#opticaladvicepat').html('');
   
    //      upurl="Sales/getopticaladvice";
    //     $("#overlay").fadeIn(300);
    //      $.ajax({
    //         type: "POST",
    //         url: upurl,
    //         dataType: "json",
    //         data:{csrf_test_name:$("#csrf_test_name").val(),opticaladvice_date1:$("#opticaladvice_date1").val(),opticaladvice_date2:$("#opticaladvice_date2").val()},
    //         success: function(data){
    //             $("#overlay").fadeOut(300);

    //            if(data.msg != ''){
    //                 $('#opticaladvicepat').html(data.msg);
                  
    //                 $('#opadv').DataTable( {
    //                 dom: 'Bfrtip',
    //                 buttons: [
    //                     'excelHtml5',
    //                     'pdfHtml5'
    //                 ]
    //             } );
    //           } else if(data.error != ''){
    //            // Swal.fire({title:"Warning!",text:""+data.error+"",type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
    //           } else if(data.error_message) 
    //           {
    //             // var error = data.error_message;
    //             // var err_str = '';
    //             // for (var key in error) {
    //             //   err_str += error[key] +'\n';
    //             // }
    //             // Swal.fire({title:"Info!",text:""+err_str+"",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
    //           }
                
    //         },
    //         error: function (error) {
    //             //Swal.fire({title:"Info!",text:"Network Busy",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
    //             $("#overlay").fadeOut(300);  
    //         }
    //     }); 
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
            url:'Sales/sales_search_stock_by_barcode',
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
            url:'Sales/sales_search_stock_by_framemodel',
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
            url:'Sales/sales_search_stock_barcode',
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
            url:'Sales/sales_search_stock_framemodel',
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
            url:'Sales/sales_search_lens',
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
            url:'Sales/sales_search_stock_framemodel',
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
    function changeeditVat(vat)
	{
		var conceptName = $('#pay_mode').find(":selected").text();
		
		if(conceptName=='M PAYMENT')
		{
		  $('#mpayment').show();
		  /* $('#edit_cgst').val('');
		  $('#edit_sgst').val('');
		  $('#edit_tax').val(''); */
		}else{
		  $('#mpayment').hide();  
		}
	}
	function myFunction(vat){
		var conceptName = $('#pay_mode').find(":selected").text();
		
		if(conceptName=='M PAYMENT')
		{
		  $('#mpayment').show();
		  /* $('#edit_cgst').val('');
		  $('#edit_sgst').val('');
		  $('#edit_tax').val(''); */
		}else{
		  $('#mpayment').hide();  
		}
	}
	
	$('input[type=radio][name=Category]').change(function() {
		
		 $.ajax({
            url:'Sales/catTypeload',
            type:'post',
            data:{cattype:this.value},
			success:function(data){
			$('#CagegoryTypeDiv').empty(); 
			$('#CagegoryTypeDiv').append(data); 
	 }
	 }); 
    
});
$( "#category_id" ).on( "change", function() {
    $('#additem').empty();
  var button='<span style="cursor:pointer;" class="notification-tag badge badge-danger float-right m-0"  onclick="addMasterDataRow();"> Add '+$("#category_id :selected").text()+'</span>';
  $('#additem').html(button);
} );

function addMasterDataRow(){
	if($('#category_id').find(":selected").val()==''){
		 Swal.fire({title:"Info!",text:"Please select Category Name",type:"info",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
	}else{
	var tableTrlength=$('#productdetails >tbody >tr').length;
		 $.ajax({
            url:'Sales/addMasterDataRow',
            type:'post',
            data:{trlength:tableTrlength,itemType:$("#category_id :selected").text()},
			success:function(data){
		$('#productdetails').append(data);
	 }
	 }); 
	}
	

	
}





function calcTotalAmount(index){
	var rate=$('#rate_'+index).val();
	var quantity=$('#quantity_'+index).val();
	var totalAmount=rate*quantity;
	$('#total_'+index).val(totalAmount);
	$('#netamount_'+index).val(totalAmount);
	/*var gst = $('#gst_'+index).find(":selected").val();
	if(gst==0){
		var gstadd = totalAmount+=(12/100)*totalAmount;
		//$('#total_'+index).val(gstadd);
		$('#netamount_'+index).val(gstadd);
	}else{
		var totalAmount=rate*quantity;
	//$('#total_'+index).val(totalAmount);
	$('#netamount_'+index).val(totalAmount);
	}
	var disc = $('#discount_'+index).find(":selected").val();
	if(disc==0){
		var discadd = totalAmount-10;
		//$('#total_'+index).val(discadd);
		$('#netamount_'+index).val(discadd);
	}else{
		var totalAmount=rate*quantity;
//	$('#total_'+index).val(totalAmount);
	$('#netamount_'+index).val(totalAmount);
	}
	
	var advan = $('#advance_'+index).val();
	alert(advan);
	var bal = $('#netamount_'+index).val() - advan;
	alert(bal);
	$('#balance_'+index).val(bal);*/
}

function gstCalc(index){
	var rate=$('#rate_'+index).val();
	var quantity=$('#quantity_'+index).val();
	var totalAmount=rate*quantity;
	var gst = $('#gst_'+index).find(":selected").val();
	if(gst==1){
		var gstAmt= totalAmount+(totalAmount*12)/100;
		$('#netamount_'+index).val(gstAmt);
	}else{
	$('#netamount_'+index).val(totalAmount);	
	}
}

function disCalc(index){
	var totalAmount=$('#total_'+index).val();
	if($('#discount_'+index).val()){
	var discAmount=$('#netamount_'+index).val()-(totalAmount*$('#discount_'+index).val())/100;
	$('#netamount_'+index).val(discAmount);	
	}else{
	var totalAmount=$('#total_'+index).val();
alert('hh');	
	}
	
	return false;
	
}

function saveData(){
	var formData=$('#savesales_form').serialize();
	var tableTrlength=$('#productdetails >tbody >tr').length;
	console.log(formData);
	 $.ajax({
            url:'Sales/saveWithOutMasterData?row='+tableTrlength,
            type:'post',
            data:formData,
			success:function(data){
		console.log(data);
		return false;
	 }
	 });
}


</script>

          