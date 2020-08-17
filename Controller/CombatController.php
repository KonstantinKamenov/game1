<?php

namespace Controller;

use Model\Services\CombatService;

class CombatController
{
    public function initCombat(){
        $characters=$_POST['characters'];
        $enemies=$_POST['enemies'];
        $service = new CombatService();
        $service->initCombat($characters, $enemies);
        require("View/CombatView.php");
    }
    public function getState(){
        $service = new CombatService();
        $state=$service->getState();
        echo json_encode($state);
    }
}