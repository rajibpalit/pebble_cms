<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>New Invoice</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/add_currency') ?>">
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">Client</label>
                        <div class="col-sm-3">
                            <select style="width: 400%" class="form-control col-sm-4" id="" name="">
                                <option value="">None</option>
                                <option value="">Please Select1</option>
                                <option value="">Please Select2</option>
                                <option value="">Please Select3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Invoice Number*</label>
                        <div class="col-sm-3">          
                            <input style="width: 150%" type="text" required="required" class="form-control" name="" value="<?php echo isset($value) ? $value[0][''] : '' ?>" id="currency_name" placeholder="Invoice Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Date of Issue*</label>
                        <div class="col-sm-3">          
                            <input style="width: 150%" type="text" class="form-control" name="" value="<?php echo isset($value) ? $value[0]['short_form'] : '' ?>" id="" placeholder="Issue Date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">PO Number</label>
                        <div class="col-sm-3">          
                            <input style="width: 150%" type="text" class="form-control" name="" value="<?php echo isset($value) ? $value[0]['short_form'] : '' ?>" id="" placeholder="PO Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Discount</label>
                        <div class="col-sm-3">          
                            <input style="width: 150%" type="text" class="form-control" name="" value="<?php echo isset($value) ? $value[0]['short_form'] : '' ?>" id="" placeholder="   %">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Online Payment</label>
                        <div class="col-sm-3">          
                            <a href="#"><p style="width: 150%; margin-top: 8px;">get Paid with stripe</p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div style="float: left; width: 100%; text-align: center">
                <table class="table table-bordered">
                    <tr class="list_header">
                        <th>Task</th>
                        <th>Time Entry Notes</th>
                        <th>Rate</th>
                        <th>Hour</th>
                        <th>Tax</th>
                        <th>Tax</th>
                        <th>Line Total</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="selectpicker" style="width: 110%;" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="selectpicker" style="width: 100%; height: 30px" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                               
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td style="background-color: #F0F0F0">
                            <strong style="float: right;"><p>0.00</p></strong>
                        </td>

                    </tr>
                </table>
            </div>
            <div style="float: left; width: 100%;">
                <table class="table table-bordered" style="">
                    <tr class="list_header">
                        <th>Item</th>
                        <th>Description</th>
                        <th>Unit Cost</th>
                        <th>Qty</th>
                        <th>Tax</th>
                        <th>Tax</th>
                        <th>Line Total</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </td>
                        <td style="background-color: #F0F0F0">
                            <strong style="float: right;"><p>0.00</p></strong>
                        </td>

                    </tr>
                </table>
            </div>
            <div style="float: left; width: 100%">
                <div class="col-lg-7">
                    <label style="margin-left: -14px; background-color: #888888; width: 100px;padding-bottom: 8px; border-radius:5px 0 0 5px;" class="control-label col-sm-2" for="">Add Line</label>
                    <select style="float: left; width: 21px; height: 37px; background-color: white; border-radius:0 5px 5px 0;" class="" id="" name="">
                                <option></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                </div>
                <div class="col-lg-5" style="float: right;margin-top: -20px; margin-right: -15px">
                    <table class="table table-bordered" style="">
                        <tr class="">
                            <td><span style="float: left">  Invoice Total </span><span style="float: right">$112</span></td>
                        </tr> 
                        <tr class="">
                            <td><span style="float: left">Paid to Date</span><span style="float: right">0.00</span></td>
                        </tr> 
                        <tr class="">
                            <td style="background-color: #F0F0F0"><span style="float: left"><b>Balance(USD)</b></span><span style="float: right">$112</span></td>
                        </tr>
                    </table>
                </div>

            </div>
        </form>
    </div>
</div>

