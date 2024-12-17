<div class="header-bottom">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo me-lg-4">
                <a href="{{ route('home') }}">
                    <img class="w-75" src="{{ siteLogo() }}" alt="logo">
                </a>
            </div>
            <div class="menu-area">
                <div class="menu-close position-static">
                    <i class="las la-times"></i>
                </div>
                <ul class="menu">
                    <li><a href="{{ route('home') }}" class="{{ menuActive('home') }}">@lang('Home')</a></li>
                    @php
                        $pages = App\Models\Page::where('tempname', $activeTemplate)
                            ->where('is_default', Status::NO)
                            ->get();
                    @endphp
                    @foreach ($pages as $k => $data)
                        <li>
                            <a href="{{ route('pages', [$data->slug]) }}"
                                class="nav-link  @if ($data->slug == Request::segment(1)) active @endif">{{ __($data->name) }}</a>
                        </li>
                    @endforeach
                    <li><a href="{{ route('blog') }}"
                            class="{{ menuActive(['blog', 'blog.details']) }}">@lang('Blog')</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ menuActive('contact') }}">@lang('Contact Us')</a></li>

                    <div class="change-language d-md-none mt-4 justify-content-center">
                        @include($activeTemplate . 'partials.login')
                    </div>
                </ul>
            </div>

            <div class="change-language ms-auto me-3 me-lg-0">
                @include($activeTemplate . 'partials.login', ['class' => 'd-none d-sm-block'])
            </div>
            <div class="header-bar d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</div>
