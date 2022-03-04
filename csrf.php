<?php

/**
 * Generate CSRF Token
 * 
 * This only used for Web
 * 
 * For API Endpoint for example Mobile App,
 * CSRF Token no need to be implemented see:
 * https://stackoverflow.com/questions/24583061/rest-web-api-for-mobile-devices-csrf-protection
 *
 * @return void
 */
function generate_token()
{
    session_start();
    if (!isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(16));
    }

    return $_SESSION["token"];
}
/**
 * Validate CSRF Token from POST Request
 *
 * @return void
 */
function validate_token()
{
    // Check if on POST Request not contain CSRF Token and not same token as stored in Session
    if (!isset($_POST["token"]) || $_POST["token"] !== $_SESSION["token"]) {
        header("HTTP/ 403");
        header("Content-Type: application/json");
        echo json_encode(array(
            "status" => 403,
            "msg" => "Forbidden"
        ));
        return false;
    }
    return true;
}
/**
 * Regenerate CSRF Token
 * 
 * If token not exists, automaticaly call generate_token function
 * to create new CSRF Token
 *
 * @return void
 */
function regenerate_token()
{
    if (isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(16));
    } else {
        generate_token();
    }
}