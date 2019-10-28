<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Mauricio Zárate
 */

require_once $GLOBALS['CFG']->path . 'class/Connection.php';
require_once $GLOBALS['CFG']->path . 'class/ErrorHandler.php';

class User {
    const TABLE_NAME = 'users';
    private $id;
    private $user;
    private $email;
    private $passsword;
    private $activo;
    
    private $errorMessage = '';
    
    public function setUser(string $value){
        $this->user = $value;
    }
    public function setPassword(string $value){
        $this->passsword = $value;
    }
    public function setEmail(string $value){
        $this->email = $value;
    }
    public function setActivo(bool $value){
        $this->activo = $value;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getUser(){
        return $this->user;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->passsword;
    }
    public function getActivo(){
        return $this->activo;
    }
    
    public function getErrorMessage(){
        return $this->errorMessage();
    }
    
    protected function getData(string $id){
        $connection = new Connection();
        $query = "SELECT u.id, u.user"
                . ", u.activo "
                . ", u.email "
                . ", u.password "
                . "FROM " . self::TABLE_NAME ." e "
                . "WHERE u.id = $id ;";
        
        $data = $connection->executeQuery($query);
        if (FALSE == $data){
            $this->errorMessage = $connection->getErrorMessage();
            return FALSE;
        }
        
        foreach ($data as $value) {
            $this->id = $value['id'];
            $this->user = $value['user'];
            $this->email = $value['email'];
            $this->password = $value['password']; 
            $this->errorMessage = '';
        }
    }
    
    protected function getByUser(string $user){
        $connection = new Connection();
        $query = "SELECT u.id, u.user"
                . ", u.activo "
                . ", u.email "
                . ", u.password "
                . " FROM " . self::TABLE_NAME ." u "
                . " WHERE u.user = '$user' "
                . " AND u.activo = TRUE;";
        if (FALSE === $data = $connection->executeQuery($query)){
            $this->errorMessage = $connection->getErrorMessage();
            return FALSE;
        }
        foreach ($data as $value) {
            $this->id = $value['id'];
            $this->user = $value['user'];
            $this->email = $value['email'];
            $this->password = $value['password']; 
            $this->errorMessage = '';
        }
    }
    
    protected function validatePassword(string $password){
        $connection = new Connection();
        $query = "SELECT COUNT(id) as result FROM " . self::TABLE_NAME 
                . " WHERE user = '{$this->user}' "
                . " AND password = '$password' ;";
        
        if (FALSE === $result = $connection->executeQuery($query)){
            $this->errorMessage = $connection->getErrorMessage();
            return FALSE;
        }
        foreach ($result as $value){
            $passwordCorrect = $value['result'];
        }
        
        if ($passwordCorrect == 0){
            return FALSE;
        }
        
        return TRUE;
    }
    
}
