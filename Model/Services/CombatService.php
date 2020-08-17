<?php

namespace Model\Services;

use Model\Repository\CharacterRepository;
use Model\Repository\EnemyRepository;
use Model\Repository\CombatRepository;

class CombatService{
    
    public function initCombat($characters,$enemies){
        $characterField=json_decode($characters);
        $enemyField=json_decode($enemies);
        $characterRepo=new CharacterRepository();
        $enemyRepo=new EnemyRepository();
        $cnt=0;
        for($y=0;$y<4;$y++){
            for($x=0;$x<4;$x++){
                if($characterField[$x][$y]!=0){
                    $loadedCharacters[$cnt]=$characterRepo->getCharacterByID($characterField[$x][$y])[0];
                    $loadedCharacters[$cnt]['x']=$x;
                    $loadedCharacters[$cnt]['y']=$y;
                    $loadedCharacters[$cnt]['id']=$cnt+1;
                    $cnt++;
                }
            }
        }
        $charCnt=$cnt;
        $cnt=0;
        for($y=0;$y<4;$y++){
            for($x=0;$x<4;$x++){
                if($enemyField[$x][$y]!=0){
                    $loadedEnemies[$cnt]=$enemyRepo->getEnemyByID($enemyField[$x][$y])[0];
                    $loadedEnemies[$cnt]['id']=$cnt+$charCnt+1;
                    $loadedEnemies[$cnt]['x']=$x;
                    $loadedEnemies[$cnt]['y']=$y;
                    $cnt++;
                }
            }
        }
        $combatRepo=new CombatRepository();
        for($i=1;$i<=$cnt;$i++){
            $turn_order[]=$i;
        }
        $user_id=$_COOKIE['user_id'];
        if($combatRepo->getCombatByUserID($user_id)){
            $combatRepo->deleteCombatByUserID($user_id);
        }
        //var_dump(json_encode($loadedCharacters));
        //var_dump(json_encode($loadedEnemies));
        $combatRepo->insertCombat($user_id, json_encode($loadedCharacters), json_encode($loadedEnemies), json_encode($turn_order), 0);
    }
    public function getState(){
        $repo = new CombatRepository();
        $state=$repo->getCombatByUserID($_COOKIE['user_id'])[0];
        //var_dump($state);
        return $state;
    }
}