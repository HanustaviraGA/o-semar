<?php
    /**
     * Generate CSRF Token, served to HTTP Header
     * 
     * This works only for forms rendered from server-side
     * like PHP
     * 
     * For API Endpoint for example Mobile App,
     * CSRF Token need to be generated from the Mobile App itself
     *
     * @return void
     */
    function generate_token() {
        if (!isset($_SESSION["token"])) {
            $_SESSION["token"] = bin2hex(random_bytes(16));
        }
        header("X-CSRF_TOKEN: " . $_SESSION["token"]);
    }
    /**
     * Validate CSRF Token from Request Header
     *
     * @return void
     */
    function validate_token() {
        $headers = get_headers($_SERVER["ORIG_PATH_INFO"], true);
        // ===========
        // DEBUG
        // 
        // Find for X-CSRF-TOKEN header, if not exist, something wrong happen
        // ===========
        // var_dump($headers);
        // die;
        // ===========
        // Check if on Request Header not contain "X-CSRF-TOKEN" and not same token as stored in Session
        if (!isset($headers["X-CSRF-TOKEN"]) || $headers["X-CSRF-TOKEN"] !== $_SESSION["token"]) {
            header("HTTP/ 403");
            header("Content-Type: application/json");
            if (isset($_ENV["ENV"]) && $_ENV["ENV"] === "development") {
                echo json_encode(array(
                    "status" => 403,
                    "msg" => "Forbidden",
                    "note" => "Check HTTP Request Header of \"X-CSRF-TOKEN\", if not exist after you login, call the dev"
                ));
            } else {
                echo json_encode(array(
                    "status" => 403,
                    "msg" => "Forbidden"
                ));
            }
            exit();
        }
        return;
    }
    /**
     * Regenerate CSRF Token, served to HTTP Header
     * 
     * If token not exists, automaticaly call generate_token function
     * to create new CSRF Token
     *
     * @return void
     */
    function regenerate_token() {
        if (isset($_SESSION["token"])) {
            $_SESSION["token"] = bin2hex(random_bytes(16));
            header("X-CSRF_TOKEN: " . $_SESSION["token"]);
        } else {
            generate_token();
        }
    }
    /**
     * Set CSRF Token to Session
     * 
     * Used for storing CSRF Token recieved from Non Server-Side Rendering App
     * like PHP Web App
     * 
     * For App like Mobile App, need to send CSRF Token at first request to server
     * in order to be used in next request
     * 
     * If CSRF Token is missing, then API will not work as the autenticity of the request
     * is questionable
     *
     * @return void
     */
    function set_token() {
        $headers = get_headers($_SERVER["ORIG_PATH_INFO"], true);
        if (!isset($_SESSION["token"]) && isset($headers["X-CSRF-TOKEN"])) {
            $_SESSION["token"] = $headers["X-CSRF-TOKEN"];
        }
    }