@php
    $ctaContent = getContent('cta.content', true);
@endphp

<section class="cta-section pt-60 pb-60 bg--section">
    <div class="container">
        <div class="cta-wrapper">
            <div class="section__header text-center mb-0">
                <h4 class="title mt-0">{{ __(@$ctaContent->data_values->heading) }}</h4>
                <p>{{ __(@$ctaContent->data_values->subheading) }}</p>
                <div class="mt-4 pt-3 btn__grp">
                    <a href="{{ url(@$ctaContent->data_values->button_link_one) }}" class="cmn--btn">{{ __(@$ctaContent->data_values->button_text_one) }}</a>
                    <a href="{{ url(@$ctaContent->data_values->button_link_two) }}" class="cmn--btn">{{ __(@$ctaContent->data_values->button_text_two) }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
