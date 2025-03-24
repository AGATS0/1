<?php 

require_once 'Rectangle.php';

$newPr= new Rectangle(-2,2);
$newPr1= new Rectangle(2,2);

$newPr->getArea();
$newPr->getPerimetr();

echo PHP_EOL;

$newPr1->getArea();
$newPr1->getPerimetr();