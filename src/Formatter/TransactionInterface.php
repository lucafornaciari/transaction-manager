<?php


namespace App\Formatter;


interface TransactionInterface
{
    public function format(array $data);
}