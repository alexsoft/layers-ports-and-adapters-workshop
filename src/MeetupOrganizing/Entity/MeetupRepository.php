<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Assert\Assert;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use PDO;

class MeetupRepository implements ListMeetupsRepository
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

    public function listUpcomingMeetups(DateTimeImmutable $now): array
    {
        $statement = $this->connection->createQueryBuilder()
            ->select(['meetupId', 'name', 'scheduledFor'])
            ->from('meetups')
            ->where('scheduledFor >= :now')
            ->setParameter('now', $now->format(ScheduledDate::DATE_TIME_FORMAT))
            ->andWhere('wasCancelled = :wasNotCancelled')
            ->setParameter('wasNotCancelled', 0)
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        return array_map(
            [MeetupForList::class, 'fromDatabaseRecord'],
            $statement->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function listPastMeetups(DateTimeImmutable $now): array
    {
        $statement = $this->connection->createQueryBuilder()
            ->select(['meetupId', 'name', 'scheduledFor'])
            ->from('meetups')
            ->where('scheduledFor < :now')
            ->setParameter('now', $now->format(ScheduledDate::DATE_TIME_FORMAT))
            ->andWhere('wasCancelled = :wasNotCancelled')
            ->setParameter('wasNotCancelled', 0)
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        return array_map(
            [MeetupForList::class, 'fromDatabaseRecord'],
            $statement->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
