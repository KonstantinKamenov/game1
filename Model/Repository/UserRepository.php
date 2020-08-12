<?php

namespace Model\Repository;

class UserRepository{
    public function getUserByName($name){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `users`
                    WHERE `username` = :name';
        $statement = $conn->prepare($query);
        $statement->execute(['name'=>$name]);
        
        $result = $statement->fetchAll();
        return $result;
    }
    public function insertUser($username,$password){
        $conn = DBManager::getInstance()->getConnection();
        
        $query = 'INSERT INTO `users` (`username`, `password`)
                VALUES (:username, :password)';
        
        $stmt = $conn->prepare($query);
        return $stmt->execute(['username'=>$username,'password'=>$password]);
    }
}