@extends('layouts.app')

@section('title'){{__('general.notifications')}} -@endsection

<style>
  .notification-center {
    margin: 0 auto;
    padding: 40px 20px;
  }

  .notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .notification-header h1 {
    font-size: 32px;
    font-weight: 600 !important;
    color: #101828;
    margin: 0;
  }

  .mark-read-btn {
    background: #4A90E2;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background 0.3s;
  }

  .mark-read-btn:hover {
    background: #3a7bc8;
  }

  .mark-read-btn i {
    font-size: 16px;
  }

  .notifications-wrapper {
    display: flex;
    gap: 30px;
    align-items: start;
  }

  .notifications-list {
    flex: 1;
    min-width: 0;
  }

  .notification-item {
    padding: 20px 0;
    margin-bottom: 12px;
    display: flex;
    align-items: start;
    gap: 15px;
    position: relative;
    transition: box-shadow 0.3s;
    border-bottom: 1px solid #E5E5E5;
  }

  .notification-item.unread::before {
    content: '';
    position: absolute;
    right: 20px;
    top: 20%;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    background: #4A90E2;
    border-radius: 50%;
  }

  .notification-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    flex-shrink: 0;
    object-fit: cover;
  }

  .notification-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .notification-icon-wrapper i,
  .notification-icon-wrapper svg {
    font-size: 24px;
    color: #666;
  }

  .notification-content {
    flex: 1;
    min-width: 0;
  }

  .notification-user {
    font-weight: 600;
    color: #101828;
    text-decoration: none;
    font-size: 20px;
  }

  .notification-user:hover {
    text-decoration: underline;
  }

  .notification-time {
    color: #475467;
    font-size: 16px;
    margin-left: 8px;
  }

  .notification-text {
    color: #475467;
    font-size: 16px;
    margin: 4px 0 0 0;
    line-height: 1.5;
  }

  .notification-link {
    color: #475467;
    text-decoration: none;
    font-size: 16px;
  }

  .type-filter-sidebar {
    width: 250px;
    padding: 20px;
    flex-shrink: 0;
    position: sticky;
    top: 20px;
  }

  .type-filter-sidebar h3 {
    font-size: 18px;
    font-weight: 600;
    color: #000;
    margin: 0 0 20px 0;
  }

  .filter-option {
    display: flex;
    align-items: center;
    padding: 6px 0;
  }

  .filter-checkbox {
    width: 18px;
    height: 18px;
    border: 2px solid #d0d0d0;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 12px;
    flex-shrink: 0;
  }

  .filter-checkbox:checked {
    background-color: #4A90E2;
    border-color: #4A90E2;
  }

  .filter-label {
    color: #475467;
    font-size: 16px;
    font-weight: 400;
    cursor: pointer;
    user-select: none;
  }

  .no-notifications {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
  }

  .no-notifications i {
    font-size: 64px;
    color: #d0d0d0;
    margin-bottom: 20px;
  }

  .no-notifications h4 {
    color: #666;
    font-weight: 400;
    font-size: 18px;
  }

  .pagination {
    margin-top: 30px;
    display: flex;
    justify-content: center;
  }

  /* Utilities */
  .context-noty {
    font-weight: 600;
    color: #4A90E2;
  }

  /* Old dropdown filter - hide it */
  .btn-block.text-right {
    display: none;
  }

  .filter-label {
    margin: 0;
    padding: 0;
  }

  /* Responsive */
  @media (max-width: 992px) { 
    .notifications-wrapper {
      flex-direction: column-reverse;
    }

    .type-filter-sidebar {
      width: 100%;
      position: static;
    }

    .notification-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 15px;
    }
  }

  @media (max-width: 576px) {
    .notification-item {
      padding: 15px;
    }

    .notification-avatar,
    .notification-icon-wrapper {
      width: 40px;
      height: 40px;
    }
  }
</style>

@section('content')
<section class="section section-sm">
  <div class="notification-center">
    <div class="notification-header">
      <h1>{{__('general.notifications')}}</h1>
      
      <div style="display: flex; gap: 10px; align-items: center;">
        {{-- <a href="javascript:;" class="btn-notify" data-toggle="modal" data-target="#notifications" style="font-size: 20px; color: #666;">
          <i class="fa fa-cog"></i>
        </a> --}}

        {{-- @if (count($notifications) != 0)
          <form method="POST" action="{{ url('notifications/delete') }}" class="d-inline">
            @csrf
            <button type="submit" class="actionDeleteNotify" style="background: none; border: none; font-size: 20px; color: #666; cursor: pointer; padding: 5px;">
              <i class="fa fa-trash-alt"></i>
            </button>
          </form>
        @endif --}}
        <button class="btn btn-sm d-flex" style="padding-left: 16px;padding-right: 16px;padding-top: 10px;padding-bottom: 10px; font-weight: 600; background: {{ $settings->theme_color_pwa ?? '#469DFA' }}; color: white; font-size: 14px; gap: 10px; align-items: center;">
          <img src="/svgs/eye.svg" alt="">
          Mark all as Read
        </button>
      </div>
    </div>

    <div class="notifications-wrapper">
      <div class="notifications-list">
        @if ($notifications->total() != 0)
          @foreach ($notifications as $key)
            <?php
              $postUrl = $key->id ? url($key->usernameAuthor, ['post', $key->id ]) : null;
              $notyNormal = true;
              $isReel = false;

              switch ($key->type) {
                case 1:
                  $action          = __('users.has_subscribed');
                  $linkDestination = false;
                  break;
                case 2:
                  $action          = __('users.like_you');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  break;
                case 3:
                  $action          = __('users.comment_you');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  break;
                case 4:
                  $action          = __('general.liked_your_comment');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  break;
                case 5:
                  $action          = __('general.he_sent_you_tip');
                  $linkDestination = url('my/payments/received');
                  $text_link       = __('general.tip');
                  break;
                case 6:
                  $action          = __('general.has_bought_your_message');
                  $linkDestination = url('messages', $key->userId);
                  $text_link       = Str::limit($key->message, 50, '...');
                  break;
                case 7:
                  $action          = __('general.has_bought_your_content');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  break;
                case 8:
                  $action          = __('general.has_approved_your_post');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  $iconNotify      = 'bi bi-check2-circle';
                  $notyNormal      = false;
                  break;
                case 9:
                  $action          = __('general.video_processed_successfully_post');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  $iconNotify      = 'bi bi-play-circle';
                  $notyNormal      = false;
                  break;
                case 10:
                  $action          = __('general.video_processed_successfully_message');
                  $linkDestination = url('messages', $key->userDestination);
                  $text_link       = Str::limit($key->message, 50, '...');
                  $iconNotify       = 'bi bi-play-circle';
                  $notyNormal      = false;
                  break;
                case 11:
                  $action          = __('general.referrals_made');
                  $linkDestination = url('my/referrals');
                  $text_link       = __('general.transaction');
                  $iconNotify      = 'bi bi-person-plus';
                  $notyNormal = false;
                  break;
                case 12:
                  $action          = __('general.payment_received_subscription_renewal');
                  $linkDestination = url('my/payments/received');
                  $text_link       = __('general.go_payments_received');
                  break;
                case 13:
                  $action          = __('general.has_changed_subscription_paid');
                  $linkDestination = url($key->username);
                  $text_link       = __('general.subscribe_now');
                  break;
                case 14:
                  $isLive          = Helper::liveStatus($key->target);
                  $action          = $isLive ? __('general.is_streaming_live') : __('general.streamed_live');
                  $linkDestination = url('live', $key->username);
                  $text_link       = $isLive ? __('general.go_live_stream') : null;
                  break;
                case 15:
                  $action          = __('general.has_bought_your_item');
                  $linkDestination = url('my/sales');
                  $text_link       = Str::limit($key->productName, 50, '...');
                  break;
                case 16:
                  $action          = __('general.has_mentioned_you');
                  $linkDestination = $postUrl;
                  $text_link       = Str::limit($key->description, 50, '...');
                  break;
                case 17:
                  $action          = __('general.story_successfully_posted');
                  $linkDestination = url('/');
                  $text_link       = __('general.see_story');
                  $iconNotify      = 'bi-clock-history';
                  $notyNormal      = false;
                  break;
                case 18:
                  $action          = __('general.body_account_verification_approved');
                  $linkDestination = false;
                  $iconNotify      = 'bi-star';
                  $notyNormal      = false;
                  break;
                case 19:
                  $action          = __('general.body_account_verification_reject');
                  $linkDestination = false;
                  $iconNotify      = 'bi-exclamation-triangle';
                  $notyNormal      = false;
                  break;
                case 20:
                  $action          = __('general.error_video_encoding_post');
                  $linkDestination = false;
                  $iconNotify      = 'bi-bug';
                  $notyNormal      = false;
                  break;
                case 21:
                  $action          = __('general.error_video_encoding_message');
                  $linkDestination = false;
                  $iconNotify      = 'bi-bug';
                  $notyNormal      = false;
                  break;
                case 22:
                  $action          = __('general.error_video_encoding_story');
                  $linkDestination = false;
                  $iconNotify      = 'bi-bug';
                  $notyNormal      = false;
                  break;
                case 23:
                  $action          = __('general.has_sent_private_live_stream_request');
                  $linkDestination = url('my/live/private/requests');
                  $text_link       = __('general.go_received_requests');
                  break;
                case 24:
                  $action          = __('general.video_processed_successfully_welcome_message');
                  $linkDestination = url('settings/conversations');
                  $text_link       = __('general.go_to_conversations');
                  $iconNotify       = 'bi bi-play-circle';
                  $notyNormal      = false;
                  break;
                case 25:
                  $action          = __('general.error_video_encoding_welcome_msg');
                  $linkDestination = false;
                  $iconNotify      = 'bi-bug';
                  $notyNormal      = false;
                  break;
                case 26:
                  $action          = __('general.he_sent_you_tip');
                  $linkDestination = url('my/payments/received');
                  $text_link       = __('general.gift');
                  break;
                case 27:
                  $action          = __('general.reel_successfully_posted');
                  $linkDestination = route('reels.section.show', $key->target);
                  $text_link       = __('general.go_to_reel');
                  $isReel          = true;
                  $notyNormal      = false;
                  break;
                case 28:
                  $action          = __('general.error_video_encoding_reel');
                  $linkDestination = false;
                  $iconNotify      = 'bi-bug';
                  $notyNormal      = false;
                  break;
                case 29:
                  $action          = __('general.liked_your_reel');
                  $linkDestination = route('reels.section.show', $key->target);
                  $text_link       = __('general.go_to_reel');
                  break;
                case 30:
                  $action          = __('general.commented_your_reel');
                  $linkDestination = route('reels.section.show', $key->target);
                  $text_link       = __('general.go_to_reel');
                  break;
                case 31:
                  $action          = __('general.has_mentioned_you_reel');
                  $linkDestination = route('reels.section.show', $key->target);
                  $text_link       = __('general.go_to_reel');
                  break;
                case 32:
                  $action          = __('general.liked_your_comment_reel');
                  $linkDestination = route('reels.section.show', $key->target);
                  $text_link       = __('general.go_to_reel');
                  break;
                case 33:
                  $action          = __('general.content_blocked_moderation', ['name' => '<span class="context-noty">' . $key->context . '</span>']);
                  $linkDestination = false;
                  $iconNotify      = 'bi-shield-x';
                  $notyNormal      = false;
                  break;
                case 34:
                  $action          = __('general.error_moderation_file', ['name' => '<span class="context-noty">' . $key->context . '</span>']);
                  $linkDestination = false;
                  $iconNotify      = 'bi-shield-exclamation';
                  $notyNormal      = false;
                  break;
                case 35:
                  $action          = __('general.video_processed_successfully_vault', ['name' => '<span class="context-noty">' . $key->context . '</span>']);
                  $linkDestination = false;
                  $iconNotify      = 'bi-play-circle';
                  $notyNormal      = false;
                  break;
                case 36:
                  $action          = __('general.error_video_encoding_vault', ['name' => '<span class="context-noty">' . $key->context . '</span>']);
                  $linkDestination = false;
                  $iconNotify      = 'bi-bug';
                  $notyNormal      = false;
              }
            ?>

            <div class="notification-item unread">
              @if ($notyNormal)
                <a href="{{url($key->username)}}">
                  <img src="{{Helper::getFile(config('path.avatar').$key->avatar)}}" class="notification-avatar" alt="{{$key->name}}">
                </a>
              @else
                <div class="notification-icon-wrapper">
                  @if ($isReel)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="24" height="24" viewBox="0 0 50 50">
                      <path d="M15 4C8.94 4 4 8.94 4 15v20c0 6.06 4.94 11 11 11h20c6.06 0 11-4.94 11-11V15c0-6.06-4.94-11-11-11H15zM16.74 6h10.69L33.26 16H22.57L16.74 6zM29.74 6H35c4.98 0 9 4.02 9 9v1h-8.43L29.74 6zM14.49 6.1L20.26 16H6v-1c0-4.8 3.76-8.62 8.49-8.9zM6 18h38v17c0 4.98-4.02 9-9 9H15c-4.98 0-9-4.02-9-9V18zm15.98 5.01c-1.54.04-2.98 1.26-2.98 2.95v9.08c0 2.25 2.55 3.67 4.51 2.56l7.99-4.54c1.94-1.1 1.94-4.01 0-5.12l-7.99-4.54a2.68 2.68 0 0 0-1.53-.35z"></path>
                    </svg>
                  @else
                    <i class="{{ $iconNotify }}"></i>
                  @endif
                </div>
              @endif

              <div class="notification-content">
                <div>
                  @if ($notyNormal)
                    <a href="{{url($key->username)}}" class="notification-user">
                      {{$key->hide_name == 'yes' ? $key->username : $key->name}}
                    </a>
                  @else
                    <span class="notification-user">System</span>
                  @endif
                  <span class="notification-time timeAgo" data="{{date('c', strtotime($key->created_at))}}"></span>
                </div>
                <p class="notification-text">
                  <p class="notification-link">Commented your post <span style="color: #469DFA; font-weight: 600 !important; font-size: 16px;">“Fasting is a not a habit - it’s a style of life”</span></p>
                  {{-- {!! $action !!} --}}
                  @if ($linkDestination != false)
                    <a href="{{url($linkDestination)}}" class="notification-link">{{$text_link}}</a>
                  @endif
                </p>
              </div>
            </div>
          @endforeach

          @if ($notifications->hasPages())
            <div class="pagination">
              {{ $notifications->onEachSide(0)->appends(['sort' => request('sort')])->links() }}
            </div>
          @endif

        @else
          <div class="no-notifications">
            <i class="far fa-bell-slash"></i>
            <h4>{{__('general.no_notifications')}}</h4>
          </div>
        @endif
      </div>

      @if ($notifications->total() != 0)
        <div class="type-filter-sidebar">
          <h3>Type:</h3>
          @php $currentSort = request()->get('sort'); @endphp

          <div class="filter-option">
            <input class="filter-checkbox" type="checkbox" id="likes" value="likes" {{ $currentSort == 'likes' ? 'checked' : '' }}>
            <label class="filter-label" for="likes">Likes</label>
          </div>

          <div class="filter-option">
            <input class="filter-checkbox" type="checkbox" id="subscriptions" value="subscriptions" {{ $currentSort == 'subscriptions' ? 'checked' : '' }}>
            <label class="filter-label" for="subscriptions">Subscriptions</label>
          </div>

          <div class="filter-option">
            <input class="filter-checkbox" type="checkbox" id="mentions" value="mentions" {{ $currentSort == 'mentions' ? 'checked' : '' }}>
            <label class="filter-label" for="mentions">Mentions</label>
          </div>

          <div class="filter-option">
            <input class="filter-checkbox" type="checkbox" id="comments" value="comments" {{ $currentSort == 'comments' ? 'checked' : '' }}>
            <label class="filter-label" for="comments">Comments</label>
          </div>

          <div class="filter-option">
            <input class="filter-checkbox" type="checkbox" id="post_threads" value="post_threads" {{ $currentSort == 'post_threads' ? 'checked' : '' }}>
            <label class="filter-label" for="post_threads">Post Threads</label>
          </div>

          <div class="filter-option">
            <input class="filter-checkbox" type="checkbox" id="system_updates" value="system_updates" {{ $currentSort == 'system_updates' ? 'checked' : '' }}>
            <label class="filter-label" for="system_updates">System Updates</label>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        checkboxes.forEach(cb => { if (cb !== this) cb.checked = false; });
        const value = this.checked ? this.value : '';
        const baseUrl = "{{ url('notifications') }}";
        window.location.href = value ? `${baseUrl}?sort=${value}` : baseUrl;
      });
    });
  });
</script>

{{-- Settings Modal - Keep exactly as is --}}
<div class="modal fade" id="notifications" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card bg-white shadow border-0">
          <div class="card-body px-lg-5 py-lg-5">
            <div class="mb-3">
              <h6 class="position-relative">{{__('general.receive_notifications_when')}}
                <small data-dismiss="modal" class="btn-cancel-msg"><i class="bi bi-x-lg"></i></small>
              </h6>
            </div>

            <form method="POST" action="{{ url('notifications/settings') }}" id="form">
              @csrf

              @if (auth()->user()->verified_id == 'yes')
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_new_subscriber" value="yes" @if (auth()->user()->notify_new_subscriber == 'yes') checked @endif id="customSwitch1">
                <label class="custom-control-label switch" for="customSwitch1">{{ __('general.someone_subscribed_content') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_liked_post" value="yes" @if (auth()->user()->notify_liked_post == 'yes') checked @endif id="customSwitch2">
                <label class="custom-control-label switch" for="customSwitch2">{{ __('general.someone_liked_post') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_commented_post" value="yes" @if (auth()->user()->notify_commented_post == 'yes') checked @endif id="customSwitch3">
                <label class="custom-control-label switch" for="customSwitch3">{{ __('general.someone_commented_post') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_new_tip" value="yes" @if (auth()->user()->notify_new_tip == 'yes') checked @endif id="customSwitch5">
                <label class="custom-control-label switch" for="customSwitch5">{{ __('general.someone_sent_tip') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_new_ppv" value="yes" @if (auth()->user()->notify_new_ppv == 'yes') checked @endif id="customSwitch9">
                <label class="custom-control-label switch" for="customSwitch9">{{ __('general.someone_bought_my_content') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_commented_reel" value="1" @checked(auth()->user()->notify_commented_reel) id="notify_commented_reel">
                <label class="custom-control-label switch" for="notify_commented_reel">{{ __('general.someone_commented_reel') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_liked_reel" value="1" @checked(auth()->user()->notify_liked_reel) id="notify_liked_reel">
                <label class="custom-control-label switch" for="notify_liked_reel">{{ __('general.someone_liked_reel') }}</label>
              </div>
              @endif

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_liked_comment" value="yes" @if (auth()->user()->notify_liked_comment == 'yes') checked @endif id="customSwitch10">
                <label class="custom-control-label switch" for="customSwitch10">{{ __('general.someone_liked_comment') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_live_streaming" value="yes" @if (auth()->user()->notify_live_streaming == 'yes') checked @endif id="notify_live_streaming">
                <label class="custom-control-label switch" for="notify_live_streaming">{{ __('general.someone_live_streaming') }}</label>
              </div>

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_mentions" value="yes" @if (auth()->user()->notify_mentions == 'yes') checked @endif id="notify_mentions">
                <label class="custom-control-label switch" for="notify_mentions">{{ __('general.someone_mentioned_me') }}</label>
              </div>

              @if ($settings->push_notification_status)
              <small class="w-100 d-block mt-2 font-weight-bold">
                <i class="bi-info-circle mr-1"></i> {{__('general.push_notification_warning')}}
              </small>
              @endif
              
              <div class="mt-3">
                <h6 class="position-relative">{{__('general.email_notification')}}</h6>
              </div>

              @if (auth()->user()->verified_id == 'yes')
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="email_new_subscriber" value="yes" @if (auth()->user()->email_new_subscriber == 'yes') checked @endif id="customSwitch4">
                  <label class="custom-control-label switch" for="customSwitch4">{{ __('general.someone_subscribed_content') }}</label>
                </div>

                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="email_new_tip" value="yes" @if (auth()->user()->email_new_tip == 'yes') checked @endif id="customSwitch7">
                  <label class="custom-control-label switch" for="customSwitch7">{{ __('general.someone_sent_tip') }}</label>
                </div>

                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="email_new_ppv" value="yes" @if (auth()->user()->email_new_ppv == 'yes') checked @endif id="customSwitch8">
                  <label class="custom-control-label switch" for="customSwitch8">{{ __('general.someone_bought_my_content') }}</label>
                </div>
              @endif

              @if (! $settings->disable_new_post_notification)
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="notify_email_new_post" value="yes" @if (auth()->user()->notify_email_new_post == 'yes') checked @endif id="customSwitch6">
                <label class="custom-control-label switch" for="customSwitch6">{{ __('general.new_post_creators_subscribed') }}</label>
              </div>
              @endif

              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="email_new_message" value="1" @checked(auth()->user()->email_new_message) id="customNewMessageEmail">
                <label class="custom-control-label switch" for="customNewMessageEmail">{{ __('general.someone_sent_message') }}</label>
              </div>

              <button type="submit" id="save" data-msg-success="{{ __('admin.success_update') }}" class="btn btn-primary btn-sm mt-3 w-100" data-msg="{{__('admin.save')}}">
                {{__('admin.save')}}
              </button>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- End Modal new Message -->
@endsection