<?php


namespace App;

/**
 * Class Env
 * @package App
 */
class Env
{
    protected static $vars = null;

    /**
     * vérifie si les variables sont complétées et sinon, va chercher les variables
     * checks if the variables are completed and if not, will look for the variables
     * @param string $key
     * @param null $default
     * @return string|null
     */
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

    /**
     * permet de récupérer les variables
     * allows you to retrieve the variables
     */
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

    /** indique le chemin du fichier et le génère à partir de l'exemple s'il n'existe pas
     * indicate the path of the file and generate it from the example if it does not exist
     * @return false|string
     */
    protected static function file()
    {
        $path = dirname(__DIR__) . '\.env';
        $pathExample = dirname(__DIR__) . '\.env.example';

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        if (file_put_contents($path, file_get_contents($pathExample))) {
            return self::file();
        }

        throw new \RuntimeException(".env is not readable");
    }
}