<?php

namespace Vantyz\Php6class2;

class PizzaWithRock extends Pizza{

    public function __construct(string $name="Пицца с камнем",string $sauce="Каменный соус",array $toppings=["камень","тесто"])
    {
        parent::__construct($name, $sauce, $toppings);
    }
}