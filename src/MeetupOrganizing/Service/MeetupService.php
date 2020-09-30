<?php

declare(strict_types=1);

namespace MeetupOrganizing\Service;

use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\ScheduleMeetupCommand;

class MeetupService
{
    private MeetupRepository $meetupRepository;

    public function __construct(MeetupRepository $meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;
    }

    public function schedule(ScheduleMeetupCommand $command): int
    {
        $meetup = new Meetup(
            $command->getOrganizerId(),
            $command->getName(),
            $command->getDescription(),
            $command->scheduledFor(),
            $command->cancelled()
        );

        return $this->meetupRepository->save($meetup);
    }
}
