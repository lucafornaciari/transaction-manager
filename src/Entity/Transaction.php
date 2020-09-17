<?php


namespace App\Entity;


class Transaction
{
    /** @var int */
    protected $customer;

    /** @var string */
    protected $date;

    /** @var Currency */
    protected $amount;

    /**
     * @return int
     */
    public function getCustomer(): int
    {
        return $this->customer;
    }

    /**
     * @param int $customer
     */
    public function setCustomer(int $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Currency
     */
    public function getAmount(): Currency
    {
        return $this->amount;
    }

    /**
     * @param Currency $amount
     */
    public function setAmount(Currency $amount): void
    {
        $this->amount = $amount;
    }
}