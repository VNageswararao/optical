<div class="row">
                                  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Item list: <span class="text-danger">*</span></label>
                                           <input type="text" style="background: #0abdef;" name="" class="form-control" id="pro_name" onkeyup="loadautocomplete($(this).val(),1)" onkeydown="add_focus_to_first(event)" autocomplete="off">
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Barcode: <span class="text-danger">*</span></label>
                                           <input type="text" name="" class="form-control" id="pro_barcode" onkeydown="loadautocomplete_barcode($(this).val(),event)" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastname">Frame Model: <span class="text-danger">*</span></label>
                                           <input type="text" name="" class="form-control" id="pro_framemodel" onkeydown="loadautocomplete_framemodel($(this).val(),event)" autocomplete="off">
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
                                                        <th>Frame Type</th>
                                                        <th>colour</th>
                                                        <th>Model No</th>
                                                        <th>Size</th>
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
                                                        <th>Frame Type</th>
                                                        <th>Colour</th>
                                                        <th>Size</th>
                                                        <th>Model</th>
                                                        <th>Lens Type</th>
                                                        <th>Coating</th>
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Advance Amount: </label>
                                            <input type="text" name="paying_amount" class="form-control" id="input_amount" onkeyup="balance_calculate($(this).val())" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
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
                                 </div>
                              
                                 <div class="row">
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Modeofpay: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="modeofpay_id" id="modeofpay_id">
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
                                        <div class="form-group">
                                            <label for="lastname">Status: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="bill_status" id="bill_status">
                                                <option>Select status</option>
                                                <option value="1">Inprogress</option>
                                                <?php if($cff!=1){ ?>
                                                <option value="2">Delivered</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                       <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Expected Delivered Date: <span class="text-danger">*</span></label>
                                            <input  type="date" name="edate" id="edate" class="form-control">
                                        </div>
                                    </div>

                                      <div class="col-md-3">
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
                                                <br/>
                                   <div class="row">
                                   <div class="col-md-2">
                                     <div class="form-group">
                                            <label>Emergency Order</label>
                                           <select class="form-control" name="emergency_order" id="emergency_order">
                                             <option value="0">No</option>
                                             <option value="1">Yes</option>
                                           </select>
                                        </div>
                                     </div>

                                     <div class="col-md-3">
                                     <div class="form-group">
                                            <label>Credit Name</label>
                                           <input type="text" class="form-control" name="credit_name" id="credit_name">
                                        </div>
                                     </div>
                                 
                                  <div class="col-md-4">
                                     <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="sdescription" id="sdescription"></textarea>
                                        </div>
                                     </div>
									 
									
                                 </div>
                               

                                  <div class="card-footer ml-auto">
                                    <button id="save" type="button" class="btn btn-success btn-min-width btn-glow mr-1 mb-1" onclick="savesalesentry();">Submit</button>
                                    <button style="display: none;" id="update" type="button" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1" onclick="updatesalesentry();">Update</button>
                                     <button type="button" class="btn btn-info btn-min-width btn-glow mr-1 mb-1" onClick="window.location.reload();">Reset</button>
                                     <t id="soc_db"></t>
                                </div>
                            </form>