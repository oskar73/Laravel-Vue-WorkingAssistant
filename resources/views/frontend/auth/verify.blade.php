@extends('layouts.authApp')

@section("title") Verify Email Address @endsection
@section('content')
    <div class="form">
        <div class="tab-content">
            <p class="font-size20 font-weight-bold">Verify Your Email Address</p>
            @if (session('resent'))
                <div class="alert alert-success mt-2" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <p class="mt-3">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            </p>
            <form method="POST" action="{{ route('verification.resend') }}" id="auth_form">
                @csrf
                @honeypot

                <button type="submit" class="auth_button mt-2">Click here to request another</button>
            </form>
            <div class="text-center mt-3">
                <a href="javascript:void(0);" class="link_to underline" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log Out</a>
            </div>

        </div><!-- tab-content -->
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
