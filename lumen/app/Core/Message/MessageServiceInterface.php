<?php

namespace App\Core\Message;

interface MessageServiceInterface
{
    public function emit(MessageInterface $message);

}
