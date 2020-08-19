<?php
namespace Controller;

use Model\Services\CombatService;

class CombatController
{

    public function initCombat()
    {
        $characters = $_POST['characters'];
        $enemies = $_POST['enemies'];
        $service = new CombatService();
        $service->initCombat($characters, $enemies);
        require ("View/CombatView.php");
    }
    public function endCombat(){
        require("View/CombatSetupView.html");
    }
    public function getState()
    {
        $service = new CombatService();
        $state = $service->getState();
        echo json_encode($state);
    }

    public function getTurn()
    {
        $service = new CombatService();
        $turn = $service->getTurn();
        echo json_encode($turn);
    }

    public function castSpell()
    {
        $x = $_POST['x'];
        $y = $_POST['y'];
        $field = $_POST['field'];
        $side = $_POST['side'];
        $spell = $_POST['spell'];
        $service = new CombatService();
        $result = $service->resolveSpell($x, $y, $field, $side, $spell);
        return $result;
    }

    public function enemyTurn()
    {
        $service = new CombatService();
        $result = $service->enemyTurn();
        return $result;
    }
}