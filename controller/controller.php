<?php

/**
 * O-Semar Framework Controller
 * 
 * @author Rafli Athala Jaskandi <rafli.jaskandi@gmail.com>
 * @version 1.2.0
 */
class Controller {
    /**
     * Mysqli
     *
     * @var mysqli
     */
    protected $mysqli;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $this->mysqli = new mysqli(
            $_ENV['DB_HOST'], 
            $_ENV['DB_USERNAME'], 
            $_ENV['DB_PASSWORD'], 
            $_ENV['DB_DATABASE']
        );

        if ($this->mysqli->errno !== 0) {
            die('Koneksi gagal: ' . $this->mysqli->error);
        }
    }

    /**
     * Non-error Response for controller endpoint
     * 
     * If result is string, it returns msg inserted on `$res` parameter
     *
     * If result is array or object, it returns data inserted on `$res` parameter
     * 
     * @param boolean|integer $status
     * @param object|array|string $res
     * @return object|\ErrorException
     */
    protected function response(bool|int $status, object|array|string $res)
    {
        if (gettype($res) === 'string')
            return (object) array(
                'status' => $status,
                'msg' => $res
            );
        else if (gettype($res) === 'array' || gettype($res) === 'object')
            return (object) array(
                'status' => $status,
                'data' => $res
            );
        else
            throw new ErrorException('Response only accept Object, Array or String!');
    }

    /**
     * Error response for controller endpoint
     *
     * @param string $err
     * @return object
     */
    protected function error(string $err)
    {
        return (object) array(
            'status' => false,
            'error' => $err
        );
    }

    /**
     * Sanitize input from XSS and Escape special chars for SQL Query
     *
     * @param string $data
     * @return string
     */
    protected function sanitize(string $data)
    {
        return $this->mysqli->real_escape_string(htmlspecialchars($data, ENT_COMPAT));
    }
}
