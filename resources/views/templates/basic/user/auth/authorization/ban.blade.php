@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 d-flex justify-content-center  flex-column">
                    <div class="change-wrapper py-5">
                        <h3 class="text-center text--danger">@lang('You are banned')</h3>
                        <div class=" d-flex justify-content-center py-3">
                            <p class="fw-bold mb-1 px-1">@lang('Reason'):</p>
                            <p>{{ $user->ban_reason }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
