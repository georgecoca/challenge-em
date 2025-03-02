# Setup
Before running the following commands make sure you are not already running other docker containers or having other services that blocks the following ports:
- 80 (nginx)
- 3306 (mysql)

### Copy local env file
```bash
cp .env.example .env
```

### Run the container

```bash
docker-compose up -d
```

### Generate app key
```bash
docker-compose run --rm php-fpm  php artisan key:generate
```

### Run migrations
```bash
docker-compose run --rm php-fpm php artisan migrate
```

# Access
The API is running at this web address:
```
http://localhost
```

# Demo data
If you want to generate demo data, run the following command:

## Run the seeder
```bash
docker-compose run --rm php-fpm php artisan db:seed
```
Teacher
```
john@edumaster.test
secret
```

Student
```
jane@edumaster.test
secret
```

# Tests
### Run tests
```bash
docker-compose run --rm php-fpm php artisan test
```

