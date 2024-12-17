@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center g-4">
        @foreach ($wallets as $wallet)
            <div class="col-sm-6 col-lg-4">
                <div class="dashboard-item">
                    <img src="{{ getImage(getFilePath('cryptoCurrency') . '/' . $wallet->currency->image, getFileSize('cryptoCurrency')) }}"
                        class="w-25 bg-transparent rounded-circle" alt="currency">
                    <div class="cont">
                        <div class="dashboard-header">
                            <h2 class="title">
                                {{ $wallet->currency->cur_sym }}{{ showAmount($wallet->amount, currencyFormat: false) }}
                            </h2>
                        </div>
                        {{ __($wallet->currency->name) }}

                        <br>
                        <a href="{{ route('user.wallet.single', $wallet->id) }}"
                            class="btn btn--base btn-sm mt-2">@lang('View')</a>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($wallets->hasPages())
            {{ paginateLinks($wallets) }}
        @endif
    </div>
@endsection
@push('style')
    <style>
        .dashboard-item:hover {
            background: transparent !important;
        }
    </style>
@endpush
