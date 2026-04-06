# Module Product

Laravel 12 service running with three database connections:

- MySQL for product data
- PostgreSQL for category data
- MongoDB for review data

## Requirements

- Docker
- Docker Compose

## Environment

The project reads database configuration from [`.env`](.env).

Main variables:

- `DB_CONNECTION=product_mysql`
- `PRODUCT_DB_*` for MySQL
- `CATEGORY_DB_*` for PostgreSQL
- `REVIEW_DB_*` for MongoDB

If `.env` does not exist, create it from `.env.example` before starting the stack.

## Run With Docker

### Step-by-step (first run)

Step 1: Build and start all services:

```bash
docker compose up -d --build
```

Step 2: Install PHP dependencies (this creates `vendor/` so Laravel can boot):

```bash
docker compose exec app composer install
```

Step 3: Generate the application key (required by Laravel):

```bash
docker compose exec app php artisan key:generate
```

Step 4: Run migrations (core + all modules):

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan module:migrate -a
```

Step 5: Run seeders (optional, for sample data):

```bash
docker compose exec app php artisan db:seed
```

Step 6: Clear caches (recommended after changing env/deps):

```bash
docker compose exec app php artisan optimize:clear
```

Step 7: Open the app:

- App: `http://localhost:8080`

### Useful Docker commands

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
- Username: 
- Password: 
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

Run migrations for all modules:

```bash
docker compose exec app php artisan module:migrate -a
```

Run seeders:

```bash
docker compose exec app php artisan db:seed
```

Run seeders for all modules:

```bash
docker compose exec app php artisan module:seed -a
```

Open Laravel Tinker:

```bash
docker compose exec app php artisan tinker
```

Open a shell in the app container:

```bash
docker compose exec app sh
```

## Category API Test

Use Postman with this base URL:

```bash
http://localhost:8080/api/v1/categories
```

### 1. Get Category List

- Method: `GET`
- URL: `http://localhost:8080/api/v1/categories`
- Body: none

Example response:

```json
{
  "data": [
    {
      "id": 1,
      "name": "Electronics",
      "slug": "electronics"
    }
  ]
}
```

### 2. Get Category Detail

- Method: `GET`
- URL: `http://localhost:8080/api/v1/categories/1`
- Body: none

### 3. Create Category

- Method: `POST`
- URL: `http://localhost:8080/api/v1/categories`
- Headers:
  - `Content-Type: application/json`
- Body:

```json
{
  "name": "Electronics",
  "slug": "electronics"
}
```

### 4. Update Category

- Method: `PUT`
- URL: `http://localhost:8080/api/v1/categories/1`
- Headers:
  - `Content-Type: application/json`
- Body:

```json
{
  "name": "Updated Electronics",
  "slug": "updated-electronics"
}
```

### 5. Delete Category

- Method: `DELETE`
- URL: `http://localhost:8080/api/v1/categories/1`
- Body: none

### Postman Notes

- Select `Body` -> `raw` -> `JSON` for `POST` and `PUT`
- Current API is available without authentication
- `GET` endpoints are ready and returning JSON

## Notes

- `docker-compose.yml` expects `docker/nginx/default.conf` to exist.
- If that file is missing, the `nginx` service will not start correctly.
