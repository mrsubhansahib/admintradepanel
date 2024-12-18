@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body p-0">
                    <!-- GrapesJS Editor Container -->
                    <div id="gjs" style="height: 500px; border: 1px solid #ddd;"></div>
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

            // Initialize GrapesJS
            const editor = grapesjs.init({
                container: '#gjs', // Target container for the editor
                height: '500px', // Editor height
                width: 'auto', // Editor width (responsive)
                fromElement: true, // Use the existing HTML as content
                storageManager: {
                    type: 'local', // Save data locally for testing
                    autosave: true,
                    autoload: true,
                },
                plugins: ['gjs-blocks-basic'], // Basic blocks plugin
                pluginsOpts: {
                    'gjs-blocks-basic': {}, // Plugin options if needed
                },
                blockManager: {
                    appendTo: '#blocks', // Optional: Create a custom block panel
                },
            });

            // Optional: Adding custom blocks
            editor.BlockManager.add('test-block', {
                label: 'Test Block',
                content: '<div style="padding:20px; background-color: #eee;">Test Block Content</div>',
                category: 'Basic',
            });
        })(jQuery);
    </script>
@endpush
