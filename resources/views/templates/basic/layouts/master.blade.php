@extends($activeTemplate . 'layouts.app')
@section('app')
    <div class="dashboard-section pt-120 pb-120">
        <div class="container">
            <div class="dashboard-menu-open d-xl-none">
                <i class="las la-ellipsis-v"></i>
            </div>
            <div class="row gy-3">
                @include($activeTemplate . 'partials.sidebar')
                <div class="col-xl-9">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });
        })(jQuery)
    </script>
@endpush
