<?php
require_once 'Animal.php';
require_once 'Zoo.php';
require_once 'Dog.php';
require_once 'Cat.php';

$newDog = new Dog('Анод', 1, 'мопс');
$newDog1 = new Dog('Катод', 1, 'Французский бульдог');
$newCat = new Cat('Патрик', 1, 'разноцветный');

$a = new Zoo();
$a->addAnimal([$newDog, $newCat, $newDog1]);
$a->animalSounds();
$a->listAnimals();

/*доп функции для понимания:
$newCat->setColor('черный');
$newCat->getColor();
*/
