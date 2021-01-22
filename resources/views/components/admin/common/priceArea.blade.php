<div class="container">
    {{-- @if(count(option("gateway", []))==0)
        <div class="alert alert-primary  m-alert m-alert--air m-alert--outline text-dark" role="alert">
            You didn't add any payment gateway yet. Please add your payment gateway first. <a href="{{route('admin.setting.payment.index')}}">Set Payment</a>.
        </div>
    @endif --}}
    <div class="text-right">
        <a href="javascript:void(0);" class="btn m-btn--square m-btn btn-outline-success btn-sm addPriceBtn">+ Add Price Plan</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered ajaxTable datatable">
            <thead>
                <tr>
                    <th>Price</th>
                    <th>Slashed Price</th>
                    <th>Payment</th>
                    <th>Standard</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="price_area">
                <tr><td colspan="6"><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i></td></tr>
            </tbody>
        </table>
    </div>
    <div class="text-right mt-4">
        <a class="btn btn-outline-info m-btn m-btn--custom m-btn--square tab-link m-1" data-area="#all" href="#/all">Previous</a>
        <a class="btn m-btn--square m-btn m-btn--custom btn-outline-success tab-link m-1" data-area="#meeting" href="#/meeting">Next</a>
    </div>
</div>
