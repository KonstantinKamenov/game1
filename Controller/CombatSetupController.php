<?php

namespace Controller;

use Model\Services\EnemyService;
use Model\Services\CharacterService;

class CombatSetupController
{
    public function home()
    {
        echo file_get_contents("View/CombatSetupView.html");
    }
    public function loadEnemies(){
        $service = new EnemyService();
        $result = $service->getEnemies();
        //var_dump($result);
        echo json_encode($result);
    }
    public function loadCharacters(){
        $service = new CharacterService();
        $result = $service->getCharacters($_COOKIE['user_id']);
        echo json_encode($result);
    }
}