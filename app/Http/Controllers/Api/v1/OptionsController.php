<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\Api\v1\SetOptionsResource;
use App\Http\Requests\Api\v1\SetOptionsRequest;
use App\Http\Resources\Api\v1\OptionsResource;
use App\Exceptions\SetOptionsExceptions;
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
    public function getOptions($product_id): OptionsResource
    {
        //if product is visible then return the options
        $options = $this->optionsService->returnOptionsIfVisible($product_id);
        //return result
        return new OptionsResource($options);
    }

    /**
     * @param $product_id
     * @param SetOptionsRequest $request
     * @return SetOptionsResource
     * @throws SetOptionsExceptions
     * @author mj.safarali
     */
    public function setOptions($product_id, SetOptionsRequest $request): SetOptionsResource
    {
        //pass data to option service for setting data
        $options = $this->optionsService->setOptions($product_id, $request);
        //return result
        return new SetOptionsResource($options);
    }
}
