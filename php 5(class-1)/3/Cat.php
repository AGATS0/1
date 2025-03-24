<?php
require_once 'Animal.php';

class Cat extends Animal
{
    public string $color;

    public function __construct(string $name, int $age, string $color, string $species='кошка',)
    {
        parent::__construct($name, $age, $species);
        $this->color=$color;

    }
//доп функции для понимания 
    public function setColor(string $a): string
    {
        $this->color=$a;
        return $this->color;
    }

    public function getColor(): void
    {
        echo $this->color;
    }
//
    public function makeSound(): string
    {
        return "meow";
    }

}