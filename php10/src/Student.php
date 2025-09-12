<?php

namespace Vantyz\Php10;

class Student 
{
    public string $firstName;
    public string $lastName;
    public array $grades;

    public function __construct(string $firstName,string $lastName,array $grades=[])
    {
       $this->firstName=$firstName;
       $this->lastName=$lastName;
       $this->grades=$grades;

    }
    
        
   
    public function addGrade($grade): void
    {
        
        $this->grades[]= $grade;

    }

    public function getAverage(): int|float
    {
       if (empty($this->grades)) {
            echo "no grades".PHP_EOL ;// Обработка случая, когда нет оценок
        }
        

        return array_sum($this->grades) / count(array_filter($this->grades));

    }

}
