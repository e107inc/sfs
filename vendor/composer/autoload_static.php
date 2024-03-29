<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7acf18453b679733afbecfd24d47fec3
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Resolventa\\StopForumSpamApi\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Resolventa\\StopForumSpamApi\\' => 
        array (
            0 => __DIR__ . '/..' . '/resolventa/stopforumspam-php-api/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7acf18453b679733afbecfd24d47fec3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7acf18453b679733afbecfd24d47fec3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7acf18453b679733afbecfd24d47fec3::$classMap;

        }, null, ClassLoader::class);
    }
}
