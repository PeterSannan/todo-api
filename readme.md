
To be able to execute these apis, please do the following:
- Create the database on your local machine.
- Open .env file and enter you database information.
- Open terminal and change your current working directory to todo-api forlder and run this command: php artisan migrate, Now you should be able to see tables in your database.
- then run the project on your localserver you can use php -S localhost:8000 -t public
- Now you can start to use the API.

All the response are based JSON:API Specification for Building APIs , You can check their website for more details https://jsonapi.org/

Authentication are required for all the apis except login and register apis.
