<?php

declare(strict_types=1);

namespace App\Domain;

use Exception;
use Throwable;

final class InvalidBinException extends Exception
{
    public function __construct(string $message = "Bin is invalid", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}