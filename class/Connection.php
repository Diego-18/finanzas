<?php

/* 
 * Conexión con la base de datos
 */
#namespace app\classes;

require_once $GLOBALS['CFG']->path . 'class/ErrorHandler.php';

class Connection{
    
    private $connection;
    private $errorMessage = '';
    
    private function setConnection_mysqli(){
        
        $conection_mysqli = new mysqli($GLOBALS['CFG']->dbhost, $GLOBALS['CFG']->dbuser, $GLOBALS['CFG']->dbpassword, $GLOBALS['CFG']->dbname, 3306);
        
        if ($conection_mysqli->connect_error) {
            print_r($conection_mysqli->connect_error);
            return FALSE;
        }
        return $conection_mysqli;
    }


    public function __construct() {
       try {
        $dsn = "mysql:host={$GLOBALS['CFG']->dbhost};"
            . "dbname={$GLOBALS['CFG']->dbname}";
        $this->connection = new PDO($dsn
                    ,$GLOBALS['CFG']->dbuser
                    ,$GLOBALS['CFG']->dbpassword
                );
       } catch (PDOException $e){
           ErrorHandler::register($e);
           echo ErrorHandler::getErrorMessage($e);
          die();
       }
       $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    }
    
    public function getErrorMessage(){
        return $this->errorMessage;
    }

    public function executeQuery($query){   
        try{
            $data = $this->connection->query($query, PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            ErrorHandler::register($e);
           $this->errorMessage = ErrorHandler::getErrorMessage($e);
            return false;
        }
        return $data;
    }
    
    public function execute($statement){
        $rows = 0;
        try {
            $rows = $this->connection->exec($statement);
        } catch (PDOException $e) {
            ErrorHandler::register($e);
           $this->errorMessage = ErrorHandler::getErrorMessage($e);
            return false;
        }
        return [
            'rows' => $rows,
            'lastInsertId' => $this->connection->lastInsertId(),
        ];
    }
    
    public function executePreparedStatement($statement, $parameters){
        try{
            $ps = $this->connection->prepare($statement);
            $ps->execute($parameters);
        } catch (PDOException $e){
            ErrorHandler::register($e);
            $this->errorMessage = ErrorHandler::getErrorMessage($e);
            return FALSE;
        }
        return [
            'rows' => $ps->rowCount(),
            'id' => $this->connection->lastInsertId()
        ];
    }
    
    public function multiQuery($query){
        if (FALSE === $connection = $this->setConnection_mysqli()){
            return FALSE;
        }
        $arrayResult = [];
        $index = 0;
        if ($connection->multi_query($query)) {
            do {
                /* almacenar primer juego de resultados */
                if ($result = $connection->store_result()) {
                    while ($row = $result->fetch_row()) {
                        $arrayResult[$index][] = $row;
                    }
                    $result->free();
                }
                /* Si existe otro resultado, crear un nuevo índice para el array */
                if ($connection->more_results()) {
                    $index++;
                }
            } while ($connection->next_result());
        }

        /* cerrar conexión */
        $connection->close();
        return $arrayResult;
    }
    
}

#$connection = new connection();

#Modelo se Select
//if (!$data = $connection->executeQuery("SELECT * FROM empresas")){
//    echo "Error " , var_dump($data);
//}

//
//foreach ($data as $item){
//    echo $item['empresa'];
//    echo $item['nombre'];
//    echo '----<br>';
//}

#Modelo de Insert
//$statement = "INSERT INTO empresa SET nombre='Tienda de la esquina'";
//
//if (FALSE === $result = $connection->execute($statement)){
//    echo $connection->getErrorMessage();
//} else {
//    echo "Registro creado con código: ". $result['lastInsertId'] ;
//}

#Modelo de Update
//$statement = "UPDATE empresa "
//        . "SET nombre= 'Tienda corazón' "
//        . "WHERE empresa = 20";
//
//if (FALSE === $result = $connection->execute($statement)){
//    echo $connection->getErrorMessage();
//} else {
//    echo "Filas actualizadas: ". $result['rows'] ;
//}

#Modelo de Delete
//$statement = "DELETE FROM empresa WHERE empresa = 24";
//if (FALSE === $result = $connection->execute($statement)){
//    echo $connection->getErrorMessage();
//} else {
//    echo "Filas actualizadas: ". $result['rows'] ;
//}

#Modelo de multiQuery
//$statement = "call multiquery();";
//#$statement = "select now();";
//if (FALSE === $result = $connection->multiQuery($statement)){
//    echo 'Error';
//    echo $connection->getErrorMessage();
//} else {
//    echo 'OK';
//    echo '<pre>';
//    #foreach ($result as $data){
//        print_r($result);
//    #}
//}