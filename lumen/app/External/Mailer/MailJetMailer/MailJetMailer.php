<?php

namespace App\External\Mailer\MailJetMailer;

use App\Core\Mailer\EmailToSendInterface;
use App\Core\Mailer\MailerException;
use App\External\Mailer\MailerStrategyTrait;
use Mailjet\Client;
use Mailjet\Resources;

class MailJetMailer implements MailJetMailerInterface
{
    use MailerStrategyTrait;

    /**
     * @throws MailerException
     */
    public function send(EmailToSendInterface $emailToSend): bool
    {
        try {
            $mailerClient = new Client(
                getenv('MJ_APIKEY_PUBLIC'),
                getenv('MJ_APIKEY_PRIVATE'),
                true,
                ['version' => 'v3.1']
            );
            $strategy = $this->getMailerStrategy();
            $cc = array_map(
                function ($cc) {
                    return ['Email' => $cc];
                },
                $emailToSend->getCc()
            );

            $body = [
                'Messages' => [
                    [
                        'From'              => [
                            'Email' => $emailToSend->getFrom()
                        ],
                        'To'               => [
                            [
                                'Email' => $emailToSend->getTo()
                            ]
                        ],
                        'Cc'                => $cc,
                        'Subject'           => $emailToSend->getSubject(),
                        $strategy->getKey() => $strategy->getBody($emailToSend)
                    ]
                ]
            ];
            return true;
            $response = $mailerClient->post(Resources::$Email, ['body' => $body]);
            return $response->success() ?? false;
        } catch (\Exception $e) {
            throw new MailerException($e->getMessage(), $e->getCode());
        }
    }
}
