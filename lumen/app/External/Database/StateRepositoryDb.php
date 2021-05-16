<?php

declare(strict_types=1);

namespace App\External\Database;

use App\Core\Message\StateInterface;
use App\Domain\State\ProcessManager\State;
use App\Domain\State\ProcessManager\StateRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class StateRepositoryDb implements StateRepositoryInterface
{
    public function find(UuidInterface $processUuid): ?StateInterface
    {
        $response = (array)DB::table('state')
            ->where('process_uuid', '=', $processUuid)
            ->get()
            ->first();

        $markedAsDoneAt = $response['marked_as_done_at'] ? new \DateTime($response['marked_as_done_at']) : null;
        return new State(
            Uuid::fromString($response['process_uuid']),
            json_decode($response['payload'], true),
            json_decode($response['phases'], true),
            $markedAsDoneAt
        );
    }

    public function save(StateInterface $state): bool
    {
        return DB::table('state')->updateOrInsert(
            ['process_uuid' => $state->getProcessUuid()],
            [
                'process_uuid'      => $state->getProcessUuid(),
                'payload'           => json_encode($state->getPayload()),
                'phases'            => json_encode($state->getPhases()),
                'marked_as_done_at' => $state->getMarkedAsDoneAt(),
            ]
        );
    }
}
