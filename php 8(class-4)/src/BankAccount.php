<?php

namespace Agats\Trycatch;

class BankAccount
{
    private float $balance;

    public function __construct(float $initialBalance)
    {
        $this->balance = $initialBalance;         
    }
    
    public function getBalance():void
    {
        echo $this->balance.PHP_EOL;
    } 

    public function deposit($amount):float
    {
        $this->balance = $this->balance + $amount;
        return $this->balance;
    }

    public function withdraw($amount):float
    {
        $this->balance = $this->balance - $amount;
        return $this->balance;
    }
}


