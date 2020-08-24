<?php

namespace Model\Services;

use Model\Repository\EnemyRepository;
use Model\Repository\InventoryRepository;

class EnemyService{
    
    public function getEnemies($zone_id){
        $repo = new EnemyRepository();
        $enemies = $repo->getEnemiesByZone($zone_id);
        $result['enemies']=$enemies;
        return $result;
    }
    
    public function dropGold($enemy_id,$user_id){
        $repo = new EnemyRepository();
        $enemy = $repo->getEnemyByID($enemy_id);
        $goldDrop=rand($enemy['gold_min'],$enemy['gold_max']);
        $invRepo = new InventoryRepository();
        $gold = $invRepo->getGold($user_id)['gold'];
        $invRepo->changeGold($user_id, $gold+$goldDrop);
    }
    
    public function dropItems($enemy_id, $user_id){
        $repo = new EnemyRepository();
        $itemDrops=$repo->getLoot($enemy_id);
        $invRepo = new InventoryRepository();
        foreach($itemDrops as $drop){
            $item = $invRepo->getItemCount($user_id, $drop['item_id']);
            if(!$item){
                $invRepo->insertItem($user_id, $drop['item_id']);
                $item = $invRepo->getItemCount($user_id, $drop['item_id']);
            }
            $count=0;
            for($i=0;$i<$drop['count'];$i++){
                $roll=rand(1,100);
                if($roll<=$drop['chance']){
                    $count++;
                }
            }
            $invRepo->changeItemCount($user_id, $drop['item_id'], $item['quantity']+$count);
        }
    }
    
}