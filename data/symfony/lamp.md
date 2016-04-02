# LAMP

Installation de LAMP : Linux, Apache, MySQL, PHP5

## Installation des logiciels

    sudo apt-get update
    sudo apt-get install apache2 php5 mysql-server php5-mysql phpmyadmin

Pendant l'installation, il faudra choisir un mot de passe root pour MySQL, tapez `root`.

## Configuration

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

Vous devez cloner ce repository. Le repertoire `TSIc/` représente ci-dessous le dossier parent en local (pour moi `/home/vsasyan/Documents/TSIc`).

Ajouter les permission d'ecriture dans les dossier `cache` et `log` :

    cd TSIc/Symfony/app
    chmod -R 777 logs
    chmod -R 777 cache

Git ne sauvegarde pas les dépendances de Symfony, il faut faire :

    composer install

(Pensez à le refaire si le site ne fonctionne pas : le ficheir composer.json a dû être modifié : il faut remettre à jour les dépendances.)

## Terminé !

Lancer appache2. Vous pouvez verifier que tout fonctionne ici :
* http://127.0.0.1/config.php
* http://127.0.0.1/app_dev.php
