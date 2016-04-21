# Add a database to Symfony

In order to add a new database to Symfony, you have to create it.

Go to a terminal as postgres

```shell
sudo su postgres
```

Now you want to enter SQL querries :

```shell
psql
```

Creation of the database :

```sql
CREATE DATABASE nameOfTheDataBase WITH OWNER symfony;
```

We want to add the postgis extension so we hve to connect to the database :

```
\connect nameOfTheDataBase
```

We add postgis extension :

```sql
CREATE EXTENSION postgis;
```

Now our database is created. We have to deal with Symfony's configuration.

First in config.yml, we have to add a new connection. This connection require parameters, we will create a yaml parameters file (parameters_new.yml) later. Don't forget to import the file in config.yml.
The driver in the example is pdo_pgsl but you can adapt with your needs.

In the orm section we have to set the default connection and add our new entiy manager. In the mappings section, we set which bundle will be used by this entity manager.
In our case, the new and default manager use the same bundle. 

doctrine:
```yaml
imports:
    - { resource: parameters.yml }
    - { resource: parameters_new.yml }
    - { resource: security.yml }
    - { resource: services.yml }
    
    ...
    
    dbal:
        default_connection: default
        connections:
            default:
                driver:   "pdo_pgsql"
                host:     "%database_host%"
                port:     "%database_port%"
                dbname:   "%database_name%"
                user:     "%database_user%"
                password: "%database_password%"
                charset:  UTF8
                # if using pdo_sqlite as your database driver:
                #   1. add the path in parameters.yml
                #     e.g. database_path: "%kernel.root_dir%/data/data.db3"
                #   2. Uncomment database_path in parameters.yml.dist
                #   3. Uncomment next line:
                #     path:     "%database_path%"
            actual:
                driver:   "pdo_pgsql"
                host:     "%database_host_new%"
                port:     "%database_port_new%"
                dbname:   "%database_name_new%"
                user:     "%database_user_new%"
                password: "%database_password_new%"
                charset:  UTF8

    orm:
        default_entity_manager: default
        auto_generate_proxy_classes: "%kernel.debug%"
        entity_managers:
            default:
                connection: default
                mappings:
                    AppBundle:  ~
                dql:
                    string_functions:
                        ST_Distance: Jsor\Doctrine\PostGIS\Functions\ST_Distance
                        ST_GeomFromText: Jsor\Doctrine\PostGIS\Functions\ST_GeomFromText
                naming_strategy: doctrine.orm.naming_strategy.underscore
                auto_mapping: true
                
            actual:
                connection: nameOfOurEm
                mappings:
                    AppBundle: ~
                dql:
                    string_functions:
                        ST_Distance: Jsor\Doctrine\PostGIS\Functions\ST_Distance
                        ST_GeomFromText: Jsor\Doctrine\PostGIS\Functions\ST_GeomFromText
                naming_strategy: doctrine.orm.naming_strategy.underscore
```

We can now create the parameters_new.yml file :

```yaml
parameters:
    database_host_new: 127.0.0.1
    database_port_new: 5432
    database_name_new: nameOfTheDataBase
    database_user_new: symfony
    database_password_new: null
    mailer_transport_new: smtp
    mailer_host_new: 127.0.0.1
    mailer_user_new: null
    mailer_password_new: null
    secret_new: ThisTokenIsNotSoSecretChangeIt
```

Now we want to create tables in our database along the existing entities we have in Symfony.
in order to do so, we can use this command to see what sql querries we have to execute :

```shell
php bin/console doctrine:schema:update --em=actual --dump-sql
```

To execute the creation of our tables :

```shell
php bin/console doctrine:schema:update --em=actual --force
```

Now in the code, to call our new entity manager :

```php
$newEm = $this->getDoctrine()->getManager('nameOfOurEm');
```
