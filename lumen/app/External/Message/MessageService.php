<?php

namespace App\External\Message;

use App\Core\Message\MessageServiceInterface;
use App\Core\Message\MessageInterface;

class MessageService implements MessageServiceInterface
{
    public function emit(MessageInterface $message)
    {
        event($message);
    }
}
