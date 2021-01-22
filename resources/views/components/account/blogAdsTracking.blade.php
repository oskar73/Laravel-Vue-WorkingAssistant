
<div class="row">
    <div class="col-md-6">
        <div class="m-portlet m-portlet--black m-portlet--head-solid-bg m-portlet--head-sm  border-333" m-portlet="true">
            <div class="m-portlet__head bg-333">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-placeholder-2 text-white"></i>
                            <h3 class="m-portlet__head-text text-white">
                                Tracking by Date
                            </h3>
                        </span>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-angle-down  text-white"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-expand  text-white"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-close  text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" style="overflow:hidden;">
                    <div class="chart">
                        <div class="loading_div">Loading...</div>
                        <canvas id="dateChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="m-portlet m-portlet--black m-portlet--head-solid-bg m-portlet--head-sm  border-333" m-portlet="true">
            <div class="m-portlet__head bg-333">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-placeholder-2  text-white"></i>
                            <h3 class="m-portlet__head-text  text-white">
                                Tracking by Device
                            </h3>
                        </span>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-angle-down text-white"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-expand text-white"></i>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-close text-white"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" style="overflow:hidden;">
                    <div class="chart">
                        <div class="loading_div">Loading...</div>
                        <canvas id="deviceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
