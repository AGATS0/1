<?php

namespace Vantyz\Php6class2;

class PizzaWithSolyamy extends Pizza{

    public function __construct(string $name="Пицца с солями",string $sauce="Колбасный соус",array $toppings=["сыр","колбаса","тесто"])
    {
        parent::__construct($name, $sauce, $toppings);
    }
}