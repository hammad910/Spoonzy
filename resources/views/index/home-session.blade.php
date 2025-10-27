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
    background: conic-gradient(
        rgba(90, 156, 255, 0.2),
        rgba(146, 83, 255, 0.25),
        rgba(255, 255, 255, 0.3)
    );
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

@media (max-width: 576px) {
  .experiment-item {
    flex-wrap: wrap;
  }

  .experiment-item button {
    margin-left: auto;
    margin-top: 0 !important;
  }
}
</style>
@section('content')
    <section class="section section-sm">
        <div class="container pt-lg-4 pt-2 max-w-100" style="max-width: 100%">
            <div class="row justify-content-center">

                <div class="d-none d-lg-block" style="height: 100vh; border-right: 1px solid #ddd; padding: 20px; width: 15%">
                    @include('includes.menu-sidebar-home')
                </div>

                <div class="col-md-7 p-0 second wrap-post">

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
                        <div class="grid-updates position-relative" id="updatesPaginator" style="padding: 10px">
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

                <div class="col-md-3 @if ($users->count() != 0) mb-4 @endif d-block d-sm-none d-lg-block">
                    <div class="d-lg-block sticky-top">
                        @if ($users->count() == 0)
                        <div class="panel panel-default panel-transparent mb-4 d-block d-md-none d-lg-block">
                            <div class="panel-body">
                                <div class="shadow-sm border-0 rounded-4 p-3 h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mt-2 fw-semibold" style="color: #000; font-size: 18px;">
                                                <img src="/images/health-vector.png" alt="" class="me-2 img-fluid" style="width: 24px;">
                                                Your Health Today
                                            </h6>
                                        </div>
                        
                                        <!-- Circular Score + Emotional Stats -->
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <div class="text-center position-relative mb-3 mb-sm-0">
                                                <img src="/images/health-widget.png" alt="Health Widget" class="img-fluid">
                                            </div>
                        
                                            <!-- Emotional Stats -->
                                            <div class="w-100 px-sm-3">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span style="font-weight: 600; color: #000; font-size: 16px;">Happiness</span>
                                                        <span class="small" style="font-weight: 600; color: #CF73FF">24 Days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-2" style="height: 4px;">
                                                        <div class="progress-bar" style="width: 90%; background: #CF73FF"></div>
                                                    </div>
                        
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <span style="font-weight: 600; color: #000; font-size: 16px;">Excitement</span>
                                                        <span class="text-primary small" style="font-weight: 600;">12 Days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-2" style="height: 4px;">
                                                        <div class="progress-bar bg-primary" style="width: 60%;"></div>
                                                    </div>
                        
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <span style="font-weight: 600; color: #000; font-size: 16px;">Sadness</span>
                                                        <span class="text-danger small" style="font-weight: 600;">2 Days</span>
                                                    </div>
                                                    <div class="progress progress-sm" style="height: 4px;">
                                                        <div class="progress-bar bg-danger" style="width: 15%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <!-- Supplements -->
                                        <div class="d-flex gap-4 align-items-center justify-content-between px-3 mb-4 mt-4">
                                            <span class="text-muted small d-flex align-items-center" style="gap: 4px;">
                                                <img src="/images/suppliment-icon.png" alt=""> <span style="color: #000; font-weight: 500; font-size: 16px"> Suppliments </span>
                                            </span>
                                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Taken</span>
                                        </div>
                        
                                        <!-- Bristol Scale -->
                                        <div class="d-flex align-items-center justify-content-between px-3 mb-4">
                                            <span class="text-muted small d-flex align-items-center" style="gap: 4px;">
                                                <img src="/images/bristol-icon.png" alt=""> <span style="color: #000; font-weight: 500; font-size: 16px"> Bristol Scale</span>
                                            </span>
                                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Type 4</span>
                                        </div>
                        
                                        <!-- Button -->
                                        <div class="text-center">
                                            <button class="btn btn-primary w-100 rounded-3 fw-semibold log-btn">
                                                Log Today's Health
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card border-0 rounded-4 p-3 mt-5">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                          <h6 class="fw-bold mb-0 d-flex align-items-center" style="color: #000; font-size: 18px; gap: 5px;">
                                            <img src="/images/experiment-vector.png" alt="" class="me-2 img-fluid" style="width: 24px;">
                                            Trending Experiments
                                          </h6>
                                          <a href="#" class="text-primary fw-semibold small text-decoration-none" style="font-size: 15px;">
                                            View all <i class="bi bi-arrow-up-right" style="font-size: 15px;"></i>
                                          </a>
                                        </div>
                                      
                                        <!-- Experiment Item -->
                                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 mb-2 flex-wrap">
                                            <div class="d-flex align-items-center flex-grow-1" style="gap: 10px; min-width: 0;">
                                              <span class="me-2 fs-5">
                                                <img src="/images/fasting-icon.png" alt="" style="width: 28px; height: 28px;">
                                              </span>
                                              <div class="text-truncate">
                                                <div class="fw-semibold" style="color: #000;">Fasting Challenge</div>
                                                <div class="small text-muted text-nowrap">
                                                  <span class="text-primary fw-semibold">1,245</span> participants
                                                </div>
                                              </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm fw-semibold px-3 rounded-3 mt-2 mt-sm-0 ms-auto">Join</button>
                                          </div>                                          
                                      
                                        <!-- Repeat Items -->
                                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 mb-2">
                                          <div class="d-flex align-items-center w-100 w-md-auto" style="gap: 10px;">
                                            <span class="me-2 fs-5"><img src="/images/fasting-icon.png" alt=""></span>
                                            <div>
                                              <div class="fw-semibold" style="color: #000">Fasting Challenge</div>
                                              <div class="small text-muted">
                                                <span class="text-primary fw-semibold">1,245</span> participants
                                              </div>
                                            </div>
                                          </div>
                                          <button class="btn btn-primary btn-sm fw-semibold px-3 rounded-3">Join</button>
                                        </div>
                                      
                                        <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3">
                                          <div class="d-flex align-items-center w-100 w-md-auto" style="gap: 10px;">
                                            <span class="me-2 fs-5"> <img src="/images/fasting-icon.png" alt=""></span>
                                            <div>
                                              <div class="fw-semibold" style="color: #000">Fasting Challenge</div>
                                              <div class="small text-muted">
                                                <span class="text-primary fw-semibold">1,245</span> participants
                                              </div>
                                            </div>
                                          </div>
                                          <button class="btn btn-primary btn-sm fw-semibold px-3 rounded-3">Join</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                            {{-- <div class="card health-widget shadow-sm border-0 rounded-4 p-3"> --}}
                            
                        @endif

                        @if ($users->count() != 0)
                            @include('includes.explore_creators')
                        @endif

                        <div class="d-lg-block d-none">
                            {{-- @include('includes.footer-tiny') --}}
                        </div>
                    </div><!-- sticky-top -->

                </div><!-- col-md -->
            </div>
        </div>
    </section>
@endsection

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
                skin: 'snapssenger', // container class
                avatars: false, // shows user photo instead of last story item preview
                list: false, // displays a timeline instead of carousel
                openEffect: true, // enables effect when opening story
                cubeEffect: false, // enables the 3d cube effect when sliding story
                autoFullScreen: false, // enables fullscreen on mobile browsers
                backButton: true, // adds a back button to close the story viewer
                backNative: false, // uses window history to enable back button on browsers/android
                previousTap: true, // use 1/3 of the screen to navigate to previous item when tap the story
                localStorage: true, // set true to save "seen" position. Element must have a id to save properly.

                stories: [

                    @foreach ($stories as $story)
                        {
                            id: "{{ $story->user->username }}", // story id
                            photo: "{{ Helper::getFile(config('path.avatar') . $story->user->avatar) }}", // story photo (or user photo)
                            name: "{{ $story->user->hide_name == 'yes' ? $story->user->username : $story->user->name }}", // story name (or user name)
                            link: "{{ url($story->user->username) }}", // story link (useless on story generated by script)
                            lastUpdated: {{ $story->created_at->timestamp }}, // last updated date in unix time format

                            items: [
                                // story item example

                                @foreach ($story->media as $media)
                                    {
                                        id: "{{ $story->user->username }}-{{ $story->id }}", // item id
                                        type: "{{ $media->type }}", // photo or video
                                        length: {{ $media->type == 'photo' ? 5 : ($media->video_length ?: $settings->story_max_videos_length) }}, // photo timeout or video length in seconds - uses 3 seconds timeout for images if not set
                                        src: "{{ Helper::getFile(config('path.stories') . $media->name) }}", // photo or video src
                                        preview: "{{ $media->type == 'photo' ? route('resize', ['path' => 'stories', 'file' => $media->name, 'size' => 280]) : ($media->video_poster ? route('resize', ['path' => 'stories', 'file' => $media->video_poster, 'size' => 280]) : route('resize', ['path' => 'avatar', 'file' => $story->user->avatar, 'size' => 200])) }}", // optional - item thumbnail to show in the story carousel instead of the story defined image
                                        link: "", // a link to click on story
                                        linkText: '{{ $story->title }}', // link text
                                        time: {{ $media->created_at->timestamp }}, // optional a date to display with the story item. unix timestamp are converted to "time ago" format
                                        seen: false, // set true if current user was read
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
                        callback(); // on end story
                    },

                    onClose(storyId, callback) {
                        getItemStoryId(storyId);
                        callback(); // on close story viewer
                    },

                    onNavigateItem(storyId, nextStoryId, callback) {
                        getItemStoryId(storyId);
                        callback(); // on navigate item of story
                    },
                },

                language: { // if you need to translate :)
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
                    let itemId = $('#zuck-modal .story-viewer[data-story-id="' + storyId + '"]').find('.itemStory.active').data(
                        'id-story');
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
