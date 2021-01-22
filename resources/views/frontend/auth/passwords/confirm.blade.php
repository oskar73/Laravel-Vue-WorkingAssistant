@extends('layouts.authApp')

@section("title") Confirm Password @endsection
@section('content')
    <div class="form">
        <div class="tab-content">
            <p class="font-size20 font-weight-bold">Confirm Password</p><br>
            <form method="POST" action="{{ route('password.confirm') }}" id="auth_form">
                @csrf
                @honeypot

                <div class="field-wrap">
                    <p class="mb-0 text-left">Password</p>
                    <input type="password" class="biz_input" required autocomplete="off" name="password" value="{{ old('password') }}"/>
                </div>
                <button type="submit" class="auth_button mt-2">Confirm</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}" class="link_to underline">Forgot Password?</a>
            </div>
        </div><!-- tab-content -->
    </div>
@endsection

