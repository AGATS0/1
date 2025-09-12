<?php

use Vantyz\Php10\Student;
use Vantyz\Php10\Group;

function printStudentInfo(Student $student): void
{
    echo "===================".PHP_EOL;
    echo "Фамилия студента: $student->lastName".PHP_EOL;
    echo "Имя студента: $student->firstName".PHP_EOL;
    echo "Средний балл студента:";
    echo $student->getAverage().PHP_EOL;
    


}

function printGroupInfo(Group $group): void
{
    echo "===================".PHP_EOL;
    echo "Название группы: $group->groupName".PHP_EOL;
    echo "Количество студентов:". count(array_filter($group->students)).PHP_EOL ;
    echo "Общий средний балл:";

    echo $group->getGroupAverage().PHP_EOL;

    
    

}