<?php

namespace App\External\Mailer;

use App\Core\Mailer\MailerStrategyInterface;

trait MailerStrategyTrait
{
    /**
     * @var MailerStrategyInterface
     */
    private $mailerStrategy;

    /**
     * @param MailerStrategyInterface $mailerStrategy
     */
    public function setMailerStrategy(MailerStrategyInterface $mailerStrategy): void
    {
        $this->mailerStrategy = $mailerStrategy;
    }

    /**
     * @return MailerStrategyInterface
     */
    public function getMailerStrategy(): MailerStrategyInterface
    {
        return $this->mailerStrategy;
    }
}
