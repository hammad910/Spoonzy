<style>
    .post-image {
        width: 100%;
        height: 314px;
        display: block;
        border-radius: 12px;
        margin-top: 12px;
        object-fit: cover;
        overflow: hidden;
    }

    .card-footer {
        padding: 0 1.25rem;
    }

    /* Comment Popup Styles */
    /* Updated Comment Popup Styles */
    .comment-popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .comment-popup-overlay.active {
        display: flex;
    }

    .comment-popup {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .comment-popup-header {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comment-popup-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
    }

    .comment-popup-header .close-popup {
        background: none;
        border: none;
        font-size: 24px;
        color: #6B7280;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .comment-popup-header .close-popup:hover {
        background: #F3F4F6;
    }

    .comment-popup-body {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
    }

    .li-group {
        border: none;
    }

    /* Comment Input at Top */
    .comment-input-section {
        background: #F8F8F8;
        border-radius: 13px;
        padding: 16px 16px 0 16px;
        margin-bottom: 20px;
    }

    .comment-input-section h4 {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin: 0 0 12px 0;
    }

    .comment-input-wrapper-new {
        position: relative;
    }

    .comment-input-wrapper-new .form-control.comments {
        padding: 0;
        width: 100%;
        border: none;
        font-size: 18px;
        resize: none;
        min-height: 80px;
        background: transparent;
        color: #000 !important;
    }

    .comment-input-wrapper-new textarea:focus {
        outline: none;
        border-color: #3B82F6;
    }

    .comment-input-wrapper-new textarea::placeholder {
        color: #9CA3AF;
    }

    .comment-input-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
    }

    .comment-input-tools {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .comment-input-tools button {
        background: none;
        border: none;
        color: #6B7280;
        font-size: 18px;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .comment-input-tools button:hover {
        color: #3B82F6;
        background: #EFF6FF;
    }

    .comment-submit-btn {
        background: {{ $settings->theme_color_pwa }} !important;
        color: white !important;
        border-radius: 20px !important;
        padding: 8px 24px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }

    .comment-submit-btn:hover {
        background: #2d92fd !important;
    }

    .comment-submit-btn:disabled {
        background: #9CA3AF !important;
        cursor: not-allowed;
    }

    .total-comments-btn {
        background: {{ $settings->theme_color_pwa }} !important;
        color: white !important;
        border-radius: 20px !important;
        padding: 5px 17px !important;
        font-size: 15px !important;
        font-weight: 400 !important;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }

    .total-comments-btn:hover {
        background: #2d92fd !important;
    }

    /* Comments List Section */
    .comments-list-section {
        flex: 1;
    }

    .comment-sort {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .comment-sort i {
        color: #6B7280;
        font-size: 16px;
    }

    .comment-sort span {
        color: #475467;
        font-weight: 400;
        font-size: 18px;
    }

    /* Existing Comments Styles - Keep them same */
    .container-media {
        /* Your existing comment styles will work here */
    }

    @media (max-width: 768px) {
        .comment-popup {
            max-width: 100%;
            max-height: 100vh;
            border-radius: 0;
        }

        .comment-popup-header,
        .comment-popup-body {
            padding: 16px;
        }

        .comment-input-section {
            padding: 12px;
        }
    }

    /* Chrome, Safari, Edge, Opera */
    textarea::placeholder {
        color: #475467;
        /* apna color yahan do */
        opacity: 1;
        /* default opacity 0.5 hota hai, set 1 for full */
    }

    /* Firefox */
    textarea::-moz-placeholder {
        color: #475467;
        opacity: 1;
    }

    /* Internet Explorer 10-11 */
    textarea:-ms-input-placeholder {
        color: #475467;
    }

    /* Older Firefox */
    textarea:-moz-placeholder {
        color: #475467;
    }
</style>

@include('includes.advertising')

@foreach ($updates as $response)
    @php
        if (auth()->check()) {
            $checkUserSubscription = auth()->user()->checkSubscription($response->creator);
            $checkPayPerView = auth()->user()->payPerView()->where('updates_id', $response->id)->first();
        }

        $creatorLive = Helper::isCreatorLive($getCurrentLiveCreators, $response->creator->id);

        $totalLikes = number_format($response->likes->count() + $response->likes_extras);
        $totalComments = $response->totalComments();
        $mediaCount = $response->media->count();
        $allFiles = $response->media()->groupBy('type')->get();
        $getFirstFile = $response
            ->media()
            ->whereIn('type', ['image', 'video'])
            ->where('video_embed', '')
            ->first();

        $mediaImageVideo = $response
            ->media()
            ->whereIn('type', ['image', 'video'])
            ->where('video_embed', '')
            ->get();

        if ($getFirstFile && $getFirstFile->type == 'image' && $getFirstFile->img_type != 'gif') {
            $urlMedia = url('media/storage/focus/photo', $getFirstFile->id);
            $backgroundPostLocked =
                'background: url(' . $urlMedia . ') no-repeat center center #b9b9b9; background-size: cover;';
            $textWhite = 'text-white';
        } elseif ($getFirstFile && $getFirstFile->type == 'video' && $getFirstFile->video_poster) {
            $videoPoster = url('media/storage/focus/video', $getFirstFile->video_poster);
            $backgroundPostLocked =
                'background: url(' . $videoPoster . ') no-repeat center center #b9b9b9; background-size: cover;';
            $textWhite = 'text-white';
        } else {
            $backgroundPostLocked = null;
            $textWhite = null;
        }

        $countFilesImage = $response->media->where('type', 'image')->count();
        $countFilesVideo = $response->media->whereIn('type', ['video', 'video_embed'])->count();
        $countFilesAudio = $response->media->where('type', 'music')->count();
        $mediaImageVideoTotal = $response->media->whereIn('type', ['image', 'video'])->count();

        $isVideoEmbed = $response->media[0]->video_embed ?? false;

        $nth = 0; // nth foreach nth-child(3n-1)

    @endphp
    <div class="card mb-3 card-updates views rounded-large shadow-large card-border-0 @if ($response->status == 'pending') post-pending @endif @if (
        ($response->fixed_post == '1' && request()->path() == $response->creator->username) ||
            (auth()->check() && $response->fixed_post == '1' && $response->creator->id == auth()->user()->id)) pinned-post @endif"
        data="{{ $response->id }}">
        <div class="card-body">
            <div
                class="pinned_post text-muted small w-100 mb-2 {{ ($response->fixed_post == '1' && request()->path() == $response->creator->username) || (auth()->check() && $response->fixed_post == '1' && $response->creator->id == auth()->user()->id) ? 'pinned-current' : 'display-none' }}">
                <i class="bi bi-pin mr-2"></i> {{ __('general.pinned_post') }}
            </div>

            @if ($response->status == 'pending')
                <h6 class="text-muted w-100 mb-4">
                    <i class="bi bi-eye-fill mr-1"></i> <em>{{ __('general.post_pending_review') }}</em>
                </h6>
            @endif

            @if ($response->status == 'schedule')
                <h6 class="text-muted w-100 mb-4">
                    <i class="bi-calendar-fill mr-1"></i> <em>{{ __('general.date_schedule') }}
                        {{ Helper::formatDateSchedule($response->scheduled_date) }}</em>
                </h6>
            @endif

            <div class="media" style="align-items: center !important;">
                <span class="rounded-circle mr-3 position-relative">
                    <a
                        href="{{ $creatorLive ? url('live', $response->creator->username) : url($response->creator->username) }}">

                        @if (auth()->check() && $creatorLive)
                            <span class="live-span">{{ __('general.live') }}</span>
                        @endif

                        <img src="{{ Helper::getFile(config('path.avatar') . $response->creator->avatar) }}"
                            alt="{{ $response->creator->hide_name == 'yes' ? $response->creator->username : $response->creator->name }}"
                            class="rounded-circle avatarUser" width="48" height="48">
                    </a>
                </span>

                <div class="media-body">
                    <h5 class="mb-0">
                        <a href="{{ url($response->creator->username) }}"
                            style="color: #101828; font-size: 20px; font-weight: 600; ">
                            {{ $response->creator->hide_name == 'yes' ? $response->creator->username : $response->creator->name }}
                        </a>

                        @if ($response->creator->verified_id == 'yes')
                            <small class="verified" title="{{ __('general.verified_account') }}"data-toggle="tooltip"
                                data-placement="top">
                                <i class="bi bi-patch-check-fill"></i>
                            </small>
                        @endif

                        @if (auth()->check() && auth()->user()->id == $response->creator->id)
                            <a href="javascript:void(0);" class="text-muted float-right d-flex align-item-center"
                                style="gap: 10px;" id="dropdown_options" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="true">
                                <small class="timeAgo post-time"
                                    style=" color: #A8ACB1; font-weight: 400; font-size: 16px; "
                                    data-time="{{ date('c', strtotime($response->date)) }}">
                                    {{ $response->date }}
                                </small>
                                <i class="fa fa-ellipsis-h"></i>
                            </a>

                            <!-- Target -->
                            <button class="d-none copy-url" id="url{{ $response->id }}"
                                data-clipboard-text="{{ url($response->creator->username . '/post', $response->id) }}">{{ __('general.copy_link') }}</button>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_options">
                                @if (request()->path() != $response->creator->username . '/post/' . $response->id)
                                    <a class="dropdown-item mb-1"
                                        href="{{ url($response->creator->username . '/post', $response->id) }}"><i
                                            class="bi bi-box-arrow-in-up-right mr-2"></i>
                                        {{ __('general.go_to_post') }}</a>
                                @endif

                                @if ($response->status == 'active')
                                    <a class="dropdown-item mb-1 pin-post" href="javascript:void(0);"
                                        data-id="{{ $response->id }}">
                                        <i class="bi bi-pin mr-2"></i>
                                        {{ $response->fixed_post == '0' ? __('general.pin_to_your_profile') : __('general.unpin_from_profile') }}
                                    </a>
                                @endif

                                <button class="dropdown-item mb-1"
                                    onclick="$('#url{{ $response->id }}').trigger('click')"><i
                                        class="feather icon-link mr-2"></i> {{ __('general.copy_link') }}</button>

                                <a href="{{ route('post.edit', ['id' => $response->id]) }}" class="dropdown-item mb-1">
                                    <i class="bi bi-pencil mr-2"></i> {{ __('general.edit_post') }}
                                </a>

                                <form method="POST" action="{{ url('update/delete', $response->id) }}"
                                    class="d-inline">
                                    @csrf
                                    @if (isset($inPostDetail))
                                        <input type="hidden" name="inPostDetail" value="true">
                                    @endif

                                    <button type="submit" class="dropdown-item mb-1 actionDelete">
                                        <i class="feather icon-trash-2 mr-2"></i> {{ __('general.delete_post') }}
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if (
                            (auth()->check() &&
                                auth()->user()->id != $response->creator->id &&
                                $response->locked == 'yes' &&
                                $checkUserSubscription &&
                                $response->price == 0.0) ||
                                (auth()->check() &&
                                    auth()->user()->id != $response->creator->id &&
                                    $response->locked == 'yes' &&
                                    $checkUserSubscription &&
                                    $response->price != 0.0 &&
                                    $checkPayPerView) ||
                                (auth()->check() &&
                                    auth()->user()->id != $response->creator->id &&
                                    $response->price != 0.0 &&
                                    !$checkUserSubscription &&
                                    $checkPayPerView) ||
                                (auth()->check() &&
                                    auth()->user()->id != $response->creator->id &&
                                    auth()->user()->role == 'admin' &&
                                    auth()->user()->permission == 'all') ||
                                (auth()->check() && auth()->user()->id != $response->creator->id && $response->locked == 'no'))
                            <a href="javascript:void(0);" class="text-muted float-right" id="dropdown_options"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-ellipsis-h"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_options">

                                <!-- Target -->
                                <button class="d-none copy-url" id="url{{ $response->id }}"
                                    data-clipboard-text="{{ url($response->creator->username . '/post', $response->id) . Helper::referralLink() }}">
                                    {{ __('general.copy_link') }}
                                </button>

                                @if (request()->path() != $response->creator->username . '/post/' . $response->id)
                                    <a class="dropdown-item"
                                        href="{{ url($response->creator->username . '/post', $response->id) }}">
                                        <i class="bi bi-box-arrow-in-up-right mr-2"></i> {{ __('general.go_to_post') }}
                                    </a>
                                @endif

                                <button class="dropdown-item" onclick="$('#url{{ $response->id }}').trigger('click')">
                                    <i class="feather icon-link mr-2"></i> {{ __('general.copy_link') }}
                                </button>

                                <button type="button" class="dropdown-item" data-toggle="modal"
                                    data-target="#reportUpdate{{ $response->id }}">
                                    <i class="bi bi-flag mr-2"></i> {{ __('admin.report') }}
                                </button>

                            </div>

                            <div class="modal fade modalReport" id="reportUpdate{{ $response->id }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title font-weight-light" id="modal-title-default">
                                                <i class="fas fa-flag mr-1"></i> {{ __('admin.report_update') }}
                                            </h6>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>

                                        <!-- form start -->
                                        <form method="POST" action="{{ url('report/update', $response->id) }}"
                                            enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <!-- Start Form Group -->
                                                <div class="form-group">
                                                    <label>{{ __('admin.please_reason') }}</label>
                                                    <select name="reason" class="form-control custom-select">
                                                        <option value="copyright">{{ __('admin.copyright') }}</option>
                                                        <option value="privacy_issue">{{ __('admin.privacy_issue') }}
                                                        </option>
                                                        <option value="violent_sexual">
                                                            {{ __('admin.violent_sexual_content') }}</option>
                                                    </select>

                                                    <textarea name="message" rows="" cols="40" maxlength="200"
                                                        placeholder="{{ __('general.message') }} ({{ __('general.optional') }})"
                                                        class="form-control mt-2 textareaAutoSize"></textarea>
                                                </div><!-- /.form-group-->
                                            </div><!-- Modal body -->

                                            <div class="modal-footer">
                                                <button type="button" class="btn border text-white"
                                                    data-dismiss="modal">{{ __('admin.cancel') }}</button>
                                                <button type="submit"
                                                    class="btn btn-xs btn-white sendReport ml-auto"><i></i>
                                                    {{ __('admin.report_update') }}</button>
                                            </div>
                                        </form>
                                    </div><!-- Modal content -->
                                </div><!-- Modal dialog -->
                            </div><!-- Modal -->
                        @endif
                    </h5>


                    @if ($response->locked == 'no')
                        <small class="text-muted type-post" title="{{ __('general.public') }}">
                        </small>
                    @endif

                    @if ($response->locked == 'yes')
                        <small class="text-muted type-post" title="{{ __('users.content_locked') }}">

                            <i class="feather icon-lock mr-1"></i>

                            @if (
                                (auth()->check() && $response->price != 0.0 && $checkUserSubscription && !$checkPayPerView) ||
                                    (auth()->check() && $response->price != 0.0 && !$checkUserSubscription && !$checkPayPerView))
                                {{ Helper::formatPrice($response->price) }}
                            @elseif (auth()->check() && $checkPayPerView)
                                {{ __('general.paid') }}
                            @endif
                        </small>
                    @endif
                </div><!-- media body -->
            </div><!-- media -->
        </div><!-- card body -->

        @if (
            (auth()->check() && auth()->user()->id == $response->creator->id) ||
                ($response->locked == 'yes' && $mediaCount != 0) ||
                (auth()->check() && $response->locked == 'yes' && $checkUserSubscription && $response->price == 0.0) ||
                (auth()->check() &&
                    $response->locked == 'yes' &&
                    $checkUserSubscription &&
                    $response->price != 0.0 &&
                    $checkPayPerView) ||
                (auth()->check() &&
                    $response->locked == 'yes' &&
                    $response->price != 0.0 &&
                    !$checkUserSubscription &&
                    $checkPayPerView) ||
                (auth()->check() && auth()->user()->role == 'admin' && auth()->user()->permission == 'all') ||
                $response->locked == 'no')
            <div class="card-body pt-0 pb-1">

                <p class="mb-0 truncated position-relative text-word-break" style="color: #475467;">
                    {!! Helper::linkText(Helper::checkText($response->description, $isVideoEmbed ?? null)) !!}
                </p>

                <a href="javascript:void(0);" class="display-none link-border">
                    {{ __('general.view_all') }}
                </a>

                <img src="/images/post-img.jpg" alt="" class="post-image">
            </div>
        @else
            @if ($response->title)
                <div class="card-body pt-0 pb-3">
                    <p class="mb-0 update-text position-relative text-word-break font-weight-bold">
                        {!! Helper::linkText($response->title) !!}
                    </p>
                </div>
            @endif
        @endif

        @if (
            (auth()->check() && auth()->user()->id == $response->creator->id) ||
                (auth()->check() && $response->locked == 'yes' && $checkUserSubscription && $response->price == 0.0) ||
                (auth()->check() &&
                    $response->locked == 'yes' &&
                    $checkUserSubscription &&
                    $response->price != 0.0 &&
                    $checkPayPerView) ||
                (auth()->check() &&
                    $response->locked == 'yes' &&
                    $response->price != 0.0 &&
                    !$checkUserSubscription &&
                    $checkPayPerView) ||
                (auth()->check() && auth()->user()->role == 'admin' && auth()->user()->permission == 'all') ||
                $response->locked == 'no')
            <div class="btn-block">

                @if ($mediaImageVideoTotal != 0)
                    @include('includes.media-post')
                @endif

                @foreach ($response->media as $media)
                    @if ($media->music != '')
                        <div class="mx-3 border rounded @if ($mediaCount > 1) mt-3 @endif">
                            <audio id="music-{{ $media->id }}" preload="metadata"
                                class="js-player w-100 @if (!request()->ajax()) invisible @endif" controls>
                                <source src="{{ Helper::getFile(config('path.music') . $media->music) }}"
                                    type="audio/mp3">
                                Your browser does not support the audio tag.
                            </audio>
                        </div>
                    @endif

                    @if ($media->type == 'file')
                        <a href="{{ url('download/file', $response->id) }}"
                            class="d-block text-decoration-none @if ($mediaCount > 1) mt-3 @endif">
                            <div class="card mb-3 mx-3">
                                <div class="row no-gutters">
                                    <div class="col-md-2 text-center bg-primary rounded-left">
                                        <i class="far fa-file-archive m-4 text-white" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary text-truncate mb-0">
                                                {{ $media->file_name }}.zip
                                            </h5>
                                            <p class="card-text">
                                                <small class="text-muted">{{ $media->file_size }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if ($media->type == 'epub')
                        <a href="{{ url('viewer/epub', $media->id) }}" target="_blank"
                            class="d-block text-decoration-none @if ($mediaCount > 1) mt-3 @endif">
                            <div class="card mb-3 mx-3">
                                <div class="row no-gutters">
                                    <div class="col-md-2 text-center bg-primary rounded-left">
                                        <i class="fas fa-book-open m-4 text-white" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary text-truncate mb-1">
                                                {{ $media->file_name }}.epub
                                            </h5>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <strong>{{ __('general.view_online') }}</strong> <i
                                                        class="bi-arrow-up-right ml-1"></i>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach

                @if ($isVideoEmbed)
                    @if (in_array(Helper::videoUrl($isVideoEmbed), [
                            'youtube.com',
                            'www.youtube.com',
                            'youtu.be',
                            'www.youtu.be',
                            'm.youtube.com',
                        ]))
                        <div class="embed-responsive embed-responsive-16by9 mb-2">
                            <iframe class="embed-responsive-item" height="360"
                                src="https://www.youtube.com/embed/{{ Helper::getYoutubeId($isVideoEmbed) }}"
                                allowfullscreen></iframe>
                        </div>
                    @endif

                    @if (in_array(Helper::videoUrl($isVideoEmbed), ['vimeo.com', 'player.vimeo.com']))
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="https://player.vimeo.com/video/{{ Helper::getVimeoId($isVideoEmbed) }}"
                                allowfullscreen></iframe>
                        </div>
                    @endif
                @endif

            </div><!-- btn-block -->
        @else
            <div class="btn-block p-sm text-center content-locked pt-lg pb-lg px-3 {{ $textWhite }}"
                style="{{ $backgroundPostLocked }}">
                <span class="btn-block text-center mb-3"><i
                        class="feather icon-lock ico-no-result border-0 {{ $textWhite }}"></i></span>

                @if (
                    ($response->creator->planActive() && $response->price == 0.0) ||
                        ($response->creator->free_subscription == 'yes' && $response->price == 0.0))
                    <a href="{{ request()->route()->named('profile') ? 'javascript:void(0);' : url($response->creator->username) }}"
                        @guest data-toggle="modal" data-target="#loginFormModal" @else @if (request()->route()->named('profile')) @if ($response->creator->free_subscription == 'yes') data-toggle="modal" data-target="#subscriptionFreeForm" @else data-toggle="modal" data-target="#subscriptionForm" @endif @endif @endguest
                        class="btn btn-primary w-100">
                        {{ __('general.content_locked_user_logged') }}
                    </a>
                @elseif (
                    ($response->creator->planActive() && $response->price != 0.0) ||
                        ($response->creator->free_subscription == 'yes' && $response->price != 0.0))
                    <a href="javascript:void(0);"
                        @guest data-toggle="modal" data-target="#loginFormModal" @else @if ($response->status == 'active') data-toggle="modal" data-target="#payPerViewForm" data-mediaid="{{ $response->id }}" data-price="{{ Helper::formatPrice($response->price, true) }}" data-subtotalprice="{{ Helper::formatPrice($response->price) }}" data-pricegross="{{ $response->price }}" @endif @endguest
                        class="btn btn-primary w-100">
                        @guest
                            {{ __('general.content_locked_user_logged') }}
                        @else
                            @if ($response->status == 'active')
                                <i class="feather icon-unlock mr-1"></i> {{ __('general.unlock_post_for') }}
                                {{ Helper::formatPrice($response->price) }}
                            @else
                                {{ __('general.post_pending_review') }}
                            @endif
                        @endguest
                    </a>
                @else
                    <a href="javascript:void(0);" class="btn btn-primary disabled w-100">
                        {{ __('general.subscription_not_available') }}
                    </a>
                @endif

                <ul class="list-inline mt-3">

                    @if ($mediaCount == 0)
                        <li class="list-inline-item"><i class="bi bi-file-font"></i> {{ __('admin.text') }}</li>
                    @endif

                    @if ($mediaCount != 0)
                        @foreach ($allFiles as $media)
                            @if ($media->type == 'image')
                                <li class="list-inline-item"><i class="feather icon-image"></i>
                                    {{ $countFilesImage }}</li>
                            @endif

                            @if ($media->type == 'video')
                                <li class="list-inline-item"><i class="feather icon-video"></i>
                                    {{ $countFilesVideo }} @if (($media->duration_video && $countFilesVideo == 1) || ($media->quality_video && $countFilesVideo == 1))
                                        <small class="ml-1">
                                            @if ($media->quality_video)
                                                <span class="quality-video">{{ $media->quality_video }}</span>
                                            @endif {{ $media->duration_video }}
                                        </small>
                                    @endif
                                </li>
                            @endif

                            @if ($media->type == 'music')
                                <li class="list-inline-item"><i class="feather icon-mic"></i> {{ $countFilesAudio }}
                                </li>
                            @endif

                            @if ($media->type == 'file')
                                <li class="list-inline-item"><i class="far fa-file-archive"></i>
                                    {{ $media->file_size }}</li>
                            @endif

                            @if ($media->type == 'epub')
                                <li class="list-inline-item"><i class="bi-book"></i> {{ $media->file_size }}</li>
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div><!-- btn-block parent -->
        @endif

        @if ($response->status == 'active')
            <div class="card-footer bg-white border-top-0 rounded-large">
                <h4 class="mb-2">
                    @php
                        $likeActive =
                            auth()->check() &&
                            auth()->user()->likes()->where('updates_id', $response->id)->where('status', '1')->first();
                        $bookmarkActive =
                            auth()->check() && auth()->user()->bookmarks()->where('updates_id', $response->id)->first();

                        if (
                            (auth()->check() && auth()->user()->id == $response->creator->id) ||
                            (auth()->check() &&
                                $response->locked == 'yes' &&
                                $checkUserSubscription &&
                                $response->price == 0.0) ||
                            (auth()->check() &&
                                $response->locked == 'yes' &&
                                $checkUserSubscription &&
                                $response->price != 0.0 &&
                                $checkPayPerView) ||
                            (auth()->check() &&
                                $response->locked == 'yes' &&
                                $response->price != 0.0 &&
                                !$checkUserSubscription &&
                                $checkPayPerView) ||
                            (auth()->check() &&
                                auth()->user()->role == 'admin' &&
                                auth()->user()->permission == 'all') ||
                            (auth()->check() && $response->locked == 'no')
                        ) {
                            $buttonLike = 'likeButton';
                            $buttonBookmark = 'btnBookmark';
                        } else {
                            $buttonLike = null;
                            $buttonBookmark = null;
                        }
                    @endphp

                    <!-- Share modal -->
                    <div class="modal fade" id="sharePost{{ $response->id }}" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <button type="button" class="close close-inherit" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url($response->creator->username . '/post', $response->id) . Helper::referralLink() }}"
                                                    title="Facebook" target="_blank"
                                                    class="social-share text-muted d-block text-center h6">
                                                    <i class="fab fa-facebook-square facebook-btn"></i>
                                                    <span class="btn-block mt-3">Facebook</span>
                                                </a>
                                            </div>
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="https://twitter.com/intent/tweet?url={{ url($response->creator->username . '/post', $response->id) . Helper::referralLink() }}&text={{ e($response->creator->hide_name == 'yes' ? $response->creator->username : $response->creator->name) }}"
                                                    data-url="{{ url($response->creator->username . '/post', $response->id) }}"
                                                    class="social-share text-muted d-block text-center h6"
                                                    target="_blank" title="Twitter">
                                                    <i class="bi-twitter-x text-dark"></i> <span
                                                        class="btn-block mt-3">Twitter</span>
                                                </a>
                                            </div>
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="whatsapp://send?text={{ url($response->creator->username . '/post', $response->id) . Helper::referralLink() }}"
                                                    data-action="share/whatsapp/share"
                                                    class="social-share text-muted d-block text-center h6"
                                                    title="WhatsApp">
                                                    <i class="fab fa-whatsapp btn-whatsapp"></i> <span
                                                        class="btn-block mt-3">WhatsApp</span>
                                                </a>
                                            </div>

                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="sms:?&body={{ __('general.check_this') }} {{ url($response->creator->username . '/post', $response->id) . Helper::referralLink() }}"
                                                    class="social-share text-muted d-block text-center h6"
                                                    title="{{ __('general.sms') }}">
                                                    <i class="fa fa-sms"></i> <span
                                                        class="btn-block mt-3">{{ __('general.sms') }}</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal share -->

                    @auth
                        @if (
                            (auth()->user()->id != $response->creator->id &&
                                $checkUserSubscription &&
                                $response->price == 0.0 &&
                                $settings->disable_tips == 'off') ||
                                (auth()->user()->id != $response->creator->id &&
                                    $checkUserSubscription &&
                                    $response->price != 0.0 &&
                                    $checkPayPerView &&
                                    $settings->disable_tips == 'off') ||
                                (auth()->check() &&
                                    $response->locked == 'yes' &&
                                    $response->price != 0.0 &&
                                    !$checkUserSubscription &&
                                    $checkPayPerView &&
                                    $settings->disable_tips == 'off') ||
                                (auth()->user()->id != $response->creator->id && $response->locked == 'no' && $settings->disable_tips == 'off'))
                            <a href="javascript:void(0);" data-toggle="modal" title="{{ __('general.tip') }}"
                                data-target="#tipForm" class="pulse-btn text-muted text-decoration-none"
                                @auth data-id="{{ $response->id }}" data-cover="{{ Helper::getFile(config('path.cover') . $response->creator->cover) }}" data-avatar="{{ Helper::getFile(config('path.avatar') . $response->creator->avatar) }}" data-name="{{ $response->creator->hide_name == 'yes' ? $response->creator->username : $response->creator->name }}" data-userid="{{ $response->creator->id }}" @endauth>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                                    <path fill-rule="evenodd"
                                        d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path fill-rule="evenodd"
                                        d="M8 13.5a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                </svg>

                                <h6 class="d-inline font-weight-lighter">@lang('general.tip')</h6>
                            </a>
                        @endif
                    @endauth
                </h4>

                <div class="w-100 mb-3 containerLikeComment d-flex justify-content-between">
                    <div>
                        <a class="pulse-btn btnLike @if ($likeActive) active @endif {{ $buttonLike }} text-muted mr-8px"
                            href="javascript:void(0);"
                            @guest data-toggle="modal" data-target="#loginFormModal" @endguest
                            @auth data-id="{{ $response->id }}" @endauth>
                            <span class="countLikes text-muted ml-1"
                                style="font-size: 16px; color: #475467 !important;">
                                {{ $totalLikes }}
                            </span>
                            <i class="@if ($likeActive) fas @else far @endif fa-heart"
                                style="font-size: 16px; color: #475467;"></i>
                        </a>

                        <span class="text-muted totalComments mr-8px open-comment-popup"
                            data-post-id="{{ $response->id }}" style="cursor: pointer;">
                            <span class="count ml-1"
                                style="font-size: 16px; color: #475467">{{ number_format($totalComments) }}</span>
                            <i class="far fa-comment" style="font-size: 16px; color: #475467"></i>
                        </span>

                        <a class="pulse-btn text-muted text-decoration-none mr-14px" href="javascript:void(0);"
                            title="{{ __('general.share') }}" data-toggle="modal"
                            data-target="#sharePost{{ $response->id }}">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        </a>

                        @if ($response->video_views)
                            <span class="text-muted ">
                                <i class="bi-play mr-1"></i> {{ Helper::formatNumber($response->video_views) }}
                            </span>
                        @endif
                    </div>
                    <a href="javascript:void(0);" @guest data-toggle="modal" data-target="#loginFormModal" @endguest
                        class="pulse-btn @if ($bookmarkActive) text-primary @else text-muted @endif float-right {{ $buttonBookmark }}"
                        @auth data-id="{{ $response->id }}" @endauth>
                        <i class="@if ($bookmarkActive) fas @else far @endif fa-bookmark"
                            style="color: #475467; font-size: 20px;"></i>
                    </a>
                </div>

                @auth

                    <!-- Comment Popup Modal -->
                    <div class="comment-popup-overlay" id="commentPopup{{ $response->id }}">
                        <div class="comment-popup">
                            {{-- <div class="comment-popup-header">
                                <h3>Comments <span style="color: #6B7280;">({{ $totalComments }})</span></h3>
                                <button class="close-popup" data-post-id="{{ $response->id }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div> --}}

                            <div class="comment-popup-body custom-scrollbar">

                                <!-- Comment Input Section at Top -->
                                @if (!auth()->user()->checkRestriction($response->creator->id) && $response->creator->allow_comments)
                                    <div class="comment-input-section">
                                        {{-- <h4>Add comment</h4> --}}

                                        <div class="alert alert-danger alert-small dangerAlertComments display-none mb-3">
                                            <ul class="list-unstyled m-0 showErrorsComments"></ul>
                                        </div>

                                        <div class="isReplyTo display-none w-100 bg-white border py-2 px-3 mb-3 rounded">
                                            {{ __('general.replying_to') }} <span class="username-reply"></span>
                                            <span class="float-right c-pointer cancelReply"
                                                title="{{ __('admin.cancel') }}">
                                                <i class="bi-x-lg"></i>
                                            </span>
                                        </div>

                                        <form action="{{ url('comment/store') }}" method="post" class="comments-form">
                                            @csrf
                                            <input type="hidden" name="update_id" value="{{ $response->id }}" />
                                            <input class="isReply" type="hidden" name="isReply" value="" />
                                            <input class="sticker" type="hidden" name="sticker" value="" />
                                            <input class="gif_image" type="hidden" name="gif_image" value="" />

                                            <div class="comment-input-wrapper-new">
                                                <textarea name="comment" class="form-control comments inputComment emojiArea" autocomplete="off"
                                                    placeholder="Add comment..." rows="3"></textarea>

                                                <div class="comment-input-toolbar">
                                                    <div class="comment-input-tools">
                                                        <button type="button" title="Bold"><i
                                                                class="bi bi-type-bold"></i></button>
                                                        <button type="button" title="Italic"><i
                                                                class="bi bi-type-italic"></i></button>
                                                        <button type="button" title="Heading"><i
                                                                class="bi bi-type-h1"></i></button>
                                                        <button type="button" title="Quote"><i
                                                                class="bi bi-quote"></i></button>
                                                        <button type="button" title="Link"><i
                                                                class="bi bi-link-45deg"></i></button>
                                                        <button type="button" title="Image"><i
                                                                class="bi bi-image"></i></button>
                                                        <button type="button" title="List"><i
                                                                class="bi bi-list-ul"></i></button>
                                                        <button type="button" title="Numbered List"><i
                                                                class="bi bi-list-ol"></i></button>

                                                        @if ($settings->giphy_status)
                                                            <div class="dropdown d-inline">
                                                                <button type="button" class="triggerGif" title="GIF"
                                                                    id="dropdownGifPopup{{ $response->id }}"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="bi-filetype-gif"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right dropdown-emoji dropdown-gifs custom-scrollbar"
                                                                    aria-labelledby="dropdownGifPopup{{ $response->id }}">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="dropdown d-inline">
                                                            <button type="button" class="triggerSticker" title="Sticker"
                                                                id="dropdownStickyPopup{{ $response->id }}"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="bi-sticky"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-emoji dropdown-stickers custom-scrollbar"
                                                                aria-labelledby="dropdownStickyPopup{{ $response->id }}">
                                                            </div>
                                                        </div>

                                                        <div class="dropdown d-inline">
                                                            <button type="button" class="triggerEmoji" title="Emoji"
                                                                data-toggle="dropdown">
                                                                <i class="bi-emoji-smile"></i>
                                                            </button>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-emoji custom-scrollbar">
                                                                @include('includes.emojis')
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="comment-submit-btn">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3
                                            style="display: flex; align-items: center; gap: 12px; font-size: 24px; color: #101828; font-weight: 600 !important;">
                                            Comments <button type="submit"
                                                class="total-comments-btn">{{ $totalComments }}</button> </h3>
                                    </div>
                                    <div>
                                        <div class="comment-sort">
                                            <img src="/images/updown-arrow.png" alt="">
                                            <span>Most Recent</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comments List Section -->
                                <div class="comments-list-section">
                                    <div class="container-media">
                                        @if ($response->comments->count() != 0)
                                            @php
                                                $comments = $response
                                                    ->comments()
                                                    ->with([
                                                        'user:id,name,username,avatar,hide_name,verified_id',
                                                        'replies',
                                                        'likes',
                                                    ])
                                                    ->take($settings->number_comments_show)
                                                    ->orderBy('id', 'DESC')
                                                    ->get();

                                                $data = [];
                                                if ($comments->count()) {
                                                    $data['reverse'] = collect($comments->values())->reverse();
                                                } else {
                                                    $data['reverse'] = $comments;
                                                }
                                                $dataComments = $data['reverse'];
                                                $counter =
                                                    $response->comments()->count() - $settings->number_comments_show;
                                            @endphp

                                            @if (auth()->user()->id == $response->creator->id ||
                                                    ($response->locked == 'yes' && $checkUserSubscription && $response->price == 0.0) ||
                                                    ($response->locked == 'yes' && $checkUserSubscription && $response->price != 0.0 && $checkPayPerView) ||
                                                    (auth()->check() &&
                                                        $response->locked == 'yes' &&
                                                        $response->price != 0.0 &&
                                                        !$checkUserSubscription &&
                                                        $checkPayPerView) ||
                                                    (auth()->user()->role == 'admin' && auth()->user()->permission == 'all') ||
                                                    $response->locked == 'no')
                                                @include('includes.comments')
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                @endauth
            </div><!-- card-footer -->
        @endif
    </div><!-- card -->

    @if (
        (request()->is('/') && $loop->first && $users->count() != 0) ||
            (request()->is('explore') && $loop->first && $users->count() != 0) ||
            (request()->is('my/bookmarks') && $loop->first && $users->count() != 0) ||
            (request()->is('my/purchases') && $loop->first && $users->count() != 0) ||
            (request()->is('my/likes') && $loop->first && $users->count() != 0))
        <div class="p-3 d-lg-none">
            @include('includes.explore_creators')
        </div>
    @endif

@endforeach

@if (!isset($singlePost))
    <div class="card mb-3 pb-4 loadMoreSpin d-none rounded-large shadow-large">
        <div class="card-body">
            <div class="media">
                <span class="rounded-circle mr-3">
                    <span class="item-loading position-relative loading-avatar"></span>
                </span>
                <div class="media-body">
                    <h5 class="mb-0 item-loading position-relative loading-name"></h5>
                    <small class="text-muted item-loading position-relative loading-time"></small>
                </div>
            </div>
        </div>
        <div class="card-body pt-0 pb-3">
            <p class="mb-1 item-loading position-relative loading-text-1"></p>
            <p class="mb-1 item-loading position-relative loading-text-2"></p>
            <p class="mb-0 item-loading position-relative loading-text-3"></p>
        </div>
    </div>
@endif

@php
    if (request()->ajax()) {
        $getHasPages = $updates->count() < $settings->number_posts_show ? false : true;
    } else {
        if (request()->route()->named('profile')) {
            $getHasPages = $updates->count() < $settings->number_posts_show ? false : true;
        } else {
            $getHasPages = $hasPages ?? null;
        }
    }
@endphp

@if ($getHasPages)
    <button rel="next" class="btn btn-primary w-100 text-center loadPaginator d-none" id="paginator">
        {{ __('general.loadmore') }}
    </button>
@endif

<script>
    function timeAgo(date) {
        const seconds = Math.floor((new Date() - new Date(date)) / 1000);

        const intervals = [{
                label: 'year',
                seconds: 31536000
            },
            {
                label: 'month',
                seconds: 2592000
            },
            {
                label: 'week',
                seconds: 604800
            },
            {
                label: 'day',
                seconds: 86400
            },
            {
                label: 'hour',
                seconds: 3600
            },
            {
                label: 'minute',
                seconds: 60
            },
            {
                label: 'second',
                seconds: 1
            }
        ];

        for (const interval of intervals) {
            const count = Math.floor(seconds / interval.seconds);
            if (count > 0) {
                return `${count} ${interval.label}${count !== 1 ? 's' : ''} ago`;
            }
        }
        return "just now";
    }

    document.querySelectorAll('.post-time').forEach(el => {
        const time = el.getAttribute('data-time');
        el.textContent = timeAgo(time);
    });

    // Comment Popup Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Open comment popup
        document.querySelectorAll('.open-comment-popup').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const postId = this.getAttribute('data-post-id');
                const popup = document.getElementById('commentPopup' + postId);
                if (popup) {
                    popup.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });
        // Add this to your existing <script> section in the new code (document 2)
        // Place it inside the DOMContentLoaded event listener

        // Reply button functionality for popup comments
        document.addEventListener('click', function(e) {
            // Handle Reply Button Click
            if (e.target.classList.contains('replyButton') || e.target.closest('.replyButton')) {
                const btn = e.target.classList.contains('replyButton') ? e.target : e.target.closest(
                    '.replyButton');
                const commentId = btn.getAttribute('data');
                const username = btn.getAttribute('data-username');

                // Find the parent popup or comment container
                const popup = btn.closest('.comment-popup-overlay');

                if (popup) {
                    // Find the form within this popup
                    const form = popup.querySelector('.comments-form');
                    const isReplyInput = form.querySelector('.isReply');
                    const isReplyToDiv = popup.querySelector('.isReplyTo');
                    const usernameSpan = popup.querySelector('.username-reply');
                    const textarea = form.querySelector('textarea[name="comment"]');

                    // Set the reply ID
                    if (isReplyInput) {
                        isReplyInput.value = commentId;
                    }

                    // Show the "Replying to" indicator
                    if (isReplyToDiv) {
                        isReplyToDiv.classList.remove('display-none');
                    }

                    // Set the username
                    if (usernameSpan) {
                        usernameSpan.textContent = username;
                    }

                    // Focus on textarea and optionally add @username
                    if (textarea) {
                        textarea.focus();
                        // Optionally prepend @username to the comment
                        if (textarea.value === '' || !textarea.value.includes(username)) {
                            textarea.value = username + ' ';
                        }
                    }

                    // Scroll to the input section
                    const inputSection = popup.querySelector('.comment-input-section');
                    if (inputSection) {
                        inputSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            }

            // Handle Cancel Reply Click
            if (e.target.classList.contains('cancelReply') || e.target.closest('.cancelReply')) {
                const btn = e.target.classList.contains('cancelReply') ? e.target : e.target.closest(
                    '.cancelReply');
                const popup = btn.closest('.comment-popup-overlay');

                if (popup) {
                    const form = popup.querySelector('.comments-form');
                    const isReplyInput = form.querySelector('.isReply');
                    const isReplyToDiv = popup.querySelector('.isReplyTo');
                    const textarea = form.querySelector('textarea[name="comment"]');

                    // Clear the reply ID
                    if (isReplyInput) {
                        isReplyInput.value = '';
                    }

                    // Hide the "Replying to" indicator
                    if (isReplyToDiv) {
                        isReplyToDiv.classList.add('display-none');
                    }

                    // Clear textarea
                    if (textarea) {
                        textarea.value = '';
                        textarea.focus();
                    }
                }
            }
        });

        // Handle "View Replies" / "Load Replies" functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('showReplies') || e.target.closest('.showReplies')) {
                const btn = e.target.classList.contains('showReplies') ? e.target : e.target.closest(
                    '.showReplies');
                const commentId = btn.getAttribute('data');
                const repliesContainer = document.querySelector('.container-replies' + commentId);

                if (repliesContainer) {
                    // Toggle visibility
                    if (repliesContainer.classList.contains('display-none')) {
                        repliesContainer.classList.remove('display-none');
                        btn.innerHTML = btn.innerHTML.replace('View', 'Hide');
                    } else {
                        repliesContainer.classList.add('display-none');
                        btn.innerHTML = btn.innerHTML.replace('Hide', 'View');
                    }
                }
            }
        });

        // Handle "Load More Comments" functionality in popup
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('loadMoreComments') || e.target.closest(
                '.loadMoreComments')) {
                const btn = e.target.classList.contains('loadMoreComments') ? e.target : e.target
                    .closest('.loadMoreComments');
                const wrapContainer = btn.closest('.wrap-container');

                if (wrapContainer) {
                    const postId = wrapContainer.getAttribute('data-id');
                    const total = wrapContainer.getAttribute('data-total');
                    const counter = wrapContainer.querySelector('.counter');
                    const currentCount = parseInt(counter.textContent);

                    // Make AJAX call to load more comments
                    fetch('/load/comments/' + postId + '?skip=' + (total - currentCount), {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.html) {
                                // Insert new comments before the "load more" button
                                wrapContainer.insertAdjacentHTML('beforebegin', data.html);

                                // Update counter or hide button
                                if (data.remaining <= 0) {
                                    wrapContainer.style.display = 'none';
                                } else {
                                    counter.textContent = data.remaining;
                                }

                                // Re-initialize timeAgo for new comments
                                document.querySelectorAll('.timeAgo').forEach(el => {
                                    const time = el.getAttribute('data');
                                    if (time) {
                                        el.textContent = timeAgo(time);
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error loading comments:', error);
                        });
                }
            }
        });

        // Close comment popup
        document.querySelectorAll('.close-popup').forEach(btn => {
            btn.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const popup = document.getElementById('commentPopup' + postId);
                if (popup) {
                    popup.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Close on overlay click
        document.querySelectorAll('.comment-popup-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Auto-resize textarea
        document.querySelectorAll('.comment-input-container textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        });

        // Close popup on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.comment-popup-overlay.active').forEach(popup => {
                    popup.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
        });

        // Handle comment form submission via AJAX
        document.querySelectorAll('.comments-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const postId = formData.get('update_id');
                const submitButton = this.querySelector('.submit-comment');
                const textarea = this.querySelector('textarea[name="comment"]');
                const containerMedia = document.querySelector('#commentPopup' + postId +
                    ' .container-media');
                const totalCommentsElement = document.querySelector('#commentPopup' + postId +
                    ' .comment-popup-header span');
                const totalCommentsCount = document.querySelector('.card[data="' + postId +
                    '"] .totalComments .count');

                // Disable submit button
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Posting...';
                }

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear textarea and reset height
                            textarea.value = '';
                            textarea.style.height = 'auto';

                            // Clear hidden fields
                            form.querySelector('.isReply').value = '';
                            form.querySelector('.sticker').value = '';
                            form.querySelector('.gif_image').value = '';

                            // Hide reply indicator if showing
                            const replyIndicator = form.closest('.comment-popup-footer')
                                .querySelector('.isReplyTo');
                            if (replyIndicator && !replyIndicator.classList.contains(
                                    'display-none')) {
                                replyIndicator.classList.add('display-none');
                            }

                            // Add new comment HTML from API response
                            if (containerMedia && data.data) {
                                containerMedia.insertAdjacentHTML('beforeend', data.data);

                                // Initialize timeAgo for new comment
                                const newComment = containerMedia.lastElementChild;
                                if (newComment) {
                                    const timeElement = newComment.querySelector(
                                        '.timeAgo');
                                    if (timeElement) {
                                        const timeData = timeElement.getAttribute('data');
                                        if (timeData) {
                                            timeElement.textContent = timeAgo(timeData);
                                        }
                                    }
                                }
                            }

                            // Update comment count
                            if (totalCommentsCount && data.total) {
                                totalCommentsCount.textContent = parseInt(data.total)
                                    .toLocaleString();
                                if (totalCommentsElement) {
                                    totalCommentsElement.textContent = '(' + data.total +
                                        ')';
                                }
                            }

                            // Scroll to new comment
                            if (containerMedia) {
                                containerMedia.scrollTop = containerMedia.scrollHeight;
                            }

                        } else {
                            // Show error
                            const errorAlert = form.closest('.comment-popup-footer')
                                .querySelector('.dangerAlertComments');
                            const errorList = errorAlert.querySelector(
                                '.showErrorsComments');
                            errorList.innerHTML = '<li>' + (data.message ||
                                'Failed to add comment') + '</li>';
                            errorAlert.classList.remove('display-none');

                            setTimeout(() => {
                                errorAlert.classList.add('display-none');
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const errorAlert = form.closest('.comment-popup-footer')
                            .querySelector('.dangerAlertComments');
                        const errorList = errorAlert.querySelector('.showErrorsComments');
                        errorList.innerHTML =
                            '<li>Something went wrong. Please try again.</li>';
                        errorAlert.classList.remove('display-none');

                        setTimeout(() => {
                            errorAlert.classList.add('display-none');
                        }, 3000);
                    })
                    .finally(() => {
                        // Re-enable submit button
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = 'Submit';
                        }
                    });
            });
        });
    });
</script>
