# CodeIgniter CMS

Purchase simulation. CodeIgniter 4 + PostgreSQL. No authentication by design, as requested by the assignment.

## Features

Dashboard, Products CRUD, Customers CRUD, Transaction create/history/detail. Server-side pricing, conditional stock decrement, atomic DB transaction with rollback.

## Requirements

PHP 8.2+, Composer 2, PostgreSQL 16+, miniserver reachable via VPN.

## Install

```bash
cd codeigniter-cms
composer install
cp env .env   # or use existing .env
```

Edit `.env` (manual setup):

```ini
database.default.hostname = MINISERVER_HOST
database.default.database = wrapstation_cms
database.default.username = CMS_USER
database.default.password = CMS_PASSWORD
database.default.DBDriver = Postgre
database.default.port = 5432
```

## Migrate + Seed + Run

```bash
php spark migrate
php spark db:seed DatabaseSeeder
php spark serve
```

Open `http://localhost:8080`.

## Routes

`GET /`, `GET/POST /products`, `GET/POST /customers`, `GET/POST /transactions`, `GET /transactions/{id}`.

## Purchase Flow

Form posts customer + item rows → `TransactionController::create` → `TransactionService::createTransaction` validates customer, merges duplicate lines, reads price/stock from DB, inserts transaction + items, decrements stock conditionally (`WHERE stock >= qty`, affected rows must be 1), commits. Any failure rolls back, no partial state.

## Troubleshooting

- connection refused → check VPN, `pg_isready -h MINISERVER_HOST`, `.env` values
- `migrate:rollback` then `migrate` to test rollback
- delete blocked on referenced product/customer is intentional (FK RESTRICT preserves history)
