<?php

namespace App\Services;

use App\Exceptions\CustomApiException;
use App\Pipelines\After;
use App\Pipelines\DeactiveComment;
use App\Pipelines\DeactiveVote;
use App\Pipelines\InvisibleProduct;
use App\Pipelines\ReviewConsumerMode;
use App\Pipelines\ReviewConsumerModel;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Repositories\CommentsRepository;
use Illuminate\Pipeline\Pipeline;

class CommentsService
{
    /**
     * @var CommentsRepository
     */
    private $commentsRepository;

    /**
     * CommentsService constructor.
     * @param CommentsRepository $commentsRepository
     */
    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * @throws BindingResolutionException
     * @throws CustomApiException
     */
    public function insertComment($request)
    {
        //create passable array
        $data = [
            'request' => $request,
            'options' => (app()->make(OptionsService::class))->returnOptionsIfVisible($request->product_id)
        ];

        return app(Pipeline::class)
            ->send($data)
            ->through([
                InvisibleProduct::class,
                ReviewConsumerMode::class,
                DeactiveComment::class,
                DeactiveVote::class,
            ])
            ->then(function ($data) {
                return $this->commentsRepository->create([
                    'product_id' => $data['request']->product_id,
                    'user_id' => NULL, #TODO: FILL WHEN USER IS LOGGED_IN AND RECEIVE FROM AUTH SERVICE
                    'comment' => $data['request']->comment,
                    'vote' => $data['request']->vote
                ]);
            });
    }

    /**
     * @return mixed
     * @author mj.safarali
     */
    public function getAllPendingComments()
    {
        return $this->commentsRepository->getAllPendingComments();
    }

    /**
     * @param $request
     * @return mixed
     * @author mj.safarali
     */
    public function changeReviewStatus($request)
    {
        return $this->commentsRepository->changeReviewStatus($request);
    }

}
