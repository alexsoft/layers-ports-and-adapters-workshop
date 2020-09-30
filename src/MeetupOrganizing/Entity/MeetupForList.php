<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

class MeetupForList
{
    private int $id;

    private string $name;

    private ScheduledDate $scheduledFor;

    public function __construct(
        int $id,
        string $name,
        ScheduledDate $scheduledFor
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->scheduledFor = $scheduledFor;
    }

    public function getMeetupId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScheduledFor(): string
    {
        return $this->scheduledFor->asString();
    }

    public static function fromDatabaseRecord(array $record): self
    {
        return new self(
            (int)$record['meetupId'],
            $record['name'],
            ScheduledDate::fromString($record['scheduledFor'])
        );
    }
}
