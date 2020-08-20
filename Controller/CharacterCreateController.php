<?php

namespace Controller;

use Model\Services\CharacterService;

class CharacterCreateController
{
    public function home()
    {
        require ("View/CharacterCreateView.php");
    }
    public function createCharacter(){
        $service = new CharacterService();
        
        $name=$_POST['name'];
        $class=$_POST['class'];
        $user_id=$_SESSION['user_id'];
        
        if($name==""){
            $_POST['create_msg']="Name cannot be empty";
            require("View/CharacterCreateView.php");
            return;
        }
        
        $result = $service->addCharacter($user_id,$name,$class);
        
        if($result['success']){
            require("View/CombatSetupView.html");
        }else{
            $_POST['create_msg']="You already have a character with that name";
            require("View/CharacterCreateView.php");
        }
        
    }
}