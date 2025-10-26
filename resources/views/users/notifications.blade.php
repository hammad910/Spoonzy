@extends('layouts.app')

@section('title'){{__('general.notifications')}} -@endsection
<style>
  .type-filter {
  font-size: 15px;
}

.type-filter .form-check-input {
  width: 18px;
  height: 18px;
  border: 1.8px solid #c8ccd1;
  border-radius: 4px;
  box-shadow: none;
  cursor: pointer;
}

.type-filter .form-check-input:checked {
  background-color: #0d6efd; /* Bootstrap primary */
  border-color: #0d6efd;
}

.type-filter .form-check-label {
  margin-left: 6px;
  color: #343a40;
  vertical-align: middle;
}

  </style>

@section('content')
<section class="section section-sm">
    <div class="container-fluid">
      <div class="row">
        <!-- Left Sidebar -->
        <div class="col-lg-2 d-none d-lg-block" style="border-right: 1px solid #ddd; padding: 20px;">
          @include('includes.menu-sidebar-home')
        </div>
        
        <!-- Main Content Area -->
        <div class="col-lg-10">
          <div class="row justify-content-center text-center mb-sm">
            <div class="col-lg-8 py-5">
              <h2 class="mb-0 font-montserrat">
                <i class="far fa-bell mr-2"></i> {{__('general.notifications')}}

                <small class="font-tiny">
                  <a href="javascript:;" class="btn-notify" data-toggle="modal" data-target="#notifications"><i class="fa fa-cog mr-2"></i></a>

              @if (count($notifications) != 0)
                  <form method="POST" action="{{ url('notifications/delete') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-lg align-baseline p-0 e-none btn-link actionDeleteNotify">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </form>
                @endif
                </small>
              </h2>
              <p class="lead text-muted mt-0">{{__('general.notifications_subtitle')}}</p>
            </div>
          </div>
          
          <div class="row">
            <div class="col-12">
              @if ($notifications->total() != 0)
              <div class="btn-block mb-3 text-right">
                <span>
                  <i class="bi-filter-right mr-1"></i>
                  <select class="ml-2 custom-select w-auto" id="filter">
                      <option @if (! request()->get('sort')) selected @endif value="{{url('notifications')}}">{{__('general.all')}}</option>
                      <option @if (request()->get('sort') == 'subscriptions') selected @endif value="{{url('notifications?sort=subscriptions')}}">{{__('admin.subscriptions')}}</option>
                      <option @if (request()->get('sort') == 'likes') selected @endif value="{{url('notifications?sort=likes')}}">{{__('general.likes')}}</option>
                      <option @if (request()->get('sort') == 'tips') selected @endif value="{{url('notifications?sort=tips')}}">{{__('general.tips')}}</option>
                      <option @if (request()->get('sort') == 'live_streaming') selected @endif value="{{url('notifications?sort=live_streaming')}}">{{__('general.live_streaming')}}</option>
                      <option @if (request()->get('sort') == 'mentions') selected @endif value="{{url('notifications?sort=mentions')}}">{{__('general.mentions')}}</option>
                    </select>
                </span>
              </div>
            @endif

            <?php

            	foreach ($notifications as $key) {

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
          <div class="d-flex flex-lg-row flex-column-reverse align-items-start" style="gap: 40px;">

            <div class="card mb-3 card-updates flex-grow-1" style="width: 100%;">
              <div class="card-body">
                <div class="media">
                  @if ($notyNormal)
                    <span class="rounded-circle mr-3">
                      <a href="{{url($key->username)}}">
                        <img src="{{Helper::getFile(config('path.avatar').$key->avatar)}}" class="rounded-circle" width="60" height="60">
                      </a>
                    </span>
                  @else
                    <span class="rounded-circle mr-3">
                      <span class="icon-notify">
                        @if ($isReel)
                          <svg xmlns="http://www.w3.org/2000/svg" class="align-top" fill="currentColor" width="60" height="60" viewBox="0 0 50 50">
                            <path d="M15 4C8.94 4 4 8.94 4 15v20c0 6.06 4.94 11 11 11h20c6.06 0 11-4.94 11-11V15c0-6.06-4.94-11-11-11H15zM16.74 6h10.69L33.26 16H22.57L16.74 6zM29.74 6H35c4.98 0 9 4.02 9 9v1h-8.43L29.74 6zM14.49 6.1L20.26 16H6v-1c0-4.8 3.76-8.62 8.49-8.9zM6 18h38v17c0 4.98-4.02 9-9 9H15c-4.98 0-9-4.02-9-9V18zm15.98 5.01c-1.54.04-2.98 1.26-2.98 2.95v9.08c0 2.25 2.55 3.67 4.51 2.56l7.99-4.54c1.94-1.1 1.94-4.01 0-5.12l-7.99-4.54a2.68 2.68 0 0 0-1.53-.35z"></path>
                          </svg>
                        @else
                          <i class="{{ $iconNotify }}"></i>
                        @endif
                      </span>
                    </span>
                  @endif
          
                  <div class="media-body">
                    <h6 class="mb-0 font-montserrat text-notify">
                      @if ($notyNormal)
                        <a href="{{url($key->username)}}">
                          {{$key->hide_name == 'yes' ? $key->username : $key->name}}
                        </a>
                      @endif
                      <small class="timeAgo text-muted" data="{{date('c', strtotime($key->created_at))}}"></small>
                      @if ($linkDestination != false)
                      <a href="{{url($linkDestination)}}">{{$text_link}}</a>
                      @endif
                    </h6>
                    {!! $action !!}
                  </div>
                </div><!-- media -->
              </div><!-- card-body -->
            </div><!-- card -->
          
            {{-- RIGHT SIDE (Filter) --}}
            @if ($notifications->total() != 0)
              <div class="type-filter mb-3" style="min-width: 250px;">
                <label class="d-block mb-2" style="color: black; font-size: 20px; font-weight: 600">Type:</label>
                @php $currentSort = request()->get('sort'); @endphp
          
                <div class="form-check mb-2">
                  <input class="form-check-input filter-checkbox" type="checkbox" id="likes" value="likes" {{ $currentSort == 'likes' ? 'checked' : '' }}>
                  <label class="form-check-label text-secondary fw-medium" for="likes">Likes</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input filter-checkbox" type="checkbox" id="subscriptions" value="subscriptions" {{ $currentSort == 'subscriptions' ? 'checked' : '' }}>
                  <label class="form-check-label text-secondary fw-medium" for="subscriptions">Subscriptions</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input filter-checkbox" type="checkbox" id="tips" value="tips" {{ $currentSort == 'tips' ? 'checked' : '' }}>
                  <label class="form-check-label text-secondary fw-medium" for="tips">Tips</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input filter-checkbox" type="checkbox" id="live_streaming" value="live_streaming" {{ $currentSort == 'live_streaming' ? 'checked' : '' }}>
                  <label class="form-check-label text-secondary fw-medium" for="live_streaming">Live Streaming</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input filter-checkbox" type="checkbox" id="mentions" value="mentions" {{ $currentSort == 'mentions' ? 'checked' : '' }}>
                  <label class="form-check-label text-secondary fw-medium" for="mentions">Mentions</label>
                </div>
              </div>
            @endif
          </div>
          
          {{-- Keep the JS filter logic the same --}}
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
          

        <?php } //foreach ?>

        @if ($notifications->isEmpty())
          <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="far fa-bell-slash ico-no-result"></i>
            </span>
          <h4 class="font-weight-light">{{__('general.no_notifications')}}</h4>
          </div>
        @endif

    @if ($notifications->hasPages())
        {{ $notifications->onEachSide(0)->appends(['sort' => request('sort')])->links() }}
      @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
                  <h6 class="position-relative">{{__('general.email_notification')}}
                  </h6>
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