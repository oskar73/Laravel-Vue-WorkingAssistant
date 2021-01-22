<div class="modal fade" id="blockDate_modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Block date and time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <form id="blockDateForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group from_date">
                        <label for="from_date">From Date</label>
                        <div class='input-group'>
                            <input type="text" class="form-control m-input--square" id='from_date' name="from_date" readonly/>
                        </div>
                        <div class="form-control-feedback error-from_date"></div>
                    </div>
                    <div class="form-group to_date">
                        <label for="to_date">To Date</label>
                        <div class='input-group'>
                            <input type="text" class="form-control m-input--square" id='to_date' name="to_date" readonly/>
                        </div>
                        <div class="form-control-feedback error-to_date"></div>
                    </div>

                    <div class="form-group">
                        <label for="specific_time" class="form-control-label">Block only specific time?</label>
                        <div>
                            <span class="m-switch m-switch--icon ml-1 mr-1">
                                <label>
                                    <input type="checkbox" id="specific_time" name="specific_time">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="block_time">
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-info p-1 mb-3 add_time_btn">+ Add time</a>
                        <table class="table custom-table">
                            <tbody id="block_table">

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="reason" class="form-control-label">Block Reason</label>
                        <textarea id="reason" class="form-control m-input--square minh-100px" name="reason"></textarea>
                        <div class="form-control-feedback error-reason"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info m-btn m-btn--custom m-btn--square" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                    <a href="javascript:void(0);" class="btn btn-outline-danger m-btn m-btn--custom m-btn--square deleteBtn">Delete</a>
                </div>
            </form>
        </div>
    </div>
</div>
