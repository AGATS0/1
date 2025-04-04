<?php

namespace Vantyz\Php6class2;

class Pizza {
    public string $name;
    public string $sauce;
    public array $toppings;

    public function __construct(string $name,string $sauce,array $toppings)
    {
        $this->name=$name;
        $this->sauce=$sauce;
        $this->toppings=$toppings;
    }

    public function prepare():void
    {
        echo "========================================".PHP_EOL;
        echo "Началась готовка пиццы: $this->name".PHP_EOL;
        echo "Добавлен соус: $this->sauce".PHP_EOL;
        echo "Добавлены топики:";
        foreach ($this->toppings as $toppings){  
            echo "$toppings ";
            };
        echo PHP_EOL;
        echo "========================================".PHP_EOL;

    }

    public function cut()
    {
        echo "Данную пиццу нарезают по диагонали".PHP_EOL;
    
    }


}