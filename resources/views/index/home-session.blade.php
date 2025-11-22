@extends('layouts.app')

<style>
    .health-widget {
        max-width: 320px;
        background: #fff;
    }

    .health-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(rgba(90, 156, 255, 0.2),
                rgba(146, 83, 255, 0.25),
                rgba(255, 255, 255, 0.3));
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        position: relative;
        color: #000;
    }

    .health-score {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .progress-sm {
        height: 4px !important;
        border-radius: 10px;
        background-color: #f1f1f1;
    }

    .badge.bg-success-subtle {
        background-color: #e7f6ec !important;
    }

    .log-btn {
        background: #4a8cff;
        border: none;
        transition: 0.2s ease;
    }

    .log-btn:hover {
        background: #3972e5;
    }

    .experiment-item {
        transition: all 0.2s ease-in-out;
        flex-wrap: nowrap !important;
    }

    .experiment-item:hover {
        transform: translateY(-2px);
    }

    /* FIXED SIDEBAR STYLES */
    .sidebar-container {
        height: 100vh;
        width: 20%;
        border-right: 1px solid #ddd;
        padding: 20px;
        flex-shrink: 0;
        overflow-y: auto;
    }

    .main-content {
        flex: 1;
        padding: 20px;
        background-color: #fbfbfb;
        min-width: 0;
    }

    .right-sidebar {
        width: 25%;
        padding: 20px;
        background-color: #fbfbfb;
        flex-shrink: 0;
    }

    .btn {
        padding: 5px 1.25rem;
    }

    .bg-right {
        border: 1px solid #00000008;
        border-radius: 10px;
    }

    /* Mobile Cards - Show only on mobile (< 576px) */
    .mobile-cards-container {
        display: none;
    }

    /* Desktop/Large screens - Show right sidebar */
    @media (min-width: 992px) {
        .right-sidebar {
            display: block !important;
        }
    }

    /* Tablet screens (576px - 991px) - Hide both mobile cards and right sidebar */
    @media (min-width: 576px) and (max-width: 991px) {
        .right-sidebar {
            display: none !important;
        }
        .mobile-cards-container {
            display: none !important;
        }
    }

    /* Mobile screens (< 576px) - Show mobile cards, hide right sidebar */
    @media (max-width: 575px) {
        .mobile-cards-container {
            display: block !important;
            margin-bottom: 20px;
        }

        .right-sidebar {
            display: none !important;
        }

        .sidebar-container {
            display: none !important;
        }

        .experiment-item {
            flex-wrap: wrap;
        }

        .experiment-item button {
            margin-left: auto;
            margin-top: 0 !important;
        }

        .mood-widget-2 {
            width: 100%;
            aspect-ratio: 1/1;
            max-width: 320px;
            margin: auto;
        }

        .center-text-2 {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .score {
            font-size: 65px;
            font-weight: 500;
            color: #469DFA;
            line-height: 39.87px;
            margin-top: 22px;
        }

        .mood-text {
            font-size: 18px;
            font-weight: 500;
            color: #8E99AA;
            line-height: 100%;
        }
    }
</style>

@section('content')
    <section class="section section-sm">
        <div class="container pt-lg-0 pt-2 max-w-100" style="max-width: 100%">
            <div class="row justify-content-center" style="flex-wrap: nowrap !important; margin-top: 30px;">

                <!-- MAIN CONTENT - FLEXIBLE WIDTH -->
                <div class="main-content col-md-7 wrap-post">
                    
                    <!-- MOBILE CARDS - Only visible on mobile (< 576px) -->
                    <div class="mobile-cards-container">
                        <!-- Your Health Today Card - Mobile -->
                        <div class="panel panel-default panel-transparent mb-4">
                            <div class="panel-body">
                                <div class="shadow-sm border-0 rounded-4">
                                    <div class="card-body" style="padding: 16px; background: #fff; border-radius: 12px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mt-2 fw-semibold"
                                                style="color: #101828; font-size: 18px; font-weight: 600 !important; display: flex; gap: 12px;">
                                                <img src="/images/health-vector.png" alt="" class="me-2 img-fluid"
                                                    style="width: 24px;">
                                                Your Health Today
                                            </h6>
                                        </div>

                                        <!-- Circular Score + Emotional Stats -->
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="mood-widget-2 position-relative d-flex justify-content-center align-items-center"
                                                style="overflow:hidden;">
                                                <img src="/svg/AIsphere.svg" alt="Health Widget"
                                                    style="object-fit:cover; height: auto; max-width: 110%;">

                                                <!-- Centered content -->
                                                <div class="center-text-2 position-absolute text-center">
                                                    <div class="score">99</div>
                                                    <div class="mood-text">Excellent</div>
                                                </div>
                                            </div>

                                            <!-- Emotional Stats -->
                                            <div class="w-100 px-3 mt-3">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between" style="flex-direction: column;">
                                                        <span style="font-weight: 600;color: #101828;font-size: 14px;margin-bottom: 2px;">Happiness</span>
                                                        <span class="small" style="font-weight: 600; color: #CF73FF; margin-bottom: 4px;">24 Days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-2" style="height: 4px;">
                                                        <div class="progress-bar" style="width: 90%; background: #CF73FF"></div>
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-2" style="flex-direction: column;">
                                                        <span style="font-weight: 600;color: #101828;font-size: 14px; margin-bottom: 2px;">Excitement</span>
                                                        <span class="text-primary small" style="font-weight: 600; margin-bottom: 4px;">12 Days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-2" style="height: 4px;">
                                                        <div class="progress-bar bg-primary" style="width: 60%;"></div>
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-2" style="flex-direction: column;">
                                                        <span style="font-weight: 600;color: #101828;font-size: 14px; margin-bottom: 2px;">Sadness</span>
                                                        <span class="text-danger small" style="font-weight: 600; margin-bottom: 4px;">2 Days</span>
                                                    </div>
                                                    <div class="progress progress-sm" style="height: 4px;">
                                                        <div class="progress-bar bg-danger" style="width: 15%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Supplements -->
                                        <div class="d-flex gap-4 align-items-center justify-content-between px-3 py-3 mb-1 mt-1 bg-right">
                                            <span class="text-muted small d-flex align-items-center" style="gap: 4px;">
                                                <img src="/images/suppliment-icon.png" alt="">
                                                <span style="color: #000; font-weight: 500; font-size: 16px">Suppliments</span>
                                            </span>
                                            <span class="badge px-3 py-1 rounded-pill" style="color: #0FB243; background: #A5FFCE; font-weight: 500;">Taken</span>
                                        </div>

                                        <!-- Bristol Scale -->
                                        <div class="d-flex align-items-center justify-content-between px-3 py-3 mb-1 bg-right">
                                            <span class="text-muted small d-flex align-items-center" style="gap: 4px;">
                                                <img src="/images/bristol-icon.png" alt="">
                                                <span style="color: #000; font-weight: 500; font-size: 16px">Bristol Scale</span>
                                            </span>
                                            <span class="badge px-3 py-1 rounded-pill" style="color: #0FB243; background: #A5FFCE; font-weight: 500;">Type 4</span>
                                        </div>

                                        <!-- Button -->
                                        <div class="text-center">
                                            <button class="btn btn-primary w-100 rounded-3 fw-semibold log-btn d-flex justify-content-center align-items-center" style="gap: 8px;">
                                                <img src="/images/pencil.png" alt="" style="width: 13px; height: 15px;">
                                                Log Today's Health
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trending Experiments Card - Mobile -->
                        <div class="panel panel-default panel-transparent mb-4">
                            <div class="panel-body">
                                <div class="shadow-sm border-0 rounded-4">
                                    <div class="card border-0 rounded-4" style="padding: 16px; border-radius: 12px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="fw-bold mb-0 d-flex align-items-center"
                                                style="color: #101828; font-size: 18px; gap: 12px; font-weight: 600 !important;">
                                                <img src="/images/experiment-vector.png" alt="" class="me-2 img-fluid" style="width: 24px;">
                                                Trending Experiments
                                            </h6>
                                            <a href="/experiments" class="text-decoration-none" style="font-size: 15px;font-weight: 600;display: flex;align-items: center;gap: 4px;">
                                                View all
                                                <img src="/images/arrow.png" alt="">
                                            </a>
                                        </div>

                                        <!-- Experiment Items -->
                                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 my-3 bg-right">
                                            <div class="d-flex flex-column" style="gap:4px;">
                                                <div class="d-flex align-items-center" style="gap: 4px;">
                                                    <img src="/images/fasting-icon.png" alt="" style="width:28px; height:28px;">
                                                    <div style="color: #101828;font-weight: 600;">Fasting Challenge</div>
                                                </div>
                                                <div>
                                                    <span style="color: #469DFA;font-weight: 600;font-size: 14px;">1,245</span>
                                                    <span style="color:#A8ACB1; font-size: 14px;"> participants</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary rounded-3 px-3 py-1">Join</button>
                                        </div>
                                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 my-3 bg-right">
                                            <div class="d-flex flex-column" style="gap:4px;">
                                                <div class="d-flex align-items-center" style="gap: 4px;">
                                                    <img src="/images/fasting-icon.png" alt="" style="width:28px; height:28px;">
                                                    <div style="color: #101828;font-weight: 600;">Fasting Challenge</div>
                                                </div>
                                                <div>
                                                    <span style="color: #469DFA;font-weight: 600;font-size: 14px;">1,245</span>
                                                    <span style="color:#A8ACB1; font-size: 14px;"> participants</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary rounded-3 px-3 py-1">Join</button>
                                        </div>
                                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 my-3 bg-right">
                                            <div class="d-flex flex-column" style="gap:4px;">
                                                <div class="d-flex align-items-center" style="gap: 4px;">
                                                    <img src="/images/fasting-icon.png" alt="" style="width:28px; height:28px;">
                                                    <div style="color: #101828;font-weight: 600;">Fasting Challenge</div>
                                                </div>
                                                <div>
                                                    <span style="color: #469DFA;font-weight: 600;font-size: 14px;">1,245</span>
                                                    <span style="color:#A8ACB1; font-size: 14px;"> participants</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary rounded-3 px-3 py-1">Join</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END MOBILE CARDS -->

                    @if ($stories->count() || ($settings->story_status && auth()->user()->verified_id == 'yes'))
                        <div id="stories" class="storiesWrapper mb-2 p-2">
                            @if ($settings->story_status && auth()->user()->verified_id == 'yes')
                                <div class="add-story" title="{{ __('general.add_story') }}">
                                    <a class="item-add-story" href="#" data-toggle="modal" data-target="#addStory">
                                        <span class="add-story-preview">
                                            <img lazy="eager" width="100"
                                                src="{{ Helper::getFile(config('path.avatar') . auth()->user()->avatar) }}">
                                        </span>
                                        <span class="info py-3 text-center text-white bg-primary">
                                            <strong class="name" style="text-shadow: none;"><i
                                                    class="bi-plus-circle-dotted mr-1"></i>
                                                {{ __('general.add_story') }}</strong>
                                        </span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if (
                        ($settings->announcement != '' &&
                            $settings->announcement_show == 'creators' &&
                            auth()->user()->verified_id == 'yes') ||
                            ($settings->announcement != '' && $settings->announcement_show == 'all'))
                        <div class="alert alert-{{ $settings->type_announcement }} announcements display-none card-border-0"
                            role="alert">
                            <button type="button" class="close" id="closeAnnouncements">
                                <span aria-hidden="true">
                                    <i class="bi bi-x-lg"></i>
                                </span>
                            </button>

                            <h4 class="alert-heading"><i class="bi bi-megaphone mr-2"></i> {{ __('general.announcements') }}
                            </h4>
                            <p class="update-text">
                                {!! $settings->announcement !!}
                            </p>
                        </div>
                    @endif

                    @if ($payPerViewsUser != 0)
                        <div class="col-md-12 d-none">
                            <ul class="list-inline">
                                <li class="list-inline-item text-uppercase h5">
                                    <a href="{{ url('/') }}"
                                        class="text-decoration-none @if (request()->is('/')) link-border @else text-muted @endif">{{ __('admin.home') }}</a>
                                </li>
                                <li class="list-inline-item text-uppercase h5">
                                    <a href="{{ url('my/purchases') }}"
                                        class="text-decoration-none @if (request()->is('my/purchases')) link-border @else text-muted @endif">{{ __('general.purchased') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif

                    @if (auth()->user()->verified_id == 'yes')
                        @include('includes.modal-add-story')
                        @include('includes.form-post')
                    @endif

                    @if ($updates->count() != 0)
                        <div class="grid-updates position-relative" id="updatesPaginator">
                            @include('includes.updates')
                        </div>
                    @else
                        <div class="grid-updates position-relative" id="updatesPaginator"></div>

                        <div class="my-5 text-center no-updates">
                            <span class="btn-block mb-3">
                                <i class="fa fa-photo-video ico-no-result"></i>
                            </span>
                            <h4 class="font-weight-light">{{ __('general.no_posts_posted') }}</h4>

                            <a href="{{ url('creators') }}" class="btn btn-primary mb-3 mt-2 px-5 d-lg-none">
                                {{ __('general.explore_creators') }}
                            </a>

                            <a href="{{ url('explore') }}" class="btn btn-primary px-5 d-lg-none">
                                {{ __('general.explore_posts') }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- RIGHT SIDEBAR - Only visible on desktop (>= 992px) -->
                <div class="right-sidebar col-md-3 mb-4 d-none d-lg-block">
                    <div class="d-lg-block sticky-top">
                        <!-- Your Health Today Card - Desktop -->
                        <div class="panel panel-default panel-transparent mb-4">
                            <div class="panel-body">
                                <div class="shadow-sm border-0 rounded-4">
                                    <div class="card-body" style="padding: 16px; background: #fff; border-radius: 12px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mt-2 fw-semibold"
                                                style="color: #101828; font-size: 18px; font-weight: 600 !important; display: flex; gap: 12px;">
                                                <img src="/images/health-vector.png" alt="" class="me-2 img-fluid"
                                                    style="width: 24px;">
                                                Your Health Today
                                            </h6>
                                        </div>

                                        <!-- Circular Score + Emotional Stats -->
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <div class="mood-widget-2 position-relative d-flex justify-content-center align-items-center"
                                                style="overflow:hidden;">
                                                <img src="/svg/AIsphere.svg" alt="Health Widget"
                                                    style="object-fit:cover; height: auto; max-width: 110%;">

                                                <!-- Centered content -->
                                                <div class="center-text-2 position-absolute text-center">
                                                    <div class="score"
                                                        style="font-size: 36px; font-weight: 500; color: #469DFA; line-height: 24px; margin-bottom: -5px;">
                                                        99
                                                    </div>
                                                    <div class="mood-text"
                                                        style="font-size: 12px; font-weight: 500; color: #469DFA; line-height: 100%; margin-bottom: 10px;">
                                                        Excellent</div>
                                                </div>
                                            </div>

                                            <!-- Emotional Stats -->
                                            <div class="w-100 px-sm-3">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between"
                                                        style="flex-direction: column;">
                                                        <span
                                                            style="font-weight: 600;color: #101828;font-size: 14px;margin-bottom: 2px;">Happiness</span>
                                                        <span class="small"
                                                            style="font-weight: 600; color: #CF73FF; margin-bottom: 4px;">24
                                                            Days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-2" style="height: 4px;">
                                                        <div class="progress-bar" style="width: 90%; background: #CF73FF">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-2"
                                                        style="flex-direction: column;">
                                                        <span
                                                            style="font-weight: 600;color: #101828;font-size: 14px; margin-bottom: 2px;">Excitement</span>
                                                        <span class="text-primary small"
                                                            style="font-weight: 600; margin-bottom: 4px;">12
                                                            Days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-2" style="height: 4px;">
                                                        <div class="progress-bar bg-primary" style="width: 60%;"></div>
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-2"
                                                        style="flex-direction: column;">
                                                        <span
                                                            style="font-weight: 600;color: #101828;font-size: 14px; margin-bottom: 2px;">Sadness</span>
                                                        <span class="text-danger small"
                                                            style="font-weight: 600; margin-bottom: 4px;">2
                                                            Days</span>
                                                    </div>
                                                    <div class="progress progress-sm" style="height: 4px;">
                                                        <div class="progress-bar bg-danger" style="width: 15%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Supplements -->
                                        <div
                                            class="d-flex gap-4 align-items-center justify-content-between px-3 py-3 mb-1 mt-1 bg-right">
                                            <span class="text-muted small d-flex align-items-center" style="gap: 4px;">
                                                <img src="/images/suppliment-icon.png" alt="">
                                                <span
                                                    style="color: #000; font-weight: 500; font-size: 16px">Suppliments</span>
                                            </span>
                                            <span class="badge px-3 py-1 rounded-pill"
                                                style="color: #0FB243; background: #A5FFCE; font-weight: 500;">Taken</span>
                                        </div>

                                        <!-- Bristol Scale -->
                                        <div
                                            class="d-flex align-items-center justify-content-between px-3 py-3 mb-1 bg-right">
                                            <span class="text-muted small d-flex align-items-center" style="gap: 4px;">
                                                <img src="/images/bristol-icon.png" alt="">
                                                <span style="color: #000; font-weight: 500; font-size: 16px">Bristol Scale</span>
                                            </span>
                                            <span class="badge px-3 py-1 rounded-pill"
                                                style="color: #0FB243; background: #A5FFCE; font-weight: 500;">Type 4</span>
                                        </div>

                                        <!-- Button -->
                                        <div class="text-center">
                                            <button
                                                class="btn btn-primary w-100 rounded-3 fw-semibold log-btn d-flex justify-content-center align-items-center"
                                                style="gap: 8px;">
                                                <img src="/images/pencil.png" alt=""
                                                    style="width: 13px; height: 15px;">
                                                Log Today's Health
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trending Experiments Card - Desktop -->
                        <div class="panel panel-default panel-transparent mb-4">
                            <div class="panel-body">
                                <div class="shadow-sm border-0 rounded-4">
                                    <div class="card border-0 rounded-4" style="padding: 16px; border-radius: 12px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="fw-bold mb-0 d-flex align-items-center"
                                                style="color: #101828; font-size: 18px; gap: 12px; font-weight: 600 !important;">
                                                <img src="/images/experiment-vector.png" alt=""
                                                    class="me-2 img-fluid" style="width: 24px;">
                                                Trending Experiments
                                            </h6>
                                            <a href="/experiments" class="text-decoration-none"
                                                style="font-size: 15px;font-weight: 600;display: flex;align-items: center;gap: 4px;">
                                                View all
                                                <img src="/images/arrow.png" alt="">
                                            </a>
                                        </div>

                                        <!-- Experiment Items -->
                                        <div
                                            class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 my-3 bg-right">
                                            <div class="d-flex flex-column" style="gap:4px;">
                                                <div class="d-flex align-items-center" style="gap: 4px;">
                                                    <img src="/images/fasting-icon.png" alt=""
                                                        style="width:28px; height:28px;">
                                                    <div style="color: #101828;font-weight: 600;">Fasting Challenge</div>
                                                </div>
                                                <div>
                                                    <span style="color: #469DFA;font-weight: 600;font-size: 14px;">1,245</span>
                                                    <span style="color:#A8ACB1; font-size: 14px;"> participants</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary rounded-3 px-3 py-1">Join</button>
                                        </div>
                                        <div
                                            class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 my-3 bg-right">
                                            <div class="d-flex flex-column" style="gap:4px;">
                                                <div class="d-flex align-items-center" style="gap: 4px;">
                                                    <img src="/images/fasting-icon.png" alt=""
                                                        style="width:28px; height:28px;">
                                                    <div style="color: #101828;font-weight: 600;">Fasting Challenge</div>
                                                </div>
                                                <div>
                                                    <span style="color: #469DFA;font-weight: 600;font-size: 14px;">1,245</span>
                                                    <span style="color:#A8ACB1; font-size: 14px;"> participants</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary rounded-3 px-3 py-1">Join</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-lg-block d-none">
                            {{-- @include('includes.footer-tiny') --}}
                        </div>
                    </div><!-- sticky-top -->
                </div><!-- right-sidebar -->
            </div>
        </div>
    </section>
@endsection

<!-- JavaScript Section -->
@section('javascript')
    @if (session('noty_error'))
        <script type="text/javascript">
            swal({
                title: "{{ __('general.error_oops') }}",
                text: "{{ __('general.already_sent_report') }}",
                type: "error",
                confirmButtonText: "{{ __('users.ok') }}"
            });
        </script>
    @endif

    @if (session('noty_success'))
        <script type="text/javascript">
            swal({
                title: "{{ __('general.thanks') }}",
                text: "{{ __('general.reported_success') }}",
                type: "success",
                confirmButtonText: "{{ __('users.ok') }}"
            });
        </script>
    @endif

    @if (session('success_verify'))
        <script type="text/javascript">
            swal({
                title: "{{ __('general.welcome') }}",
                text: "{{ __('users.account_validated') }}",
                type: "success",
                confirmButtonText: "{{ __('users.ok') }}"
            });
        </script>
    @endif

    @if (session('error_verify'))
        <script type="text/javascript">
            swal({
                title: "{{ __('general.error_oops') }}",
                text: "{{ __('users.code_not_valid') }}",
                type: "error",
                confirmButtonText: "{{ __('users.ok') }}"
            });
        </script>
    @endif

    @if ($settings->story_status && $stories->isNotEmpty() && $stories->first()->media->isNotEmpty())
        <script>
            let stories = new Zuck('stories', {
                skin: 'snapssenger',
                avatars: false,
                list: false,
                openEffect: true,
                cubeEffect: false,
                autoFullScreen: false,
                backButton: true,
                backNative: false,
                previousTap: true,
                localStorage: true,

                stories: [
                    @foreach ($stories as $story)
                        {
                            id: "{{ $story->user->username }}",
                            photo: "{{ Helper::getFile(config('path.avatar') . $story->user->avatar) }}",
                            name: "{{ $story->user->hide_name == 'yes' ? $story->user->username : $story->user->name }}",
                            link: "{{ url($story->user->username) }}",
                            lastUpdated: {{ $story->created_at->timestamp }},

                            items: [
                                @foreach ($story->media as $media)
                                    {
                                        id: "{{ $story->user->username }}-{{ $story->id }}",
                                        type: "{{ $media->type }}",
                                        length: {{ $media->type == 'photo' ? 5 : ($media->video_length ?: $settings->story_max_videos_length) }},
                                        src: "{{ Helper::getFile(config('path.stories') . $media->name) }}",
                                        preview: "{{ $media->type == 'photo' ? route('resize', ['path' => 'stories', 'file' => $media->name, 'size' => 280]) : ($media->video_poster ? route('resize', ['path' => 'stories', 'file' => $media->video_poster, 'size' => 280]) : route('resize', ['path' => 'avatar', 'file' => $story->user->avatar, 'size' => 200])) }}",
                                        link: "",
                                        linkText: '{{ $story->title }}',
                                        time: {{ $media->created_at->timestamp }},
                                        seen: false,
                                        story: "{{ $media->id }}",
                                        text: "{{ $media->text }}",
                                        color: "{{ $media->font_color }}",
                                        font: "{{ $media->font }}",
                                    },
                                @endforeach
                            ]
                        },
                    @endforeach
                ],

                callbacks: {
                    onView(storyId) {
                        getItemStoryId(storyId);
                    },
                    onEnd(storyId, callback) {
                        getItemStoryId(storyId);
                        callback();
                    },
                    onClose(storyId, callback) {
                        getItemStoryId(storyId);
                        callback();
                    },
                    onNavigateItem(storyId, nextStoryId, callback) {
                        getItemStoryId(storyId);
                        callback();
                    },
                },

                language: {
                    unmute: '{{ __('general.touch_unmute') }}',
                    keyboardTip: 'Press space to see next',
                    visitLink: 'Visit link',
                    time: {
                        ago: '{{ __('general.ago') }}',
                        hour: '{{ __('general.hour') }}',
                        hours: '{{ __('general.hours') }}',
                        minute: '{{ __('general.minute') }}',
                        minutes: '{{ __('general.minutes') }}',
                        fromnow: '{{ __('general.fromnow') }}',
                        seconds: '{{ __('general.seconds') }}',
                        yesterday: '{{ __('general.yesterday') }}',
                        tomorrow: 'tomorrow',
                        days: 'days'
                    }
                }
            });

            function getItemStoryId(storyId) {
                let userActive = '{{ auth()->user()->username }}';
                if (userActive !== storyId) {
                    let itemId = $('#zuck-modal .story-viewer[data-story-id="' + storyId + '"]').find('.itemStory.active').data('id-story');
                    insertViewStory(itemId);
                }
                insertTextStory();
            }

            insertTextStory();

            function insertTextStory() {
                $('.previewText').each(function() {
                    let text = $(this).find('.items>li:first-child>a').data('text');
                    let font = $(this).find('.items>li:first-child>a').data('font');
                    let color = $(this).find('.items>li:first-child>a').data('color');
                    $(this).find('.text-story-preview').css({
                        fontFamily: font,
                        color: color
                    }).html(text);
                });
            }

            function insertViewStory(itemId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(URL_BASE + "/story/views/" + itemId + "");
            }

            $(document).on('click', '.profilePhoto, .info>.name', function() {
                let element = $(this);
                let username = element.parents('.story-viewer').data('story-id');
                if (username) {
                    window.location.href = URL_BASE + '/' + username;
                }
            });
        </script>
    @endif
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadTrendingExperiments();
        window.addEventListener('load', function() {
            loadTrendingExperiments();
        });
    });

    function loadTrendingExperiments() {
        fetch('/contents/experiments')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    updateTrendingExperiments(data.data);
                }
            })
            .catch(error => {
                console.error('Error loading trending experiments:', error);
                showDefaultExperiments();
            });
    }

    function updateTrendingExperiments(experiments) {
        // Update both desktop and mobile experiment containers
        const containers = document.querySelectorAll('.card.border-0.rounded-4');
        containers.forEach(container => {
            if (container.querySelector('.experiment-item')) {
                const trendingExperiments = experiments.slice(0, 3);
                let experimentsHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 d-flex align-items-center" style="color: #101828; font-size: 18px; gap: 12px; font-weight: 600 !important;">
                            <img src="/images/experiment-vector.png" alt="" class="me-2 img-fluid" style="width: 24px;">
                            Trending Experiments
                        </h6>
                        <a href="/experiments" class="text-decoration-none" style="font-size: 15px;font-weight: 600;display: flex;align-items: center;gap: 4px;">
                            View all
                            <img src="/images/arrow.png" alt="">
                        </a>
                    </div>
                `;

                trendingExperiments.forEach(experiment => {
                    experimentsHTML += `
                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 my-3 bg-right">
                            <div class="d-flex flex-column" style="gap:4px;">
                                <div class="d-flex align-items-center" style="gap: 4px;">
                                    <img src="/images/fasting-icon.png" alt="${experiment.title}" style="width: 28px; height: 28px;">
                                    <div style="color: #101828;font-weight: 600;">${experiment.title}</div>
                                </div>
                                <div>
                                    <span style="color: #469DFA;font-weight: 600;font-size: 14px;">${experiment.participants || '1,245'}</span>
                                    <span style="color:#A8ACB1; font-size: 14px;"> participants</span>
                                </div>
                            </div>
                            <button class="btn btn-primary rounded-3 px-3 py-1">Join</button>
                        </div>
                    `;
                });

                container.innerHTML = experimentsHTML;
            }
        });
    }
</script>