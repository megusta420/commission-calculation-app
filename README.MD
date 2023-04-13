# Commission calculation app

## Docker

```bash
  docker-compose up
  docker exec -it {CONTAINER_NAME} sh
```

## Usage

`./data.txt` is the committed file with sample transactions.

```bash
// run app
php app.php data.txt

// run tests
./vendor/bin/phpunit
```

## TODO

Use github/lib-money