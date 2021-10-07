<?php

namespace App\Exceptions;

use App\Http\Resources\Api\v1\ExceptionResource;
use Exception;

class InsertCommentException extends Exception
{

    /**
     * @param $request
     * @return ExceptionResource
     * @author mj.safarali
     */
    public function render($request): ExceptionResource
    {
        return new ExceptionResource([
            'status' => 'failed',
            'error' => 'INSERT_COMMENT_ERROR',
            'message' => $this->getMessage(),
            'data' => NULL
        ], $this->getCode());
    }
}
