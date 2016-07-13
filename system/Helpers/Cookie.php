<?php
/**
 * Simple cookie class.
 *
 * @author Jhobanny Morillo geomorillo@yahoo.com
 * @version 3.0
 */

namespace Helpers;

use Core\Config;
use Encryption\DecryptException;
use Support\Facades\Crypt;


/**
 * Class Cookie.
 */
class Cookie
{
    const FOURYEARS = 126144000;

    /**
     * Does the cookie with the specified key exist?
     *
     * @param string $key
     * @return bool
     */
    public static function exists($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Set cookie value and optionals: expiry, path and domain.
     *
     * @param string $key
     * @param mixed $value
     * @param int $expiry
     * @param string $path
     * @param bool $domain
     * @return bool
     */
    public static function set($key, $value, $expiry = self::FOURYEARS, $path = '/', $domain = false)
    {
        // Retrieve the Session configuration.
        $config = Config::get('session');

        // Encrypt the value
        if ($key != 'PHPSESSID') {
            // // No PHPSESSID and end-user want the Cookie encryption.
            $value = Crypt::encrypt($value);
        }

        // Ensure to have a valid domain.
        $domain = ($domain !== false) ? $domain : $_SERVER['HTTP_HOST'];

        if ($expiry === -1) {
            $expiry = 1893456000; // Lifetime = 2030-01-01 00:00:00
        } else if (is_numeric($expiry)) {
            $expiry += time();
        } else {
            $expiry = strtotime($expiry);
        }

        return @setcookie($key, $value, $expiry, $path, $domain);
    }

    /**
     * Retrieve the value of the cookie.
     *
     * @param $key
     * @param string $default
     * @return string|mixed
     */
    public static function get($key, $default = null)
    {
        if(! isset($_COOKIE[$key])) {
            return $default;
        }

        $cookie = $_COOKIE[$key];

        // Retrieve the Session configuration.
        $config = Config::get('session');

        if ($key == 'PHPSESSID') {
            // A PHPSESSID or when end-user want not Cookie encryption.
            return $cookie;
        }

        try {
            return Crypt::decrypt($cookie);
        } catch (DecryptException $e) {
            return $default;
        }
    }

    /**
     * Retrieve the cookie array.
     * @return array
     */
    public static function display()
    {
        return $_COOKIE;
    }

    /**
     * Destroy the cookie entry.
     * @param string $key
     * @param string $path Optional
     * @param string $domain Optional
     */
    public static function destroy($key, $path = '/', $domain = false)
    {
        // Ensure to have a valid domain.
        $domain = ($domain !== false) ? $domain : $_SERVER['HTTP_HOST'];

        if (! headers_sent()) {
            unset($_COOKIE[$key]);

            // To delete the Cookie we set the expiration four years into past.
            @setcookie($key, '', time() - FOURYEARS, $path, $domain);
        }
    }
}
