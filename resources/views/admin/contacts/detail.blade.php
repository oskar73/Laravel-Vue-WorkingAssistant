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
            <div class="d-flex mb-5">
                <a href="{{route('admin.contacts.index')}}" class="btn btn-secondary">Back</a>
            </div>
            <table>
                <tbody>
                <tr>
                    <th style="width: 200px"><label>First Name:</label></th>
                    <td>{{$contact->first_name}}</td>
                </tr>
                <tr>
                    <th><label>Last Name:</label></th>
                    <td>{{$contact->last_name}}</td>
                </tr>
                <tr>
                    <th><label>Email Address:</label></th>
                    <td>{{$contact->email}}</td>
                </tr>
                <tr>
                    <th><label>Email Subject:</label></th>
                    <td>{{$contact->subject}}</td>
                </tr>
                <tr>
                    <th><label>Date:</label></th>
                    <td>{{$contact->date}}</td>
                </tr>
                <tr>
                    <th><label>Message:</label></th>
                    <td>{{$contact->message}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
