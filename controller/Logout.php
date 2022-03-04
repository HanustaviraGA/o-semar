<?php

class Logout extends Controller
{

    // TODO: Controller for Web
    public static function post()
    {
        self::clear_session();
    }

    public static function api_post()
    {
        self::clear_session();
        return (object) array(
            'status' => true,
            'msg' => 'Sukses'
        );
    }

    private static function clear_session()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
