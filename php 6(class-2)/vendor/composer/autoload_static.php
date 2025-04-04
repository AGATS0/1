<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf01ff5b38ea2b47a4eaa5f6e7f22a1d2
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vantyz\\Php6class2\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vantyz\\Php6class2\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf01ff5b38ea2b47a4eaa5f6e7f22a1d2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf01ff5b38ea2b47a4eaa5f6e7f22a1d2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf01ff5b38ea2b47a4eaa5f6e7f22a1d2::$classMap;

        }, null, ClassLoader::class);
    }
}
