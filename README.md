## Description
REST API in which you can create companies and employees.

## Technologies
- Laravel 10
- MySql 8
- Phpmyadmin

## Deployment

Install composer in `my-app` directory.

```bash
  cd my-app
  composer install
```

To install all images in docker run this command in main project directory.

```bash
  cd ..
  docker compose up -d
```

Migrate tables into database. Run this command in `my-app` directory.

```bash
  cd my-app
  php artisan migrate
```

After running this command project is ready to testing.

Here is, a link into Postman collection which have all endpoints from this project [Link](https://interstellar-shuttle-234972.postman.co/workspace/My-Workspace~d2471d54-0a7a-448e-8aa0-8b4d3d3d3c4d/collection/24912160-431cd2d3-ebf8-43df-abe1-8ca847b9815b?action=share&creator=24912160).
