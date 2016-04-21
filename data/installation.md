# README Symfony

## Installations

### Installation des programmes

Pour fonctionner, le site à besoin de :
* `Apache 2.4` : gestion du serveur ;
* `PHP 5.6` : gestion du site, droit d'accès des utilisateurs, enregistrement dans les base de données ;
* `Postgres 9.4` et `PostGIS 2.1` : base de donnée SQL pour le stockage des informations ;
* `NodeJS` : socket temps réel lors de l'ajout / la visualisation des peturbations.

On peut ajouter en plus :
* `Redis` : base de donnée pour stocker les perturbations envoyées pour éviter de surcharger le site ;
* `Java` : script pour copeir les pertrubations de la base Redis à la base PostGIS.

Commades à exécuter sous linux (debian Jessie) :

    sudo apt-get update
    sudo apt-get install apache2 php5 php5-pgsql postgresql-9.4-postgis-2.1 nodejs

Installation pour Debian Wheezy : [Voir ici](update-debian.md)

## Cloner le projet

Vous devez cloner ce repository. Le repertoire `TSIc/` représente ci-dessous le dossier parent en local (pour moi `/home/vsasyan/Documents/TSIc`).
Git ne doit pas changer les droits des fichiers :

    git config core.fileMode false

## Configuration

### Proxy

Il faut configurer le proxy, ajoutez dans `~/.bashrc` :

    export http_proxy="http://10.0.4.2:3128"
    export https_proxy="http://10.0.4.2:3128"
    export HTTP_PROXY=$http_proxy
    export HTTPS_PROXY=$https_proxy
    
Note : `composer`, le programme qui gère les dépendances de Symfony, a besoin d'un `https_proxy` en
`http://` au lieu de `https://`. Pensez à modifier ses paramètres si vous utilisez d'autres
programmes (notaement Git en https et non ssh).

### Apache

Ajouter l'utilisateur apache dans votre groupe (ici `gtsi`) :

    sudo adduser www-data gtsi

Modifier le répertorie par défaut d'apache :

* Dans le fichier `/etc/apache2/apache2.conf` modifier `/var/www` pour que ça pointe
dans le dossier web de votre copie locale du GitHub. (Pour moi `/home/vsasyan/Documents/TSIc/Symfony/web`.)

* Dans le fichier `/etc/apache2/sites-available/000-default.conf` modifier `/var/www/html`
pour que ça pointe dans le dossier web de votre copie locale du GitHub. (Pour moi `/home/vsasyan/Documents/TSIc/Symfony/web`.)

### PHP

Les paramètres sont à ajouter dans le fichier `/etc/php5/apache2/php.ini`.

Vous devez préciser le fuseau horaire :

    date.timezone = "Europe/Paris"

Ajouter l'extension PDO (gestion avancée des base de données) :

    extension=pdo.so
    extension=php_pdo.so
    extension=php_pdo_pgsql.so

### Symfony

Ajouter les permission d'écriture dans les dossier `cache` et `log` :

    cd TSIc/Symfony
    chmod -R 777 var/*

Git ne sauvegarde pas les dépendances de Symfony, il faut faire :

    php composer.phar install

Note pour la suite : pensez à le refaire si le site ne fonctionne pas : le fichier 
composer.json a dû être modifié : il faut remettre à jour les dépendances. Dans ce 
cas, il suffit de mettre à jour :

    php composer.phar update

Composer a dû initialiser les paramètres de la base de donnée, vérifiez le fichier `Symfony/app/config/parameters.yml`, il doit contenir :

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

### Postgres

Dans le fichier :
* `/etc/postgresql/9.4/main/pg_hba.conf` (Debian Jessie)
* `/etc/postgresql/9.5/main/pg_hba.conf` (Debian Testing)

Mettre les droits de connexion :

    # Database administrative login by Unix domain socket
    local   all             postgres                                trust
    local   all             symfony                                 trust
    
    # TYPE  DATABASE        USER            ADDRESS                 METHOD
    
    local   all             all                                     trust
    host    all             all             127.0.0.1/32            trust
    host    all             symfony         0.0.0.0/0               trust
    host    all             all             ::1/128                 md5

Passer en utilisateur posgres :

    sudo su postgres

Se connecter à la base via psql :

    psql

Ajouter un utilisateur symfony :

    create role symfony WITH createdb login;

Ajouter la base `tsic` :

    create database tsic WITH owner symfony;
    create database osm WITH owner symfony;

Ajouter l'extension spatiale dans la base `tsic` :

    \connect tsic
    CREATE EXTENSION postgis;

Ajouter l'extension spatiale dans la base `osm` :

    \connect osm
    CREATE EXTENSION postgis;

Ensuite, toute la gestion de la base de donnée est délégué à Symfony. L'initialisation 
de la base se fait donc via ligne de commadne :

    php bin/console doctrine:schema:update --dump-sql

Cette ligne vous affiche les modifications à effectuer pour mettre à jour la base par rapport aux Entities que nous avions faites. Pour effectivement mettre à jour tapez :

    php bin/console doctrine:schema:update --force

L'ensemble (?) des commandes est disponible ici : [Liste des commandes](commandes.md)



### C'est terminé !

Redémarrer les services :

Debian 7 :

    sudo service postgresql restart
    sudo service apache2 restart

Debian 9 :

    sudo systemctl restart postgresql
    sudo systemctl restart apache2

Démarrage de NodeJS :

Il faut bien penser à démarrer NodeJS. Pour cela allez dans le dossier `TSIc/node` et entrez :

    (nodejs app.js &)

## Accéder au site !

Lancer appache2. Vous pouvez verifier que tout fonctionne ici :
* http://127.0.0.1/config.php
* http://127.0.0.1/app_dev.php
    
## Notes diverses

### PHP 7

Il y a parfois php 7 qui fait des misères... Il faut tester si php7 est installé : `php --version`. Si oui :
* ou vous appelez toujours `php5` et plus `php` ;
* ou vous désinstallez php7 : `sudo apt-get remove php7-cli`.
