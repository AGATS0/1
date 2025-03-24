<?php 
require_once 'animal.php';
require_once 'zoo.php';
require_once 'dog.php';
require_once 'cat.php';

$newDog= new Dog ('Анод',1,'мопс');
$newDog1= new Dog ('Катод',1,'Французский бульдог');
$newCat= new Cat ('Патрик',1,'разноцветный');

$a= new Zoo();
$a->addAnimal([$newDog, $newCat, $newDog1]);
$a->animalSounds();
$a->listAnimals();

/*доп функции для понимания:
$newCat->setColor('черный');
$newCat->getColor();
*/
