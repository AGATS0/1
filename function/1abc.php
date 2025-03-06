<?php
$vvod = readline("Введите строку:");
//$vvod = str_replace(' ', '', $vvod); (если нужно)


$res = alphabeticalOrder($vvod);
echo "результат: $res";


function alphabeticalOrder(&$vvod){
    $vvod = str_split($vvod);
    sort($vvod);
    return implode('', $vvod);
}

