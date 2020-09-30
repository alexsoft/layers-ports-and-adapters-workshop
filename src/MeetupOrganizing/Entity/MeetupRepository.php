<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Doctrine\DBAL\Connection;

class MeetupRepository
{
    /** @var Connection */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Meetup $meetup): int
    {
        $this->connection->insert('meetups', $meetup->getData());

        return (int)$this->connection->lastInsertId();
    }
}
