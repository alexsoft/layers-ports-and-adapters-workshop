<?php

declare(strict_types=1);

namespace MeetupOrganizing\Controller;

use DateTimeImmutable;
use MeetupOrganizing\Entity\MeetupRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ListMeetupsController implements MiddlewareInterface
{
    private TemplateRendererInterface $renderer;

    private MeetupRepository $meetupRepository;

    public function __construct(
        MeetupRepository $meetupRepository,
        TemplateRendererInterface $renderer
    ) {
        $this->renderer = $renderer;
        $this->meetupRepository = $meetupRepository;
    }

    public function __invoke(Request $request, Response $response, callable $out = null): ResponseInterface
    {
        $now = new DateTimeImmutable();

        $upcomingMeetups = $this->meetupRepository->listUpcomingMeetups($now);

        $pastMeetups = $this->meetupRepository->listPastMeetups($now);

        $response->getBody()->write(
            $this->renderer->render(
                'list-meetups.html.twig',
                [
                    'upcomingMeetups' => $upcomingMeetups,
                    'pastMeetups' => $pastMeetups
                ]));

        return $response;
    }
}
