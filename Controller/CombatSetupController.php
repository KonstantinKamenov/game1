<?php

namespace Controller;

use Model\Services\EnemyService;
use Model\Services\CharacterService;

class CombatSetupController
{
    public function home()
    {
        require("View/CombatSetupView.html");
    }
    public function loadEnemies(){
        $service = new EnemyService();
        $result = $service->getEnemies($_SESSION['zone_id']);
        //var_dump($result);
        echo json_encode($result);
    }
    public function loadCharacters(){
        $service = new CharacterService();
        $result = $service->getCharacters($_SESSION['user_id']);
        echo json_encode($result);
    }
}