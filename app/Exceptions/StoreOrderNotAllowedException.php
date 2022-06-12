<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class StoreOrderNotAllowedException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response([
            'message' => 'store order not allowed'
        ], Response::HTTP_FORBIDDEN);
    }

}
