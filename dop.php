<?php 

$expression=readline('Введите строку для вычисленя:');

function calculate($expression) {
    // Удаляем все пробелы из строки
    $expression = str_replace(' ', '', $expression);

    // Проверяем, что строка содержит только допустимые символы
    if (!preg_match('/^[0-9+\-*\/\.]+$/', $expression)) {
        return "Error";
    }

    // Разделяем выражение на числа и операторы
    preg_match_all('/(\-?\d+)|[\+\-\*\/]/', $expression, $matches);
    $tokens = $matches[0];

    // Проверяем количество слагаемых
    if (count($tokens) > 5) {
        return "Error";
    }

    // Инициализируем переменные для хранения результата и текущего оператора
    $result = 0;
    $currentOperator = '+';

    // Проходим по всем токенам и выполняем операции
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // Если токен - число, выполняем операцию
            switch ($currentOperator) {
                case '+':
                    $result += $token;
                    break;
                case '-':
                    $result -= $token;
                    break;
                case '*':
                    $result *= $token;
                    break;
                case '/':
                    if ($token == 0) {
                        return "Error"; // Деление на ноль
                    }
                    $result /= $token;
                    break;
            }
        } else {
            // Если токен - оператор, сохраняем его для следующей операции
            $currentOperator = $token;
        }
    }

    return $result;
}


/*
$vvod=readline('Введите строку для вычисленя:');
$vvod = str_replace(' ','',$vvod);
$vvod=str_split($vvod);

if ($vvod[0]=='-'){
    $vvod[1]=$vvod[1]-$vvod[1]-$vvod[1];
    unset($vvod[0]);
}



print_r($vvod);
*/

 /* Проверяем корректность символов в выражении
 if (!preg_match('/^[0-9+\-*\/\.]+$/', $expression)) {
    return "Error";
}

/* Разбиваем выражение на токены (числа и операторы)
preg_match_all('/(\-?\d+\.?\d*)|([+\-*\/])/', $expression, $matches);
$tokens = $matches[0];

// Проверяем количество слагаемых (не более 5)
if (count($tokens) > 9) { // 5 чисел + 4 оператора
    return "Error";
}

// Обрабатываем умножение и деление
for ($i = 1; $i < count($tokens); $i += 2) {
    if ($tokens[$i] == '*' || $tokens[$i] == '/') {
        $left = $tokens[$i - 1];
        $operator = $tokens[$i];
        $right = $tokens[$i + 1];

        // Проверка деления на ноль
        if ($operator == '/' && $right == 0) {
            return "Error";
        }

        // Вычисляем результат
        $result = ($operator == '*') ? $left * $right : $left / $right;

        // Заменяем три токена на результат
        array_splice($tokens, $i - 1, 3, $result);
        $i -= 2; // Сдвигаем индекс назад
    }
}

// Обрабатываем сложение и вычитание
$result = $tokens[0];
for ($i = 1; $i < count($tokens); $i += 2) {
    $operator = $tokens[$i];
    $right = $tokens[$i + 1];

    if ($operator == '+') {
        $result += $right;
    } elseif ($operator == '-') {
        $result -= $right;
    }
}

return $result;
}





$res;
var_dump($vvod);

1) Разработать программу которая на вход принимает строковое выражение калькулятора. Калькулятор должен выполнять действия сложения и вычитания, деления, умножения, между целочисленными слагаемыми (ограничение слагаемых: 5), также поддерживает операции с отрицательными числами. Функция eval запрещена.
Пример:
1. Входная строка: 2+4 Ответ: 6
2. Входная строка: -2+8-4 Ответ: 2
3. Входная строка: abc Ответ: Error
4. Входная строка: 5\\\5 Ответ: Error
5. Входная строка 5 \ 0 Ответ: Error
*/