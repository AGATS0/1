<?php
namespace Vantyz\Php9final;

class PasswordValidator 
{
  
    public static function validate(string $password): bool
    {
        $words=str_split($password);

        if (count($words)<8) return false;
 
        $i=0;
        foreach($words as $word)
        {
            
            if ($word==1 || $word==2 ||$word==3 ||$word==4 ||$word==5 ||$word==6 ||$word==7 ||$word==8 ||$word==9 || $word==0) $i=$i+1;
           
        }
        if ($i<1) return false;
 
        if (str_contains($password,' ')) return false;
 
        if (!preg_match('/[A-ZА-Я]/', $password)) return false;

        return true;
    }



}



