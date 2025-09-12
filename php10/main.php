<?php

use Vantyz\Php10\Group;
use Vantyz\Php10\Student;

require 'vendor/autoload.php';
require_once 'src/functions.php';


$student1 = new Student("Вадим", "Байков");
$student1->addGrade(5);
$student1->addGrade(4);
$student1->addGrade(3);

$student3 = new Student("Матвей", "Черный");
$student3->addGrade(3);
$student3->addGrade(2);
$student3->addGrade(4);

$student4 = new Student("На СВО", "Тузов");
$student4->addGrade(10);
$student4->addGrade(10);
$student4->addGrade(10);

$group = new Group("Группа П-31");
$group->addStudent($student1);
$group->addStudent($student3);
$group->addStudent($student4);


printStudentInfo($student1);
printStudentInfo($student3);
printStudentInfo($student4);

printGroupInfo($group);

echo "Лучший студент группы:".PHP_EOL;
$bestStudent= $group->getBestStudent();
printStudentInfo($bestStudent);

echo "cool";
