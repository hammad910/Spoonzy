<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-bs-theme="{{ auth()->check() && auth()->user()->dark_mode == 'on' ? 'dark' : 'light' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('description_custom')@if (!Request::route()->named('seo') && !Request::route()->named('profile')) {{ trans('seo.description') }} @endif">
    <meta name="keywords" content="@yield('keywords_custom'){{ trans('seo.keywords') }}" />
    <meta name="theme-color" content="{{ config('settings.theme_color_pwa') }}">
    <title>
    {{ auth()->check() && User::notificationsCount() ? '(' . User::notificationsCount() . ') ' : '' }}@section('title')@show
    {{ $settings->title . ' - ' . __('seo.slogan') }}</title>
<!-- Favicon -->
<link href="{{ asset('img', $settings->favicon) }}" rel="icon">
<link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
<link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-pap7XgC9v+ljyFJx0KXzvL6v/Jc1RtaEkIejcXc8H8rK+5tV8rjYwB+J0h7z6a8e0aYZl2R8W2mvNf6qR3+5Vg==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" 
/>

@if ($settings->google_tag_manager_head != '')
    {!! $settings->google_tag_manager_head !!}
@endif

@include('includes.css_general')

@if ($settings->status_pwa)
    @laravelPWA
@endif

@yield('css')

@if ($settings->google_analytics != '')
    {!! $settings->google_analytics !!}
@endif

<style>
    body {
        font-family: 'Onest', sans-serif;
        margin: 0;
        padding: 0;
    }

    .app-layout {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    .main-content-wrapper {
        display: flex;
        flex: 1;
        margin-top: 70px; /* Navbar height */
    }

    .sidebar-left {
        width: 250px;
        flex-shrink: 0;
        background: #fff;
        border-right: 1px solid #ddd;
        position: fixed;
        /* top: 100px; */
        left: 0;
        height: calc(100vh - 70px);
        overflow-y: auto;
        z-index: 100;
        padding: 20px 10px 20px 10px;
    }

    .content-area {
        flex: 1;
        margin-left: 250px; /* Sidebar width */
        min-height: calc(100vh - 70px);
        background-color: #fbfbfb;
    }

    .content-area-full {
        margin-left: 0;
    }

    /* Mobile styles */
    @media (max-width: 1024px) {
        .sidebar-left {
            width: 220px;
        }
        .content-area {
            margin-left: 220px;
        }
    }

    @media (max-width: 990px) {
        .sidebar-left {
            display: none;
        }
        .content-area {
            margin-left: 0;
        }
        .main-content-wrapper {
            margin-top: 60px; /* Adjusted for mobile navbar */
        }
    }

    /* For login/signup pages */
    .auth-pages .main-content-wrapper {
        margin-top: 0;
    }
    .auth-pages .content-area {
        margin-left: 0;
    }
</style>
</head>

<body class="@if(request()->is('login', 'signup', 'password*')) auth-pages @endif">
@if ($settings->google_tag_manager_body != '')
    {!! $settings->google_tag_manager_body !!}
@endif

@if ($settings->disable_banner_cookies == 'off')
    <div class="btn-block text-center showBanner padding-top-10 pb-3 display-none">
        <i class="fa fa-cookie-bite"></i> {{ trans('general.cookies_text') }}
        @if ($settings->link_cookies != '')
            <a href="{{ $settings->link_cookies }}" class="mr-2 text-white link-border"
                target="_blank">{{ trans('general.cookies_policy') }}</a>
        @endif
        <button class="btn btn-sm btn-primary" id="close-banner">{{ trans('general.go_it') }}
        </button>
    </div>
@endif

<div id="mobileMenuOverlay" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
    aria-expanded="false"></div>

@auth
    @if (!request()->is('messages/*') && !request()->is('live/*'))
        @include('includes.menu-mobile')
    @endif
@endauth

@if ($settings->alert_adult == 'on')
    <div class="modal fade" tabindex="-1" id="alertAdult">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <p>{{ __('general.alert_content_adult') }}</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="https://google.com" class="btn e-none p-0 mr-3">{{ trans('general.leave') }}</a>
                    <button type="button" class="btn btn-primary"
                        id="btnAlertAdult">{{ trans('general.i_am_age') }}</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="popout popout-error font-default"></div>

<div class="app-layout">
    @if (
        (auth()->guest() && request()->path() == '/' && $settings->home_style == 0) ||
            (auth()->guest() && request()->path() != '/' && $settings->home_style == 0) ||
            (auth()->guest() && request()->path() != '/' && $settings->home_style == 1) ||
            (auth()->guest() && request()->path() == '/' && $settings->home_style == 2) ||
            (auth()->guest() && request()->path() != '/' && $settings->home_style == 2) ||
            auth()->check())
        @unless (request()->is('login', 'signup', 'password*'))
            @include('includes.navbar')
        @endunless
    @endif

    <div class="main-content-wrapper">
        <!-- LEFT SIDEBAR - Only show on non-auth pages and when user is authenticated -->
        @unless (request()->is('login', 'signup', 'password*'))
            @if (auth()->check() || 
                (auth()->guest() && request()->path() == '/' && $settings->home_style == 0) ||
                (auth()->guest() && request()->path() != '/' && $settings->home_style == 0) ||
                (auth()->guest() && request()->path() != '/' && $settings->home_style == 1) ||
                (auth()->guest() && request()->path() == '/' && $settings->home_style == 2) ||
                (auth()->guest() && request()->path() != '/' && $settings->home_style == 2))
                <div class="sidebar-left d-none d-lg-block">
                    @include('includes.menu-sidebar-home')
                </div>
            @endif
        @endunless

        <!-- MAIN CONTENT AREA -->
        <div class="content-area @if(request()->is('login', 'signup', 'password*') || !auth()->check()) content-area-full @endif">
            <main @if (request()->is('messages/*') || request()->is('live/*')) class="h-100" @endif role="main">
                @yield('content')

                @if (
                    (auth()->guest() &&
                        !request()->route()->named('profile') &&
                        !request()->is(['creators', 'category/*', 'creators/*'])) ||
                        (auth()->check() &&
                            request()->path() != '/' &&
                            !request()->route()->named('profile') &&
                            !request()->is([
                                'my/bookmarks',
                                'my/likes',
                                'my/purchases',
                                'explore',
                                'messages',
                                'messages/*',
                                'creators',
                                'category/*',
                                'creators/*',
                                'live/*',
                            ])))

                    @if (
                        (auth()->guest() && request()->path() == '/' && $settings->home_style == 0) ||
                            (auth()->guest() && request()->path() != '/' && $settings->home_style == 0) ||
                            (auth()->guest() && request()->path() != '/' && $settings->home_style == 1) ||
                            (auth()->guest() && request()->path() != '/' && $settings->home_style == 2) ||
                            auth()->check())
                        {{-- @unless (request()->is('login', 'signup', 'password*'))
                            @if (auth()->guest() && $settings->who_can_see_content == 'users')
                                <div class="text-center py-3 px-3">
                                    @include('includes.footer-tiny')
                                </div>
                            @else
                                @include('includes.footer')
                            @endif
                        @endunless --}}
                    @endif
                @endif

                @guest
                    @if (Helper::showLoginFormModal())
                        @include('includes.modal-login')
                    @endif
                @endguest

                @auth
                    @if ($settings->disable_tips == 'off')
                        @include('includes.modal-tip')
                    @endif

                    @if ($settings->gifts)
                        @include('includes.modal-gifts')
                    @endif

                    @include('includes.modal-payperview')

                    @if ($settings->live_streaming_status == 'on')
                        @include('includes.modal-live-stream')
                    @endif

                    @if ($settings->allow_scheduled_posts)
                        @include('includes.modal-scheduled-posts')
                    @endif

                    @if ($settings->video_call_status)
                        @include('includes.modal-video-call-incoming')
                    @endif

                    @if ($settings->audio_call_status)
                        @include('includes.modal-audio-call-incoming')
                    @endif

                    @if ($settings->allow_vault)
                        @include('includes.modal-vault')
                    @endif
                @endauth

                @guest
                    @include('includes.modal-2fa')
                @endguest
            </main>
        </div>
    </div>
</div>

@include('includes.javascript_general')
@yield('javascript')

@auth
    <div id="bodyContainer"></div>
@endauth
</body>
</html>