<?php
$vvod = readline('Введите строку для вычисленя:');
$vvod = str_replace(' ', '', $vvod);
$vvod = str_split($vvod);

//вызов функций
proverkaVvoda($vvod);
uberaemMinus($vvod);
umnozhenieDelenie($vvod);
slozhenie($vvod);

echo "Результат вычисления:$vvod[0]";




//функции
function slozhenie(array &$vvod)
{
    for ($j = 0; $j < 4; $j++) {
        for ($i = 0; $i < count($vvod); $i++) {
            if ($vvod[$i] == '+') {
                $vvod[$i] = $vvod[$i - 1] + $vvod[$i + 1];
                unset($vvod[$i - 1]);
                unset($vvod[$i + 1]);
                $vvod = array_values($vvod);
            }
            if ((isset($vvod[$i + 1]) && is_numeric($vvod[$i]) && is_numeric($vvod[$i + 1]))) {
                $vvod[$i] = $vvod[$i] + $vvod[$i + 1];
                unset($vvod[$i + 1]);
                $vvod = array_values($vvod);
            }
        }
    }
}

function umnozhenieDelenie(array &$vvod)
{
    for ($j = 0; $j < 3; $j++) {
        for ($i = 0; $i < count($vvod); $i++) {
            if ($vvod[$i] == '*') {
                $vvod[$i] = $vvod[$i - 1] * $vvod[$i + 1];
                unset($vvod[$i - 1]);
                unset($vvod[$i + 1]);
                $vvod = array_values($vvod);
            }
            if ($vvod[$i] == '/') {
                $vvod[$i] = $vvod[$i - 1] / $vvod[$i + 1];
                unset($vvod[$i - 1]);
                unset($vvod[$i + 1]);
                $vvod = array_values($vvod);
            }
        }
    }
}

function uberaemMinus(array &$vvod): void
{
    for ($j = 0; $j < 3; $j++) {
        for ($i = 0; $i < count($vvod); $i++) {
            if ($vvod[$i] == '-') {
                $vvod[$i + 1] = $vvod[$i + 1] - $vvod[$i + 1] * 2;
                unset($vvod[$i]);
                $vvod = array_values($vvod);
            }
        }
    }
}

function proverkaVvoda(array $vvod): void
{
    for ($i = 0; $i < count($vvod); $i++) {
        if (($vvod[$i] == '/' && $vvod[$i + 1] == '/') || ($vvod[$i] == '*' && $vvod[$i + 1] == '*') || ($vvod[$i] == '+' && $vvod[$i + 1] == '+')
            || ($vvod[$i] == '-' && $vvod[$i + 1] == '-') || !preg_match("/^[0-9\+\-\*\/()]+$/", $vvod[$i]) || count($vvod) > 10 ||
            (isset($vvod[$i - 1]) && is_numeric($vvod[$i]) && is_numeric($vvod[$i - 1])) || ($vvod[$i] == '/' && $vvod[$i + 1] == 0) ||
            ($vvod[0] != '-' && $vvod[0] != null && !is_numeric($vvod[0]))
        ) {
            echo "error" . PHP_EOL;
            exit;
        }
    }
}
