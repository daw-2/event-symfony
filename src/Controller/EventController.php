<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class EventController extends AbstractController
{
    /**
     * @Route("/evenements", name="event_list")
     */
    public function index(
        Request $request,
        EventService $eventService,
        EntityManagerInterface $em
    ): Response {
        // $em est la même chose que $this->getDoctrine()
        $repository = $em->getRepository(Event::class);

        // Tous les events
        $events = $repository->findAll(); // select * from event

        // Un event
        $event = $repository->find(1); // select * from event where id = 1

        // Des events where name
        $events = $eventService->search('c');
        dump($events);

        // Pour récupérer un $_GET['sort']
        $sort = $request->query->get('sort');
        // Pour récupèrer un $_POST['sort']
        $sort = $request->request->get('sort');
        $sort = $request->get('sort');

        return $this->render('event/index.html.twig', [
            // Modifier le search pour avoir un paramètre sort
            // et ensuite ajouter un orderBy avec la valeur de
            // ce sort, la valeur sera price ou date
            'events' => $eventService->search(
                $request->get('search'),
                $request->get('sort'),
                $page = $request->get('page', 1)
            ),
            'incoming' => $eventService->countIncoming(),
            'page' => $page
        ]);
    }

    /**
     * @Route(
     *     "/evenements/{id}",
     *     name="event_show",
     *     requirements={"id"="\d+"}
     * )
     */
    public function show(
        Environment $twig,
        EventService $eventService,
        $id
    ): Response {
        // $twig est un service que l'on récupère via l'injection de dépendances
        // Le fait que ce soit dans les paramètres du controller s'appelle
        // l'auto wiring
        // dump($twig);
        // Le service évite d'instancier la classe nous même
        // $eventServicePlain = new EventService($twig);
        // dump($eventServicePlain);
        dump($eventService);

        if (is_null($event = $eventService->find($id))) {
            throw $this->createNotFoundException();
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/evenements/nouveau", name="event_new")
     */
    public function new(
        Request $request,
        EventService $eventService
    ): Response {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On veut créer l'événement...
            $eventService->create($event);
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($event);
            // $em->flush(); // INSERT

            $this->addFlash('success', 'Votre événement a été créé.');

            // Redirection vers l'événement
            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/evenements/{id}/rejoindre",
     *     name="event_join",
     *     requirements={"id"="\d+"}
     * )
     */
    public function join($id): Response
    {
        return new Response("Rejoindre l'événement $id");
    }
}
