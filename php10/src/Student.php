<?php

namespace Vantyz\Php10;

class Student
{
    public string $firstName;
    public string $lastName;
    public array $grades;

    public function __construct(string $firstName, string $lastName, array $grades = [])
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->grades = $grades;
    }



    public function addGrade($grade): void
    {

        $this->grades[] = $grade;
    }

    public function getAverage(): float
    {
        if (empty($this->grades)) {
            return 0;
        }


        return array_sum($this->grades) / count(array_filter($this->grades));
    }
}
