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

    /**
     * @param $product_id
     * @param $request
     * @return array
     * @author mj.safarali
     */
    public function setOptions($product_id, $request): array
    {
        $options = $this->optionsRepository->setOptions($product_id, $request);
        if ($options instanceof \Illuminate\Database\Eloquent\Model) {
            return [
                'status' => 'success',
                'error' => NULL,
                'message' => config('review_message.set_options.success_message'),
                'data' => [],
            ];
        }

        return [
            'status' => 'failed',
            'error' => $options->getPrevious()->getMessage(),
            'message' => config('review_message.set_options.failed_message'),
            'data' => [],
        ];
    }
}
