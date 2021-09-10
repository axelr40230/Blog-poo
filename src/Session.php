<?php

namespace App;

/**
 * Class Session
 * @package App
 */
class Session
{

    /**
     * vérification des limites et expiration du cache
     * limit checking and cache expiration
     * Session constructor.
     * @param string|null $cacheExpire
     * @param string|null $cacheLimiter
     */
    public function __construct(?string $cacheExpire = null, ?string $cacheLimiter = null)
    {
        if (session_status() === PHP_SESSION_NONE) {

            if ($cacheLimiter !== null) {
                session_cache_limiter($cacheLimiter);
            }

            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire);
            }

            session_start();
        }
    }

    /**
     * permet de récupérer une donnée de session
     * allows you to retrieve session data
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * permet de définir une donnée de session
     * allows you to define session data
     * @param string $key
     * @param mixed $value
     * @return Session
     */
    public function set(string $key, $value): Session
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * permet de retirer une donnée de session
     * allows you to remove session data
     * @param string $key
     */
    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * destruction de la session
     * session destruction
     */
    public function clear(): void
    {
        session_destroy();
    }

    /**
     * vérifie si une donnée de session existe
     * checks if session data exists
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

}