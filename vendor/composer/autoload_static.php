<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit49adbc95f6920bf160838a141ade1757
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PcsIndonesia\\FmsbriPackage\\Scripts\\' => 35,
            'PcsIndonesia\\FmsbriPackage\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PcsIndonesia\\FmsbriPackage\\Scripts\\' => 
        array (
            0 => __DIR__ . '/../..' . '/scripts',
        ),
        'PcsIndonesia\\FmsbriPackage\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit49adbc95f6920bf160838a141ade1757::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit49adbc95f6920bf160838a141ade1757::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit49adbc95f6920bf160838a141ade1757::$classMap;

        }, null, ClassLoader::class);
    }
}
