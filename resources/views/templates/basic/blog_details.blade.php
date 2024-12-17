@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-section pt-120 pb-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="post__details pb-50">
                        <div class="post__thumb">
                            <img src="{{ frontendImage('blog', @$blog->data_values->image, '860x420') }}" alt="blog">
                        </div>
                        <div class="meta__date">
                            <div class="meta__item">
                                <i class="las la-calendar"></i> {{ showDateTime($blog->created_at) }}
                            </div>
                        </div>
                        <p>
                            @php
                                echo @$blog->data_values->description;
                            @endphp
                        </p>
                    </div>
                    <div class="mt-4 d-flex align-items-center flex-wrap gap-2">
                        <h6 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h6>
                        <ul class="footer-social">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    class="social-list__link flex-center"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li><a href="https://twitter.com/intent/tweet?text={{ __(@$blog->data_values->title) }}%0A{{ url()->current() }}"
                                    class="social-list__link flex-center"> <i class="fab fa-twitter"></i></a>
                            </li>
                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __(@$blog->data_values->title) }}&amp;summary={{ __(@$blog->data_values->description) }}"
                                    class="social-list__link flex-center"> <i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li><a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __(@$blog->data_values->title) }}&media={{ frontendImage('blog', @$blog->data_values->image, '970x490') }}"
                                    class="social-list__link flex-center"> <i class="fab fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                    <div class="fb-comments"
                        data-href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}"
                        data-numposts="5"></div>
                </div>
                <div class="col-lg-4 ps-xl-5">
                    <div class="widget widget__post__area">
                        <h6 class="widget__title">@lang('Recent Post')</h6>
                        <ul>
                            @foreach ($latestBlogs as $latestBlog)
                                <li>
                                    <a href="{{ route('blog.details', [slug($latestBlog->data_values->title), $latestBlog->id]) }}"
                                        class="widget__post">
                                        <div class="widget__post__thumb">
                                            <img src="{{ frontendImage('blog', 'thumb_' . @$latestBlog->data_values->image, '430x210') }}"
                                                alt="blog">
                                        </div>
                                        <div class="widget__post__content">
                                            <h6 class="widget__post__title">{{ __(@$latestBlog->data_values->title) }}</h6>
                                            <span>{{ showDateTime($latestBlog->created_at, 'Y-m-d') }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
