@php
    $marketPriceContents = getContent('market_price.content', true);
    $currencies = App\Models\Currency::active()->take(6)->get();
@endphp
<section class="market-price pt-60 pb-60">
    <div class="container">
        <div class="section__header text-center">
            <h4 class="title">{{ __(@$marketPriceContents->data_values->heading) }}</h4>
            <p>{{ __(@$marketPriceContents->data_values->subheading) }}</p>
        </div>
        @include($activeTemplate . 'partials.currency_list', [
            'currencyAll' => $currencies,
            'cssClass' => 'market--table mb-0',
            'src' => 'market_price',
        ])
    </div>
</section>
