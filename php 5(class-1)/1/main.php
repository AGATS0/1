<?php
require_once 'Car.php';

$newCar = new Car('Cadillac','Escalade', 2025 , 1000);

echo $newCar->getInfo();

$newCar->drive(234);

echo $newCar->getInfo();

