@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- Dashboard Section -->
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 d-flex justify-content-center ">

                    <div class="verification-code-wrapper change-wrapper">
                        <div class="verification-area">
                            <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form">
                                @csrf
                                <p>@lang('A 6 digit verification code sent to your mobile number') :
                                    +{{ showMobileNumber(auth()->user()->mobileNumber) }}</p>
                                @include($activeTemplate . 'partials.verification_code')
                                <div class="mb-3">
                                    <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit')</button>
                                </div>
                                <div>
                                    <p>
                                        @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span
                                                id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a
                                            href="{{ route('user.send.verify.code', 'sms') }}"
                                            class="try-again-link d-none"> @lang('Try again')</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Section -->
@endsection

@push('script')
    <script>
        var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush

@push('style')
    <style>
        .verification-code span {
            border: solid 1px #{{ gs('base_color') }}63 !important;
            color: #{{ gs('base_color') }} !important;
        }
    </style>
@endpush
