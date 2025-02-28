<?php
$vvod=readline('Введите строку для вычисленя:');
$vvod = str_replace(' ','',$vvod);
$vvod=str_split($vvod);
if (count($vvod)>10){
    echo "больше 5 значений";
   } else {
   for($j = 0; $j < count($vvod); $j++){
       for ($i = 0; $i < count($vvod); $i++) {

        if(($vvod[$i]=='/' && $vvod[$i+1]=='/') || ($vvod[$i]=='*' && $vvod[$i+1]=='*') || ($vvod[$i]=='+' && $vvod[$i+1]=='+') || ($vvod[$i]=='-' && $vvod[$i+1]=='-') ){
            echo "error";
            break 2;
        }
           if ($vvod[$i]=='-'){
               $vvod[$i+1]= $vvod[$i+1]-$vvod[$i+1]*2;
               unset($vvod[$i]);
               if(isset($vvod[$i-1])){
                $vvod[$i-1]= $vvod[$i-1]-$vvod[$i];
               }
               $vvod = array_values($vvod);
           }
          
         

           if ($vvod[$i]=='*'){
            if ($vvod[$i+1]=='-'){
                $vvod[$i+1]= $vvod[$i+1]-$vvod[$i+1]*2;    
            }
               $vvod[$i]=$vvod[$i-1]*$vvod[$i+1];
               unset($vvod[$i-1]);
               unset($vvod[$i+1]);
               $vvod = array_values($vvod);
           } 
           

           if ($vvod[$i]=='/'){
            if ($vvod[$i+1]=='-'){
                $vvod[$i+1]= $vvod[$i+1]-$vvod[$i+1]*2;    
            }
                   $vvod[$i]=$vvod[$i-1]/$vvod[$i+1];
                   unset($vvod[$i-1]);
                   unset($vvod[$i+1]); 
                   $vvod = array_values($vvod);  
           }
           ;

           if ($vvod[$i]=='+'){ 
            if ($vvod[$i+1]=='-'){
                $vvod[$i+1]= $vvod[$i+1]-$vvod[$i+1]*2;    
            }
            $vvod[$i]=$vvod[$i-1]+$vvod[$i+1];
            unset($vvod[$i-1]);
            unset($vvod[$i+1]);
            $vvod = array_values($vvod); 
           }
           
           

         
           }
          
       }
    } 
    while(count($vvod)>1){
    for($i = 0; $i < count($vvod); $i++){
        if ($vvod[$i]<0 && $vvod[$i+1]<0){
            $vvod[$i]=$vvod[$i]+$vvod[$i+1];
            unset($vvod[$i+1]);
            $vvod = array_values($vvod); 
           } 
       
     
    } 
   
} 
  
echo  "Результат:$vvod[0]";

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