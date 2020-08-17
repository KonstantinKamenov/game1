<?php

namespace Model\Repository;

class EnemyRepository{
    public function getAllEnemies(){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `enemies`';
        $statement = $conn->prepare($query);
        $statement->execute();
        
        $result = $statement->fetchAll();
        return $result;
    }
    public function getEnemyByID($enemy_id){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `enemies`
                    WHERE `enemy_id` = :enemy_id';
        $statement = $conn->prepare($query);
        $statement->execute(['enemy_id'=>$enemy_id]);
        
        $result = $statement->fetchAll();
        return $result;
    }
}