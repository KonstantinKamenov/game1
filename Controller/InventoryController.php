<?php
namespace Controller;

use Model\Services\InventoryService;
use Model\Services\CharacterService;

class InventoryController
{
    
    public function load()
    {
        require ("View/InventoryView.php");
    }
    
    public function getItems(){
        $service = new InventoryService();
        $result = $service->getItems($_SESSION['user_id']);
        echo json_encode($result);
    }
    
    public function getCharactersInventory(){
        $character_id = $_POST['character_id'];
        $service = new CharacterService();
        $result = $service->getArmor($character_id);
        echo json_encode($result);
    }
    
    public function unequipItem(){
        $character_id = $_POST['character_id'];
        $slot=$_POST['slot'];
        $service = new CharacterService();
        $service->unequipItem($character_id, $slot);
    }
    public function equipItem(){
        $character_id = $_POST['character_id'];
        $slot=$_POST['slot'];
        $item_id = $_POST['item_id'];
        $service = new CharacterService();
        $service->equipItem($character_id, $slot, $item_id);
    }
    
}