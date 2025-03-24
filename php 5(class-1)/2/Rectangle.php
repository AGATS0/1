<?php
class Rectangle
{
    public int $lenght;
    public int $weight;

    public function __construct(int $lenght,int $weight)
    {
       
        $this->lenght=$lenght;
        $this->weight=$weight; 
        if($this->lenght<0 || $this->weight<0)
       {
        echo "Стороны не могут быть меньше 0, введите положительное число";
        exit;
       };
    }

    public function getArea():void
    {
        $s=$this->lenght*$this->weight;
        echo "Площадь прямоугольника = $s".PHP_EOL;
    }

    public function getPerimetr():void
    {
        $p=$this->lenght*2+$this->weight*2;
        echo "Периметр прямоугольника = $p".PHP_EOL;
    }

}