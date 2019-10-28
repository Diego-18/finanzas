<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// required headers
//header("Access-Control-Allow-Origin: http://localhost/finanzas/");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// required to decode jwt
//include_once '../config.php';
$path = $GLOBALS['CFG']->path;
require_once $path . 'class/ErrorHandler.php';
include_once $path . 'libs/php-jwt-master/src/BeforeValidException.php';
include_once $path . 'libs/php-jwt-master/src/ExpiredException.php';
include_once $path . 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once $path . 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

class JWTHandler{
    
    private $httpResponse;
    private $errorMessage;

    public function getErrorMessage(){
        return $this->errorMessage;
    }
    
    public function getHttpResponse(){
        return $this->httpResponse;
    }

// get posted data
//$data = json_decode(file_get_contents("php://input"));
    #public function validate($data){
    public function validate($jwt){
        // get jwt
        #$jwt=isset($data->jwt) ? $data->jwt : "";
        
        // if jwt is not empty
        if($jwt != ''){
            
            // if decode succeed, show user details
            try {
                // decode jwt
                $decoded = JWT::decode($jwt, $GLOBALS['CFG']->key, array('HS256'));
                
                // set response code
                $this->httpResponse = 200;

                // show user details
                return json_encode(array(
                    "message" => "Access granted.",
                    "data" => $decoded->data
                ));

            }

            // if decode fails, it means jwt is invalid
            catch (Exception $e){
                ErrorHandler::register($e);
                $this->errorMessage = ErrorHandler::getErrorMessage($e);
                // set response code
                $this->httpResponse = 401;

                // tell the user access denied  & show error message
//                return json_encode(array(
//                    "message" => "Access denied.",
//                ));
                return FALSE;
            }
        }

        // show error message if jwt is empty
        else{

            // set response code
            $this->httpResponse = 401;

            // tell the user access denied
            #return json_encode(array("message" => "Access denied."));
            return FALSE;
        }
    }
}