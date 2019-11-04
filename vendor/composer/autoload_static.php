<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EasySwoole\\Spl\\Test\\' => 20,
            'EasySwoole\\Spl\\' => 15,
            'EasySwoole\\Memcache\\Tests\\' => 26,
            'EasySwoole\\Memcache\\' => 20,
            'EGroupware\\SwoolePush\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EasySwoole\\Spl\\Test\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/spl/test',
        ),
        'EasySwoole\\Spl\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/spl/src',
        ),
        'EasySwoole\\Memcache\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/memcache/tests',
        ),
        'EasySwoole\\Memcache\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/memcache/src',
        ),
        'EGroupware\\SwoolePush\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
