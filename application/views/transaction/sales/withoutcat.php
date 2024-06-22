<tr style="background:#ffedb8;">
                  <td>
                        <a href="#" onclick="$(this).parent().parent().remove();calcnet();checkgridcount();" class="input_column">
                        <button class="btn btn-danger btnDelete btn-sm">
                           <i class="la la-trash"></i>
                        </button>
                        </a>
                   </td>
                   <td>10</td>
                   <td><b>BUDGET PAL CRIZAL UV</b><input type="hidden" value="BUDGET PAL CRIZAL UV" name="product[]"><input type="hidden" name="original_selling_price[]" id="original_selling_price_1" value="4800"></td>
                   <td></td>
                   <td><input type="text" name="selling_price[]" id="selling_price_1" class="form-control grid_table" value="4800" onkeyup="calcrow(1)" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))"></td>
                   <td><input type="number" step="any" name="quantity[]" id="quantity_1" class="form-control grid_table" value="0" onkeyup="calcrow(1)" onkeydown="changefocus(event,$(this))" onkeypress="return isFloat(event)" required="" autocomplete="off"></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td>NONE</td>
                   <td>NONE1</td>
                   <td class="mbl_view">
                       <select name="discount_type[]" id="discount_type_1" class="form-control grid_table" onchange="calcrow(1)">
                         <option value="0">Amount</option>
                         <option value="1">Percentage</option>
                       </select>
                   </td>
                   <td class="mbl_view">
                      <input type="text" name="discount_input[]" value="" class="form-control grid_table" onkeyup="calcrow(1)" id="discount_input_1" onkeypress="isFloat(event)" onkeydown="changefocus(event,$(this))">
                      <input type="hidden" name="discount_amount[]" value="0" id="discount_amount_1"></td>
                   
                   <td>
                      <input name="amount[]" id="amount_1" class="form-control grid_table" value="0" readonly="">
                   </td>
                   <td style="display: none;" class="mbl_view">
                     <select name="tax_type[]" id="tax_type_1" style="font-size:12px" class="form-control grid_table disabled_select">
                       <option value="0">Non Tax</option>
                       <option value="1">Inclusive</option>
                       <option value="2">Exclusive</option>
                     </select>
                   </td>
                   <td style="display: none;" class="mbl_view"><input type="text" class="form-control grid_table" name="gst[]" id="gst_1" readonly="" value="12"></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="cgst[]" id="cgst_1" readonly="" value="0.00"></td>
                   <td style="display: none;"><input type="hidden" class="form-control grid_table" name="sgst[]" id="sgst_1" readonly="" value="0.00"></td>
                   <td style="display:none" class="mbl_view">
                     <input type="hidden" name="stock_id[]" id="stock_id_1" value="14">
                     <input type="hidden" name="product_id[]" id="product_id_1" value="14">
                     <input type="hidden" name="tax_amount[]" id="tax_amount_1" value="0">
                     <input type="hidden" name="product_type[]" id="product_type_1" value="1">
                   </td>
                </tr>