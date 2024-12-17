@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="dashboard-item h-100">
                <i class="fs-1 la la-bank text--base"> </i>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">
                            {{ $wallet->currency->cur_sym }}{{ showAmount($withdrawalApproved, currencyFormat: false) }}
                        </h2>
                    </div>
                    @lang('Total Withdraw')
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="dashboard-item h-100">
                <i class="fs-1 las la-money-bill-wave text--base"> </i>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">
                            {{ $wallet->currency->cur_sym }}{{ showAmount($withdrawalPending, currencyFormat: false) }}
                        </h2>
                    </div>
                    @lang('Pending Withdraw')
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-item h-100">
                <i class="fs-1 las la-ban text--base"> </i>

                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">
                            {{ $wallet->currency->cur_sym }}{{ showAmount($withdrawalRejected, currencyFormat: false) }}
                        </h2>
                    </div>
                    @lang('Rejected Withdraw')


                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-item h-100">
                <i class="fs-1 las la-coins text--base"> </i>

                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">
                            {{ $wallet->currency->cur_sym }}{{ showAmount($wallet->amount, currencyFormat: false) }}
                        </h2>
                    </div>
                    @lang('Available ') {{ __(@$wallet->currency->cur_text) }}
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-item h-100">
                <i class="fs-1 las la-hand-holding-usd text--base"> </i>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">
                            {{ showAmount($wallet->currency->selling_price_total) }}
                        </h2>
                    </div>
                    @lang('Price Per '){{ __(@$wallet->currency->cur_text) }}
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-item h-100 text-center">
                <i class="fs-1 las la-exchange-alt text--base"> </i>
                <div class="cont">
                    <a href="#" class="buy py-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        @lang('Withdraw Now')
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="dashboard-item h-100 text-center">
                <small id="emailHelp" class="form-text  text-warning"><b>please enter the native network receivers wallet address (no other networks are currently supported)</b></small>
            </div>
        </div>

    </div>



    <!-- Table -->
    <div class="mt-4">
        <table class="table cmn--table">
            <thead>
                <tr>
                    <th>@lang('Trx')</th>
                    <th>@lang('Transacted')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Post Balance')</th>
                    <th>@lang('Detail')</th>
                </tr>
            </thead>
            <tbody class=" border-0">
                @forelse ($transactions as $trx)
                    <tr>
                        <td>
                            <span>{{ $trx->trx }}</span>
                        </td>
                        <td>
                            <span>{{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}</span>
                        </td>
                        <td>
                            <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                {{ $trx->trx_type }}{{ showAmount($trx->amount, currencyFormat: false) }}
                                {{ __(@$trx->currencyCode->cur_text) }}
                            </span>
                        </td>
                        <td>
                            <span>{{ showAmount($trx->post_balance, currencyFormat: false) }}
                                {{ __(@$trx->currencyCode->cur_text) }}</span>
                        </td>
                        <td>
                            {{ __($trx->details) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($transactions->hasPages())
        {{ paginateLinks($transactions) }}
    @endif
    <div class="modal custom--modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"> @lang('Withdraw') </h6>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('user.wallet.withdraw', $wallet->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="form--label">@lang('Receiver Wallet Address')</label>
                                <div class="input-group">
                                    <input type="text" step="any" name="wallet_address"
                                        value="{{ old('wallet_address') }}" class="form-control form--control" required>
                                     <small id="emailHelp" class="form-text text-warning"><b>please enter the native network receivers wallet address (no other networks are currently supported)</b></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form--label">@lang('Amount')</label>
                                <div class="input-group">
                                    <input type="number" step="any" name="amount" value="{{ old('amount') }}"
                                        class="form-control form--control" min="0" required>
                                    <span class="input-group-text bg--base">{{ $wallet->currency->cur_sym }}</span>
                                </div>
                            </div>

                            <div class="my-3 preview-details d-none">
                                <ul class="list-group text-center">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Limit')</span>
                                        <span>
                                            <span class="fw-bold">{{ showAmount($wallet->amount) }}</span>
                                            {{ __($wallet->currency->cur_text) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('[name=amount]').on('input', function() {
                var inputValue = Number($(this).val());
                if (inputValue <= 0) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var resource = @json($wallet);
                var amount = parseFloat($('[name=amount]').val());
                if (isNaN(amount)) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                $('.preview-details').removeClass('d-none');
                var buying_price = parseFloat(resource.currency.selling_price_total);
            });

        })(jQuery);
    </script>
@endpush

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