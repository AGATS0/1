<?php
require_once 'Animal.php';

class Zoo
{
    public $animals = [];


    public function addAnimal(array $a): void
    {
        foreach ($a as $animal) {
            $this->animals[] = $animal;
        }
    }

    public function listAnimals(): void
    {
        $n = 1;

        foreach ($this->animals as $animal) {
            echo "$n. Имя: {$animal->name}, Возраст: {$animal->age}, Вид: {$animal->species}\n";
            $n++;
        }
    }


    public function animalSounds(): void
    {
        foreach ($this->animals as $animal) {
            echo $animal->makeSound();
            echo PHP_EOL;
        }
    }
}
