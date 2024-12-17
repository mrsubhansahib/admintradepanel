@extends($activeTemplate . 'layouts.app')
@section('app')
    @if (gs('registration'))
        @php
            $registerContent = getContent('register.content', true);
        @endphp
        <div class="account-section bg_img"
            data-background="{{ frontendImage('register', @$registerContent->data_values->image, '1920x1080') }}">
            <div class="account__section-wrapper">
                <div class="account__section-thumb"></div>
                <div class="account__section-content bg--section account__section-content-reg">
                    <div class="w-100">
                        <div class="logo mb-5">
                            <a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
                        </div>
                        <div class="section__header text--white">
                            <h4 class="section__title mb-0"> {{ __(@$registerContent->data_values->title) }}
                            </h4>
                        </div>
                        <form action="{{ route('user.register') }}" method="POST" class="account--form verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input type="text" class="form-control form--control" name="firstname"
                                        value="{{ old('firstname') }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input type="text" class="form-control form--control" name="lastname"
                                        value="{{ old('lastname') }}" required>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('E-Mail Address')</label>
                                        <input type="email" class="form-control form--control checkUser" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Password')</label>
                                        <input type="password"
                                            class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                            name="password" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Confirm Password')</label>
                                        <input type="password" class="form-control form--control"
                                            name="password_confirmation" required>
                                    </div>
                                </div>

                                <x-captcha />

                                @if (gs('agree'))
                                    @php
                                        $policyPages = getContent('policy_pages.element', false, orderById: true);
                                    @endphp
                                    <div class="form-group">
                                        <input type="checkbox" id="agree" @checked(old('agree')) name="agree"
                                            required>
                                        <label for="agree">@lang('I agree with')</label> <span>
                                            @foreach ($policyPages as $policy)
                                                <a class="text--base" href="{{ route('policy.pages', $policy->slug) }}"
                                                    target="_blank">{{ __($policy->data_values->title) }}</a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="cmn--btn w-100"> @lang('Sign Up')</button>
                        </form>

                        @include($activeTemplate . 'partials.social_login')

                        <div class="mt-5 text-center text--white">
                            @lang('Already have an Account ?') <a href="{{ route('user.login') }}" class="text--base">@lang('Login') </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal custom--modal fade" id="existModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="existModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h6>
                        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <p class="text-center mb-0">@lang('You already have an account please Login')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn-sm"
                            data-bs-dismiss="modal">@lang('Close')</button>
                        <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include($activeTemplate . 'partials.registration_disabled')
    @endif
@endsection

@if (gs('secure_password'))
    @push('style')
        <style>
            .country-code .input-group-text {
                background: #fff !important;
            }

            .country-code select {
                border: none;
            }

            .country-code select:focus {
                border: none;
                outline: none;
            }

            .account-section {
                overflow-x: hidden
            }

            .social-login-btn {
                border: 1px solid #cbc4c4;
            }
        </style>
    @endpush


    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush


    @push('script')
        <script>
            "use strict";
            (function($) {

                $('.checkUser').on('focusout', function(e) {
                    var url = '{{ route('user.checkUser') }}';
                    var value = $(this).val();
                    var token = '{{ csrf_token() }}';

                    var data = {
                        email: value,
                        _token: token
                    }

                    $.post(url, data, function(response) {
                        if (response.data != false) {
                            $('#existModalCenter').modal('show');
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
@else
    @push('style')
        <style>
            .register-disable {
                height: 100vh;
                width: 100%;
                background-color: #fff;
                color: black;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .register-disable-image {
                max-width: 300px;
                width: 100%;
                margin: 0 auto 32px;
            }

            .register-disable-title {
                color: rgb(0 0 0 / 80%);
                font-size: 42px;
                margin-bottom: 18px;
                text-align: center
            }

            .register-disable-icon {
                font-size: 16px;
                background: rgb(255, 15, 15, .07);
                color: rgb(255, 15, 15, .8);
                border-radius: 3px;
                padding: 6px;
                margin-right: 4px;
            }

            .register-disable-desc {
                color: rgb(0 0 0 / 50%);
                font-size: 18px;
                max-width: 565px;
                width: 100%;
                margin: 0 auto 32px;
                text-align: center;
            }

            .register-disable-footer-link {
                color: #fff;
                background-color: #5B28FF;
                padding: 13px 24px;
                border-radius: 6px;
                text-decoration: none
            }

            .register-disable-footer-link:hover {
                background-color: #440ef4;
                color: #fff;
            }
        </style>
    @endpush
@endif
