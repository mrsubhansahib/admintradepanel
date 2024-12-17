@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-end mb-3">
        <div class="col-xl-6 col-md-7 col-sm-8">
            <form>
                <div class="input-group">
                    <input type="text" name="search" class="form--control flex-fill px-2" value="{{ request()->search }}"
                        placeholder="@lang('Search by currency')">
                    <button class="input-group-text bg--base text-white">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @include($activeTemplate . 'partials.currency_list', [
        'currencyAll' => $currencyAll,
        'cssClass' => 'cmn--table',
        'src' => 'index',
    ])
@endsection
@push('style')
    <style>
        .dashboard-item:hover {
            background: transparent !important;
        }

        .buy {
            font-size: 14px;
            color: #ec810d;
            background: rgba(236, 129, 13, 0.2);
            font-weight: 500;
            text-transform: capitalize;
            margin: 5px;
            padding: 2px 15px;
            font-family: "Nunito", sans-serif;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }
    </style>
@endpush
