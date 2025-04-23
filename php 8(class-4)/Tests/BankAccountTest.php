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
        $this->bankaccount=new BankAccount(0);
    }

    public function testDeposit()
    {
        $this->assertSame($this->bankaccount->deposit(1000),1000);
    }

    public function testwithdraw()
    {
        $this->assertSame($this->bankaccount->withdraw(1000),0);
    }

    public function testInsufficientFundsException():void
    {
        $this->expectException( InsufficientFundsException::class);
    }

    public function testInvalidAmountException():void
    {
        $this->expectException( InvalidAmountException::class);
    }


}