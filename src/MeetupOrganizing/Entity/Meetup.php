<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Assert\Assert;
use DateTimeImmutable;

class Meetup
{
    private UserId $organizer;

    private string $name;

    private string $description;

    private ScheduledDate $scheduledFor;

    private bool $isCancelled;

    public function __construct(
        UserId $organizer,
        string $name,
        string $description,
        ScheduledDate $scheduledFor,
        bool $isCancelled
    )
    {
        $this->organizer = $organizer;

        Assert::that($name)->notEmpty();
        $this->name = $name;

        Assert::that($description)->notEmpty();
        $this->description = $description;

        Assert::that($scheduledFor->isInTheFuture(new DateTimeImmutable()))->true();
        $this->scheduledFor = $scheduledFor;
        $this->isCancelled = $isCancelled;
    }

    public function getData(): array
    {
        return [
            'organizerId' => $this->organizer->asInt(),
            'name' => $this->name,
            'description' => $this->description,
            'scheduledFor' => $this->scheduledFor->asString(),
            'wasCancelled' => (int)$this->isCancelled,
        ];
    }
}
