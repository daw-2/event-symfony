<?php

namespace App\Service;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{
    protected $events = [
        [
            'id' => 1,
            'name' => 'Concert',
            'description' => 'Lorem ipsum',
            'startAt' => '2021-09-01 08:00:00',
            'endAt' => '2021-09-01 13:30:00',
        ],
        [
            'id' => 2,
            'name' => 'Cinéma',
            'description' => 'Lorem ipsum',
            'startAt' => '2021-09-17 10:00:00',
            'endAt' => '2021-09-25 13:30:00',
        ],
        [
            'id' => 3,
            'name' => 'Plage',
            'description' => 'Lorem ipsum',
            'startAt' => '2021-09-25 10:00:00',
            'endAt' => '2021-09-25 13:30:00',
        ],
    ];

    protected $em;

    /**
     * @var \App\Repository\EventRepository $repo
     */
    protected $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Event::class);
    }

    /**
     * Récupèrer tous les events.
     *
     * @return array
     */
    public function all()
    {
        return $this->repo->findAll();
    }

    /**
     * Récupérer un événement particulier.
     *
     * @param  int  $id
     * @return array|null
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Permet de créer un événement.
     *
     * @param  \App\Entity\Event  $event
     * @return void
     */
    public function create($event)
    {
        $this->uploadPoster($event);

        $this->em->persist($event);
        $this->em->flush(); // INSERT
    }

    /**
     * @param  \App\Entity\Event  $event
     */
    protected function uploadPoster($event)
    {
        if (! empty($event->getPosterUrl())) {
            return $event->setPoster($event->getPosterUrl());
        }

        if (!$file = $event->getPosterFile()) {
            return;
        }

        $filename = md5(uniqid()).'.'.$file->guessExtension();
        $file->move('./images', $filename);

        // On mets le filename en BDD
        $event->setPoster($filename);
    }

    /**
     * Rechercher des événements par nom.
     *
     * @param  string  $name
     * @param  string|null  $sort
     * @param  int  $page
     * @return array
     */
    public function search($name, $sort = null, $page = 1)
    {
        return $this->repo->search($name, $sort, $page);
    }

    /**
     * Nombre d'événements à venir.
     *
     * @return int
     */
    public function countIncoming()
    {
        return $this->repo->countIncoming();
    }
}
