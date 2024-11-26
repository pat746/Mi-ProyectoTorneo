<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit661a00d6a6ff7f885ebbc4d2edabb68e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit661a00d6a6ff7f885ebbc4d2edabb68e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit661a00d6a6ff7f885ebbc4d2edabb68e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit661a00d6a6ff7f885ebbc4d2edabb68e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
