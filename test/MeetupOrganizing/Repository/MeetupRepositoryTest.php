<?php

declare(strict_types=1);

namespace MeetupOrganizing\Repository;

use Doctrine\DBAL\Connection;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;
use PHPUnit\Framework\TestCase;

class MeetupRepositoryTest extends TestCase
{
    /** @test */
    public function it_saves_calling_insert_with_proper_data(): void
    {
        $userId = 123;
        $name = 'iPhone 12 reveal';
        $description = 'Fabulous event';
        $dateTime = '2020-10-20 09:35';

        $meetup = new Meetup(
            UserId::fromInt($userId),
            $name,
            $description,
            ScheduledDate::fromString($dateTime),
            false
        );

        $connection = $this->createMock(Connection::class);

        $sut = new MeetupRepository(
            $connection
        );

        $connection->expects($this->once())
            ->method('insert')
            ->with(
                'meetups',
                [
                    'organizerId' => $userId,
                    'name' => $name,
                    'description' => $description,
                    'scheduledFor' => $dateTime,
                    'wasCancelled' => 0,
                ]
            );

        $connection->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(111);

        $this->assertEquals(111, $sut->save($meetup));
    }
}
