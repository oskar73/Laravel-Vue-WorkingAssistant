<div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="meeting_area">
    <div class="m-portlet__body" >
        <form action="{{$action}}" id="updateMeetingForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container" x-data="{meeting:{{$item->meeting}},form:{{$item->form}}}">
                <div>
                    <label for="form" class="form-control-label">Attach Purchase Follow-up Form?</label>
                    <div>
                        <span class="m-switch m-switch--icon m-switch--info">
                            <label>
                                <input type="checkbox" name="form" id="form" @if($item->form) checked @endif  x-on:click="form=form===1?0:1">
                                <span></span>
                            </label>
                        </span>
                    </div>
                    <div  x-show="form===1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="followupEmail" class="form-control-label">Choose Email:</label>
                                    <select name="followupEmail" id="followupEmail" class="followupEmail selectpicker" data-live-search="true" data-width="100%">
                                        <option value="" disabled selected>Choose Email</option>
                                        @foreach($followEmails as $email)
                                            <option value="{{$email->id}}" @if($email->id===$item->email_id) selected @endif>{{$email->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-feedback error-followupEmail"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="followupForm" class="form-control-label">Choose Form:</label>
                                    <select name="followupForm" id="followupForm" class="followupForm selectpicker" data-live-search="true" data-width="100%">
                                        <option value="" disabled selected>Choose Form</option>
                                        @foreach($followForms as $form)
                                            <option value="{{$form->id}}" @if($form->id===$item->form_id) selected @endif>{{$form->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-feedback error-followupForm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @publishedModule("appointment")
                <div>
                    <label for="meeting" class="form-control-label">Allow Meeting?</label>
                    <div>
                        <span class="m-switch m-switch--icon m-switch--info">
                            <label>
                                <input type="checkbox" name="meeting" id="meeting" @if($item->meeting) checked @endif x-on:click="meeting=meeting===1?0:1">
                                <span></span>
                            </label>
                        </span>
                    </div>
                    <div x-show="meeting===1">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="appCats" class="form-control-label">Choose Appointment Categories:</label>
                                    <select name="appCats[]" id="appCats" class="appCats meeting_select2" multiple>
                                        <option ></option>
                                        @foreach($appCats as $appCat)
                                            <option value="{{$appCat->id}}"
                                                    @if(in_array($appCat->id, $meetingSet->categories->pluck("id")->toArray())) selected @endif
                                            >{{$appCat->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-feedback error-appCats"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="meetingPeriod" class="form-control-label">Meeting Period (minutes):</label>
                                    <select name="meetingPeriod" id="meetingPeriod" class="meetingPeriod selectpicker" data-width="100%">
                                        <option value="30" @if($meetingSet->meeting_period==30) selected @endif>30 minutes</option>
                                        <option value="60" @if($meetingSet->meeting_period==60) selected @endif>60 minutes</option>
                                        <option value="90" @if($meetingSet->meeting_period==90) selected @endif>90 minutes</option>
                                        <option value="120" @if($meetingSet->meeting_period==120) selected @endif>120 minutes</option>
                                    </select>
                                    <div class="form-control-feedback error-meetingPeriod"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="meetingLimit" class="form-control-label">Meeting Limit Number:</label>
                                    <input type="number" class="form-control" name="meetingLimit" id="meetingLimit" value="{{$meetingSet->meeting_number}}">
                                    <div class="form-control-feedback error-meetingLimit"></div>
                                </div>
                            </div>
                        </div>
                        <p>Available Weekday & Time set</p>
                        <div class="row seven-cols">
                            @foreach($weekArray as $wA)
                                <div class="col-md-1">
                                    <label class="m-checkbox m-checkbox--state-primary">
                                        <input type="checkbox" name="{{$wA}}"
                                               class="checkbox"
                                               data-name="{{$wA}}"
                                               @if(isset($data[$wA])) checked @endif
                                        > {{ucfirst($wA)}}
                                        <span></span>
                                    </label>
                                    <div class="{{$wA}}_table_area" style="display:@if(isset($data[$wA])) block @else none @endif">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-info p-1 mb-3 add_time_btn" data-name="{{$wA}}">+ Add time</a>
                                        <table class="table custom-table">
                                            <tbody id="{{$wA}}_table">
                                                @if(isset($data[$wA]))
                                                    @foreach($data[$wA]->hours as $meeting_key=>$hour)
                                                        <tr id="rowe_{{$item.$meeting_key}}">
                                                            <td><input class="form-control timepicker start_time_area" name="start_time_{{$wA}}[]" placeholder="start" readonly type="text" value="{{$hour->start}}"/></td>
                                                            <td><input class="form-control timepicker end_time_area" placeholder="end" name="end_time_{{$wA}}[]" readonly type="text" value="{{$hour->end}}"/></td>
                                                            <td><a href="javascript:void(0);" data-id="rowe_{{$wA.$meeting_key}}" class="btn m-btn--square  btn-danger btn-sm p-1 btn_remove">X</a></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endpublishedModule
                <div class="text-right mt-4">
                    <a class="btn btn-outline-info m-btn m-btn--custom m-btn--square tab-link" data-area="#price" href="#/price">Previous</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success meetingSmtBtn">Next</button>
                </div>
            </div>
        </form>
    </div>
</div>
