  @php
      $infoContent = getContent('app.content', true);
  @endphp

  <section class="app-section pt-60 pb-60">
      <div class="container">
          <div class="row align-items-center justify-content-between gy-5">
              <div class="col-lg-6">
                  <div class="apps-thumb">
                      <img src="{{ frontendImage('app', @$infoContent->data_values->image, '695x350') }}" alt="info">
                  </div>
              </div>
              <div class="col-lg-6 col-xl-5">
                  <div class="app-content">
                      <div class="section__header">
                          <h4 class="title ">{{ __(@$infoContent->data_values->heading) }}</h4>
                          <p>{{ __(@$infoContent->data_values->subheading) }}</p>
                      </div>
                      <div class="app-btn-area">
                          <p>
                              @php
                                  echo @$infoContent->data_values->description;
                              @endphp
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
