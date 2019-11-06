<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $GLOBALS['CFG']->path . 'class/Connection.php';
require_once $GLOBALS['CFG']->path . 'class/ErrorHandler.php';

class Empresa{
    
    const TABLE_NAME = 'empresas';
    
    private $id;
    private $nombre;
    private $activo;
    
    private $errorMessage = '';
    
    protected function setId($value){
        $this->id = $value;
    }
    
    protected function setNombre($value){
        $this->nombre = $value;
    }
    
    protected function setActivo($value){
        $this->activo = $value;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    
    public function getActivo(){
        return $this->activo;
    }
    
    public function getErrorMessage(){
        return $this->errorMessage;
    }
    
    protected function getData($id){
        $connection = new Connection();
        $query = "SELECT e.id, e.nombre, e.activo "
                . "FROM " . self::TABLE_NAME ." e "
                . "WHERE e.id = '$id';";
        
        $data = $connection->executeQuery($query);
        if (FALSE == $data){
            $this->errorMessage = $connection->getErrorMessage();
            return FALSE;
        }
        
        foreach ($data as $value) {
            $this->id = $value['id'];
            $this->nombre = $value['nombre'];
            $this->activo = $value['activo']; 
            $this->errorMessage = '';
        }
        
    }
    
    protected function insert(){
        $connection = new Connection();
        $statement = "INSERT INTO " . self::TABLE_NAME
                . " SET "
                . " nombre = :nombre ;";
        $parameters = [
            'nombre' => $this->nombre,
        ];
        if (FALSE === $result = $connection->executePreparedStatement($statement, 
                $parameters)){
            $this->errorMessage = $connection->getErrorMessage();
        }
        return $result;
    }
    
    protected function update(){
        $connection = new Connection();
        $statement = "UPDATE " . self::TABLE_NAME 
            . " SET "
            . " nombre = :nombre "
            . " , activo = :activo "
            . " WHERE id = :id ;";
        $parameters = [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'activo' => $this->activo
        ];
        if (FALSE === $result = $connection->executePreparedStatement($statement, 
                $parameters)){
            $this->errorMessage = $connection->getErrorMessage();
        }
        return $result;
    }
    
    protected function delete(){
        $connection = new Connection();
        $statement = "DELETE FROM ". self::TABLE_NAME
                . " WHERE id = :id; ";
        $parameters = ['id' => $this->id];
        if (FALSE === $result = $connection->executePreparedStatement($statement, 
                $parameters)){
            $this->errorMessage = $connection->getErrorMessage();
        }
        return $result;
    }
    
    protected function arraylist($criterios = [], $id = NULL){
        $connection = new Connection();
        $query = "SELECT e.id, e.nombre "
                . "FROM " . self::TABLE_NAME . " e ";
        
        if (count($criterios)>0){
            $query .= " WHERE TRUE ";
        }
        foreach ($criterios as $campo => $valor){
            $query .= " AND e.$campo = '$valor' ";
        } 
        $query .= ";";
        
        $result = $connection->executeQuery($query);
        if (FALSE === $result){
            $this->errorMessage = $connection->getErrorMessage();
            return FALSE;
        }
        $arrayResult = array();
        foreach ($result as $value){
            if ($id === NULL){
                $arrayResult[] = $value;
            } else {
                $arrayResult[$value[$id]] = $value;
            }
        }
        return $arrayResult;
    }
    
    protected function getById($id){
        $query = "SELECT e.id, e.nombre, e.activo "
                . " FROM ". self::TABLE_NAME . " as e "
                . " WHERE e.id = '$id';";
        $conection = new Connection();
        if (FALSE === $result = $conection->executeQuery($query) ){
            $this->errorMessage = $conection->getErrorMessage();
            return FALSE;
        }
        foreach ($result as $item){
            return $item;
        }
    }
}
# Prueba de cargar la clase
//$empresa = new Empresa();
//$empresa->getData(1);
//echo '<pre>';
//print_r($empresa);

#Prueba de insertar
//$empresa = new Empresa();
//$empresa->setNombre('Otra empresa');
//if (FALSE === ($result = $empresa->insert())){
//    echo $empresa->getErrorMessage();
//} else {
//    echo "El registro se insertó con el código: " 
//    , $result['lastInsertId'];
//}

#Prueba de actualizar
//echo '<pre>';
//$empresa = new Empresa();
//$empresa->getData('1');
//print_r($empresa);
//$empresa->setNombre("Tienda Corazón");
//if (FALSE === $result = $empresa->update()){
//    echo 'Error al actualizar: '. $empresa->getErrorMessage();
//} else {
//    echo '<pre>'; print_r($result);
//    echo "Registros actualizados: " . $result['rows'];
//}
//
//echo '<pre>';
//print_r($empresa);

#Prueba de eliminar
//$empresa = new Empresa();
//$empresa->getData(4);
//if (FALSE === $result = $empresa->delete()){
//    echo "Error al eliminar ". $empresa->getErrorMessage();
//} else
//{
//    echo "Registros eliminados: " . $result['rows'];
//}

#Prueba de lista
//$empresa = new Empresa();
//$list = $empresa->arraylist();
//echo '<pre>';
//print_r($list);


#actualización para intentar cambiar a codificación utf-8

//$empresa = new Empresa();
//$listEmpresas = $empresa->arraylist();
//foreach ($listEmpresas as $key=>$value) {
//    print $key . '<br>';
//    $empresa->getData($key);
//    print_r($empresa);
//    $empresa->setNombre(utf8_encode($empresa->getNombre()));
//    $empresa->update();
//}