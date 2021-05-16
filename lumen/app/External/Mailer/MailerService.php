<?php

namespace App\External\Mailer;

use App\Core\Mailer\MailerServiceInterface;
use App\Core\Mailer\MailerStrategyInterface;

class MailerService implements MailerServiceInterface
{
    public function listMailers(): array
    {
        return self::MAILERS;
    }

    public function listStrategy(string $mailer): array
    {
        return MailerStrategyInterface::FORMATS[$mailer];
    }
}
