@extends('layouts.authApp')

@section("title") Reset Password @endsection
@section('content')
    <div class="form">
        <div class="tab-content">
            <p class="font-size20 font-weight-bold">Reset Password</p>
            <form method="POST" action="{{ route('password.update') }}" id="auth_form">
                @csrf
                @honeypot

                <input type="hidden" name="token" value="{{ $token }}">
                <div class="field-wrap">
                    <p class="mb-0 text-left">Email Address</p>
                    <input type="email" class="biz_input" required autocomplete="off" name="email" value="{{ old('email') }}"/>

                    @error('email')
                    <div class="text-danger text-left">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-wrap">
                    <p class="mb-0 text-left">New Password</p>
                    <input type="password" class="biz_input" required autocomplete="off" name="password"/>

                    @error('password')
                    <div class="text-danger text-left">{{ $message }}</div>
                    @enderror

                </div>

                <div class="field-wrap">
                    <p class="mb-0 text-left">Confirm Password</p>
                    <input type="password" class="biz_input" required autocomplete="off" name="password_confirmation"/>
                </div>

                <button type="submit" class="auth_button mt-2">Submit</button>
            </form>
        </div>
    </div>
@endsection

