<?php

namespace App\Http\Controllers;

use App\Supports\ApiResponse;
use App\Supports\ExceptionHandler;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse;

    /**
     * @var ExceptionHandler
     */
    protected $exceptionHandler;

    public function __construct()
    {
        $this->exceptionHandler = new ExceptionHandler();
    }
}
