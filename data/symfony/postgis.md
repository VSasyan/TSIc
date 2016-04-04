## Instalaltion de PostGIS

    sudo apt-get update
    sudo apt-get install postgresql-9.5-postgis-2.2 -y

Informations sur l'installation :

    Creating new cluster 9.5/main ...
        config /etc/postgresql/9.5/main
        data   /var/lib/postgresql/9.5/main
        locale fr_FR.UTF-8
        socket /var/run/postgresql
        port   5432

## Configurer Symfony pour PostGIS

Normalement, il faut ajouter la dépendance dans composer (ici non !):

    php composer.phar require jsor/doctrine-postgis

Pas besoin de lme faire car le `composer.json` est synchronisé avec git, il faut donc juste synchroniser :

    php composer.phar update

