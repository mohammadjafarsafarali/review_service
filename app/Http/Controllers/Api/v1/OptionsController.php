<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\Api\v1\OptionsResource;
use App\Http\Controllers\Controller;
use App\Services\OptionsService;

class OptionsController extends Controller
{
    /**
     * @var OptionsService
     */
    private $optionsService;

    /**
     * OptionsController constructor.
     * @param OptionsService $optionsService
     */
    public function __construct(OptionsService $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    /**
     * @param $product_id
     * @return OptionsResource
     * @author mj.safarali
     */
    public function reviewOptions($product_id): OptionsResource
    {
        //if product is visible then return the options
        $options = $this->optionsService->returnOptionsIfVisible($product_id);
        //return result
        return new OptionsResource($options);
    }
}
