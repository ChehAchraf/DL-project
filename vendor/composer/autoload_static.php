<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf85963926389ab4b239515de077eec9a
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Helpers\\' => 8,
        ),
        'C' => 
        array (
            'Classes\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/helpers',
        ),
        'Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf85963926389ab4b239515de077eec9a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf85963926389ab4b239515de077eec9a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf85963926389ab4b239515de077eec9a::$classMap;

        }, null, ClassLoader::class);
    }
}