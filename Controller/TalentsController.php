<?php
namespace Controller;

use Model\Services\InventoryService;
use Model\Services\CharacterService;
use Model\Services\TalentService;

class TalentsController
{
    
    public function load()
    {
        require ("View/TalentView.php");
    }
    
    public function getTalents(){
        $character_id = $_POST['character_id'];
        $service = new TalentService();
        $result = $service->getCharacterTalents($character_id);
        echo json_encode($result);
    }
    
    public function resetTalents(){
        $character_id = $_POST['character_id'];
        $service = new TalentService();
        $service->resetTalents($character_id);
    }
    
    public function levelTalent(){
        $character_id = $_POST['character_id'];
        $talent = $_POST['talent'];
        $service = new TalentService();
        $service->levelTalent($character_id, $talent);
    }
    
}