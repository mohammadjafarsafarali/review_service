<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\SetOptionsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\OptionsService;
use Exception;

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
        parent::__construct();
        $this->optionsService = $optionsService;
    }

    /**
     * @param $product_id
     * @return JsonResponse
     * @author mj.safarali
     */
    public function getOptions($product_id): JsonResponse
    {
        try {
            $response = $this->optionsService->getOptions($product_id);
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }

    /**
     * @param SetOptionsRequest $request
     * @return JsonResponse
     * @author mj.safarali
     */
    public function setOptions(SetOptionsRequest $request): JsonResponse
    {
        try {
            $response = $this->optionsService->setOptions($request);
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }
}
