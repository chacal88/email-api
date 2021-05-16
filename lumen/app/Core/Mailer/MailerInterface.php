<?php

namespace App\Core\Mailer;

interface MailerInterface
{
    public const FORMAT_HTML = "html";
    public const FORMAT_MARKDOWN = "markdown";
    public const FORMAT_TEXT = "text";

    public const FORMATS = [
        self::FORMAT_HTML,
        self::FORMAT_MARKDOWN,
        self::FORMAT_TEXT
    ];

    public function send(EmailToSendInterface $emailToSend): bool;

    public function getMailerStrategy(): MailerStrategyInterface;

    public function setMailerStrategy(MailerStrategyInterface $mailerStrategy): void;

}
