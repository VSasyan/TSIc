# LAMP

Installation de LAMP : Linux, Apache, MySQL, PHP5

## Installation des logiciels

    sudo apt-get update
    sudo apt-get install apache2 php5 mysql-server php5-mysql phpmyadmin

## Configuration

### Apache

Ajouter un utilisateur apache :

    sudo chown -R www-data:pi /var/www/html/
    sudo chmod -R 770 /var/www/html/

[A finir]
