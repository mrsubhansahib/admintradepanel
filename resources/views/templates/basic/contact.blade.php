@php
    $contact_infoContent = getContent('contact_us.content', true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- Contact Section -->
    <section class="contact-section pt-120 pb-60">
        <div class="container">
            <div class="d-flex flex-wrap align-items-start">
                <div class="contact__wrapper__1 bg--section">
                    <div class="section__header mb-0">
                        <h4 class="title">@lang('Send Us Message Now')</h4>
                        <div class="section__shape">
                            <div class="progress-bar progress-bar-striped bg--base progress-bar-animated w-100"></div>
                        </div>
                    </div>
                    <form method="post" action="{{ route('contact') }}" class="contact-form verify-gcaptcha">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fname" class="form--label">@lang('Name')</label>
                                    <input name="name" type="text" class="form-control form--control"
                                        value="{{ old('name', @$user->fullname) }}"
                                        @if ($user && $user->profile_complete) readonly @endif required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="lname" class="form--label">@lang('Email')</label>
                                    <input name="email" type="email" class="form-control form--control"
                                        value="{{ old('email', @$user->email) }}"
                                        @if ($user) readonly @endif required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="subject" class="form--label">@lang('Subject')</label>
                                    <input name="subject" type="text" class="form-control form--control"
                                        value="{{ old('subject') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message" class="form--label">@lang('Message')</label>
                                    <textarea name="message" wrap="off" class="form-control form--control" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <x-captcha />
                        </div>
                        <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>
                    </form>
                </div>
                <div class="contact__wrapper__2">
                    <div class="contact__wrapper__2_inner bg--section p-4">
                        <div class="maps rounded">
                            <iframe src="{{ @$contact_infoContent->data_values->map_url }}" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-60 pb-120">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item bg--section">
                        <div class="contact__icon">
                            <i class="las la-phone"></i>
                        </div>
                        <div class="contact__body">
                            <h6 class="contact__title">@lang('Phone') </h6>
                            <ul class="contact__info">
                                <li>
                                    <a href="tel:{{ @$contact_infoContent->data_values->contact_number }}">{{ @$contact_infoContent->data_values->contact_number }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item bg--section">
                        <div class="contact__icon">
                            <i class="las la-envelope"></i>
                        </div>
                        <div class="contact__body">
                            <h6 class="contact__title"> @lang('Email') </h6>
                            <ul class="contact__info">
                                <li>
                                    <a
                                        href="mailto:{{ @$contact_infoContent->data_values->email_address }}">{{ @$contact_infoContent->data_values->email_address }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item bg--section">
                        <div class="contact__icon">
                            <i class="las la-map-marker"></i>
                        </div>
                        <div class="contact__body">
                            <h6 class="contact__title">@lang('Address') </h6>
                            <ul class="contact__info text--base">
                                <li>
                                    {{ __(@$contact_infoContent->data_values->address) }}
                                </li>
                            </ul>
                        </div>
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

@push('style')
    <style>
        .contact-section {
            overflow-x: hidden;
        }
    </style>
@endpush
