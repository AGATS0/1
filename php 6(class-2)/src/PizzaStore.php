<?php

namespace Vantyz\Php6class2;

class PizzaStore 
{
    public array $speciesPizza=["Пицца с солями","Пицца с камнем","Пицца с шаурмой"];

    public function orderPizza(string $name): void
    {
        $pizza = $this->createPizza($name);

        $pizza->prepare();
    }


    public function createPizza(string $name): Pizza|string
    {
        if ($name === "Пицца с солями") {
            $newPizza1 = new PizzaWithSolyamy();
            return $newPizza1;
        }

        if ($name === "Пицца с камнем") {
            $newPizza2 = new PizzaWithRock();
            return $newPizza2;
        }

        if ($name === "Пицца с шаурмой") {
            $newPizza3 = new PizzaWithShaurma();
            return $newPizza3;
        }

        $i=0;
        foreach($this->speciesPizza as $speciePizza){
            if ($name===$speciePizza){
                $i=$i+1;
            }
        }
        if ($i===0){
            return "Такой пиццы нет в списке возможных";   
        }
        $i=0;

        exit;

        
    }
}
