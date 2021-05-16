<?php

namespace App\Domain\Mailer;

use App\Core\Mailer\EmailToSendInterface;
use Ramsey\Uuid\UuidInterface;

class EmailToSend implements EmailToSendInterface
{
    /**
     * @var UuidInterface
     */
    private $uuid;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    /**
     * @var array
     */
    private $cc;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string|null
     */
    private $format;

    /**
     * EmailToSend constructor.
     * @param UuidInterface $uuid
     * @param string $from
     * @param string $to
     * @param array $cc
     * @param string $subject
     * @param string $body
     * @param string|null $format
     */
    public function __construct(
        UuidInterface $uuid,
        string $from,
        string $to,
        array $cc,
        string $subject,
        string $body,
        ?string $format
    ) {
        $this->uuid = $uuid;
        $this->from = $from;
        $this->to = $to;
        $this->cc = $cc;
        $this->subject = $subject;
        $this->body = $body;
        $this->format = $format;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return array
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function toArray(): array
    {
        return [
            'uuid'    => $this->uuid,
            'from'    => $this->from,
            'to'      => $this->to,
            'cc'      => $this->cc,
            'format'  => $this->format,
            'subject' => $this->subject,
            'body'    => $this->body,
        ];
    }

    public function toString(): string
    {
        return json_encode($this->toArray());
    }
}
