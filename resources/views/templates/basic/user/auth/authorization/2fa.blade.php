@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 d-flex justify-content-center">
                    <div class="verification-code-wrapper">
                        <div class="verification-area">
                            <form action="{{ route('user.2fa.verify') }}" method="POST" class="submit-form">
                                @csrf
                                @include($activeTemplate . 'partials.verification_code')
                                <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit')</button>
                            </form>
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
