<?php
require 'vendor/autoload.php';

use  Agats\Trycatch\BankAccount;
use  Agats\Trycatch\InvalidAmountException;
use  Agats\Trycatch\InsufficientFundsException;

try {
    $a = new BankAccount(2000);
    echo "Баланс:";
    echo $a->getBalance();
   
    $a->deposit(1000);
    echo "Депозит:";
    $a->getBalance() ;
   
    $a->withdraw(300);
    echo "Снятие:" ;
    echo  $a->getBalance();
   
    $a->withdraw(500);
   } catch (InvalidAmountException $e) {
    echo "Ошибка: " . $e->getMessage() . PHP_EOL;
   } catch (InsufficientFundsException $e) {
    echo "Ошибка: " . $e->getMessage() . PHP_EOL;
   } 





