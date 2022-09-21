<?php

namespace App\Utils\Traits;

trait ResponseHandler
{
    public function jsonErrorNotFound(string $message)
    {
        return $this->failNotFound($message);
    }
}
