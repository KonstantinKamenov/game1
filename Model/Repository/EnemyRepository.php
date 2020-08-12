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
}