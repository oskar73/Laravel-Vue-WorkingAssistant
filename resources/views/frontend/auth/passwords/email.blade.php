@extends('layouts.authApp')

@section("title") Reset Password @endsection
@section('content')
    <div class="form">
        <div class="tab-content">
            <p class="font-size20 font-weight-bold">Reset Password Request</p>
            <form method="POST" action="{{ route('password.email') }}" id="auth_form">
                @csrf
                @honeypot
                @if (session('status'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="field-wrap">
                    <p class="mb-0 text-left">Email Address</p>
                    <input type="email" class="biz_input" required autocomplete="off" name="email" value="{{ old('email') }}"/>
                    @error('email')
                    <div class="text-danger text-left">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="auth_button mt-2">Send</button>
            </form>

            <div class="mt-3 text-center">
                Go back to <a href="{{ route('login') }}" class="link_to underline">Log in</a>
            </div>
        </div><!-- tab-content -->
    </div>


@endsection
