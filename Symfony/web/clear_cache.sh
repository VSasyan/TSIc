sudo chmod -R 777 ../var/*
php ../bin/console cache:clear --env=prod
sudo rm -rf ../var/logs/*
sudo chmod -R 777 ../var/*
php ../bin/console doctrine:schema:update --dump-sql
php ../bin/console doctrine:schema:update --force
php ../bin/console doctrine:schema:update --em=osm --dump-sql
php ../bin/console doctrine:schema:update --em=osm --force
