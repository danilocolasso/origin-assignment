<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class InvalidApiKeyException extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct(trans('exceptions.invalid-api-key'), Response::HTTP_UNAUTHORIZED);
    }
}
