<?php 
$path=base_url('template1/modern-admin/');
?>      
 <div class="content-body">
             <!-- Justified With Top Border start -->
                 <section id="basic-tabs-components">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Customers</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Add Customers</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">View/Edit/Delete</a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                               <form id="customer" action="#" method="post"> 
                                <input type="hidden" name="csrf_test_name" id="csrf_test_name" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">Customer Code: <span class="text-danger">*</span></label>
                                           <input type="text" readonly name="code" id="code" class="form-control" placeholder="Customer Code" value="<?php print $codeno; ?>">
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
                                            <label for="firstname">Customer Mobile: <span class="text-danger">*</span></label>
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
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">GST:</label>
                                           <select class="form-control" name="gst" id="gst">
                                               <option value="1">Yes</option>
                                               <option value="2">No</option>
                                              
                                           </select>
                                        </div>
                                    </div>
                                </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group mt-1">
                                        <label for="switcheryColor2" class="card-title ml-1">De-Active</label>
                                          <input type="checkbox" value="1" id="switcheryColor2" class="switchery" name="status" data-color="info" checked />
                                          <label for="switcheryColor2" class="card-title ml-1">Active</label>
                                        </div>
                                    </div>
                                </div>
                               <div class="card-footer ml-auto">
                                    <button type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savecustomer();">Submit</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onclick="this.form.reset();">Reset</button>
                                </div>
                            </form>
                                            </div>
                                            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                                 <div class="card-body collapse show">
                                                    <form id="edit_customer" action="#" method="post"> 
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
                                            <input type="hidden" name="edit_customerid" id="edit_customerid">
                                           <input type="hidden" name="csrf_test_name" id="csrf_test_name1" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                           <input type="text" readonly name="edit_code" id="edit_code" class="form-control" placeholder="Customer Code">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Customer Name: <span class="text-danger">*</span></label>
                                           <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Customer Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Gender: <span class="text-danger">*</span></label>
                                           <select class="form-control" name="edit_gender" id="edit_gender">
                                               <option value="1">Male</option>
                                               <option value="2">Female</option>
                                               <option value="3">Transgender</option>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Customer Mobile: <span class="text-danger">*</span></label>
                                           <input type="text" name="edit_mobile" id="edit_mobile" class="form-control" placeholder="Customer Mobile">
                                        </div>
                                    </div>
                                   
                                </div>
                                  <div class="row">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Customer Alternate Mobile:</label>
                                           <input type="text" name="edit_customer_alter_mobile" id="edit_customer_alter_mobile" class="form-control" placeholder="Customer Alternate Mobile">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Customer Email ID: </label>
                                           <input type="text" name="edit_email_id" id="edit_email_id" class="form-control" placeholder="Customer Email ID">
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname">Customer MRD NO: <span class="text-danger">*</span></label>
                                           <input type="text" name="edit_mrd" id="edit_mrd" class="form-control" placeholder="Customer MRD NO">
                                        </div>
                                    </div>
                                   
                                
                                   
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Address:</label>
                                            <textarea cols="3" rows="3" id="edit_address" name="edit_address" class="form-control" placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symptoms">Description:</label>
                                            <textarea cols="3" rows="3" id="edit_description" name="edit_description" class="form-control" placeholder="Description"></textarea>
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
                                                        <td style="padding:10px;"><input type="text" name="edit_resph1" id="edit_resph1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_recyl1" id="edit_recyl1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reaxis1" id="edit_reaxis1" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reva1" id="edit_reva1" class="form-control"></td>
                                                    </tr>
                                                     <tr>
                                                        <td style="background: #1e9ff24f;" class="tab_tit">N.V</td>
                                                        <td style="padding:10px;"><input type="text" name="edit_resph2" id="edit_resph2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_recyl2" id="edit_recyl2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reaxis2" id="edit_reaxis2" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reva2" id="edit_reva2" class="form-control"></td>
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
                                                        <td style="padding:10px;"><input type="text" name="edit_resph3" id="edit_resph3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_recyl3" id="edit_recyl3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reaxis3" id="edit_reaxis3" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reva3" id="edit_reva3" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:10px;"><input type="text" name="edit_resph4" id="edit_resph4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_recyl4" id="edit_recyl4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reaxis4" id="edit_reaxis4" class="form-control"></td>
                                                        <td style="padding:10px;"><input type="text" name="edit_reva4" id="edit_reva4" class="form-control"></td>
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
                                           <input type="text" name="edit_material" id="edit_material" class="form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">CR: </label>
                                           <input type="text" name="edit_cr" id="edit_cr" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Usage:</label>
                                           <input type="text" name="edit_usage" id="edit_usage" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Type:</label>
                                           <input type="text" name="edit_type" id="edit_type" class="form-control" >
                                        </div>
                                    </div>
                                   
                                </div>
                                    <div class="row">
                                    <div class="col-md-2">
                                         <div class="form-group">
                                            <label for="firstname">IPD:</label>
                                           <input type="text" name="edit_ipd" id="edit_ipd" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">PD RE: </label>
                                           <input type="text" name="edit_pdre" id="edit_pdre" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">LE:</label>
                                           <input type="text" name="edit_le" id="edit_le" class="form-control" >
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">Segment RE:</label>
                                           <input type="text" name="edit_segment" id="edit_segment" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="firstname">LE:</label>
                                           <input type="text" name="edit_lle" id="edit_lle" class="form-control">
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">Type:</label>
                                           <select class="form-control" name="edit_prestype" id="edit_prestype">
                                               <option value="1">Undilatated</option>
                                               <option value="2">Cycloplegic</option>
                                               <option value="3">PMT</option>
                                               <option value="4">Final prescription</option>
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="firstname">GST:</label>
                                           <select class="form-control" name="gst" id="edit_gst">
                                               <option value="1">Yes</option>
                                               <option value="2">No</option>
                                              
                                           </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                         <div class="form-group">
                                             <label for="lastname">Status: </label>
                                         <select class="form-control" name="edit_status" id="edit_status">
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
                <button id="save" class="btn btn-primary btn-sm" type="button" onclick="updatecustomer();"><i class="fas fa-plus-square"></i>Update</button>

                    <button type="button" id="mclose" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
                                                <div class="table-responsive">
                                           <table id="tableid" class="table table-striped table-bordered opticaltable-list" style="width: 100%;">
                                                        <thead>
                                                          <tr>
                                                            <th>Sl No</th>
                                                            <th>Code</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Status</th>
                                                            <th>Print</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                         <tfoot>
                                                            <tr>
                                                                <th>Sl No</th>
                                                                <th>Code</th>
                                                                <th>Name</th>
                                                                <th>Mobile</th>
                                                                <th>Status</th>
                                                                <th>Print</th>
                                                                <th>Edit</th>
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
            <style type="text/css">
                .tab_tit
                {
                    font-weight: bold;
                }
                @media (min-width: 992px){
                .modal-lg, .modal-xl {
                    max-width: 909px;
                }
                }
            </style>
             <script type="text/javascript">
          function printcustomer(customer_id){
        $('<form target="_blank" method="post" action="<?php echo base_url('master/Customers/printcustomer'); ?>"><input name="data_generatebill" value="'+customer_id+'"/><input name="csrf_test_name" value="'+$('#csrf_test_name').val()+'"></form>').appendTo('body').submit().remove();
    }  
 var table;
$( document ).ready(function() {
   table= $('#tableid').DataTable( {
          'processing': true,
          'serverSide': true,
          'ajax':'<?=base_url()?>master/Customers/ajax_call',
          'columns': [
             { data: 'slno' },
             { data: 'code' },
             { data: 'name' },
             { data: 'mobile' },
             { data: 'status' },
             { data: 'print' },
             { data: 'edit' },
             { data: 'delete' }
                     ],
                      buttons: [
                        {
                           extend: 'excelHtml5',
                            exportOptions: {
                                columns: [ 0, 1, 2,3 ]
                            }
                        }

                       ],
                   dom: 'Blfrtip',
        "lengthMenu": [[5,10,25, 50, 100, 1000, 10000], [5,10,25, 50, 100, 1000, 10000]]

     } );
}); 
          </script>

          