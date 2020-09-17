
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
composer install
```
---

## How to use

You can retrieve the CSV, running the following code in your terminal:
```
php bin/console generate-report [customerId]
```
The `customerId` param is mandatory

## Managed Currencies
Project manage this currencies:
`EUR, USD, GBP`
