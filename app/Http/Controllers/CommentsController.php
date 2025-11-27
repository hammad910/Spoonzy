<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Replies;
use App\Models\Updates;
use App\Models\Comments;
use Illuminate\Http\Request;
use App\Models\CommentsLikes;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	protected function validator(array $data)
	{
		Validator::extend('ascii_only', function ($attribute, $value, $parameters) {
			return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		$messages = [
			'comment.required' => __('general.please_write_something'),
		];

		$rules = [
			'comment' =>  'required|max:' . config('settings.comment_length') . '|min:2',
			'sticker' => 'nullable|url',
			'gif_image' => 'nullable|url'
		];

		if (!empty($data['sticker']) || !empty($data['gif_image'])) {
			$rules['comment'] = 'nullable|max:' . config('settings.comment_length');
		}

		return Validator::make($data, $rules, $messages);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();
		$validator = $this->validator($input);

		$update = Updates::where('id', $request->update_id)->first();

		if (!isset($update)) {
			return response()->json([
				'success' => false,
				'errors' => ['error' => trans('general.error')],
			]);
			exit;
		}

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),
			]);
		}

		$isReply = $request->isReply ? Comments::find($request->isReply) : null;

		if ($isReply) {
			$commentId = $request->isReply;
			$sql              = new Replies();
			$sql->reply       = trim(Helper::checkTextDb($request->comment));
			$sql->comments_id = $commentId;
			$sql->user_id     = auth()->id();
			$sql->updates_id  = $request->update_id;
			$sql->sticker     = $request->sticker ?: null;
			$sql->gif_image   = $request->gif_image ?: null;
			$sql->save();

			$idReply = $sql->id;
			$modal = view('includes.modal-edit-comment', [
				'data' => $sql,
				'isReply' => true,
				'modalId' => 'modalEditReply' . $sql->id
			]);
		} else {
			$sql            = new Comments();
			$sql->reply     = trim(Helper::checkTextDb($request->comment));
			$sql->updates_id = $request->update_id;
			$sql->user_id   = auth()->id();
			$sql->sticker     = $request->sticker ?: null;
			$sql->gif_image   = $request->gif_image ?: null;
			$sql->save();

			$idComment = $sql->id;
			$idReply = null;
			$modal = view('includes.modal-edit-comment', [
				'data' => $sql,
				'isReply' => false,
				'modalId' => 'modalEditComment' . $sql->id
			]);
		}

		/*------* SEND NOTIFICATION * ------*/
		if (auth()->id() != $update->user_id  && $update->user()->notify_commented_post == 'yes') {
			Notifications::send($update->user_id, auth()->id(), '3', $update->id);
		}

		$totalComments = $update->totalComments();

		// Send Notification Mention
		Helper::sendNotificationMention($sql->reply, $request->update_id);

		$nameUser = auth()->user()->hide_name == 'yes' ? auth()->user()->username : auth()->user()->name;
		$verifiedId = auth()->user()->verified_id == 'yes' ? '<small class="verified"> <i class="bi bi-patch-check-fill"></i> </small>' : null;
		$sticker = $sql->sticker ? '<div class="w-100 d-block"><img src="' . $sql->sticker . '" width="70"></div>' : null;
		$gifImage = $sql->gif_image ? '<div class="w-100 d-block mt-2"><img class="rounded" src="' . $sql->gif_image . '" width="200"></div>' : null;

		// Build HTML based on comment or reply
		if ($isReply) {
			$commentHtml = '
        <div class="comments media li-group pt-3 pb-3 isCommentReply" data="' . $commentId . '" style="padding-left: 80px; position: relative;">
            <div class="reply-connector-line"></div>
            <div class="reply-connector-horizontal"></div>
            <a class="float-left" href="' . url(auth()->user()->username) . '">
                <img class="rounded-circle mr-3 avatarUser" src="' . Helper::getFile(config('path.avatar') . auth()->user()->avatar) . '" width="40"></a>
            <div class="media-body">
                <h6 class="media-heading mb-0" style="display: flex; align-items: center; gap: 10px;">
                    <div>
                        <a href="' . url(auth()->user()->username) . '" style="color: #101828; font-size: 20px; font-weight: 600 !important;">
                            ' . $nameUser . '</a>
                    </div>
                    <div>
                        <span class="small sm-font sm-date text-muted timeAgo mr-2" style="font-size: 16px; font-weight: 400 !important; color: #A8ACB1;" data="' . date('c', time()) . '"></span>
                    </div>
                </h6>
                <p class="list-grid-block p-text my-2 text-word-break updateComment isReply' . $idReply . '" style="color: #475467;">' . Helper::linkText(Helper::checkText($sql->reply)) . '</p>
                ' . $sticker . '
                ' . $gifImage . '
                <div class="reply-actions" style="margin-top: 10px;">
                    <span class="action likeComment c-pointer pulse-btn" style="margin-right: 20px;" data-id="' . $idReply . '">
                        <img src="/images/like.png" alt="">
                        <span class="countCommentsLikes"></span>
                    </span>
                    <span class="action c-pointer" data-id="' . $commentId . '" style="margin-right: 20px;">
                        <img src="/images/dislike.png" alt="">
                        <span>25</span>
                    </span>
                    <span class="action replyButton c-pointer" style="margin-right: 20px;" data="' . $commentId . '" data-username="@' . auth()->user()->username . '">
                        <img src="/images/comment-reply.png" alt="">
                        <span class="reply-text">' . __('general.reply') . '</span>
                    </span>
                    <div class="dropdown d-inline-block" style="margin-right: 20px;">
                        <span id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi-three-dots"></i>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item editComment' . $commentId . '" data-id="' . $idReply . '" data-type="isReplies" data-comment="' . $sql->reply . '" href="javascript:void(0);" data-toggle="modal" data-target="#modalEditReply' . $idReply . '">
                                <i class="bi-pencil mr-2"></i> ' . __('admin.edit') . '
                            </a>
                            <a class="dropdown-item delete-replies" data="' . $idReply . '" href="javascript:void(0);">
                                <i class="feather icon-trash-2 mr-2"></i> ' . __('general.delete') . '
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            ' . $modal . '
        </div>';
		} else {
			$commentHtml = '<div class="wrap-comments' . $idComment . ' wrapComments">
            <div class="comments isCommentWrap media li-group pt-3 pb-3" data="' . $idComment . '">
                <a class="float-left" href="' . url(auth()->user()->username) . '">
                    <img class="rounded-circle mr-3 avatarUser" src="' . Helper::getFile(config('path.avatar') . auth()->user()->avatar) . '" width="40"></a>
                <div class="media-body">
                    <h6 class="media-heading mb-0" style="display: flex; align-items: center; gap: 5px; margin-top: 10px;">
                        <div>
                            <a href="' . url(auth()->user()->username) . '" style="color: #101828; font-size: 20px; font-weight: 600 !important;">
                                ' . $nameUser . '</a>
                        </div>
                        <div>
                            <span class="small sm-font sm-date text-muted timeAgo mr-2" style="font-size: 16px; font-weight: 400 !important; color: #A8ACB1;" data="' . date('c', time()) . '"></span>
                        </div>
                    </h6>
                    <p class="list-grid-block p-text my-2 text-word-break updateComment isComment' . $idComment . '" style="color: #475467;">' . Helper::linkText(Helper::checkText($sql->reply)) . '</p>
                    ' . $sticker . '
                    ' . $gifImage . '
                    <div class="comment-actions" style="margin-top: 10px;">
                        <span class="action likeComment c-pointer pulse-btn" data-id="' . $idComment . '" style="margin-right: 20px;" data-type="isComment">
                            <img src="/images/like.png" alt="">
                            <span class="countCommentsLikes"></span>
                        </span>
                        <span class="action c-pointer" data-id="' . $idComment . '" style="margin-right: 20px;">
                            <img src="/images/dislike.png" alt="">
                            <span>25</span>
                        </span>
                        <span class="action replyButton c-pointer" style="margin-right: 20px;" data="' . $idComment . '" data-username="@' . auth()->user()->username . '">
                            <img src="/images/comment-reply.png" alt="">
                            <span class="reply-text">' . __('general.reply') . '</span>
                        </span>
                        <div class="dropdown d-inline-block" style="margin-right: 20px;">
                            <span id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi-three-dots"></i>
                            </span>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item editComment' . $idComment . '" href="javascript:void(0);" data-toggle="modal" data-target="#modalEditComment' . $idComment . '">
                                    <i class="bi-pencil mr-2"></i> ' . __('admin.edit') . '
                                </a>
                                <a class="dropdown-item delete-comment" data="' . $idComment . '" data-type="isComment" href="javascript:void(0);">
                                    <i class="feather icon-trash-2 mr-2"></i> ' . __('general.delete') . '
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ' . $modal . '
        </div>';
		}

		return response()->json([
			'success' => true,
			'isReply' => $isReply ? true : false,
			'idComment' => $isReply ? $commentId : $idComment,
			'total' => $totalComments,
			'data' => $commentHtml,
		]);
	} //<--- End Method

	/**
	 * Edit comment.
	 *
	 * @return Response
	 */
	public function edit(Request $request)
	{
		$input = $request->all();
		$validator = $this->validator($input);
		$comment = $request->isReply ? Replies::whereId($request->id)->whereUserId(auth()->id())->first() : Comments::whereId($request->id)->whereUserId(auth()->id())->first();

		if (!isset($comment)) {
			return response()->json([
				'success' => false,
				'errors' => ['error' => trans('general.error')],
			]);
			exit;
		}

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),
			]);
		}

		$comment->reply = trim(Helper::checkTextDb($request->comment));
		$comment->save();

		// Send Notification Mention
		Helper::sendNotificationMention($comment->reply, $comment->updates_id);

		return response()->json([
			'success' => true,
			'target' => $request->isReply ? '.isReply' . $comment->id : '.isComment' . $comment->id,
			'comment' => Helper::linkText(Helper::checkText($comment->reply)),
		]);
	} //<--- End Method


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$comment = Comments::with(['updates:id,user_id'])->findOrFail($id);

		if ($comment->user_id == auth()->id() || $comment->updates->user_id == auth()->id()) {

			$comment->likes()->delete();

			// Delete Notification
			Notifications::where('author', $comment->user_id)
				->where('target', $comment->updates_id)
				->where('created_at', $comment->date)
				->delete();

			$comment->delete();

			// Delete replies
			$comment->replies()->delete();

			$totalComments = $comment->updates->totalComments();

			return response()->json([
				'success' => true,
				'total' => $totalComments
			]);
		} else {
			return response()->json([
				'success' => false,
				'error' => trans('general.error')
			]);
		}
	} //<--- End Method

	/**
	 * Load More Comments
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return Response
	 */
	public function loadmore(Request $request)
	{
		$id       = $request->input('id');
		$postId   = $request->input('post');
		$skip     = $request->input('skip');
		$response = Updates::findOrFail($postId);

		$page     = $request->input('page');
		$comments = $response->comments()->skip($skip)->take(config('settings.number_comments_show'))->orderBy('id', 'DESC')->get();
		$data = [];

		if ($comments->count()) {
			$data['reverse'] = collect($comments->values())->reverse();
		} else {
			$data['reverse'] = $comments;
		}

		$dataComments = $data['reverse'];
		$counter = ($response->comments()->count() - config('settings.number_comments_show') - $skip);

		return response()->json([
			'comments' => view(
				'includes.comments',
				[
					'dataComments' => $dataComments,
					'comments' => $comments,
					'response' => $response,
					'counter' => $counter
				]
			)->render()
		]);
	} //<--- End Method

	public function like()
	{
		$id   = $this->request->comment_id;
		$type = $this->request->typeComment;

		// Find Comment
		$comment = $type == 'isComment' ? Comments::whereId($id)->with(['user'])->firstOrFail() : Replies::whereId($id)->with(['user'])->firstOrFail();

		// Find Like on comments likes if exists
		$commentLike = CommentsLikes::whereUserId(auth()->id())
			->whereCommentsId($id)
			->orWhere('replies_id', $id)
			->whereUserId(auth()->id())
			->first();

		if ($commentLike) {
			$commentLike->delete();

			Notifications::where('destination', $comment->user_id)
				->where('author', auth()->id())
				->where('target', $comment->updates_id)
				->where('type', '4')
				->delete();

			return response()->json([
				'success' => true,
				'type' => 'unlike',
				'count' => $comment->likes()->count()
			]);
		} else {
			$sql = new CommentsLikes();
			$sql->user_id = auth()->id();

			if ($type == 'isComment') {
				$sql->comments_id = $comment->id;
			} else {
				$sql->replies_id = $comment->id;
			}

			$sql->save();

			if ($comment->user_id != auth()->id() && $comment->user->notify_liked_comment == 'yes') {
				Notifications::send($comment->user_id, auth()->id(), '4', $comment->updates_id);
			}

			return response()->json([
				'success' => true,
				'type' => 'like',
				'count' => $comment->likes()->count()
			]);
		}
	} //<--- End Method

}
