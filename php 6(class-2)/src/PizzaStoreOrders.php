<?php

namespace Vantyz\Php6class2;

class PizzaStoreOrders extends PizzaStore{

    public array $speciesPizza=["Пицца с солями","Пицца с камнем","Пицца с шаурмой","Пицца с сыром"];

    public function createPizza(string $name): Pizza
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

        if ($name === "Пицца с сыром") {
            $newPizza4 = new Pizza($name,"сырный соус",["сыр","СЫР","СЫР"]);
            return $newPizza4;
        }

        $i=0;
        foreach($this->speciesPizza as $speciePizza){
            if ($name===$speciePizza){
                $i=$i+1;
            }
        }
        if ($i===0){
            echo 'такой пиццы нет';   
        }
        $i=0;

        exit;
    }

}