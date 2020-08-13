<?php

namespace Model\Services;

use Model\Repository\UserRepository;

class UserService{
    
    public function registerUser($username, $password){
        $result = ['success' => false];
        $repo = new UserRepository();
        if($repo->getUserByName($username)){
            return $result;
        }
        if($repo->insertUser($username, $password)){
            $result['success']=true;
        }
        $result['user']=$repo->getUserByName($username);
        return $result;
    }
    
    public function checkUser($username, $password){
        $result = ['success' => false];
        $repo = new UserRepository();
        $user = $repo->getUserByName($username);
        if(!$user || !password_verify($password,$user[0]['password'])){
            return $result;
        }
        $result['success']=true;
        $result['user']=$user[0];
        return $result;
    }
    
}