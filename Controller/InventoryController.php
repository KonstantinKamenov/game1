<?php
namespace Controller;

use Model\Services\InventoryService;

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
    
}