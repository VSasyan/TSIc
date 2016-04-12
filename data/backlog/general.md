# Backlog general

## Sprint 1 : 4-7

* Formalisation UML [OK]
* Voir l'intégration Jenkins avec Symfony [KO]
* Configuration de Symfony [OK]
* Mise en place des "Entity" : Particulier, Professionnel, Perturbation, Formulation, Validation, Terminated, Formulation [50%]
* Mise en place des "Controller" : Utilisateur, Perturbation [avec Tests unitaires] [50%]
  * voir perturbations : [50%]
    * lister perturbations locales [OK]
    * lister toutes les perturbations [0%]
    * afficher une perturbation en détails [OK]
* Mise en place des "View" : [OK]
* Mise en place des "Type" : Particulier, Pro, Perturbation/Formulation [OK]
* Trouver base pour fournir les objects "autres" [OK]
* Liste des objets INSPIRE [50%]

## Sprint 1.5 : 8-11

* Mise en place des Objets Terrains
    * creation du controller ObjetTerrain [OK]
    * importation des données récupérées [OK]
* Mise en place du système de vote [...]
* Amélioration de la carte pour voir les ObjetTerrain [...]
    * récupération d'icones [...]
    * ajout des types dans AdminController:initAction [OK]
* Amélioration de la carte pour la géolocalisation [OK]
    * chargement des objets dans un rayon de 2-3 "vues Leaflet" [...]
    * rechargelment si on sort de ce rayon [OK]
* Ajouter la cause supposée de la perturbation (Champ de texte libre), modifier : Type, Entity [...]
* AdminController : ajouter des Type de Perturbation avec des icones (Route bloquée, Réduction de voies, Réduction de la vitesse) [OK, icone ...]

## Sprint 2 : 12-14

### Modélisation :

* Modélisation de l'ajout d'un socket NodeJS
* Modélisation de l'ajout d'une base "chaude" en Redis
* Modélisation de l'ajout (par les pro) d'objets (perturbation) de la directive Inspire :
    * Perturbations Anticipées : AccesRestrictionValue, RestrictionTypeValue
    * Pertubations Météos
* Modélisation de l'ajout (par les pro) d'objets (réseau routier) de la directive Inspire :
    * Services : RoadServiceTypeValue, ServiceFacilityValue
    * Réseau : Link, LinkDirectionValue, NumberOfLanes
    * Trouve base pour l'existant

Le but est de proposer un modèle à ajouter au notre pour prendre en compte ces objets. Il faudra creuser autour du document de Romain pour identifier les classes.

### Implémentation : 13-14

A détailler le 12 au soir.

## Sprint 3 : 18-20

Implementation du reste de la Sprint2.
A détailler le 12 au soir.

## Sprint4 : préparation de la soutenance : le 21
