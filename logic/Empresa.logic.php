<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author Mauricio Zárate
 */

require_once $GLOBALS['CFG']->path . 'models/Empresa.model.php';
require_once $GLOBALS['CFG']->path . 'class/ErrorHandler.php';

class EmpresaLogic extends Empresa {
    
    public function __construct($id = NULL) {
        if ($id !== NULL){
            $this->get($id);
        }
    }
    
    public function setNombre($value){
        parent::setNombre($value);
    }

    public function setActivo($value) {
        parent::setActivo($value);
    }

    private function errorHandler($code,$message,$file=NULL,$line=NULL){
        /*TODO:
        Crear manejador de errores para los json
         *          */
        $error = new ErrorHandler();
        $error->setErrorArray(['code'=>$code, 
                                'message'=>$message
                               ],$file, $line
                );
    }
    
    public function get($id){
        if(FALSE === parent::getData($id)){
            return FALSE;
        }
        return TRUE;
    }
    
    public function getById($id) {
        if (FALSE === $item =  parent::getById($id)){
            return json_encode([
               'status' => 'FAIL',
                'message' => parent::getErrorMessage(),
                'result' => ['id'=>NULL,'nombre'=>NULL, 'activo' => NULL]
            ]);
        }
        $json = json_encode([
            'status' => 'OK',
            'message' => 'Registro encontrado',
            'result' => $item
        ]);
        if (json_last_error() !== JSON_ERROR_NONE){
            $this->errorHandler(json_last_error(), json_last_error_msg());
            return [
                'status' => 'FAIL',
                'message' => json_last_error_msg(),
                'result' => ['id' => NULL, 'nombre' => NULL, 'activo' => NULL]
            ];
        }
        return $json;
    }
    
    public function listar($criterios = array(), $id = NULL){
        $list= parent::arraylist($criterios, $id);
        #echo '<pre>'; print_r($list);
        $json =  json_encode($list);
        if (json_last_error() !== JSON_ERROR_NONE){
            $this->errorHandler(json_last_error(),  json_last_error_msg());
            return false;
        }
        return $json;
    }
    
    public function insert(){
        if (FALSE === $result = parent::insert()){
            return json_encode([
                'status' => 'FAIL',
                'message' => parent::getErrorMessage(),
            ]);
        } 
        return json_encode(['status' => 'OK', 
            'message' => "Nuevo registro creado con código: "
                . "{$result['id']}"]);
    }
    
    public function update(){
        if (FALSE === $result = parent::update()){
            return json_encode([
                'status' => 'FAIL',
                'message' => parent::getErrorMessage()]);
        }
        $json =  json_encode([
            'status' => 'OK',
            'message' => "Registros actualizados: {$result['rows']}"]);
        if (json_last_error() !== JSON_ERROR_NONE){
            $this->errorHandler(json_last_error(),  json_last_error_msg());
            return false;
        }
        return $json;
    }
    
    public function delete(){
        if (FALSE === $result = parent::delete()){
            return json_encode(['status' => 'FAIL',
                    'message' => parent::getErrorMessage()]);
        }
        return json_encode(['status' => 'OK',
                'message' => "Registros eliminados: {$result['rows']}"]);
    }
    
}

# Test listar:
//$empresa = new EmpresaLogic();
//$result = $empresa->listar();
//var_dump($result);

#Test insert()
#$empresa = new EmpresaLogic();
#$empresa->setNombre("La mega");
//echo $empresa->insert();

# $empresa->listar([],'id');
#Test update()
//$empresa = new EmpresaLogic();
//if(FALSE===$empresa->get(5)){
//    echo "Error ";
//    exit;
//}
//echo '<pre>';
//print_r($empresa);
//echo '</pre>';
//$empresa->setNombre("Coralcentro-Batán");
//echo $empresa->update();
//echo '<pre>';
//print_r($empresa);
//echo '</pre>';


