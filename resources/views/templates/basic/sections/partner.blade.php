@php
    $partnerElements = getContent('partner.element', orderById: true);
@endphp
<div class="partner-section bg--section pt-60 pb-60">
    <div class="container">
        <div class="partner-slider owl-theme owl-carousel">
            @foreach ($partnerElements as $partnerElement)
                <div class="partner-thumb">
                    <img src="{{ frontendImage('partner', @$partnerElement->data_values->image, '205x110') }}"
                        alt="partner">
                    <img src="{{ frontendImage('partner', @$partnerElement->data_values->image, '205x110') }}"
                        alt="partner">
                </div>
            @endforeach
        </div>
    </div>
</div>
