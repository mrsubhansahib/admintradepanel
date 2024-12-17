@php
    $aboutContent = getContent('about.content', true);
@endphp
<section class="about-section pb-60 pt-60">
    <div class="container">
        <div class="row gy-5 justify-content-between align-items-center">
            <div class="col-lg-6 col-xl-5">
                <div class="about-thumb">
                    <img src="{{ frontendImage('about', @$aboutContent->data_values->image, '525x330') }}"
                        alt="about">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section__header">
                        <h4 class="title">{{ __(@$aboutContent->data_values->heading) }}</h4>
                        <p>{{ __(@$aboutContent->data_values->subheading) }}</p>
                    </div>
                    <div class="text--blue-gray">
                        @php
                            echo @$aboutContent->data_values->description;
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
