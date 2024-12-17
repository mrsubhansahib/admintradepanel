@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-section pt-120 pb-120">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-12">
                    <div class="row g-4 justify-content-center">
                        @foreach ($blogs as $blog)
                            <div class="col-md-4 col-sm-10">
                                <div class="post__item">
                                    <div class="post__thumb">
                                        <a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}">
                                            <img
                                                src="{{ frontendImage('blog', '/thumb_' . @$blog->data_values->image, '430x210') }}">
                                        </a>
                                    </div>
                                    <div class="post__content">
                                        <h6 class="post__title">
                                            <a
                                                href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}">{{ __(@$blog->data_values->title) }}</a>
                                        </h6>
                                        <div class="meta__date">
                                            <div class="meta__item">
                                                <i class="las la-calendar"></i>
                                                {{ showDateTime($blog->created_at, 'Y-m-d') }}
                                            </div>
                                        </div>
                                        <a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}"
                                            class="post__read">@lang('Read More') <i
                                                class="las la-long-arrow-alt-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($blogs->hasPages())
                            {{ paginateLinks($blogs) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
