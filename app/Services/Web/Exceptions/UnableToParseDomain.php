<?php

namespace App\Services\Web\Exceptions;

use \Exception;
use \Throwable;

class UnableToParseDomain extends Exception
{
    /**
     * Create new UnableToParseDomain instance
     *
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     * @throws Exception
     **/
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
