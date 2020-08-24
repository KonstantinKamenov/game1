<?php

namespace Model\Services;

use Model\Repository\InventoryRepository;

class InventoryService{
    
    public function getItems($user_id){
        $repo = new InventoryRepository();
        $items = $repo->getItems($user_id);
        $result['items']=$items;
        return $result;
    }
    
    public function getGold($user_id){
        $repo = new InventoryRepository();
        $gold = $repo->getGold($user_id)['gold'];
        $result['gold'] = $gold;
        return $result;
    }
    
}