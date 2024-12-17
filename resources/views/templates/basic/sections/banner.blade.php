@php
    $bannerContent = getContent('banner.content', true);
    $currencies = App\Models\Currency::active()->latest()->take(10)->get();
@endphp
<section class="banner-section"
    style="background: url({{ frontendImage('banner', @$bannerContent->data_values->banner_image, '1920x1080') }}) #0d162e no-repeat center center">
    <div class="container">
        <div class="banner-content">
            <h2 class="title">{{ __(@$bannerContent->data_values->heading) }}</h2>
            <p>
                {{ __(@$bannerContent->data_values->subheading) }}
            </p>
            <a href="{{ url(@$bannerContent->data_values->button_link) }}"
                class="cmn--btn">{{ __(@$bannerContent->data_values->button_name) }}</a>
        </div>
        @if (!blank($currencies))
            <div class="banner-slider-wrapper">
                <div class="crpto-slider owl-carousel owl-theme">
                    @foreach ($currencies as $currency)
                        <div class="slide-item">
                            <div class="crp__item">
                                <div class="crp__top">
                                    <div class="thumb">
                                        <img src="{{ getImage(getFilePath('cryptoCurrency') . '/' . $currency->image, getFileSize('cryptoCurrency')) }}"
                                            alt="currency" class="rounded-circle">
                                    </div>
                                    <div class="buy-trade">
                                        <a href="{{ route('user.currency.all') }}">@lang('Buy') </a>
                                        <a href="{{ route('user.wallet.all') }}">@lang('Trade') </a>
                                    </div>
                                </div>
                                <h6 class="subtitle">{{ __($currency->name) }} {{ __($currency->cur_text) }}</h6>
                                <span class="price">{{ showAmount($currency->selling_price_total) }} </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
