## Steps to run the project locally
1. clone the repository from github - git clone https://github.com/IgorOleniuk/products-crud.git
2. enter the project folder and run composer install command
3. create .env file and fill DB connection credentials
4. run php artisan migrate -seed (to create DB tables & default user: email: test@gmail.com, pass: 123456)
5. run php artisan serve to start the project
6. import postman collection to your Postman application in order to make api calls
