<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class WalletHasNotEnoughCredit extends Exception
{
    private $userId;
    private $currencyId;

    public function __construct($userId, $currencyId, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->userId = $userId;
        $this->currencyId = $currencyId;
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        info("wallet not enough. userId: {$this->userId}, currencyId:{$this->currencyId}");
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
            'message' => __('messages.wallet.not_enough')
        ], Response::HTTP_FORBIDDEN);

    }
}
