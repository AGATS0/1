<?php
require_once 'Animal.php';


class Dog extends Animal
{
    public string $breed;

    public function __construct(string $name, int $age, string $breed,  string $species = 'собака', string $soundOfAnimal = 'гав')
    {
        parent::__construct($name, $age, $species, $soundOfAnimal);
        $this->breed = $breed;
    }

    public function makeSound(): string
    {
        return "waw";
    }
}
