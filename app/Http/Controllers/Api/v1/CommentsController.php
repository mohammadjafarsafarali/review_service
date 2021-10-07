<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Contracts\Container\BindingResolutionException;
use App\Http\Resources\Api\v1\InsertCommentResource;
use App\Http\Resources\Api\v1\ReviewCollection;
use App\Exceptions\InsertCommentException;
use App\Http\Controllers\Controller;
use App\Services\CommentsService;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * @var CommentsService
     */
    private $commentsService;

    /**
     * CommentsController constructor.
     * @param CommentsService $commentsService
     */
    public function __construct(CommentsService $commentsService)
    {
        $this->commentsService = $commentsService;
    }

    /**
     * @param Request $request
     * @return InsertCommentResource
     * @throws InsertCommentException
     * @throws BindingResolutionException
     * @author mj.safarali
     */
    public function insert(Request $request): InsertCommentResource
    {
        //insert comments
        $comment = $this->commentsService->insertComment($request);
        //return response
        return new InsertCommentResource($comment);
    }

    /**
     * @return ReviewCollection
     * @author mj.safarali
     */
    public function getAllPendingComments(): ReviewCollection
    {
        //get all pending comments
        $comments = $this->commentsService->getAllPendingComments();
        //return response
        return new ReviewCollection($comments);
    }
}
