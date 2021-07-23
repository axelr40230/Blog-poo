<?php


namespace App;


class Env
{
    protected static $vars = null;

    public static function get(string $key, $default = null): ?string
    {
        if (is_null(self::$vars)) {
            self::read();
        }

        $key = strtoupper($key);

        if (array_key_exists($key, self::$vars)) {
            return self::$vars[$key];
        }

        return $default;
    }

    protected static function read(): void
    {
        $vars = [];

        if (preg_match_all('/([A-Z\_]+)\=(.*)\n?/ium', self::file(), $vars)) {
            foreach ($vars[1] as $index => $value) {
                self::$vars[strtoupper($value)] = trim($vars[2][$index]);
            }

            return;
        }

        throw new \RuntimeException(".env is empty");
    }

    protected static function file()
    {
        $path = __DIR__.'\.env';
        $pathExample =  __DIR__.'\.env.example';
        //var_dump($path, $pathExample);exit();

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        if (file_put_contents($path, file_get_contents($pathExample))) {
            return self::file();
        }

        throw new \RuntimeException(".env is not readable");
    }
}