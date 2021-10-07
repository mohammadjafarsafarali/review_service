<?php


namespace App\Services;


use Illuminate\Contracts\Container\BindingResolutionException;
use App\Exceptions\UpdateReviewStatusException;
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
        $product_options = $this->checkAndPrepareDataForInsert($request);

        $preparing_data = [
//            'product_id' => $request->product_id,
            'user_id' => NULL, #TODO: FILL WHEN USER IS LOGGED_IN AND RECEIVE FROM AUTH SERVICE
            'comment' => $request->comment,
            'vote' => $request->vote
        ];
        $this->commentsRepository->insertComment($product_options, $preparing_data);
        //return response
        return responseApi('success', NULL, config('review_message.insert_comment.success_message'), NULL);
    }

    /**
     * @throws BindingResolutionException
     * @throws InsertCommentException
     */
    private function checkAndPrepareDataForInsert($request)
    {
        $optionsService = app()->make(OptionsService::class);

        //check product visibility and check if comment and vote need user be consumer
        $product_options = $optionsService->returnOptionsIfVisible($request->product_id);

        //check if options is null (means hidden product)
        if (is_null($product_options)) {
            throw new InsertCommentException(config('review_message.insert_comment.product_visibility_failed'), 422);
        } //check if comment mode or vote mode is on `REVIEW_CONSUMER_MODE`
        elseif (
            $product_options->comments_mode == $product_options::REVIEW_CONSUMER_MODE ||
            $product_options->vote_mode == $product_options::REVIEW_CONSUMER_MODE
        ) {
            //check user has any order by `product_id = $request->product_id` on order service
            //for example : $userHasOrder = BOOLEAN DATA FROM ORDER SERVICE
            $userHasOrder = FALSE; #TODO: MOCK DATA INSTEAD OF ORDER SERVICE RESPONSE
            if (!$userHasOrder)
                throw new InsertCommentException(config('review_message.insert_comment.review_consumer_failed'), 422);
        }
        //check if comment mode is deavtive and api has vote in body
        // ( its like a trick because client-side will not render its component if get deactive mode from get-options api)
        elseif ($product_options->comments_mode == $product_options::REVIEW_DEACTIVE_MODE && $request->filled('comment')) {
            throw new InsertCommentException(config('review_message.insert_comment.review_deactive_failed'), 422);
        }
        //check if vote mode is deavtive and api has vote in body
        // ( its like a trick because client-side will not render its component if get deactive mode from get-options api)
        elseif ($product_options->vote_mode == $product_options::REVIEW_DEACTIVE_MODE && $request->filled('vote')) {
            throw new InsertCommentException(config('review_message.insert_comment.review_deactive_failed'), 422);
        }

        //insert comment
        return $product_options;
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
     * @throws UpdateReviewStatusException
     * @author mj.safarali
     */
    public function changeReviewStatus($request)
    {
        return $this->commentsRepository->changeReviewStatus($request);
    }
}
