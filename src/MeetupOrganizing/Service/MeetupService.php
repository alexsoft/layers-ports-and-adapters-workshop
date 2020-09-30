<?php

declare(strict_types=1);

namespace MeetupOrganizing\Service;

use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;

class MeetupService
{
    private MeetupRepository $meetupRepository;

    public function __construct(MeetupRepository $meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;
    }

    public function schedule(
        int $organizerId,
        string $name,
        string $description,
        string $dateTime,
        bool $isCancelled = false
    ): int
    {
        $meetup = new Meetup(
            UserId::fromInt($organizerId),
            $name,
            $description,
            ScheduledDate::fromString($dateTime),
            $isCancelled
        );

        return $this->meetupRepository->save($meetup);
    }
}
