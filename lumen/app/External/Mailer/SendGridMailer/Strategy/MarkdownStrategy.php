<?php

namespace App\External\Mailer\SendGridMailer\Strategy;

use App\Core\Mailer\EmailToSendInterface;
use App\Core\Mailer\MailerStrategyInterface;
use Illuminate\Mail\Markdown;

class MarkdownStrategy implements MailerStrategyInterface
{
    public function getBody(EmailToSendInterface $emailToSend): string
    {
        return Markdown::parse($emailToSend->getBody())->toHtml();
    }

    public function getKey(): string
    {
        return 'text/html';
    }
}
