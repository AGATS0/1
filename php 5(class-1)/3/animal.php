<?php
class Animal
{
    public string $name;
    public int $age;
    public string $species;

    public function __construct(string $name, int $age, string $species)
    {
        $this->name = $name;
        $this->age = $age;
        $this->species = $species;
    }

    public function makeSound(): string
    {
        return "животное издает звук";
    }
}
