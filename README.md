# Symfony Project manager
This is a project for school. It's a bit like a todo list but with a little twist.

### Features
* User can create a project
* User can add tasks to a project
* User can mark tasks as done
* User can see all tasks in a project
* User can see all projects

### Running the application
* clone the project to your local machine 
  * ```git clone https://github.com/anis00723/symfony_pm```
* navigate into the project directory 
  * ```cd symfony_pm```
* Run ```docker-compose up -d```
* Run ```docker exec -it php /bin/bash```
- Run these commands:
    ```
    composer install
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
    php bin/console doctrine:fixtures:load
    ```
* Open http://localhost:8080/

#### Admin credentials:
* Email: admin@admin.me
* Password: admin