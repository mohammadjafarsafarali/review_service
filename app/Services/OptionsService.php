<?php

namespace App\Services;

use App\Repositories\CommentsRepository;
use App\Repositories\OptionsRepository;

class OptionsService
{
    /**
     * @var OptionsRepository
     */
    private $optionsRepository;

    /**
     * OptionsService constructor.
     * @param OptionsRepository $optionsRepository
     */
    public function __construct(OptionsRepository $optionsRepository)
    {
        $this->optionsRepository = $optionsRepository;
    }

    public function getOptions($product_id)
    {
        //get options
        $option = $this->returnOptionsIfVisible($product_id);

        //get some data from comment repository
        $commentRepo = app()->make(CommentsRepository::class);
        //vote average
        $option->vote_avg = floatval($commentRepo->voteAverageCalculator());
        $option->comments_count = intval($commentRepo->commentsCount());
        $option->last_comments = $commentRepo->lastComments(3);

        return $option;
    }

    /**
     * @param $product_id
     * @return mixed
     * @author mj.safarali
     */
    public function returnOptionsIfVisible($product_id)
    {
        return $this->optionsRepository->returnOptionsIfVisible($product_id);
    }

    /**
     * @param $request
     * @return mixed
     * @author mj.safarali
     */
    public function setOptions($request)
    {
        return $this->optionsRepository->setOptions($request);
    }
}
