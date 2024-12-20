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

            // BlockManager Reference
            const blockManager = editor.BlockManager;

            // Adding custom blocks with improvements

            // Responsive Text Block
            blockManager.add('responsive-text-block', {
                label: 'Responsive Text',
                content: `<div style="padding:10px; text-align:center;">
                        <p style="font-size:1rem;">Insert your responsive text here</p>
                      </div>`,
                category: 'Basic',
            });

            // Responsive Image Block
            blockManager.add('responsive-image-block', {
                label: 'Responsive Image',
                content: `<img src="https://via.placeholder.com/300" alt="Placeholder Image" style="width:100%; height:auto;" />`,
                category: 'Media',
            });

            // Button Block with Customizable Styles
            blockManager.add('styled-button-block', {
                label: 'Styled Button',
                content: `<button style="padding:10px 20px; background-color:var(--btn-bg-color, blue); color:var(--btn-text-color, white); border:none; border-radius:5px;">
                        Click Me
                      </button>`,
                category: 'Basic',
            });

            // Responsive Banner Block
            blockManager.add('responsive-banner-block', {
                label: 'Responsive Banner',
                content: `<section style="padding:30px; background-color:var(--banner-bg, lightgray); text-align:center; font-size:1.5rem;">
                        Banner Content
                      </section>`,
                category: 'Sections',
            });

            // Flex Grid Design Block
            blockManager.add('flex-grid-block', {
                label: 'Flex Grid',
                content: `<div style="display:flex; flex-wrap:wrap; gap:10px; padding:10px;">
                        <div style="flex:1 1 calc(33.333% - 10px); background-color:#f4f4f4; padding:20px; box-sizing:border-box;">
                            <p>Column 1</p>
                        </div>
                        <div style="flex:1 1 calc(33.333% - 10px); background-color:#e9e9e9; padding:20px; box-sizing:border-box;">
                            <p>Column 2</p>
                        </div>
                        <div style="flex:1 1 calc(33.333% - 10px); background-color:#dedede; padding:20px; box-sizing:border-box;">
                            <p>Column 3</p>
                        </div>
                      </div>`,
                category: 'Layout',
            });

            // Dark Mode Compatible Hero Section
            blockManager.add('hero-block', {
                label: 'Hero Section',
                content: `<section style="padding:50px; background-color:var(--hero-bg, #333); color:var(--hero-text-color, white); text-align:center;">
                        <h1>Hero Title</h1>
                        <p>Hero Subtitle</p>
                        <button style="padding:10px 20px; background-color:var(--btn-bg, white); color:var(--btn-color, #333); border:none; border-radius:5px;">
                            Learn More
                        </button>
                      </section>`,
                category: 'Sections',
            });

            // Token Sale Countdown Block
            blockManager.add('token-countdown-block', {
                label: 'Token Sale Countdown',
                content: `<section style="padding:20px; background-color:var(--countdown-bg, #333); color:var(--countdown-text-color, white); text-align:center;">
                        <h2>Token Sale Ends In</h2>
                        <p style="font-size:24px; font-weight:bold;">10 Days, 5 Hours, 30 Minutes</p>
                      </section>`,
                category: 'Crypto',
            });

            // Partners Section Block
            blockManager.add('partners-block', {
                label: 'Partners',
                content: `<div style="display:flex; justify-content:space-between; padding:20px;">
                        <img src="https://via.placeholder.com/100" alt="Partner 1">
                        <img src="https://via.placeholder.com/100" alt="Partner 2">
                        <img src="https://via.placeholder.com/100" alt="Partner 3">
                      </div>`,
                category: 'Sections',
            });

            // Newsletter Signup Block
            blockManager.add('newsletter-block', {
                label: 'Newsletter Signup',
                content: `<form style="padding:20px; background-color:var(--form-bg, #f9f9f9); text-align:center;">
                        <p>Subscribe to get updates:</p>
                        <input type="email" placeholder="Enter your email" style="padding:10px; width:80%; margin-bottom:10px; border:1px solid #ccc;">
                        <button type="submit" style="padding:10px 20px; background-color:var(--btn-bg, #007bff); color:var(--btn-text-color, white); border:none;">
                            Subscribe
                        </button>
                      </form>`,
                category: 'Forms',
            });

            // Dark Mode Toggle (Optional Implementation)
            const toggleDarkMode = () => {
                document.documentElement.style.setProperty('--hero-bg', '#fff');
                document.documentElement.style.setProperty('--hero-text-color', '#000');
            };

            // Call the toggleDarkMode function for testing
            // toggleDarkMode();

        })(jQuery);
    </script>
@endpush
