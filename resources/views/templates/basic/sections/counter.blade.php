@php
    $counterElements = getContent('counter.element', orderById: true);
@endphp

<div class="counter-section pt-60 pb-60">
    <div class="container">
        <div class="row justify-content-center g-4">
            @foreach ($counterElements as $counterElement)
                <div class="col-lg-3 col-sm-6">
                    <div class="counter-item">
                        <div class="counter-header">
                            <h3 class="title rafcounter" data-counter-end="{{ getAmount(@$counterElement->data_values->counter_digit) }}">00</h3>
                            <h3 class="title">{{ __(@$counterElement->data_values->title) }}</h3>
                        </div>
                        <div class="counter-content">
                            {{ __(@$counterElement->data_values->sub_title) }}
                        </div>
                        <div class="icon">
                            @php
                                echo @$counterElement->data_values->counter_icon;
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/rafcounter.min.js') }}"></script>
@endpush
