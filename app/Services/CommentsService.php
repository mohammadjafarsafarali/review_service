<?php


namespace App\Services;


use Illuminate\Contracts\Container\BindingResolutionException;
use App\Exceptions\InsertCommentException;
use App\Repositories\CommentsRepository;

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
     * @param $request
     * @return array
     * @throws BindingResolutionException
     * @throws InsertCommentException
     * @author mj.safarali
     */
    public function insertComment($request): array
    {
        $this->commentsRepository->insertComment($this->checkAndPrepareDataForInsert($request));
        //return response
        return responseApi('success', NULL, config('review_message.insert_comment.success_message'), NULL);
    }

    /**
     * @throws BindingResolutionException
     * @throws InsertCommentException
     */
    private function checkAndPrepareDataForInsert($request): array
    {
        $optionsService = app()->make(OptionsService::class);

        //check product visibility and check if comment and vote need user be consumer
        $product_options = $optionsService->returnOptionsIfVisible($request->product_id);

        //check if options is null (means hidden product)
        if (is_null($product_options)) {
            throw new InsertCommentException(config('review_message.insert_comment.product_visibility_failed'), 422);
        } elseif ( //check if comment mode or vote mode is on `REVIEW_CONSUMER_MODE`
            $product_options->comments_mode == $product_options::REVIEW_CONSUMER_MODE ||
            $product_options->vote_mode == $product_options::REVIEW_CONSUMER_MODE
        ) {
            //check user has any order by `product_id = $request->product_id` on order service
            //for example : $userHasOrder = BOOLEAN DATA FROM ORDER SERVICE
            $userHasOrder = TRUE; #TODO: MOCK DATA INSTEAD OF ORDER SERVICE RESPONSE
            if (!$userHasOrder)
                throw new InsertCommentException(config('review_message.insert_comment.review_consumer_failed'), 422);
        }

        //insert comment
        return [
            'product_id' => $request->product_id,
            'user_id' => NULL, #TODO: FILL WHEN USER IS LOGGED_IN AND RECEIVE FROM AUTH SERVICE
            'comment' => $request->comment,
            'vote' => $request->vote
        ];
    }
}
