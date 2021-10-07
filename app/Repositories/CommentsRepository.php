<?php

namespace App\Repositories;


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
     * @param $preparedCommentData
     * @return Exception|QueryException
     * @throws InsertCommentException
     * @author mj.safarali
     */
    public function insertComment($preparedCommentData)
    {
        try {
            return $this->comment->create($preparedCommentData);
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
        return $this->comment->select(['id', 'product_id', 'user_id', 'comment', 'vote', 'status'])->pending()->get();
    }
}
