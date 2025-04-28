<?php

use Vantyz\Php9final\PasswordValidator; 
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $passwordValidator;

    protected function setUp():void
    {
        $this->passwordValidator=new PasswordValidator();
    }

    public static function additionProvider(): array
    {
        return [
            ['Cool 234',false],
            ['Cool1234',true],
            ['Cool123',false],
            ['cool1234',false],
            ['Coolcool',false],
        ];
    }

    #[DataProvider('additionProvider')]
    public function testValidate(string $a,bool $b): void
    {
        $this->assertSame($this->passwordValidator->validate($a),$b);
    }


}