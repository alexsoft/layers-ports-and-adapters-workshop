<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use DateTimeImmutable;

interface ListMeetupsRepository
{
    /**
     * @param DateTimeImmutable $now
     *
     * @return MeetupForList[]
     */
    public function listUpcomingMeetups(DateTimeImmutable $now): array;

    /**
     * @param DateTimeImmutable $now
     *
     * @return MeetupForList[]
     */
    public function listPastMeetups(DateTimeImmutable $now): array;
}
