@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kyc = getContent('kyc.content', true);
    @endphp

    <div class="notice"></div>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="card custom--card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="alert-heading">@lang('KYC Documents Rejected')</h6>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ __(@$kyc->data_values->reject) }} <a
                        href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>.</p>
                <a href="{{ route('user.kyc.data') }}" class="text--base">@lang('See KYC Data')</a>
            </div>
        </div>
    @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
        <div class="card custom--card mb-4">
            <div class="card-body">
                <h6 class="alert-heading">@lang('KYC Verification required')</h6>
                <hr>
                <p class="mb-0">{{ __(@$kyc->data_values->required) }} <a href="{{ route('user.kyc.form') }}"
                        class="text--base">@lang('Click Here to Submit Documents')</a></p>
            </div>
        </div>
    @elseif(auth()->user()->kv == Status::KYC_PENDING)
        <div class="card custom--card mb-4">
            <div class="card-body">
                <h6 class="alert-heading">@lang('KYC Verification pending')</h6>
                <hr>
                <p class="mb-0">{{ __(@$kyc->data_values->pending) }} <a href="{{ route('user.kyc.data') }}"
                        class="text--base">@lang('See KYC Data')</a></p>
            </div>
        </div>
    @endif


    <div class="row justify-content-center g-4">
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="las la-link"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ showAmount($user->balance) }} </h2>
                    </div>
                    <a href="{{ route('user.transactions') }}">@lang('Balance') </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="las la-link"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ $tickets }}</h2>
                    </div>
                    <a href="{{ route('ticket.index') }}">@lang('Opened Ticket') </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="las la-link"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ $wallets }}</h2>
                    </div>
                    <a href="{{ route('user.wallet.all') }}">@lang('Active Wallets') </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="las la-link"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ showAmount($totalTransaction) }}</h2>
                    </div>
                    <a href="{{ route('user.transactions') }}">@lang('Total Transaction') </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="las la-link"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ showAmount($depositAmount) }}</h2>
                    </div>
                    <a href="{{ route('user.deposit.history') }}">@lang('Deposit') </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="las la-link"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ showAmount($withdrawal) }}</h2>
                    </div>
                    <a href="{{ route('user.withdraw.history') }}">@lang('Withdraw') </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div>
        <h6 class="my-4">@lang('Transaction History')</h6>
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
            <tbody class="border-0">
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
                                {{ $trx->trx_type }} {{ showAmount($trx->amount, 8) }}
                                @if ($trx->wallet_id)
                                    {{ __(@$trx->currencyCode->cur_text) }}
                                @else
                                    {{ __(gs('cur_text')) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            {{ showAmount($trx->post_balance, 8) }}
                            @if ($trx->wallet_id)
                                {{ __(@$trx->currencyCode->cur_text) }}
                            @else
                                {{ __(gs('cur_text')) }}
                            @endif
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
    <!-- Table -->

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal custom--modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">@lang('KYC Document Rejection Reason')</h6>
                        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
