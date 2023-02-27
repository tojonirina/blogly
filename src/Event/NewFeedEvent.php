<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class NewFeedEvent extends Event
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
