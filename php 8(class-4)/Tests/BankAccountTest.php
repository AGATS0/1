<?php

use  Agats\Trycatch\BankAccount;
use PHPUnit\Framework\TestCase;
use Agats\Trycatch\InvalidAmountException;
use Agats\Trycatch\InsufficientFundsException;


class BankAccountTest extends TestCase
{
    private $bankaccount;

    protected function setUp():void
    {
        $this->bankaccount=new BankAccount(1000);
    }

    public function testDeposit():void
    {
        $this->assertSame($this->bankaccount->deposit(1000.0),2000.0);
    }

    public function testwithdraw():void
    {
        $this->assertSame($this->bankaccount->withdraw(1000.0),0.0);
    }

    
    public function testInvalidAmountException():void
    {
        $this->expectException( InvalidAmountException::class);
        $a=new BankAccount(0);
        $a->deposit(0);
    }

    public function testInsufficientFundsException():void
    {
        $this->expectException(InsufficientFundsException::class);
        $a=new BankAccount(0);
        $a->withdraw(0);
    }


}