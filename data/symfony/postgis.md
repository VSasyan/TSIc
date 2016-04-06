## Installation de PostGIS

    sudo apt-get update
    sudo apt-get install postgresql-9.5-postgis-2.2 php5-pgsql -y

Informations sur l'installation :

    Creating new cluster 9.5/main ...
        config /etc/postgresql/9.5/main
        data   /var/lib/postgresql/9.5/main
        locale fr_FR.UTF-8
        socket /var/run/postgresql
        port   5432

## Configuration

### de Symfony

Normalement, il faut ajouter la dépendance dans composer (ici non !):

    php composer.phar require jsor/doctrine-postgis

Pas besoin de lme faire car le `composer.json` est synchronisé avec git, il faut donc juste synchroniser :

    git pull origin master
    php composer.phar update

Ensuite, il faut donner les paramètres de configuration de la base :

Dans le fichier `TSIc/Symfony/app/config/parameters.yml` :

    # This file is auto-generated during the composer install
    parameters:
        database_driver: pdo_pgsql
        database_host: 127.0.0.1
        database_port: 5432
        database_name: tsic
        database_user: symfony
        database_password: null
        mailer_transport: smtp
        mailer_host: 127.0.0.1
        mailer_user: null
        mailer_password: null
        secret: ThisTokenIsNotSoSecretChangeIt

**ATTENTION** : il faut bien copier la ligne **database_driver**.

### de Postgres

Dans le fichier :
* `/etc/postgresql/9.4/main/pg_hba.conf` (Debian Jessie)
* `/etc/postgresql/9.5/main/pg_hba.conf` (Debian Testing)

Ajouter la ligne :

    local   all             symfony                                 trust

Après la ligne :

    local   all             postgres                                peer

Et la ligne :

    host    all             symfony         0.0.0.0/0               trust

Après les lignes :

    # IPv4 local connections:
    host    all             all             127.0.0.1/32            md5

Passer en utilisateur posgres :

    sudo su postgres

Se connecter à la base via psql :

    psql

Ajouter un utilisateur symfony :

    create role symfony WITH createdb login;

Ajouter la base `tsic` :

    create database tsic WITH owner symfony;

Ajouter l'extension spatiale dans la base `tsic` :

    \connect tsic
    CREATE EXTENSION postgis;

### de PHP

Ajouter dans les fichiers `/etc/php5/apache2/php.ini` :

    extension=pdo.so
    extension=php_pdo.so
    extension=php_pdo_pgsql.so

# Problème php7

Il y a parfois php 7 qui fait des misères... Il faut tester si php7 est installé : `php --version`. Si oui :
* ou vous appelez toujours `php5` et plus `php` ;
* ou vous désinstallez php7 : `sudo apt-get remove php7-cli`.

## C'est terminé !

Redémarrer les services :

Debian 7 :

    sudo service postgresql restart
    sudo service apache2 restart

Debian 9 :

    sudo systemctl restart postgresql
    sudo systemctl restart apache2

Synchroniser le repository git, allez dans le dossier `TSIc/Symfony` et tapez :

    php bin/console doctrine:schema:update --dump-sql

Cette ligne vous affiche les modifications à effectuer pour mettre à jour la base par rapport aux Entities que nous avions faites. Pour effectivement mettre à jour tapez :

    php bin/console doctrine:schema:update --force

L'ensemble (?) des commandes est disponible ici : [Liste des commandes](commandes.md)
