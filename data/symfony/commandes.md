# Liste des commandes

## Commandes BDD

### Pour créer bdd defini dans parameters.yml :

    php bin/console doctrine:database:create 

### Maj de la bdd :

    php bin/console doctrine:schema:update --dump-sql 

### Application du sql à la bdd :

    php bin/console doctrine:schema:update --force 

### Création d'une nouvelle entity :

	php bin/console generate:doctrine:entity

### Generation getter/setter

    php bin/console doctrine:generate:entities AppBundle:Particulier

### Creation de formulaire :

    php bin/console doctrine:generate:form AppBundle:Particulier

## Cache

### prod

    php bin/console cache:clear --env=prod

### dev

    php bin/console cache:clear

## Vider base postgis :

Executer dans pgAdmin :

	DROP TABLE admin CASCADE;
	DROP TABLE formulation CASCADE;
	DROP TABLE message CASCADE;
	DROP TABLE objet_terrain CASCADE;
	DROP TABLE particulier CASCADE;
	DROP TABLE perturbation CASCADE;
	DROP TABLE professionnel CASCADE;
	DROP TABLE type_objet_terrain CASCADE;
	DROP TABLE type_perturbation CASCADE;
	DROP TABLE vote CASCADE;