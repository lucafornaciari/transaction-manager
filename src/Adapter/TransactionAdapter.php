<?php


namespace App\Adapter;


use App\Entity\Transaction;

class TransactionAdapter implements AdapterInterface
{
    /**
     * This method adapt Transactions to generic export array
     *
     * @param Transaction[] $transactions
     *
     * @return array
     */
    public function adapt(array $transactions)
    {
        $data = [];

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            $data[] = [
                'customer' => $transaction->getCustomer(),
                'date' => $transaction->getDate(),
                'value' =>  $transaction->getAmount()->getSymbol() . round($transaction->getAmount()->getValue(), 2)
            ];
        }

        return $data;
    }
}