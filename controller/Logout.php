<?php

require_once "controller.php";

class Logout extends Controller
{

    // TODO: Controller for Web
    public function post()
    {
        $this->clear_session();
    }

    public function api_post()
    {
        $this->clear_session();
        return $this->response(true, 'Logout sukses!');
    }

    private function clear_session()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
