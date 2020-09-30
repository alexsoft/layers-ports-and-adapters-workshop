<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MeetupTest extends TestCase
{
    /** @test */
    public function it_can_provide_data_as_array(): void
    {
        $userId = 123;
        $name = 'iPhone 12 Reveal';
        $description = 'Fabulous';
        $dateTime = '2020-10-20 09:35';

        $sut = new Meetup(
            UserId::fromInt($userId),
            $name,
            $description,
            ScheduledDate::fromString($dateTime),
            false
        );

        $this->assertEquals(
            [
                'organizerId' => 123,
                'name' => $name,
                'description' => $description,
                'scheduledFor' => $dateTime,
                'wasCancelled' => 0,
            ],
            $sut->getData()
        );
    }

    /** @test */
    public function it_throws_an_exception_when_empty_name_is_provided(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Meetup(
            UserId::fromInt(123),
            '',
            'Fabulous',
            ScheduledDate::fromString('2020-10-20 09:35'),
            false
        );
    }

    /** @test */
    public function it_throws_an_exception_when_empty_description_is_provided(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Meetup(
            UserId::fromInt(123),
            'iPhone 12 Reveal',
            '',
            ScheduledDate::fromString('2020-10-20 09:35'),
            false
        );
    }

    /** @test */
    public function it_throws_an_exception_when_date_in_past_is_provided(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Meetup(
            UserId::fromInt(123),
            'iPhone 12 Reveal',
            'Fabulous',
            ScheduledDate::fromString('2019-10-20 09:35'),
            false
        );
    }
}
