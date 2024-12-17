@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            @if ($user->kv == Status::KYC_PENDING)
                @php
                    $kycContent = getContent('kyc.content', true);
                @endphp

                <div class="d-flex justify-content-center align-items-center store-alert-message mb-2">
                    <p class="text--warning mb-0">{{ __(@$kycContent->data_values->pending) }}</p>
                </div>
            @endif
            @if ($user->kyc_data)
                <ul class="list-group list-group-flush">
                    @foreach ($user->kyc_data as $val)
                        @continue(!$val->value)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 px-0">
                            {{ __($val->name) }}
                            <span>
                                @if ($val->type == 'checkbox')
                                    {{ implode(',', $val->value) }}
                                @elseif($val->type == 'file')
                                    <a
                                        href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"><i
                                            class="text--base"></i> <i class="fa fa-file"></i> @lang('Attachment') </a>
                                @else
                                    <p class="mb-0">{{ __($val->value) }}</p>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <h6 class="text-center">@lang('KYC data not found')</h6>
            @endif
        </div>
    </div>
@endsection
