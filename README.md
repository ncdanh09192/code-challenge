# Code-challenge Project README

Welcome to my Laravel project! This project is built using Laravel framework, Composer and utilizes Docker with Sail for easy set up.

To install and run this project, please install Composer then follow the instructions below:

## Installation

1. Clone the project from the GitHub repository.
2. CD to your project.
3. Run the following command to download dependency library :
```
composer install
```
3. Run the following command to create your project's env file :
```
cp .env_example .env
```
4. Run the following command to set up Docker with Sail:

```
./vendor/bin/sail up -d
```
5. Run the following command to re-generate app-key:
```
./vendor/bin/sail artisan key:generate
```
6. After the Docker setup is complete, run the following command to migrate the database structure:

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
Please click here to run collection on your Postman 
[![Run in Postman](https://run.pstmn.io/button.svg)](https://god.gw.postman.com/run-collection/12674271-a687300e-f5f5-4c29-ae8a-eb7459948f93?action=collection%2Ffork&collection-url=entityId%3D12674271-a687300e-f5f5-4c29-ae8a-eb7459948f93%26entityType%3Dcollection%26workspaceId%3D43cccfc1-41a3-466c-8eff-a83b4c0bf695)

Thank you for using my Laravel project!
