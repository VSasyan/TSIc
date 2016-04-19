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
	DROP TABLE file CASCADE;
	DROP TABLE formulation CASCADE;
	DROP TABLE message CASCADE;
	DROP TABLE objet_terrain CASCADE;
	DROP TABLE particulier CASCADE;
	DROP TABLE perturbation CASCADE;
	DROP TABLE perturbation_file CASCADE;
	DROP TABLE professionnel CASCADE;
	DROP TABLE road_link CASCADE;
	DROP TABLE road_node CASCADE;
	DROP TABLE type_objet_terrain CASCADE;
	DROP TABLE type_perturbation CASCADE;
	DROP TABLE vote CASCADE;

	DROP SEQUENCE admin_id_seq;
	DROP SEQUENCE formulation_id_seq;
	DROP SEQUENCE file_id_seq;
	DROP SEQUENCE message_id_seq;
	DROP SEQUENCE objet_terrain_id_seq;
	DROP SEQUENCE particulier_id_seq;
	DROP SEQUENCE perturbation_id_seq;
	DROP SEQUENCE perturbation_file_id_seq;
	DROP SEQUENCE professionnel_id_seq;
	DROP SEQUENCE road_link_inspireid_seq;
	DROP SEQUENCE road_node_inspireid_seq;
	DROP SEQUENCE type_objet_terrain_id_seq;
	DROP SEQUENCE type_perturbation_id_seq;
	DROP SEQUENCE vote_id_seq;
