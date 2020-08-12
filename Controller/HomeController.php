<?php

namespace Controller;

use Model\Services\UserService;

class HomeController
{
    public function home()
    {
        echo file_get_contents("View/HomeView.php");
    }
    
    public function register(){
        $service = new UserService();
        
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        $result=$service->registerUser($username, $password);
        if($result['success']){
            echo file_get_contents("View/CombatSetupView.html");
        }
    }
    
    public function login(){
        
    }
}