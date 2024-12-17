@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name | Code')</th>
                                    <th>@lang('Symbol')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Selling Price(%)')</th>
                                    <th>@lang('Selling Price')</th>
                                    <th>@lang('1h% Change')</th>
                                    <th>@lang('24h% Change')</th>
                                    <th>@lang('Marketcop')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cryptocurrencies as $cryptocurrency)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ __($cryptocurrency->name) }}</span>
                                            <br>
                                            <span>
                                                {{ __($cryptocurrency->cur_text) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $cryptocurrency->cur_sym }}</span>
                                        </td>
                                        <td>
                                            <span>{{ showAmount($cryptocurrency->rate, currencyFormat: false) }} </span>
                                            <span>{{ __(gs('cur_text')) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ showAmount($cryptocurrency->selling_price, currencyFormat: false) }}%</span>
                                        </td>
                                        <td>
                                            <span>{{ showAmount($cryptocurrency->selling_price_total) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ showAmount($cryptocurrency->one_hour_change, currencyFormat: false) }}%</span>
                                        </td>
                                        <td>
                                            <span>{{ showAmount($cryptocurrency->twentyfour_hour_change, currencyFormat: false) }}%</span>
                                        </td>
                                        <td>
                                            <span>{{ showAmount($cryptocurrency->market_cap) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                echo $cryptocurrency->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                @php
                                                    $cryptocurrency->image_with_path = getImage(
                                                        getFilePath('cryptoCurrency') . '/' . $cryptocurrency->image,
                                                        getFileSize('cryptoCurrency'),
                                                    );
                                                @endphp
                                                <button class="btn btn-outline--primary btn-sm cuModalBtn"
                                                    data-modal_title="@lang('Update Crypto Currency')"
                                                    data-resource="{{ $cryptocurrency }}">
                                                    <i class="las la-pen"></i>
                                                    @lang('Edit')
                                                </button>

                                                @if ($cryptocurrency->status == Status::DISABLE)
                                                    <button class="btn btn-outline--success btn-sm confirmationBtn"
                                                        data-action="{{ route('admin.cryptocurrency.status', $cryptocurrency->id) }}"
                                                        data-question="@lang('Are you sure to enable this currency?')" type="button">
                                                        <i class="la la-eye"></i>
                                                        @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-outline--danger btn-sm confirmationBtn"
                                                        data-action="{{ route('admin.cryptocurrency.status', $cryptocurrency->id) }}"
                                                        data-question="@lang('Are you sure to disable this currency?')" type="button">
                                                        <i class="la la-eye-slash"></i>
                                                        @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                @if ($cryptocurrencies->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($cryptocurrencies) }}
                    </div>
                @endif

            </div><!-- card end -->
        </div>
    </div>

    <x-confirmation-modal />

    <!-- Add Crypto Currency Api Key -->
    <div class="modal fade" id="apiModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="apiKey" action="{{ route('admin.cryptocurrency.api.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>@lang('Crypto Currency API')</label>
                            <input class="form-control" name="crypto_currency_api" type="text" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Crypto Currency Api Key -->
    <div class="modal fade" id="apiModalHelp" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">1. @lang('Go to the CoinMarketCap website') <a href="https://coinmarketcap.com/api"
                                target="_blank">@lang('https://coinmarketcap.com/api')</a></li>
                        <li class="list-group-item px-0">2. @lang('Signup this platform or login existing account') </li>
                        <li class="list-group-item px-0">3. @lang('After logging into your CoinMarketCap account, Choose an API Plan') </li>
                        <li class="list-group-item px-0">4. @lang('Generate an API Key') </li>
                        <li class="list-group-item px-0">5. @lang('Copy API key & configure here') </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.cryptocurrency.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Symbol')</label>
                            <input class="form-control" name="cur_sym" type="text" value="{{ old('cur_sym') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Code')</label>
                            <input class="form-control" name="cur_text" type="text" value="{{ old('cur_text') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Additional Price(%)')</label>
                            <div class="input-group">
                                <input class="form-control" name="selling_price" type="number"
                                    value="{{ old('selling_price') }}" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <x-image-uploader class="w-100" type="cryptoCurrency" :required=false />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary currencyAPI" data-modal_title="@lang('Add Api Key')"
        data-crypto_currency_api="{{ gs('crypto_currency_api') }}">
        <i class="las la-key"></i> @lang('Currency Api Key')
    </button>
    <button class="btn btn-outline--dark currencyAPIHelp" data-modal_title="@lang('Coinmarketcap api key setting instruction')">
        <i class="la la-question"></i> @lang('Help')
    </button>
    <button type="button" class="btn btn-outline--primary cuModalBtn addBtn" data-modal_title="@lang('Add Crypto Currency')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
    <x-search-form placeholder="Currency Name / Code" />
@endpush



@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";
            var apiModal = $("#apiModal");

            $(".currencyAPI").on('click', function() {
                let data = $(this).data();
                let cryptoCurrencyApi = data.crypto_currency_api ?? null;
                apiModal.find(".modal-title").text(`${data.modal_title}`);
                apiModal.find("[name='crypto_currency_api']").val(cryptoCurrencyApi);
                apiModal.modal("show");
            })

            var apiModalHelp = $("#apiModalHelp");
            $(".currencyAPIHelp").on('click', function() {
                let data = $(this).data();
                apiModalHelp.find(".modal-title").text(`${data.modal_title}`);
                apiModalHelp.modal("show");
            })

            $(".addBtn").on('click', function() {
                $("#cuModal").find('form').trigger('reset');
                $("#cuModal").find(".image-upload-preview").css("background-image",
                    `url({{ getImage(null, getFileSize('cryptoCurrency')) }})`);
            })
        })(jQuery);
    </script>
@endpush
