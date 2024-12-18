@extends('admin.layouts.app')

@section('panel')
        <div class="row">
            <div class="col-lg-12 col-md-12 mb-30">
                <div class="card">
                    <div class="card-body">
                        <h1>Heelo nifty</h1>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
        <x-back route="{{ route('admin.frontend.index') }}" />
    </div>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/cms/grapes.min.css') }}" rel="stylesheet">

@endpush

@push('script-lib')
    <script src="{{ asset('assets/cms/grapes.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.addBtn').on('click', function() {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $(document).on('click', '.updateBtn', function() {
                var modal = $('#updateBtn');
                modal.find('input[name=id]').val($(this).data('id'));

                var obj = $(this).data('all');
                var images = $(this).data('images');

                var imagePreviews = modal.find('.image-upload-preview');


                if (images) {

                    for (var i = 0; i < images.length; i++) {

                        var imgloc = images[i];
                        $(imagePreviews[i]).css("background-image", "url(" + imgloc + ")");
                    }
                }
                $.each(obj, function(index, value) {
                    modal.find('[name=' + index + ']').val(value);
                });
                modal.modal('show');
            });

            $('#updateBtn').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });
            $('#addModal').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });
            $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                $(this).closest('.form-group').find('.iconpicker-input').val(
                    `<i class="${e.iconpickerValue}"></i>`);
            });
        })(jQuery);
    </script>
@endpush
