<?php


namespace App\Services;


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
     * @return bool
     * @author mj.safarali
     */
    public function checkVisibility($product_id): bool
    {
        return $this->optionsRepository->is_visible($product_id);
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
}
