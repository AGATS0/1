<?php

use  Agats\Trycatch\BankAccount;
use PHPUnit\Framework\TestCase;

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

}