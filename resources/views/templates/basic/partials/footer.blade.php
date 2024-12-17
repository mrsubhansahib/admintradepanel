@php
    $socialLinksElements = getContent('social_icon.element', orderById: true);
    $contactInfoContent = getContent('contact_us.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp
<!-- Footer Section -->
<footer>
    <div class="footer-top">
        <div class="container">
            <div class="footer-wrapper justify-content-between">
                <div class="footer-widget">
                    <div class="logo me-lg-4 mb-4">
                        <a href="{{ route('home') }}">
                            <img class="w-75" src="{{ siteLogo() }}" alt="logo">
                        </a>
                    </div>
                    <p>
                        {{ __(@$contactInfoContent->data_values->short_details) }}
                    </p>
                </div>
                <div class="footer-widget">
                    <h6 class="title">@lang('Quick Link') </h6>

                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('home') }}"> @lang('Home')</a>
                        </li>
                        <li>
                            <a href="{{ route('blog') }}"> @lang('Blog')</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}"> @lang('Contact')</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h6 class="title"> @lang('Policy Pages')</h6>
                    <ul class="footer-links">
                        @foreach ($policyPages as $policy)
                            <li>
                                <a
                                    href="{{ route('policy.pages', $policy->slug) }}">{{ __(@$policy->data_values->title) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-widget widget-social">
                    <h6 class="title">@lang('Contact')</h6>
                    <ul class="my-4">
                        <p class="mt-3">
                            <i class="fa fa-map-marker-alt me-3"> </i>
                            {{ __(@$contactInfoContent->data_values->address) }}
                        </p>
                        <p class="mb-3">
                            <i class="fa fa-phone-alt me-3"> </i>
                            {{ @$contactInfoContent->data_values->contact_number }}
                        </p>
                        <p class="mb-3">
                            <i class="fa fa-envelope me-3"> </i> {{ @$contactInfoContent->data_values->email_address }}
                        </p>
                    </ul>
                    <ul class="footer-social">
                        @foreach ($socialLinksElements as $socialLinksElement)
                            <li>
                                <a href=" {{ @$socialLinksElement->data_values->url }}" target="_blank">
                                    @php
                                        echo @$socialLinksElement->data_values->social_icon;
                                    @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg--section">
        <div class="container">
            <div class="py-4 text-center">
                @lang('Copyright') &copy; {{ date('Y') }} <a href="{{ route('home') }}"
                    class="text--base">{{ __(gs('site_name')) }}</a> @lang('All Right Reserved.')
            </div>
        </div>
    </div>
</footer>
