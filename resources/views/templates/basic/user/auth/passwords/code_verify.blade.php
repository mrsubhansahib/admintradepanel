@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- Dashboard Section -->
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper">
                            <div class="verification-area">
                                <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                    @csrf
                                    <p class="mb-3">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    @include($activeTemplate . 'partials.verification_code')
                                    <div class="form-group">
                                        <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit')</button>
                                    </div>
                                    <div class="mt-3">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a href="{{ route('user.password.request') }}"
                                            class="text--base">@lang('Try to send again')</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .verification-code span {
            border: solid 1px #{{ gs('base_color') }}63 !important;
            color: #{{ gs('base_color') }} !important;
        }
    </style>
@endpush
