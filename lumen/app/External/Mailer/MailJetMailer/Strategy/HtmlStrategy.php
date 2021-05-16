<?php

namespace App\External\Mailer\MailJetMailer\Strategy;

use App\Core\Mailer\EmailToSendInterface;
use App\Core\Mailer\MailerStrategyInterface;

class HtmlStrategy implements MailerStrategyInterface
{
    public function getBody(EmailToSendInterface $emailToSend): string
    {
        return $emailToSend->getBody();
    }

    public function getKey(): string
    {
        return 'HtmlPart';
    }
}
