<?php


namespace Light\Sessions;

/**
 * Class SessionHandler
 * @package Light\Session
 *
 * Manage The Sessions In Easy Way
 */

class SessionHandler
{
    /**
     * Session constructor.
     */
    private function __construct() {}

    /**
     * Session Start
     * @return void
     */
    public static function start() :void
    {
        if(!session_id()){
            session_start();
        }
    }

    /**
     * Check if Session exists
     * @return bool
     */
    public static function check($session_name) :bool
    {
        return ($_SESSION[$session_name]) ? true : false;
    }

    /**
     * Create Session
     * @return void
     */
    public static function create($session_name, $session_value) :void
    {
        if (!static::check($session_name)){
            $_SESSION[$session_name] = $session_value;
        }
    }

    /**
     * Delete session
     * @return void
     */
    public static function delete($session_name) :void
    {
        unset($_SESSION[$session_name]);
    }

    /**
     * Get One Session
     * @return string
     */
    public static function get($session_name) :string
    {
        return $_SESSION[$session_name];
    }

    /**
     * Get All Sessions
     * @return array|null
     */
    public static function all() :?array
    {
        return $_SESSION;
    }

    /**
     * Delete All Session
     * @return void
     */
    public function destroy() :void
    {
        foreach (static::all() as $session_name){
            static::delete($session_name);
        }
    }

    /**
     * Get Flash Session
     * Get The Session Then Delete It
     * @return string
     */
    public static function flash($session_name) :?string
    {
        $session_value = null;
        if(static::check($session_name)){
            $session_name = static::get($session_name);
            static::delete($session_name);
        }
        return $session_value;
    }
}