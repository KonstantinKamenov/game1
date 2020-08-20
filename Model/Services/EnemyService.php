<?php

namespace Model\Services;

use Model\Repository\EnemyRepository;

class EnemyService{
    
    public function getEnemies($zone_id){
        $repo = new EnemyRepository();
        $enemies = $repo->getEnemiesByZone($zone_id);
        $result['enemies']=$enemies;
        return $result;
    }
    
}