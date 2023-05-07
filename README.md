# Code-challenge Project README

Welcome to my Laravel project! This project is built using Laravel framework and utilizes Docker with Sail for easy set up.

To install and run this project, please follow the instructions below:

## Installation

1. Clone the project from the GitHub repository.
2. Run the following command to set up Docker with Sail:

```
./vendor/bin/sail up -d
```

3. After the Docker setup is complete, run the following command to migrate the database structure:

```
./vendor/bin/sail artisan migrate
```

4. Once the migration is complete, run the following command to create the default admin user:

```
./vendor/bin/sail artisan db:seed
```

5. Your installation is complete and you are ready to start using the project!

## Unit and Feature Tests

To run the unit and feature tests for this project, run the following command:

```
./vendor/bin/sail test
```

## Postman Testing

To test the project with Postman, first use the "User Login" API in the Postman collection provided with the default admin account : admin@code-challenge.com/123456. 
After logging in, copy the token from the response and use it as a bearer token when calling other APIs for testing purposes.

Thank you for using my Laravel project!
