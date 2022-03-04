<?php

class Controller {
    protected static $mysqli;

    public function __construct()
    {
        self::$mysqli = new mysqli(
            $_ENV['DB_HOST'], 
            $_ENV['DB_USERNAME'], 
            $_ENV['DB_PASSWORD'], 
            $_ENV['DB_DATABASE']
        );

        if (self::$mysqli->errno !== 0) {
            die('Koneksi gagal: ' . self::$mysqli->error);
        }
    }
}
