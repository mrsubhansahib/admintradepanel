@php
    $blogContent = getContent('blog.content', true);
    $blogElements = getContent('blog.element', limit: 3, orderById: true);
@endphp
<section class="blog-section pt-60 pb-60">
    <div class="container">
        <div class="section__header text-center">
            <h4 class="title">{{ __(@$blogContent->data_values->heading) }}</h4>
            <p>{{ __(@$blogContent->data_values->subheading) }}</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($blogElements as $blogElement)
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="post__item">
                        <div class="post__thumb">
                            <a
                                href="{{ route('blog.details', [slug(@$blogElement->data_values->title), $blogElement->id]) }}">
                                <img src="{{ frontendImage('blog', '/thumb_' . @$blogElement->data_values->image, '430x210') }}"
                                    alt="blog">
                            </a>
                        </div>
                        <div class="post__content">
                            <h6 class="post__title">
                                <a
                                    href="{{ route('blog.details', [slug(@$blogElement->data_values->title), $blogElement->id]) }}">{{ __(@$blogElement->data_values->title) }}</a>
                            </h6>
                            <div class="meta__date">
                                <div class="meta__item">
                                    <i class="las la-calendar"></i>
                                    {{ showDateTime($blogElement->created_at, 'Y-m-d') }}
                                </div>
                            </div>
                            <a href="{{ route('blog.details', [slug(@$blogElement->data_values->title), $blogElement->id]) }}"
                                class="post__read">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Blog Section -->
