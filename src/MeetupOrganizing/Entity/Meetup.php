<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

class Meetup
{
    private UserId $organizer;

    private string $name;

    private string $description;

    private ScheduledDate $scheduledFor;

    private bool $isCancelled;

    public function __construct(UserId $organizer,
                                string $name,
                                string $description,
                                ScheduledDate $scheduledFor,
                                bool $isCancelled = false)
    {
        $this->organizer = $organizer;
        $this->name = $name;
        $this->description = $description;
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
