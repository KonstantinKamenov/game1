<?php

namespace Model\Services;

use Model\Repository\UserRepository;

class UserService{
    
    public function registerUser($username, $password){
        $result = ['success' => false];
        $repo = new UserRepository();
        if($repo->getUserByName($username)){
            return result;
        }
        if($repo->insertUser($username, $password)){
            $result['success']=true;
        }
        return $result;
    }
    
}