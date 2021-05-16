<?php

namespace App\Core\Mailer;

use Ramsey\Uuid\UuidInterface;

interface EmailToSendInterface
{
    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface;

    /**
     * @return string
     */
    public function getFrom(): string;

    /**
     * @return string
     */
    public function getTo(): string;

    /**
     * @return array
     */
    public function getCc(): array;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return string
     */
    public function getBody(): string;

    /**
     * @return string|null
     */
    public function getFormat(): ?string;

    /**
     * @return array
     */
    public function toArray(): array;

}
