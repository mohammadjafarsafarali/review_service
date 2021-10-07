<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\InsertCommentException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\InsertCommentResource;
use App\Services\CommentsService;
use Illuminate\Contracts\Container\BindingResolutionException;
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
}
