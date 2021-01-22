@extends('layouts.authApp')

@section("title") Register @endsection
@section('content')
    <div class="form">
        <div class="tab-content">
            <form method="POST" action="{{ route('register') }}" id="auth_form">
                @csrf
                @honeypot
                <input type="hidden" name="timezone" id="timezone">

                <p class="font-size20 font-weight-bold">Account Register</p>
                <div class="field-wrap">
                    <p class="mb-0 text-left">
                        Name:
                        <i class="fa fa-info-circle tipso2"
                           data-tipso-title="What is this?"
                           data-tipso="This is your name."
                        ></i>
                    </p>
                    <input type="text" class="biz_input" name="name" value="{{ old('name')}}" autocomplete="off" autofocus required/>
                    @error('name')
                    <div class="text-danger text-left">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field-wrap">
                    <p class="mb-0 text-left">Email Address
                        <i class="fa fa-info-circle tipso2"
                           data-tipso-title="What is this?"
                           data-tipso="This is your email address."
                        ></i>
                    </p>
                    <input type="email" class="biz_input" autocomplete="off" name="email" value="{{ old('email') }}" required/>
                    @error('email')
                    <div class="text-danger text-left">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-wrap" x-data={show:false}>
                    <p class="mb-0 text-left">Password
                        <i class="fa fa-info-circle tipso2"
                           data-tipso-title="What is this?"
                           data-tipso="This is your account password. Minimum characters:8."
                        ></i>
                    </p>
                    <div class="position-relative">
                        <input x-bind:type="show===true?'text':'password'" id="password" class="biz_input" autocomplete="off" name="password" required/>
                        <i class="fa fa-eye psw_eye" x-show="show===true" x-on:click="show=!show"></i>
                        <i class="fa fa-eye-slash psw_eye" x-show="show===false" x-on:click="show=!show"></i>
                    </div>
                    @error('password')
                    <div class="text-danger text-left">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    @if($terms)
                    <div class="mt-4">
                        By proceeding, you agree to <a href="/{{$terms->url}}" class="link_to underline" target="_blank">Terms of Service & Privacy Policy</a>
                    </div>
                    @endif
                    <button type="submit" class="auth_button mt-3">
                        SIGN UP
                    </button>
                </div>

            </form>
            @php
                $social = optional(option("social", null));
            @endphp

            @if(in_array(1,[$social['twitter'], $social['facebook'], $social['instagram'], $social['google'], $social['linkedin'], $social['github']]))
                <div class="row mt-3">
                    <div class="col-4"><hr></div>
                    <div class="col-4">Or continue with</div>
                    <div class="col-4"><hr></div>
                </div>
            @endif
            <div class="auth-social-links mt-3">
                @if($social['twitter']==1)<a href="{{route('social.login', 'twitter')}}" class="twitter bg-tw"><i class="fab fa-twitter"></i></a>@endif
                @if($social['facebook']==1)<a href="{{route('social.login', 'facebook')}}" class="facebook bg-fb"><i class="fab fa-facebook"></i></a>@endif
                @if($social['instagram']==1)<a href="{{route('social.login', 'instagram')}}" class="instagram bg-ins"><i class="fab fa-instagram"></i></a>@endif
                @if($social['google']==1)<a href="{{route('social.login', 'google')}}" class="google-plus bg-go"><i class="fab fa-google-plus"></i></a>@endif
                @if($social['linkedin']==1)<a href="{{route('social.login', 'linkedin')}}" class="linkedin bg-ln"><i class="fab fa-linkedin"></i></a>@endif
                @if($social['github']==1)<a href="{{route('social.login', 'github')}}" class="github bg-git"><i class="fab fa-github"></i></a>@endif
            </div>
            <div class="mt-3 text-center text-dark">
                Already have an account? <a href="{{ route('login') }}" class="link_to underline">Log in</a>
            </div>
        </div><!-- tab-content -->
    </div>

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
    <script>
        $(document).ready(function() {
            var timezone = moment.tz.guess();
            console.log(timezone);
            $('#timezone').val(timezone);
        })
    </script>
@endsection

