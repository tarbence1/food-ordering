# Foord ordering

## How to get started:

1. Create a `.env` file from the `.env.example` file

2. Install composer dependencies:
```bash
docker run --rm -it -v $PWD:/app -v /app composer:2 composer i --ignore-platform-reqs
```

3. Start sail:
```bash
./vendor/bin/sail up
```

4. Run migrations:
```bash
./vendor/bin/sail php artisan migrate:fresh --seed
```

# Documentation

The documentations can be found under the `public/documentation` folder
