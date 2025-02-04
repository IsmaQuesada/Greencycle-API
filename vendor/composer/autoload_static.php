<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64ae62d7ffaad4c4f5dcbf4592626fa1
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64ae62d7ffaad4c4f5dcbf4592626fa1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64ae62d7ffaad4c4f5dcbf4592626fa1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit64ae62d7ffaad4c4f5dcbf4592626fa1::$classMap;

        }, null, ClassLoader::class);
    }
}
