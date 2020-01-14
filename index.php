<?php

require_once 'config.php';
$path = $GLOBALS['CFG']->path;
require_once $path  . 'logic/Empresa.logic.php';
require_once $path . 'access/validate_token.php';

#$data = json_decode(file_get_contents("php://input"));
session_start();
if(!key_exists("token", $_SESSION)){
    header('location: login.html');
    die();
}

$jwt = $_SESSION['token'];



$jwtHandler = new JWTHandler();
#if ($jwtHandler->validate($data) === FALSE){
if ($jwtHandler->validate($jwt) === FALSE){
    http_response_code($jwtHandler->getHttpResponse());
    echo json_encode("Acceso denegado");
    die();
}



echo file_get_contents('index.html');
