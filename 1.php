<?php 
$students = [ 
    ['name' => 'Маша', 'grades' => [5, 4, 5]],
    ['name' => 'Витя', 'grades' => [3, 4, 2]],
    ['name' => 'Олег', 'grades' => [4, 5, 2]], 
];

foreach ($students as $student) {//перебор массива
    $name = $student['name'];
    $grades = $student['grades'];
    
    $sumOfMarks = array_sum($grades); 
    $countOfMarks = count($grades);
    
    $average = $sumOfMarks / $countOfMarks; //вычисление

    echo "Средняя оценка студента $name: $average".PHP_EOL;//вывод
   
}

/*У вас есть массив с информацией о студентах:

$students = [ 
    ['name' => 'Маша', 'age' => 22, 'grades' => [5, 4, 5]],
     ['name' => 'Витя', 'age' => 23, 'grades' => [3, 4, 2]],
     ['name' => 'Олег', 'age' => 21, 'grades' => [4, 5, 5]], 
    ];
    
    Напишите программу, которая выводит имена студентов, чьи средние оценки больше или равны 4. Выведите имена студентов с их средним баллом в формате:
    Маша: 4.67 Олег: 4.67*/
    
