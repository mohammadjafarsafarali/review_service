<?php

namespace App\Repositories;


use App\Models\Option;
use Throwable;

class OptionsRepository
{
    /**
     * @var Option
     */
    private $option;

    /**
     * OptionsRepository constructor.
     * @param Option $option
     */
    public function __construct(Option $option)
    {
        $this->option = $option;
    }

    /**
     * @param $product_id
     * @return bool
     * @author mj.safarali
     */
    public function is_visible($product_id): bool
    {
        return $this->option->where('product_id', '=', $product_id)->firstOrFail()->is_visible;
    }


    /**
     * @param $product_id
     * @return mixed
     * @author mj.safarali
     */
    public function returnOptionsIfVisible($product_id)
    {
        return $this->option
            ->select(['product_id', 'product_visibility', 'comments_mode', 'vote_mode'])
            ->where('product_id', '=', $product_id)
            ->visible()
            ->first();
    }

    /**
     * @param $product_id
     * @param $request
     * @return mixed
     * @author mj.safarali
     */
    public function setOptions($product_id, $request)
    {
        try {
            return $this->option->updateOrCreate(
                ['product_id' => $product_id],
                [
                    'product_visibility' => $request->visible,
                    'comments_mode' => $request->comments_mode,
                    'vote_mode' => $request->vote_mode,
                ]
            );
        } catch (\Illuminate\Database\QueryException $exception) {
            return $exception;
        }

    }

}
