<?php

declare(strict_types=1);

namespace MeetupOrganizing;

use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;

class ScheduleMeetupCommand
{
    private int $organizerId;

    private string $name;

    private string $description;

    private string $scheduledFor;

    private bool $cancelled;

    public function __construct(
        int $organizerId,
        string $name,
        string $description,
        string $scheduledFor,
        bool $cancelled = false
    )
    {
        $this->organizerId = $organizerId;
        $this->name = $name;
        $this->description = $description;
        $this->scheduledFor = $scheduledFor;
        $this->cancelled = $cancelled;
    }

    public function getOrganizerId(): UserId
    {
        return UserId::fromInt($this->organizerId);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function scheduledFor(): ScheduledDate
    {
        return ScheduledDate::fromString($this->scheduledFor);
    }

    public function cancelled(): bool
    {
        return $this->cancelled;
    }
}
