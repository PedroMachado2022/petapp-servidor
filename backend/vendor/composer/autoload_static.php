<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit467af02bf84c5eb43b6b2248e1e14519
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit467af02bf84c5eb43b6b2248e1e14519::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit467af02bf84c5eb43b6b2248e1e14519::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit467af02bf84c5eb43b6b2248e1e14519::$classMap;

        }, null, ClassLoader::class);
    }
}
