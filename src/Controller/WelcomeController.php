<?php

// App\Controller signifie qu'on est dans src/Controller
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello()
    {
        $name = 'Matthieu';

        dump(['name' => [$name]]);

        // return new Response('<body>Bonjour '.$name.'</body>');
        return $this->render('welcome/hello.html.twig', [
            'name' => $name // La variable name sera accessible dans Twig
        ]);
    }

    /**
     * Un commentaire avec {name} non interprété par Symfony.
     * @Route("/bonjour/{name}", name="hello_you", requirements={"name"="\w+"})
     */
    public function helloYou($name = 'inconnu')
    {
        $users = [
            ['name' => 'toto', 'firstname' => 'Fabien'],
            ['name' => 'titi', 'firstname' => 'Thibault'],
            ['name' => 'tata', 'firstname' => 'Guillaume'],
        ];

        foreach ($users as $user) {
            if ($name === $user['firstname']) {
                return $this->render('welcome/hello.html.twig', [
                    'name' => $name,
                    'users' => $users
                ]);
            }
        }

        // Renvoie une 404...
        throw $this->createNotFoundException();
    }
}
