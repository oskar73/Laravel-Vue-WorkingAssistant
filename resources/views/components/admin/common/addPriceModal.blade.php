
<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <form id="addPriceModalForm" action="{{$action}}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="edit_price" name="edit_price">
                    <div class="row" x-data="{recurrent:true}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_type" class="form-control-label">
                                    Payment Type:

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is payment type. You can choose either onetime or recurrent subscription payment."
                                    ></i>
                                </label>
                                <select name="payment_type" id="payment_type" class="payment_type selectpicker disable_item" data-width="100%" x-on:change="recurrent=!recurrent">
                                    <option value="1" selected>Recurrent</option>
                                    <option value="0" >Onetime</option>
                                </select>
                                <div class="form-control-feedback error-payment_type"></div>
                            </div>
                        </div>
                        <div class="col-md-6" x-show="recurrent">
                            <label for="period" class="form-control-label">
                                Recurring Billing Cycle:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="When payment type is recurrent, you can define how often it would be happened."
                                ></i>
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control text-right m-input--square disable_item" value="1" name="period" id="period">
                                <div class="input-group-append" style="width:150px;">
                                    <select class="form-control m-bootstrap-select selectpicker disable_item" name="period_unit" id="period_unit">
                                        <option value="day">Day</option>
                                        <option value="week">Week</option>
                                        <option value="month" selected>Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-control-feedback error-period"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-control-label">
                                    Price:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is price of this package."
                                    ></i>
                                </label>
                                <input type="text" class="form-control price disable_item" name="price" id="price">
                                <div class="form-control-feedback error-price"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slashed_price" class="form-control-label">
                                    Slashed Price:
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is slashed price of this package. Optional. You can give the better price to customers with this field."
                                    ></i>
                                </label>
                                <input type="text" class="form-control price" name="slashed_price" id="slashed_price">
                                <div class="form-control-feedback error-slashed_price"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="standard" class="form-control-label">Set As Standard?
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="When you defined multi price plans on this package, if you set this price plan as standard, then it will be displayed on package item card. If the customer adds this package to cart without choosing plan, then this standard price will be applied."
                                ></i>
                            </label>
                            <div>
                                <span class="m-switch m-switch--icon m-switch--info">
                                    <label>
                                        <input type="checkbox" name="standard" id="price_standard">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-control-label">
                                Status
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="You can disable or enable this price plan."
                                ></i>
                            </label>
                            <div>
                                <span class="m-switch m-switch--icon m-switch--info">
                                    <label>
                                        <input type="checkbox" name="status" checked id="price_status">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info m-btn m-btn--custom m-btn--square" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn m-btn--square m-btn btn-outline-success smtBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
