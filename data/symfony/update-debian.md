# Ajout des dépôts de Debian jessie

Dans votre `/etc/apt/sources.list`, vous devez avoir deux lignes :

    deb <mirroir.debian.org/packages> wheezy main
    deb-src <mirroir.debian.org/packages> wheezy main

Dupliquez-les et remplacez dans la copie *wheezy* par *jessie*.


# Mise à jour de la liste

    apt-get update

# Installation d'un paquet

    apt-get install -t jessie apache2 php5 postgis postgresql-9.4-postgis-2.1 php5-pgsql
