<?php

namespace Model\Services;

use Model\Repository\EnemyRepository;

class EnemyService{
    
    public function getEnemies(){
        $repo = new EnemyRepository();
        $enemies = $repo->getAllEnemies();
        $result['enemies']=$enemies;
        return $result;
    }
    
}