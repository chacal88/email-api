<?php

namespace App\External\Mailer;

use App\Core\Mailer\MailerFactoryInterface;
use App\Core\Mailer\MailerInterface;

class MailerFactory implements MailerFactoryInterface
{
    /**
     * @throws \Exception
     */
    public function build(string $mailerClass, string $strategyClass): MailerInterface
    {
        if (!class_exists($mailerClass)) {
            throw new \Exception("Unknown mailer type $mailerClass");
        }
        if (!class_exists($strategyClass)) {
            throw new \Exception("Unknown strategy type $strategyClass");
        }
        $strategy = new $strategyClass();
        $mailer = new $mailerClass();
        $mailer->setMailerStrategy($strategy);
        return $mailer;
    }
}
