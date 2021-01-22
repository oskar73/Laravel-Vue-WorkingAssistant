<div class="modal fade" id="addAppointment_modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment date and time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <form id="appointmentDateForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control selectpicker" id="category_id" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-control-feedback error-category_id"></div>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" readonly id="date" name="date">
                        <div class="form-control-feedback error-date"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start">Start Time</label>
                                <input class="form-control timepicker start" name="start" placeholder="start" type="text" value="7:00" readonly>
                                <div class="form-control-feedback error-start"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end">End Time</label>
                                <input class="form-control timepicker end" name="end" placeholder="end" type="text" value="18:00" readonly>
                                <div class="form-control-feedback error-end"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <textarea class="form-control" id="reason" name="reason"></textarea>
                        <div class="form-control-feedback error-reason"></div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control minh-100" id="description" name="description"></textarea>
                        <div class="form-control-feedback error-description"></div>
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
