<?php

namespace App\Repositories;


use App\Exceptions\UpdateReviewStatusException;
use App\Exceptions\InsertCommentException;
use Illuminate\Database\QueryException;
use App\Models\Comment;
use Exception;

class CommentsRepository
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * CommentsRepository constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param $option
     * @param $preparedCommentData
     * @return Exception|QueryException
     * @throws InsertCommentException
     * @author mj.safarali
     */
    public function insertComment($option, $preparedCommentData)
    {
        try {
            return $option->comments()->create($preparedCommentData);
        } catch (QueryException $exception) {
            throw new InsertCommentException(config('review_message.insert_comment.failed_message'), 422);
        }
    }

    /**
     * @return mixed
     * @author mj.safarali
     */
    public function getAllPendingComments()
    {
        return $this->comment
            ->select(['id', 'option_id', 'user_id', 'comment', 'vote', 'status'])
            ->pending()
            ->with(['option' => function ($query) {
                $query->select(['id']);
            }])
            ->get();
    }

    /**
     * @param $request
     * @return mixed
     * @throws UpdateReviewStatusException
     * @author mj.safarali
     */
    public function changeReviewStatus($request)
    {
        try {
            return $this->comment->find($request->review_id)->update(['status' => $request->status]);
        } catch (exception $e) {
            throw new UpdateReviewStatusException(config('review_message.review.update_failed'));
        }

    }
}
