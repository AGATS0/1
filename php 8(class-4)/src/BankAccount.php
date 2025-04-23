<?php

namespace Agats\Trycatch;

class BankAccount
{
    private float $balance;

    public function __construct(float $initialBalance)
    {
        if ($initialBalance<0) throw new InvalidAmountException;
        $this->balance = $initialBalance;         
    }
    
    public function getBalance():void
    {
        echo $this->balance.PHP_EOL;
    } 

    public function deposit($amount):float
    {
        if ($amount<=0) throw new InvalidAmountException;
        $this->balance = $this->balance + $amount;
        return $this->balance;
    }

    public function withdraw($amount):float
    {
        if ($amount<=0 || $amount>$this->balance) throw new InsufficientFundsException;
        $this->balance = $this->balance - $amount;
        return $this->balance;
    }
}


