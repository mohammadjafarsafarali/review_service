<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\ChangeReviewStatusRequest;
use App\Http\Requests\Api\v1\InsertReviewRequest;
use App\Http\Controllers\Controller;
use App\Services\CommentsService;
use Illuminate\Http\JsonResponse;
use Exception;

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
        parent::__construct();
        $this->commentsService = $commentsService;
    }

    /**
     * @param InsertReviewRequest $request
     * @return JsonResponse
     * @author mj.safarali
     */
    public function insert(InsertReviewRequest $request): JsonResponse
    {
        try {
            $response = $this->commentsService->insertComment($request);
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }

    /**
     * @return JsonResponse
     * @author mj.safarali
     */
    public function getAllPendingComments(): JsonResponse
    {
        try {
            $response = $this->commentsService->getAllPendingComments();
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }

    /**
     * @param ChangeReviewStatusRequest $request
     * @return JsonResponse
     * @author mj.safarali
     */
    public function changeReviewStatus(ChangeReviewStatusRequest $request): JsonResponse
    {
        try {
            $response = $this->commentsService->changeReviewStatus($request);
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }
}
