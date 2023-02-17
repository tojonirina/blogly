<?php

namespace App\Exception;

class ItemNotFoundException extends \Exception
{
    public function __construct(string $message = "Item not found", int $code)
    {
        parent::__construct($message, $code);
    }
}
