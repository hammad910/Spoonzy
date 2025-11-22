@if ($response->comments->count() > $settings->number_comments_show && $counter >= 1)
    <div class="btn-block mb-4 text-center wrap-container" data-total="{{ $response->comments->count() }}"
        data-id="{{ $response->id }}">
        <a href="javascript:void(0)" class="loadMoreComments">
            <span class="line-replies"></span>{{ __('general.load_comments') }}
            (<span class="counter">{{ $counter }}</span>)
        </a>
    </div>
@endif

@foreach ($dataComments as $comment)
    @php
        $replies = $comment->replies;
        $totalReplies = $replies->count();
    @endphp
    <div class="wrap-comments{{ $comment->id }} wrapComments">
        <div class="comments isCommentWrap media li-group pt-3 pb-3" data="{{ $comment->id }}">
            <a class="float-left" href="{{ url($comment->user->username) }}">
                <img class="rounded-circle mr-3 avatarUser"
                    src="{{ Helper::getFile(config('path.avatar') . $comment->user->avatar) }}" width="40"></a>
            <div class="media-body">
                <h6 class="media-heading mb-0" style="display: flex; align-items: center; gap: 5px; margin-top: 10px;">
                    <div>
                        <a href="{{ url($comment->user->username) }}"
                            style="color: #101828; font-size: 20px; font-weight: 600 !important;">
                            {{-- {{ $comment->user->hide_name == 'yes' ? $comment->user->username : $comment->user->name }} --}}
                            {{ $comment->user->name }}
                        </a>
                        {{-- @if ($comment->user->verified_id == 'yes')
                            <small class="verified">
                                <i class="bi bi-patch-check-fill"></i>
                            </small>
                        @endif --}}
                    </div>
                    <div>
                        <span class="small sm-font sm-date text-muted timeAgo mr-2"
                            style="font-size: 16px; font-weight: 400 !important; color: #A8ACB1;"
                            data="{{ date('c', strtotime($comment->date)) }}"></span>
                    </div>

                </h6>
                <p class="list-grid-block p-text my-2 text-word-break updateComment isComment{{ $comment->id }}" style="color: #475467;">
                    {!! Helper::linkText(Helper::checkText($comment->reply)) !!}</p>

                @if ($comment->sticker)
                    <div class="w-100 d-block"><img src="{{ $comment->sticker }}" width="70"></div>
                @endif

                @if ($comment->gif_image)
                    <div class="w-100 d-block mt-2"><img class="rounded" src="{{ $comment->gif_image }}"
                            width="200"></div>
                @endif
                <div class="comment-actions" style="margin-top: 10px;">
                  <!-- Like -->
                  <span class="action likeComment c-pointer pulse-btn" data-id="{{ $comment->id }}" style="margin-right: 20px;" data-type="isComment">
                      <img src="/images/like.png" alt="">
                      <span class="countCommentsLikes">
                          {{ $comment->likes->count() != 0 ? $comment->likes->count() : null }}
                      </span>
                  </span>

                  <!-- Dislike -->
                  <span class="action c-pointer" data-id="{{ $comment->id }}" style="margin-right: 20px;">
                      <img src="/images/dislike.png" alt="">
                      <span>
                        25
                      </span>
                  </span>
              
                  <!-- Reply -->
                  <span class="action replyButton c-pointer" style="margin-right: 20px;"
                      data="{{ $comment->id }}"
                      data-username="{{ '@' . $comment->user->username }}">
                      <img src="/images/comment-reply.png" alt="">
                      <span class="reply-text">{{ __('general.reply') }}</span>
                  </span>
              
                  @if ($comment->user_id == auth()->id() || $response->creator->id == auth()->id())
                      <div class="dropdown d-inline-block" style="margin-right: 20px;">
                          <span id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="bi-three-dots"></i>
                          </span>
              
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              @if ($comment->user_id == auth()->id())
                                  <a class="dropdown-item editComment{{ $comment->id }}" href="javascript:void(0);"
                                      data-toggle="modal" data-target="#modalEditComment{{ $comment->id }}">
                                      <i class="bi-pencil mr-2"></i> {{ __('admin.edit') }}
                                  </a>
                              @endif
              
                              <a class="dropdown-item delete-comment" data="{{ $comment->id }}"
                                  data-type="isComment" href="javascript:void(0);">
                                  <i class="feather icon-trash-2 mr-2"></i> {{ __('general.delete') }}
                              </a>
                          </div>
                      </div>
                  @endif
              </div>
              
            </div><!-- media-body -->
        </div>

        @include('includes.modal-edit-comment', [
            'data' => $comment,
            'isReply' => false,
            'modalId' => 'modalEditComment' . $comment->id,
        ])

        @include('includes.replies')
    </div>
@endforeach
