@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- Dashboard Section -->
    <div class="row justify-content-end mb-3">
        <div class="col-xl-6 col-md-7 col-sm-8">
            <form action="">
                <div class="input-group">
                    <input type="search" name="search" class="form--control flex-fill px-2" value="{{ request()->search }}"
                        placeholder="@lang('Search by transactions')">
                    <button class="input-group-text bg--base text-white">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <table class="table cmn--table">
        <thead>
            <tr>
                <th>@lang('Gateway | Transaction')</th>
                <th>@lang('Initiated')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Conversion')</th>
                <th>@lang('Status')</th>
                <th>@lang('Details')</th>
            </tr>

        </thead>
        <tbody class="border-0">
            @forelse($deposits as $deposit)
                <tr>
                    <td>
                        <span class="fw-bold">
                            <span class="text--base">
                                @if ($deposit->method_code < 5000)
                                    {{ __(@$deposit->gateway->name) }}
                                @else
                                    @lang('Google Pay')
                                @endif
                            </span>
                        </span>
                        <br>
                        <small> {{ $deposit->trx }} </small>
                        </div>
                    </td>
                    <td>
                        <span>{{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}</span>
                    </td>
                    <td class="text-center">
                        {{ showAmount($deposit->amount) }} + <span class="text--danger" data-bs-toggle="tooltip"
                            title="@lang('Processing Charge')">{{ showAmount($deposit->charge) }} </span>
                        <br>
                        <strong data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                            {{ showAmount($deposit->amount + $deposit->charge) }}
                        </strong>
                        </span>
                    </td>
                    <td class="text-center">
                        {{ showAmount(1) }} = {{ showAmount($deposit->rate, currencyFormat: false) }}
                        {{ __($deposit->method_currency) }}
                        <br>
                        <strong>{{ showAmount($deposit->final_amount, currencyFormat: false) }}
                            {{ __($deposit->method_currency) }}</strong>
                    </td>
                    <td>
                        <div>
                            @php echo $deposit->statusBadge @endphp
                        </div>
                    </td>
                    @php
                        $details = [];
                        if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000) {
                            foreach (@$deposit->detail ?? [] as $key => $info) {
                                $details[] = $info;
                                if ($info->type == 'file') {
                                    $details[$key]->value = route(
                                        'user.download.attachment',
                                        encrypt(getFilePath('verify') . '/' . $info->value),
                                    );
                                }
                            }
                        }
                    @endphp

                    <td>
                        @if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000)
                            <a href="javascript:void(0)" class="btn btn--base btn-sm detailBtn"
                                data-info="{{ json_encode($details) }}"
                                @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                <i class="las la-desktop"></i>
                            </a>
                        @else
                            <button type="button" class="btn btn--success btn-sm" data-bs-toggle="tooltip"
                                title="@lang('Automatically processed')">
                                <i class="las la-check"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse

        </tbody>
    </table>
    @if ($deposits->hasPages())
        {{ paginateLinks($deposits) }}
    @endif

    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal custom--modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Details')</h6>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        } else {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center  px-0">
                                <span>${element.name}</span>
                                <span"><a href="${element.value}"><i class="fa-regular fa-file"></i> @lang('Attachment')</a></span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

        })(jQuery);
    </script>
@endpush
