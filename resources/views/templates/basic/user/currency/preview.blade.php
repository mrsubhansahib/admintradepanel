    @extends($activeTemplate . 'layouts.master')
    @section('content')
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card custom--card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ getImage(getFilePath('cryptoCurrency') . '/' . $currency->image, getFileSize('cryptoCurrency')) }}"
                                alt="currency" class="mx-2 cur-img-width rounded-circle">
                            <h6 class="card-title">{{ __($currency->name) }} - {{ __($currency->cur_text) }}</h6>
                        </div>
                        <h6>
                            @lang('Current Rate : '){{ showAmount($currency->selling_price_total, 8) }}
                        </h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('user.currency.store', $currency->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="form--label">@lang('Crypto Amount') </label>
                                <div class="input-group">
                                    <input id="cryptoAmount" type="number" step="any" name="crypto_amount"
                                        value="" class="form-control form--control" min="0" required="">
                                    <span class="input-group-text bg--base">{{ __($currency->cur_text) }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form--label">@lang('Paid Amount')</label>
                                <div class="input-group ">
                                    <input id="paidAmount" type="number" step="any" name="paid_amount" value=""
                                        class="form-control form--control" min="0" required="">
                                    <span class="input-group-text bg--base">{{ __(gs('cur_text')) }}</span>
                                </div>
                            </div>
                            <button type="submit" class="cmn--btn btn--lg w-100">@lang('Submit') </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script>
            (function($) {
                "use strict";

                let cryptoInput = $('[name=crypto_amount]');
                let paidInput = $('[name=paid_amount]');
                let cryptoAmount = 0;
                let paidAmount = 0;

                cryptoInput.on('input', function() {
                    cryptoAmount = Number($(this).val());
                    if (cryptoAmount <= 0) {
                        cryptoInput.val(0);
                        paidInput.val(0);
                        return false;
                    }
                    var resource = @json($currency);
                    var sellingPrice = Number(resource.selling_price_total);
                    paidAmount = parseFloat(sellingPrice * cryptoAmount).toFixed(8);
                    paidInput.val(paidAmount);
                });

                paidInput.on('input', function() {
                    paidAmount = parseFloat($(this).val());
                    if (paidAmount <= 0) {
                        cryptoInput.val(0);
                        paidInput.val(0);
                        return false;
                    }

                    var resource = @json($currency);
                    var sellingPrice = Number(resource.selling_price_total);
                    cryptoAmount = parseFloat(paidAmount / sellingPrice).toFixed(8);
                    cryptoInput.val(cryptoAmount);
                })

            })(jQuery);
        </script>
    @endpush
