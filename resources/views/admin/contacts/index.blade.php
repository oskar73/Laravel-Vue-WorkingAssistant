@extends('layouts.master')
@section('title', 'Contacts')
@section('style')

@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['Contacts']"/>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile" >
        <div class="m-portlet__body">
            <div class="table-responsive">
                <table id="contacts_table" class="table table-hover ajaxTable datatable">
                    <thead>
                    <tr>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Email Address
                        </th>
                        <th>
                            Subject
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="loading-tbody"><tr><td style="height:200px;"></td></tr></tbody>
                </table>
            </div>

        </div>
    </div>

    <form id="delete_contact" method="post" action="">
        @csrf
        @method('DELETE')
    </form>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/contacts/index.js')}}"></script>
@endsection
