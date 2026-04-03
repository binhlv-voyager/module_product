# Module Product

Laravel 12 service running with three database connections:

- MySQL for product data
- PostgreSQL for category data
- MongoDB for review data

## Requirements

- Docker
- Docker Compose

## Environment

The project reads database configuration from [`.env`](D:\Module-Product\.env).

Main variables:

- `DB_CONNECTION=product_mysql`
- `PRODUCT_DB_*` for MySQL
- `CATEGORY_DB_*` for PostgreSQL
- `REVIEW_DB_*` for MongoDB

If `.env` does not exist, create it from `.env.example` before starting the stack.

## Run With Docker

Build and start all services:

```bash
docker compose up -d --build
```

Check running containers:

```bash
docker compose ps
```

Show logs for all services:

```bash
docker compose logs -f
```

Show logs for one service:

```bash
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f mysql
docker compose logs -f pgsql
docker compose logs -f mongo
```

Stop all services:

```bash
docker compose down
```

Stop all services and remove volumes:

```bash
docker compose down -v
```

## Application URL

- App: `http://localhost:8080`

## Database Services

## Navicat Connection Settings

Use the following values when creating connections in Navicat.

### MySQL

- Connection type: `MySQL`
- Host: `127.0.0.1`
- Port: `33060`
- Username: `root`
- Password: `root`
- Database: `module_product`

### PostgreSQL

- Connection type: `PostgreSQL`
- Host: `127.0.0.1`
- Port: `54320`
- Username: `root`
- Password: `root`
- Database: `module_category`

### MongoDB

- Connection type: `MongoDB`
- Host: `127.0.0.1`
- Port: `27018`
- Username: leave empty
- Password: leave empty
- Database: `module_review`

### MySQL

- Container: `modude_product_mysql`
- Host: `127.0.0.1`
- Port: `33060`
- Database: `module_product`
- Username: `root`
- Password: `root`

Connect from your host machine:

```bash
mysql -h 127.0.0.1 -P 33060 -u root -p
```

Open a MySQL shell inside the container:

```bash
docker compose exec mysql mysql -u root -p
```

### PostgreSQL

- Container: `modude_product_pgsql`
- Host: `127.0.0.1`
- Port: `54320`
- Database: `module_category`
- Username: `root`
- Password: `root`

Connect from your host machine:

```bash
psql -h 127.0.0.1 -p 54320 -U root -d module_category
```

Open a PostgreSQL shell inside the container:

```bash
docker compose exec pgsql psql -U root -d module_category
```

### MongoDB

- Container: `modude_product_mongo`
- Host: `127.0.0.1`
- Port: `27018`
- Database: `module_review`

Connect from your host machine:

```bash
mongosh mongodb://127.0.0.1:27018/module_review
```

Open a MongoDB shell inside the container:

```bash
docker compose exec mongo mongosh module_review
```

## Useful Laravel Commands

Install PHP dependencies:

```bash
docker compose exec app composer install
```

Generate the application key:

```bash
docker compose exec app php artisan key:generate
```

Run migrations:

```bash
docker compose exec app php artisan migrate
```

Open Laravel Tinker:

```bash
docker compose exec app php artisan tinker
```

Open a shell in the app container:

```bash
docker compose exec app sh
```

## Notes

- `docker-compose.yml` expects `docker/nginx/default.conf` to exist.
- If that file is missing, the `nginx` service will not start correctly.
