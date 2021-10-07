<?php

namespace App\Repositories;


use App\Exceptions\SetOptionsExceptions;
use App\Models\Option;

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
            ->select(['id', 'product_id', 'product_visibility', 'comments_mode', 'vote_mode', 'vote_avg'])
            ->where('product_id', '=', $product_id)
            ->visible()
            ->with(['comments' => function ($query) {
                $query->select(['option_id', 'comment'])
                    ->passed()
                    ->orderBy('updated_at', 'desc')
                    ->take(3);
            }])
            ->first();
    }

    /**
     * @param $product_id
     * @param $request
     * @return mixed
     * @throws SetOptionsExceptions
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
            throw new SetOptionsExceptions(config('review_message.set_options.failed_message'), 422);
        }

    }
}
