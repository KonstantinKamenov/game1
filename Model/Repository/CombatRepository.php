<?php

namespace Model\Repository;

class CombatRepository{
    public function insertCombat($user_id,$characters,$enemies,$turn_order,$turn){
        $conn = DBManager::getInstance()->getConnection();
        
        $query = 'INSERT INTO `combats` (`user_id`, `characters`, `enemies`, `turn_order`, `turn`)
                VALUES (:user_id, :characters, :enemies, :turn_order, :turn)';
        
        $stmt = $conn->prepare($query);
        return $stmt->execute(['user_id'=>$user_id,'characters'=>$characters,'enemies'=>$enemies,'turn_order'=>$turn_order, 'turn'=>$turn]);
    }
    public function getCombatByUserID($user_id){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `combats`
                    WHERE `user_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute(['user_id'=>$user_id]);
        
        $result = $statement->fetchAll();
        return $result;
    }
    public function deleteCombatByUserID($user_id){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'DELETE
                    FROM `combats`
                    WHERE `user_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute(['user_id'=>$user_id]);
        return;
    }
}