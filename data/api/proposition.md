# Design d'une api de consultation des données

Ce document a pour but de présenter une proposition d'arcitecture d'une API (Application Programming Interface) permettant de récupérer les données collectées par les utilisateurs de l'application.

## Quels consommateurs de données?

Les utilisateurs des données seront décrits plus en détails dans la partie suivante, mais il devrait s'agir principalement des services de guidage routier automobile, des organismes public qui utilisent les données du traffic . Enfin, la liste n'est pas exhaustive, mais on pourrait très bien imaginer des services plus généraux (pompiers, samu...) à travers leurs application de calcul d'itinéraire utiliser ce genre d'application et les ressources associées.

## Choix de l'API

Le format des données retournées par l'API devrait être normalement JSON, afin de privilégier sa légèreté par rapport au xml. En outre, le client n'aura besoin d'aucune connaissance pour utiliser le service avec aucune connaissance de l'API, mis à part l'emplacement des données dans l'API.
. Toutes ces raisons font que nous nous orienterons ainsi vers une architecture client-serveur de type REST (Representational State Transfer), simple d'utilisation et reposant sur des protocoles standardisés tels que HTTP. 

## Choix des ressources 

Les ressources concernées par l'API sont de notre point de vue:

* Les modifications définitives du réseaux (limitations de vitesse, cédez le passage ...). Ces données devraient être intégrer par des services de guidage automobile tels que TomTom, Here, Google ou Waze.

* Les perturbations validées sur le réseaux (accident...). Ces données pourraient être utiliser également par les services de guidage automobiles, mais également aussi par des organismes tels que Sytadin.

Nous ne proposerons donc pas d'accès aux infrastructures fixes composant notre application. En effet, il s'agit là de la première activité de nombreux autres organismes, leurs données sont donc bien plus conséquentes et pas seulement limitées à l'Ile de France.

## Choix du nom de domaine

L'API est designée pour les clients, elle doit donc rester intuitive, y compris dans le choix du nom de domaine, afin de favoriser son tuilisation. Nous nous orienterons donc vers une URL suivante, avec la version de l'API à la fin de l'URL:  

[https://api.fakecompany.com/v1/](http://www.google.com)

Il sera bien évidemment illustré dans la documentation les appels à l'API.

## Choix des URI

### Les perturbations


Comme évoqué précédemment, les seules ressources rendues disponibles seront les perturbations validées, ainsi que les modifications définitives du réseaux. Ainsi les URI, seront extrèmement simples et nous n'auront pas de choix à faire concernant la granularité à utiliser. Concernant les perturbations, comme dans le cadre du fonctionnement de l'application, nous considérerons que nous récupéreront à chaque fois la dernière formulation valide. En outre, considérées comme sûres, les ressources ne pourront pas être modifiées ou supprimées, mais seulement être récupérées au travers de l'interface, via des requêtes GET. Le retour sera effectué en JSON. 

Considérons ainsi l'exemple suivant :

    GET /perturbations/42?fields=name,creation_date,center,description 
    
    200 OK
    
    {
    
      "id":"42",
    
      "name":"gros accident",
    
      "creation_date":"15/04/2016",
    
      "center":"POINT(2.59 48.84)",
    
      "description":"tunnel de Nogent bouché, un poids lourd impliqué"
    
    }


### Les modifications

Modifications are coming soon ...


## Les entêtes

### Contenu des entêtes

### Status code

Liste des codes retour HTTP utilisés (un code pour chaque cas d'utilisation courant):

* 200 OK : code de succès classique fonctionnant dans les principaux cas (requêtes GET réussies sur une ressource)

* 401 : unauthorized

* 403 : forbidden

GET /perturbations/42
< 403 Forbidden
< {"error": "not_allowed", "error_description": "You're not allowed to perform this request"}

* 404 : doesn't exist

* 50x : server error

(Penser à rajouter des exemples de retour pour chaque cas) 

## Sécuriser l'accès aux données

Deux protocoles sont généralement utilisés pour sécuriser les API REST :

* OAuth1

* OAuth2

Dans le cadre de cette application, nous préconisons d'utiliser OAuth2. En effet, OAuth2 est le standard de sécurisation des API : proposer un protocole marginal freinerait vraisemblablement l’adoption de notre API. De plus, contrairement à OAuth1, OAuth2 permet de gérer l’authentification et l’habilitation des ressources par tout type d’application (native mobile, native tablette, application javascript, application web de type serveur, application batch/back-office, …) avec ou sans consentement de l’utilisateur propriétaire des ressources.

## La documentation

Le succès d'une API dépend principalement de sa facilité d'utilisation et donc de la qualité de sa documentation. Un effort important sera donc mis en place afin garantir une bonne utilisation de l'API. Par ailleurs, la documentation sera disponible à l'adresse suivante:

[https://api.fakecompany.com/v1/doc/](http://www.google.com)

