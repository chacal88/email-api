<?php

namespace App\External\Mailer\SendGridMailer;

use App\Core\Mailer\EmailToSendInterface;
use App\Core\Mailer\MailerException;
use App\External\Mailer\MailerStrategyTrait;
use Exception;
use SendGrid;
use SendGrid\Mail\Mail;

class SendGridMailer implements SendGridMailerInterface
{
    use MailerStrategyTrait;

    /**
     * @throws MailerException
     * @throws SendGrid\Mail\TypeException
     */
    public function send(EmailToSendInterface $emailToSend): bool
    {
        try {
            $mailerClient = new SendGrid(env('SENDGRID_API_KEY'));
            $strategy     = $this->getMailerStrategy();
            $sendGridMail = new Mail();
            $sendGridMail->setFrom($emailToSend->getFrom());
            $sendGridMail->setSubject($emailToSend->getSubject());
            $sendGridMail->addTo($emailToSend->getTo());
            $sendGridMail->addCc(implode(',', $emailToSend->getCc()));
            $sendGridMail->addContent($strategy->getKey(), $strategy->getBody($emailToSend));
            $response = $mailerClient->send($sendGridMail);
            return $response->statusCode() === 202 ?? false;
        } catch (Exception $e) {
            throw new MailerException($e->getMessage(), $e->getCode());
        }
    }
}
