<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EasySwoole\\Utility\\' => 19,
            'EasySwoole\\Spl\\Test\\' => 20,
            'EasySwoole\\Spl\\' => 15,
            'EasySwoole\\Pool\\Tests\\' => 22,
            'EasySwoole\\Pool\\' => 16,
            'EasySwoole\\Memcache\\Tests\\' => 26,
            'EasySwoole\\Memcache\\' => 20,
            'EasySwoole\\MemcachePool\\' => 24,
            'EasySwoole\\Component\\Tests\\' => 27,
            'EasySwoole\\Component\\' => 21,
            'EGroupware\\SwoolePush\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EasySwoole\\Utility\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/utility/src',
        ),
        'EasySwoole\\Spl\\Test\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/spl/test',
        ),
        'EasySwoole\\Spl\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/spl/src',
        ),
        'EasySwoole\\Pool\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/pool/tests',
        ),
        'EasySwoole\\Pool\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/pool/src',
        ),
        'EasySwoole\\Memcache\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/memcache/tests',
        ),
        'EasySwoole\\Memcache\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/memcache/src',
        ),
        'EasySwoole\\MemcachePool\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/memcache-pool/src',
        ),
        'EasySwoole\\Component\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/component/Tests',
        ),
        'EasySwoole\\Component\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyswoole/component/src',
        ),
        'EGroupware\\SwoolePush\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'H' => 
        array (
            'Horde_Translation' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/translation/lib',
            ),
            'Horde_Text_Flowed' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/text-flowed/lib',
            ),
            'Horde_Support' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/support/lib',
            ),
            'Horde_Stream_Wrapper' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/stream-wrapper/lib',
            ),
            'Horde_Stream_Filter' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/stream-filter/lib',
            ),
            'Horde_Stream' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/hstream/lib',
            ),
            'Horde_Mime' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/mime/lib',
            ),
            'Horde_Mail' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/mail/lib',
            ),
            'Horde_ListHeaders' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/listheaders/lib',
            ),
            'Horde_Idna' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/idna/lib',
            ),
            'Horde_Exception' => 
            array (
                0 => __DIR__ . '/..' . '/egroupware/exception/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Horde_Array' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/Array.php',
        'Horde_Array_Sort_Helper' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/Array/Sort/Helper.php',
        'Horde_Domhtml' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/Domhtml.php',
        'Horde_String' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/String.php',
        'Horde_String_Transliterate' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/String/Transliterate.php',
        'Horde_Util' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/Util.php',
        'Horde_Variables' => __DIR__ . '/..' . '/egroupware/util/lib/Horde/Variables.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInita1d9162b029fff796c6de39eb3e3c0c0::$classMap;

        }, null, ClassLoader::class);
    }
}
