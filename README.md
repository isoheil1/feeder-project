<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## How To Run Project

-   Install [Docker](https://docs.docker.com/get-docker/)
-   Clone the repository

```
git clone https://github.com/isoheil1/feeder-project
```

-   Switch to the repository folder

```
cd feeder-project
```

-   Start your development containers

```
docker-compose up -d
```

-   Install dependencies

```
docker-compose exec feeder_app composer install
```

-   Copy the example env file

```
cp .env.example .env
```

-   Generate application key

```
docker-compose exec feeder_app php artisan key:generate
```

-   Run the database migrations and seeders

```
docker-compose exec feeder_app php artisan migrate
docker-compose exec feeder_app php artisan db:seed
```

You can now access the server at http://localhost:8000/
