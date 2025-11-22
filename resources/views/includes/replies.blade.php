@if ($totalReplies > 0)
    <div class="btn-block mb-4 text-left wrap-container" data-total="{{ $totalReplies }}" data-id="{{ $comment->id }}">
        <a href="javascript:void(0)" class="loadMoreReplies">
            <span class="line-replies"></span>{{ trans('general.view_replies') }}
            (<span class="counter">{{ $totalReplies }}</span>)
        </a>
    </div>
@endif

@if (isset($getReplies))
    @foreach ($dataReplies as $reply)
        <div class="comments media li-group pt-3 pb-3 isCommentReply" data="{{ $comment->id }}" style="padding-left: 80px;">
            <a class="float-left" href="{{ url($reply->user->username) }}">
                <img class="rounded-circle mr-3 avatarUser"
                    src="{{ Helper::getFile(config('path.avatar') . $reply->user->avatar) }}" width="40"></a>
            <div class="media-body">
                <h6 class="media-heading mb-0" style="display: flex; align-items: center; gap: 5px;">
                    <div>
                        <a href="{{ url($reply->user->username) }}"
                            style="color: #101828; font-size: 20px; font-weight: 600 !important;">
                            {{-- {{$reply->user->hide_name == 'yes' ? $reply->user->username : $reply->user->name}} --}}
                            {{ $comment->user->name }}
                        </a>

                        {{-- @if ($reply->user->verified_id == 'yes')
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
                <p class="list-grid-block p-text my-2 text-word-break updateComment isReply{{ $reply->id }}" style="color: #475467; ">
                    {!! Helper::linkText(Helper::checkText($reply->reply)) !!}
                  </p>

                @if ($reply->sticker)
                    <div class="w-100 d-block"><img src="{{ $reply->sticker }}" width="70"></div>
                @endif

                @if ($reply->gif_image)
                    <div class="w-100 d-block mt-2"><img class="rounded" src="{{ $reply->gif_image }}" width="200">
                    </div>
                @endif

                {{-- <span class="small sm-font sm-date text-muted timeAgo mr-2"
                    data="{{ date('c', strtotime($reply->created_at)) }}"></span> --}}
                <div class="reply-actions" style="margin-top: 10px;">

                    <!-- Like -->
                    <span class="action likeComment c-pointer pulse-btn" style="margin-right: 20px;"
                        data-id="{{ $reply->id }}">
                        <img src="/images/like.png" alt="">
                        <span class="countCommentsLikes">
                            {{ $reply->likes->count() != 0 ? $reply->likes->count() : null }}
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
                    <span class="action replyButton c-pointer" style="margin-right: 20px;" data="{{ $comment->id }}"
                        data-username="{{ '@' . $reply->user->username }}">
                        <img src="/images/comment-reply.png" alt="">
                        <span class="reply-text">{{ __('general.reply') }}</span>
                    </span>

                    <!-- Dropdown -->
                    @if ($reply->user_id == auth()->id() || $comment->updates->user()->id == auth()->id())
                        <div class="dropdown d-inline-block" style="margin-right: 20px;">
                            <span id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bi-three-dots"></i>
                            </span>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                <a class="dropdown-item editComment{{ $comment->id }}" data-id="{{ $reply->id }}"
                                    data-type="isReplies" data-comment="{{ $reply->reply }}" href="javascript:void(0);"
                                    data-toggle="modal" data-target="#modalEditReply{{ $reply->id }}">
                                    <i class="bi-pencil mr-2"></i> {{ __('admin.edit') }}
                                </a>

                                <a class="dropdown-item delete-replies" data="{{ $reply->id }}"
                                    href="javascript:void(0);">
                                    <i class="feather icon-trash-2 mr-2"></i> {{ __('general.delete') }}
                                </a>

                            </div>
                        </div>
                    @endif

                </div>

            </div><!-- media-body -->

            @include('includes.modal-edit-comment', [
                'data' => $reply,
                'isReply' => true,
                'modalId' => 'modalEditReply' . $reply->id,
            ])

        </div>
    @endforeach
@endif
