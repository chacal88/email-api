<?php

namespace App\Core\Mailer;

interface MailerFactoryInterface
{
    public function build(string $mailerClass, string $strategyClass): MailerInterface;
}
