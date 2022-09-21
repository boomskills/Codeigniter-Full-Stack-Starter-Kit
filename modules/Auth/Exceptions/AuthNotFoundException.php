<?php

namespace Modules\Auth\Exceptions;

use App\Exceptions\ExceptionInterface;

class AuthNotFoundException extends \RuntimeException implements ExceptionInterface
{
    public static function forAuthID(int $id)
    {
        return new self(lang('Auth.acountNotFound', [$id]), 404);
    }
}
