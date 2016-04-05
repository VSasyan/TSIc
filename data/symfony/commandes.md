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
