<?php
class Car
{
    public string $mark;
    public string $model;
    public int $year;
    public int $probeg;

    public function __construct(string $mark, string $model,int $year,int $probeg)
    {
        $this->mark=$mark;
        $this->model=$model;
        $this->year=$year;
        $this->probeg=$probeg;

    }

    public function getInfo()
    {
        return "Машина:$this->mark $this->model, год выпуска:$this->year,  пробег:$this->probeg".PHP_EOL;

    }

    public function drive(int $n):void
    {
        $error=false;
        while(!$error){
        echo "Насколько километров прибавить пробег?".PHP_EOL;
        if (is_numeric($n))
        { 
            $this->probeg=$this->probeg + $n ;
            $error=true;
        }
        else 
        {
            echo "$n не число, введите правильное значение".PHP_EOL;
        }
    }

    }

    public function getMileage()
    {
        echo $this->probeg;

    }


}

