<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4caeca4dca62b9643c2b234d3b7e35a0
{
    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'Requests' => 
            array (
                0 => __DIR__ . '/..' . '/rmccue/requests/library',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit4caeca4dca62b9643c2b234d3b7e35a0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit4caeca4dca62b9643c2b234d3b7e35a0::$classMap;

        }, null, ClassLoader::class);
    }
}
