<?php
namespace Controller;

use Model\Services\InventoryService;
use Model\Services\ShopService;

class ShopController
{
    
    public function load()
    {
        require ("View/ShopView.php");
    }
    
    public function getItems(){
        $service = new InventoryService();
        $result = $service->getItems($_SESSION['user_id']);
        echo json_encode($result);
    }
    
    public function getGold(){
        $service = new InventoryService();
        $result = $service->getGold($_SESSION['user_id']);
        echo json_encode($result);
    }
    
    public function getSellOffers(){
        $service = new ShopService();
        $result = $service->getSellOffers($_SESSION['zone_id']);
        echo json_encode($result);
    }
    
    public function getBuyOffers(){
        $service = new ShopService();
        $result = $service->getBuyOffers($_SESSION['zone_id']);
        echo json_encode($result);
    }
    
    public function sellItem(){
        $item_id = $_POST['item_id'];
        $service = new ShopService();
        $service->sellItem($item_id,$_SESSION['user_id'],$_SESSION['zone_id']);
    }
    
    public function buyItem(){
        $item_id = $_POST['item_id'];
        $service = new ShopService();
        $service->buyItem($item_id,$_SESSION['user_id'],$_SESSION['zone_id']);
    }
    
}