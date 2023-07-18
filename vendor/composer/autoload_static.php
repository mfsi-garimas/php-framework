<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite0c47998b4fa18ed6c413bc4232bb3b4
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pds\\Skeleton\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pds\\Skeleton\\' => 
        array (
            0 => __DIR__ . '/..' . '/pds/skeleton/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite0c47998b4fa18ed6c413bc4232bb3b4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite0c47998b4fa18ed6c413bc4232bb3b4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite0c47998b4fa18ed6c413bc4232bb3b4::$classMap;

        }, null, ClassLoader::class);
    }
}
