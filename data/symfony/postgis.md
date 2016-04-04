## Instalaltion de PostGIS

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

    php composer.phar update

Ensuite, il faut donner les paramètres de configuration de la base :

Dans le fichier `TSIc/Symfony/config/parameters.yml` :

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

### de Postgres

Dans le fichier `sudo vim pg_hba.conf`, ajouter la ligne :

    local   all             symfony                                 trust

Après la ligne :

    local   all             postgres                                peer

Passer en utilisateur posgres :

    sudo su postgres

Ajouter un utilisateur symfony :

    create role symfony WITH createdb login;

### de PHP

Ajouter dans les fichiers `/etc/php5/apache2/php.ini` (et `/etc/php/7.0/cli/php.ini` si besoin) :

    extension=pdo.so
    extension=php_pdo.so
    extension=php_pdo_pgsql.so

C'est terminé ?
