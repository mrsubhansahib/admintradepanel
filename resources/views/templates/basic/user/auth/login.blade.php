@extends($activeTemplate . 'layouts.app')
@php
    $loginContent = getContent('login.content', true);
@endphp
@section('app')
    <div class="account-section bg_img"
        data-background="{{ frontendImage('login', @$loginContent->data_values->image, '1920x1080') }}">
        <div class="account__section-wrapper">
            <div class="account__section-thumb"></div>
            <div class="account__section-content bg--section account__section-content-reg">
                <div class="w-100">
                    <div class="logo mb-5">
                        <a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
                    </div>
                    <div class="section__header text--white">
                        <h4 class="section__title mb-0">{{ __(@$loginContent->data_values->title) }}</h4>
                    </div>
                    <form method="POST" action="{{ route('user.login') }}" class="account--form verify-gcaptcha">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form--label">@lang('Username or Email')</label>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control form--control" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form--label">@lang('Password')</label>
                            <input type="password" name="password" class="form-control form--control" autocomplete="off"
                                required>
                        </div>

                        <x-captcha />

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                            </div>
                            <a href="{{ route('user.password.request') }}" class="text--base">@lang('Forgot your password?') </a>
                        </div>
                        <button type="submit" class="cmn--btn w-100 mt-3">@lang('Sign In') </button>
                    </form>

                    @include($activeTemplate . 'partials.social_login')

                    <div class="mt-3 text-center">
                        @lang('Don\'t have an Account ?') <a href="{{ route('user.register') }}" class="text--base">@lang('Create New') </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .account-section {
            overflow-x: hidden
        }

        .g-recaptcha>div,
        .g-recaptcha iframe {
            width: 100% !important;
        }
    </style>
@endpush
