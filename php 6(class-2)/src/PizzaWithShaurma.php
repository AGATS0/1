<?php 

namespace Vantyz\Php6class2;

class PizzaWithShaurma extends Pizza{

    public function __construct(string $name="Пицца с шаурмой",string $sauce="Соус для шаурмы",array $toppings=["сыр","колбаса","тесто","шаурма"])
    {
        parent::__construct($name, $sauce, $toppings);
    }
}