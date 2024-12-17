@php
    $credentials = $general->socialite_credentials;
@endphp
@if (@$credentials->google->status == Status::ENABLE || @$credentials->facebook->status == Status::ENABLE || @$credentials->linkedin->status == Status::ENABLE)
    <div class="or">
        <span class="bg--section">@lang('Or') </span>
    </div>
    <ul class="social-icons">
        @if (@$credentials->facebook->status == Status::ENABLE)
            <li class="social-list__item">
                <a class="social-list__link flex-center facebook" href="{{ route('user.social.login', 'facebook') }}">
                    <i class="fab fa-facebook"></i>
                </a>
            </li>
        @endif
        @if (@$credentials->google->status == Status::ENABLE)
            <li class="social-list__item">
                <a class="social-list__link flex-center google" href="{{ route('user.social.login', 'google') }}">
                    <i class="fab fa-google"></i>
                </a>
            </li>
        @endif
        @if (@$credentials->linkedin->status == Status::ENABLE)
            <li class="social-list__item">
                <a class="social-list__link flex-center linkedin" href="{{ route('user.social.login', 'linkedin') }}">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </li>
        @endif
    </ul>
@endif
