@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- Dashboard Section -->
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="change-wrapper py-5">

                        <form method="POST" action="{{ route('user.password.email') }}" class="row g-4 verify-gcaptcha ">
                            @csrf

                            <p>@lang('To recover your account please provide your email or username to find your account.')</p>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="text" class="form--label">@lang('Email or Username')</label>
                                    <input type="text" name="value" value="{{ old('value') }}"
                                        class="form-control form--control" required autofocus="off" required>
                                </div>
                            </div>

                            <x-captcha />

                            <div class="mt-3">
                                <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
