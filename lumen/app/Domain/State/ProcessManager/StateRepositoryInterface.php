<?php

declare(strict_types=1);

namespace App\Domain\State\ProcessManager;

use App\Core\Message\StateInterface;
use Ramsey\Uuid\UuidInterface;

interface StateRepositoryInterface
{
    public function find(UuidInterface $processUuid): ?StateInterface;

    public function save(StateInterface $state);
}
