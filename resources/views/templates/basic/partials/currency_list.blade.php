<table class="table {{ $cssClass }}">
    <thead>
        <tr>
            <th>@lang('Currency')</th>
            <th>@lang('Last Price')</th>
            <th>@lang('1h Change(%)')</th>
            <th>@lang('24h Change(%)')</th>
            <th>@lang('Marketcop')</th>
            @if ($src == 'index')
                <th>@lang('Action')</th>
            @endif
        </tr>
    </thead>
    <tbody class="border-0">
        @forelse($currencyAll as $currency)
            <tr>
                <td>
                    <div class="crypto-name d-flex gap-2 py-md-2 py-lg-3">
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('cryptoCurrency') . '/' . $currency->image, getFileSize('cryptoCurrency')) }}" alt="currency" class="rounded-circle">
                        </div>
                        <p class="m-0">{{ __($currency->name) }} {{ __($currency->cur_text) }}</p>
                    </div>
                </td>
                <td>
                    <span>{{ showAmount($currency->selling_price_total) }} {{ gs('cur_text') }}</span>
                </td>
                <td>
                    @php
                        $class = $currency->one_hour_change > 0 ? 'text--success' : 'text--danger';
                        $sign = $currency->one_hour_change > 0 ? '+' : '';
                    @endphp
                    <div class="m-cap {{ $class }}">
                        {{ $sign . showAmount($currency->one_hour_change) }}%
                    </div>
                </td>
                <td>
                    @php
                        $class = $currency->twentyfour_hour_change > 0 ? 'text--success' : 'text--danger';
                        $sign = $currency->twentyfour_hour_change > 0 ? '+' : '';
                    @endphp
                    <div class="m-cap {{ $class }}">
                        {{ $sign . showAmount($currency->twentyfour_hour_change) }}%
                    </div>
                </td>
                <td>
                    <div class="m-cap ">
                        {{ showAmount($currency->market_cap) }} {{ gs('cur_text') }}
                    </div>
                </td>

                @if ($src == 'index')
                    <td>
                        <a href="{{ route('user.currency.single', $currency->id) }}" class="btn btn--base table-action-btn">
                            @lang('Buy')
                        </a>
                    </td>
                @endif

            </tr>

        @empty
            <tr>
                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
<!-- Table -->
@if ($src == 'index')
    @if ($currencyAll->hasPages())
        {{ paginateLinks($currencyAll) }}
    @endif
@endif
