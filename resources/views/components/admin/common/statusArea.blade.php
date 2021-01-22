
<div class="m-portlet m-portlet--mobile tab_area" id="status_area">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <label for="final_status" class="form-control-label">
                    Status Approve?

                    <i class="la la-info-circle tooltip_icon"
                       title='{{$tooltip[200]}}'
                       data-page="{{$view_name}}"
                       data-id="200"
                    ></i>
                </label>
                <div>
                    <span class="m-switch m-switch--icon m-switch--info">
                        <label>
                            <input type="checkbox" name="final_status" id="final_status" @if($status)checked @endif>
                            <span></span>
                        </label>
                    </span>
                </div>
                <div class="text-left">
                    <a class="btn btn-outline-info m-btn m-btn--custom m-btn--square tab-link" data-area="#meeting" href="#/meeting">Previous</a>
                    <a href="{{$action}}" class="btn btn-outline-success m-btn m-btn--custom m-btn--square tab-link statusUpdate">Update Status</a>
                </div>
            </div>
        </div>
    </div>
</div>
