<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Exception;
use Throwable;

final class BinNotFoundException extends Exception
{
    public function __construct(string $message = "Bin not found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}