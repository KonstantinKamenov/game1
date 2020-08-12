<?php

namespace Controller;

use Model\Services\EnemyService;

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
}