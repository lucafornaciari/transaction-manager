
# TRANSACTION MANAGER

Transaction manager load customer transactions in several currencies and export it in EUR.
#### Technologies
- `Symfony 5.1` 
- `PHP 7.2`

#### Installation
```
git clone https://github.com/lucafornaciari/transaction-manager.git
```

```
cd transaction-manager
docker-compose up -d --build
```
---

## How to use

You can retrieve the CSV, running the following code in your terminal:
```
docker-compose exec console bin/console generate-report [customerId]
```
The `customerId` param is mandatory

CSV file will be generated in the main folder

## How to test

You can start the tests, running the following code in your terminal:
```
docker-compose exec console ./vendor/bin/simple-phpunit
```

## Managed Currencies
Project manage this currencies:
`EUR, USD, GBP`
