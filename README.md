# ERP

## Stack:

-   Laravel 12
-   Livewire
-   Flux - frontend
-   MySql
-   Redis

## Setup

### .env

```bash
cp .env.example .env

```

### Compose install

```bash
composer install
```

### Sail (Docker)

```bash

./vendor/bin/sail up

```

### Key generate

```bash
./vendor/bin/sail artisan key:generate
```


### npm install

```bash
./vendor/bin/sail npm install
```

### npm run build

```bash
./vendor/bin/sail npm run build
```

### Database

```bash
./vendor/bin/sail artisan migrate
```

### Queue for send email

```bash
./vendor/bin/sail artisan queue:work
```

### Default User

-   E-mail: teste@teste.com
-   Password: password

### E-mail Viewer

-   http://localhost:8025

### Webhook endpoint

-   http://localhost/api/webhook

```json
{
  "order_id": "1",
  "status": "canceled"
}
```
