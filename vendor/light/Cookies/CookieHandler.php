<?php


namespace Light\Cookies;

/**
 * Class CookieHandler
 * @package Light\Cookies
 *
 * CookieHandler Responsible for Handling The Cookies Easly
 */

class CookieHandler
{
    /**
     * Cookie constructor.
     */
    private function __construct() {}

    /**
     * Check if Cookie exists
     * @return bool
     */
    public static function check($cookie_name) :bool
    {
        return (isset($_COOKIE[$cookie_name])) ? true : false;
    }

    /**
     * Create Cookie
     * Default Expire Data Is 1 Day
     * @return void
     */
    public static function create($cookie_name, $cookie_value,$exp_data = 3600 * 60 * 60 * 24): void
    {
        if (!static::check($cookie_name)){
            setcookie($cookie_name, $cookie_value, time() + $exp_data);
        }
    }

    /**
     * Delete Cookie
     * @return void
     */
    public static function delete($cookie_name) :void
    {
        unset($_COOKIE[$cookie_name]);
    }

    /**
     * Get One Cookie
     * @return string
     */
    public static function get($cookie_name): string
    {
        return (isset($_COOKIE[$cookie_name])) ? $_COOKIE[$cookie_name] : null;
    }

    /**
     * Get All COOKIES
     * @return array|null
     */
    public static function all() :?array
    {
        return $_COOKIE;
    }

    /**
     * Delete All Coookies
     * @return void
     */
    public function destroy() :void
    {
        foreach (static::all() as $cookie_name){
            static::delete($cookie_name);
        }
    }

    /**
     * Get Flash Cookies
     * Get The Cookie Then Delete It
     * @return string
     */
    public static function flash($cookie_name) :?string
    {
        $cookie_value = null;
        if(static::check($cookie_name)){
            $cookie_name = static::get($cookie_name);
            static::delete($cookie_name);
        }
        return $cookie_value;
    }
}