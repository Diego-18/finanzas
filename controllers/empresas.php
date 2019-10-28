<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



require_once '../config.php';
$path = $GLOBALS['CFG']->path;
require_once $path  . 'logic/Empresa.logic.php';
require_once $path . 'access/validate_token.php';

#$data = json_decode(file_get_contents("php://input"));
session_start();
if(!key_exists("token", $_SESSION)){
    http_response_code('401');
    echo json_encode("No se ha iniciado sesión");
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



$action = filter_input(INPUT_GET, "action");

$empresa = new EmpresaLogic();
$response = '';
switch ($action){
    case 'view':
        $response = view();
        break;
    case 'list':
        $response = $empresa->listar();
        break;
    case 'insert':{
        $response = insert();
        break;
    }
    case 'update':{
        $response = update();
        break;
    }
    case 'delete':{
        $response = delete();
        break;
    }
}

echo $response;

function view(){
    if (!key_exists('id', $_GET)){
        return json_encode(['Error' => 'El campo id no existe']);
    }
    $id = filter_input(INPUT_GET, 'id');
    $empresa = new EmpresaLogic();
    return $empresa->getById($id);
}

function insert(){
    if (!key_exists("nombre", $_POST)){
        return json_encode(["Error"=>"El campo indicado no existe"]);
    }
    $nombre = filter_input(INPUT_POST, "nombre");
    $empresa = new EmpresaLogic();
    $empresa->setNombre($nombre);
    return $empresa->insert();
}

function update(){
    if (!key_exists("id", $_POST)){
        return json_encode([
            'status' => 'FAIL',
            'message' => 'El campo id no existe']);
    }
    if (!key_exists("nombre", $_POST)){
        return json_encode([
            'status' => 'FAIL',
            'message' => 'El campo nombre no existe']);
    }
    if (!key_exists("activo", $_POST)){
        return json_encode([
            'status' => 'FAIL',
            'message' => 'El campo activo no existe']);
    }
    $id = filter_input(INPUT_POST, 'id');
    $nombre = filter_input(INPUT_POST, 'nombre');
    $activo = filter_input(INPUT_POST, 'activo');
    $empresa = new EmpresaLogic($id);
    $empresa->setNombre($nombre);
    $empresa->setActivo($activo);
    if (FALSE === $result = $empresa->update()){
        return [
            'status' => 'FAIL',
            'message' => $empresa->getErrorMessage(),
        ];
    }
    return $result;
}

function delete(){
    if (!key_exists("id", $_POST)){
        return json_encode([
            'status' => 'FAIL',
            'message' => 'El campo id no existe']);
    }
    $id = filter_input(INPUT_POST, 'id');
    $empresa = new EmpresaLogic($id);
    if (FALSE === $result = $empresa->delete()){
        return [
            'status' => 'FAIL',
            'message' => $empresa->getErrorMessage(),
        ];
    }
    return $result;
}