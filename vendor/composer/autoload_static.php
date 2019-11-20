<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite2b0884dba3cf30ad0f24552407ef218
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MF\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MF\\' => 
        array (
            0 => __DIR__ . '/..' . '/mf/phpclasses/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
        'R' => 
        array (
            'Rain' => 
            array (
                0 => __DIR__ . '/..' . '/rain/raintpl/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite2b0884dba3cf30ad0f24552407ef218::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite2b0884dba3cf30ad0f24552407ef218::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite2b0884dba3cf30ad0f24552407ef218::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}