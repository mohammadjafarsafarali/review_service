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
            $comment = $this->comment->find($request->review_id);
            $comment->status = $request->status;

            //if status changed to passed from rejected or pending should increase its vote to average
            if (!empty($comment->vote) && $comment->status == 'passed') {
                //get option
                $option = $comment->option()->first();
                //get count of affected comment vote => not empty and status = passed
                $count = $this->comment->whereNotNull('vote')->passed()->count();
                //calculate new average
                $newVoteAvg = $count > 0 ? (($option->vote_avg * $count) + $comment->vote) / ($count + 1) : $comment->vote;
                //plus average process
                $option->vote_avg = $newVoteAvg;
                //save
                $option->save();
            } //if status changed to rejected or pending from passed should decrease its vote from average
            elseif (
                !empty($comment->vote) &&
                ($comment->status == 'rejected' || $comment->status == 'pending') && //check if current status is `rejected` OR `pending`
                $comment->getOriginal('status') == 'passed' //get previous status and check if was `passed`
            ) {
                $option = $comment->option()->first();
                //get count of affected comment vote => not empty and status = passed
                $count = $this->comment->whereNotNull('vote')->passed()->count();
                //calculate new average
                $newVoteAvg = $count > 1 ? (($option->vote_avg * $count) - $comment->vote) / ($count - 1) : 0;
                $option->vote_avg = round($newVoteAvg, 1);
                $option->save();
            }
            return $comment->save();
        } catch (exception $e) {
            throw new UpdateReviewStatusException(config('review_message.review.update_failed'));
        }

    }
}
