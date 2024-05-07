# README #

1. Clone project from bitbucket
2. Execute the "composer install" command inside the project (if there is no composer on the computer, you can download https://getcomposer.org/download/)
3. Execute the following commands in order
   1. php bin/console doctrine:database:create 
   2. php bin/console make:migration
   3. php bin/console doctrine:migrations:migrate
4. Add a domain (I used open server with api.lc domain)
5. Can run apis (I use postman for it)