@props(['class' => ''])
@guest
    <div class="sign-in-up {{ $class }}">
        <span><i class="fas la-user"></i></span>
        <a href="{{ route('user.login') }}"> @lang('Login') </a>
        <a href="{{ route('user.register') }}"> @lang('Register') </a>
    </div>
@else
    <div class="sign-in-up {{ $class }}">
        <span><i class="fas la-home font-size--18px"></i></span>
        <a href="{{ route('user.home') }}">@lang('Dashboard') </a>
        <span><i class="fas la-sign-out-alt font-size--18px"></i></span>
        <a href="{{ route('user.logout') }}">@lang('Logout') </a>

    </div>
@endguest

@if (gs('multi_language'))
    @php
        $language = App\Models\Language::all();
        $selectedLang = $language->where('code', session('lang'))->first();
    @endphp
    <div class="dropdown-lang dropdown mt-0 d-block">
        <a href="#" class="language-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img class="flag"
                src="{{ getImage(getFilePath('language') . '/' . @$selectedLang->image, getFileSize('language')) }}"
                alt="us">
            <span class="language-text text-white">{{ @$selectedLang->name }}</span>
        </a>
        <ul class="dropdown-menu">
            @foreach ($language as $lang)
                <li><a href="{{ route('lang', $lang->code) }}">
                        <img class="flag"
                            src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}"
                            alt="@lang('image')">
                        {{ @$lang->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
