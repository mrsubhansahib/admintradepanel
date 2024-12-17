@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', orderById: true);
@endphp
<section class="clients-section pt-60 pb-60">
    <div class="container">
        <div class="section__header text-center">
            <h4 class="title">{{ __(@$testimonialContent->data_values->heading) }}</h4>
            <p>{{ __(@$testimonialContent->data_values->subheading) }}</p>
        </div>
        <div class="testimonial-slider owl-theme owl-carousel">
            @foreach ($testimonialElements as $testimonialElement)
                <div class="testimonial-item">
                    <div class="testimonial-thumb">
                        <img src="{{ frontendImage('testimonial', @$testimonialElement->data_values->client_image, '120x120') }}"
                            alt="client">
                        <span class="shape"></span>
                    </div>
                    <div class="testimonial-content">
                        <h6 class="title text--base">{{ __(@$testimonialElement->data_values->name) }}</h6>
                        <span>{{ __(@$testimonialElement->data_values->profession) }}</span>
                        <p>{{ __(@$testimonialElement->data_values->comment) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
