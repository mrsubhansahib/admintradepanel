@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- Dashboard Section -->
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="change-wrapper py-5">
                        <form method="POST" action="{{ route('user.password.update') }}" class="row g-4">
                            @csrf
                            <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Password')</label>
                                    <input type="Password" name="password"
                                        class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Confirm Password')</label>
                                    <input type="Password" name="password_confirmation" class="form-control form--control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit')</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Section -->
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
