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

interface MailerServiceInterface
{
    public const MAILERS = [
        MailJetMailer::class,
        SendGridMailer::class
    ];

    public function listMailers(): array;

    public function listStrategy(string $mailer): array;

}
