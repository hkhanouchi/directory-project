Docker Symfony 3.x with (Elasticsearch and Kibana)
=================


Getting started
---------------
## Installation

1. Build/run containers with (with and without detached mode)

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```
    
2. Prepare Symfony app
     
    1. Composer install & update database
    
        ```bash
        $ docker-compose exec php bash
        $ composer install
        $ sf3 doctrine:generate:entities AppBundle/Entity
        $ sf3 doctrine:schema:update --force
        ```
    
3. Enjoy :-)

## Usage

Just run `docker-compose up -d`, then:

* Directory app: visit [projectdirectory.dev](http://projectdirectory.dev)  
* Symfony dev mode: visit [projectdirectory.dev/app_dev.php](http://projectdirectory.dev/app_dev.php)  
* Logs (Kibana): [projectdirectory.dev:5601](http://projectdirectory.dev:5601)

    1. Account for test:

        ```bash
        Login/pwd : admin/admin
        ```

## Customize

If you want to add optionnals containers like Redis, PHPMyAdmin... take a look on [doc/custom.md](doc/custom.md).

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `db`: This is the MySQL database container,
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,

This results in the following running containers:

```bash
$ docker-compose ps
           Name                          Command               State              Ports            
--------------------------------------------------------------------------------------------------
dockersymfony_db_1            /entrypoint.sh mysqld            Up      0.0.0.0:3306->3306/tcp      
dockersymfony_elk_1           /usr/bin/supervisord -n -c ...   Up      0.0.0.0:81->80/tcp          
dockersymfony_nginx_1         nginx                            Up      443/tcp, 0.0.0.0:80->80/tcp
dockersymfony_php_1           php-fpm                          Up      0.0.0.0:9000->9000/tcp      
```

## Useful commands

```bash
# bash commands
$ docker-compose exec php bash

# Composer (e.g. composer update)
$ docker-compose exec php composer update

# Same command by using alias
$ docker-compose exec php bash
$ sf3 cache:clear --env=prod --no-warmup
$ sf3 assets:install --symlink
$ sf3 avanzu:admin:fetch-vendor --root
```


  [1]: https://github.com/symfony/symfony-standard/tree/3.1 "The Symfony Standard Edition 3.1 release"
  [2]: https://symfony.com/roadmap "Symfony roadmap"
  [3]: https://phpunit.de/manual/current/en/ "The PHPUnit stable release"
  [4]: https://symfony.com/doc/current/book/testing.html "Symfony documentation"
