<?php
$text = "Тестовый текст. Тестовый текст содержит какое-то частое слово, самое частое слово - это слово 'текст' текст.";
echo mostRecent($text);

function mostRecent(string $text):string 
{  
    if (strlen($text) > 1000) {
        return "Текст превышает 1000 символов.";
    }

    $text = strtolower($text);
    $text = str_replace([',', '.', '!', '?', ';', ':', "'", '!'], '', $text);
    $slova = explode(' ', $text);
    
    $kolichWords = [];

    foreach ($slova as $slovo) {
        if (isset($kolichWords[$slovo])) {
            $kolichWords[$slovo]++;
        } else {
            $kolichWords[$slovo] = 1;
        }
    }
    print_r( $kolichWords);


    $chastoeSlovo = '';
    $maxKol = 0;

    foreach ( $kolichWords as $slovo => $kol) {
        if ($kol > $maxKol) {
            $chastoeSlovo = $slovo;
            $maxKol = $kol;
        }
    }

    return  $chastoeSlovo;
}





