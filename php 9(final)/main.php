<?php

require 'vendor/autoload.php';

use Vantyz\Php9final\PasswordValidator;

$a = new PasswordValidator();

if ($a->validate('A1234567')===true) echo "cool";
else echo "fooo";
