<?php

namespace App\Core\Mailer;

use App\External\Mailer\MailJetMailer\MailJetMailer;
use App\External\Mailer\MailJetMailer\Strategy\HtmlStrategy as HtmlStrategyMailJetMailer;
use App\External\Mailer\MailJetMailer\Strategy\MarkdownStrategy as MarkdownStrategyMailJetMailer;
use App\External\Mailer\MailJetMailer\Strategy\TextStrategy as TextStrategyMailJetMailer;
use App\External\Mailer\SendGridMailer\SendGridMailer;
use App\External\Mailer\SendGridMailer\Strategy\HtmlStrategy as HtmlStrategySendGridMailer;
use App\External\Mailer\SendGridMailer\Strategy\MarkdownStrategy as MarkdownStrategySendGridMailer;
use App\External\Mailer\SendGridMailer\Strategy\TextStrategy as TextStrategySendGridMailer;

interface MailerStrategyInterface
{
    public const FORMATS = [
        MailJetMailer::class  => [
            MailerInterface::FORMAT_HTML     => HtmlStrategyMailJetMailer::class,
            MailerInterface::FORMAT_MARKDOWN => MarkdownStrategyMailJetMailer::class,
            MailerInterface::FORMAT_TEXT     => TextStrategyMailJetMailer::class,
        ],
        SendGridMailer::class => [
            MailerInterface::FORMAT_HTML     => HtmlStrategySendGridMailer::class,
            MailerInterface::FORMAT_MARKDOWN => MarkdownStrategySendGridMailer::class,
            MailerInterface::FORMAT_TEXT     => TextStrategySendGridMailer::class,
        ]
    ];

    public function getBody(EmailToSendInterface $emailToSend): string;

    public function getKey(): string;
}
