@php
    $communityContent = getContent('community.content', true);
@endphp

<section class="comunity-section pt-60 pb-60">
    <div class="container">
        <div class="section__header text-center">
            <h4 class="title">{{ __(@$communityContent->data_values->heading) }}</h4>
            <p>
                {{ __(@$communityContent->data_values->subheading) }}
            </p>
        </div>
        <div class="agent-wrapper">
            <div class="agent-area">
                <img src="{{ frontendImage('community', @$communityContent->data_values->image, '1295x545') }}"
                    alt="banner">
            </div>
            <div class="agent-area">
                <img src="{{ frontendImage('community', @$communityContent->data_values->image, '1295x545') }}"
                    alt="banner">
            </div>
            <div class="agent-area">
                <img src="{{ frontendImage('community', @$communityContent->data_values->image, '1295x545') }} "
                    alt="banner">
            </div>
            <div class="text-center btn-area">
                <a href="{{ url(@$communityContent->data_values->button_link) }}"
                    class="cmn--btn">{{ __(@$communityContent->data_values->button_text) }}</a>
            </div>
        </div>
    </div>
</section>
