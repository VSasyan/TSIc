# README Symfony


## Installations

### Installation de LAMP : Linux, Apache, MySQL, PHP5

    sudo apt-get update
    sudo apt-get install apache2 php5 mysql-server postgresql-9.5-postgis-2.2 php5-pgsql

Installation pour Debian Wheezy : [Voir ici](update-debian.md)

### Installation de composer

Composer gère toutes les dépendances de votre projet Symfony. Elles sont toutes stockées dans le fichier `composer.json`.
Pour appeler composer il faudra se mettre dans le dossier `TSIc/Symfony` et lancer via la commande :

    php composer.phar [commande]

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

### Apache

Ajouter l'utilisateur apache dans votre groupe (ici `gtsi`) :

    sudo adduser www-data gtsi

Modifier le répertorie par défaut d'apache :

Dans le fichier `/etc/apache2/apache2.conf` modifier `/var/www` pour que ça pointe dans le dossier web de votre copie locale du GitHub. (Pour moi `/home/vsasyan/Documents/TSIc/Symfony/web`.)

Dans le fichier `/etc/apache2/sites-available/000-default.conf` modifier `/var/www/html` pour que ça pointe dans le dossier web de votre copie locale du GitHub. (Pour moi `/home/vsasyan/Documents/TSIc/Symfony/web`.)

### PHP

Vous devez préciser le fuseau horaire dans `/etc/php5/apache2/php.ini`,

    date.timezone = "Europe/Paris"

### Symfony

Ajouter les permission d'ecriture dans les dossier `cache` et `log` :

    cd TSIc/Symfony/var
    chmod -R 777 logs
    chmod -R 777 cache

Git ne sauvegarde pas les dépendances de Symfony, il faut faire :

    php composer.phar install

(Pensez à le refaire si le site ne fonctionne pas : le fichier composer.json a dû être modifié : il faut remettre à jour les dépendances.)

### Base de données

[Voir ici.](postgis.md)

## Terminé !

Lancer appache2. Vous pouvez verifier que tout fonctionne ici :
* http://127.0.0.1/config.php
* http://127.0.0.1/app_dev.php
