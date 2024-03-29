<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9027adbc04b6a6298021179ef02ae30f
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'ConditionalAddToCart\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ConditionalAddToCart\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9027adbc04b6a6298021179ef02ae30f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9027adbc04b6a6298021179ef02ae30f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
