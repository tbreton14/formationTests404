food-diary
==========

 
Installation
============


** Docker
============

Renommer le fichier 'docker-compose.override.yml.dist' et l'ajuster en fonction de sa machine

Builder le conteneur docker
`docker-compose build`

Monter le conteneur docker
`docker-compose up`

Accès bash au docker
`docker exec -it formation_tests_v2_app_1 bash`


** Symfony
============
 
Une fois le docker monté et que vous avez accès au bash 
 
Lancer composer
`$ composer install`.
 
 
Composer vous demandera les informations de connexion à la bdd
 
     database_host => db
     database_port => null
     database_name => reprendre le nom de docker-compose.override.yml
     database_user => root
     database_password => root


Créer ensuite la base de donnée
`$ bin/console doctrine:database:create`
`$ bin/console doctrine:schema:create`

