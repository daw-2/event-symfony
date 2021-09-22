# EventTime: Fil Rouge

- Lister des événements
- Afficher les détails d'un événement
- Créer un événement
- Nombre d'événements
- Recherche par nom, tri
- Rejoindre un événement

## Créer le projet avec Symfony

## Configurer la base de données

## Créer les routes suivantes
  - Accueil => / => HomeController
  - Liste des événements => /evenements => EventController
  - Affichage d'un événement => /evenements/12 => EventController
  - Création d'un événement => /evenements/nouveau => EventController
  - Rejoindre un événement => /evenements/12/rejoindre => EventController

  On peut utiliser la commande : php bin/console make:controller

## Créer les templates
  - Accueil => Présentation et lien vers la liste des événements
  - Liste des événements => Placer les événements dans un tableau PHP (id, name, description, startAt, endAt)
    et passez le à la vue. Chaque événement aura une pastille à venir, en cours, passé.
  - Détail d'un événement => Récupérer l'évenement à partir du tableau, si l'événement n'existe pas, on renvoie une 404.
  - Affichage d'un menu sur le template de base

[
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
]

## Créer un service
  - Créer un service pour centraliser la logique des événements
  - Tableau avec les événements
  - Fonction pour retourner tous les événements
  - Fonction pour retourner un événement

## Créer les entités
  - Créer une entité Event: name, description, price (nullable), createdAt, startAt, endAt, poster (nullable)
  - Créer une entité Place: name, address, zipCode, city, country
  - Créer une entité Category: name

## Modifier le service
  - Le service doit maintenant permettre de récupérer les événements en base de données.
    On injectera l'EntityManager via l'injection de dépendances (constructeur).
  - Créer une méthode pour rechercher les événements par nom.
  - Créer une méthode renvoyant le nombre d'événements à venir.

## Liste des événements
  - Mettre en place le système de tri
  - Rendre fonctionnel le système de recherche
  - Mettre en place la pagination
  - Adapter les templates si nécessaire

## Créer un formulaire
  - Créer un formulaire de création d'événements (Le Form Type)
  - Instancier le formulaire sur une nouvelle page.
  - Afficher le formulaire sur cette page.
  - Gérer le traitement du formulaire
  - Ajouter les règles de validation : name (3 caractères min), date de début doit être une date future et la date de fin doit y être supérieure.
  - Afficher un message flash après une redirection sur la liste des événements
  - Gérer l'upload de l'image, on pourra également définir une url vers une image.

## Intégrer Bootstrap
  - Intégrer le framework Bootstrap avec un lien CDN
  - Adapter les thèmes des formulaires de Symfony
  
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ path('home') }}">Event Time</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ path('home') }}">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ path('event_list') }}">Evénements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ path('event_new') }}">Créer un événement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ path('hello') }}">Hello</a>
            </li>
        </ul>
    </div>
</nav>

## Créer les relations
  - Créer une relation ManyToOne entre Event et Place puis une relation ManyToMany entre Event et Category.
  - Créer les fixtures avec Doctrine et Faker

https://artisansweb.net/how-to-implement-jquery-datepicker-with-timepicker/

## Espace utilisateur
  - Créer une entité User
  - Créer un formulaire de login et d'inscription

## Créer un formulaire d'inscription à un événement
  - Créer un formulaire permettant de d'inscrire à un événement.
  - Il faudra une entité Booking avec les champs: user, event et number. Le number sera généré aléatoirement et unique.
  - Le formulaire contiendra un champ avec la liste des événement. On associera le booking à l'utilisateur connecté.
  - Restreindre la page d'inscription événement à un utilisateur connecté
  - Pré-remplir le nom du participant avec le nom de l'utilisateur connecté

## Commentaires
  - Ajouter la possibilité de commenter les événements
  - Créer l'entité Comment: message, createdAt, user, event

## Back office
  - Définir l'utilisateur connecté comme propriétaire de l'événement lors d'une création
  - Créer un back office: Gérer les Categories et les Places
  - Ajouter la possibilité de valider ou non les commentaires
