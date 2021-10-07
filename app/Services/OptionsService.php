<?php


namespace App\Services;


use App\Exceptions\SetOptionsExceptions;
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
     * @param $product_id
     * @param $request
     * @return array
     * @throws SetOptionsExceptions
     * @author mj.safarali
     */
    public function setOptions($product_id, $request): array
    {
        $this->optionsRepository->setOptions($product_id, $request);
        //return response
        return responseApi('success', NULL, config('review_message.set_options.success_message'));
    }
}
