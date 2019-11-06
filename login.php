<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config.php';
header("Access-Control-Allow-Origin: " . $GLOBALS['CFG']->url . "rest-api-authentication/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once $GLOBALS['CFG']->path . 'logic/User.logic.php';
$path = $GLOBALS['CFG']->path;

$userName = 'admin';
$password = 'admin';

$user = new UserLogic();
#user validation
if (FALSE === $user->getByUser($userName)){
    http_response_code(401);
    echo json_encode("Usuario no encontrado");
    session_destroy();
    setcookie("PHPSESSID","",time()-3600);
    die();
}

#password validation
if(FALSE === $user->validatePassword($password)){
    http_response_code(401);
    echo json_encode("Contraseña no válida");
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
    session_destroy();
    die();
}

// generate json web token
#include_once $path . 'config/core.php';
include_once $path . 'libs/php-jwt-master/src/BeforeValidException.php';
include_once $path . 'libs/php-jwt-master/src/ExpiredException.php';
include_once $path . 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once $path . 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;


$token = [
    "iss" => $GLOBALS['CFG']->iss,
    "aud" => $GLOBALS['CFG']->aud,
    "iat" => $GLOBALS['CFG']->iat,
    "nbf" => $GLOBALS['CFG']->nbf,
    "data" => array(
        "id" => $user->getId(),
        "user" => $user->getUser(),
        "email" => $user->getEmail()
       )
    
];

$jwt = JWT::encode($token,$GLOBALS['CFG']->key);
session_start();
$_SESSION['token'] = $jwt;
http_response_code(200);
echo json_encode([
    "message" => "Successful login.",
    "jwt" => $jwt
]);