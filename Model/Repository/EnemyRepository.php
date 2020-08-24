<?php
namespace Model\Repository;

class EnemyRepository
{

    public function getAllEnemies()
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `enemies`';
        $statement = $conn->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }

    public function getLoot($enemy_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `loot_table`
                    WHERE `enemy_id` = :enemy_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'enemy_id' => $enemy_id
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function getEnemyByID($enemy_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `enemies`
                    WHERE `enemy_id` = :enemy_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'enemy_id' => $enemy_id
        ]);

        $result = $statement->fetch();
        return $result;
    }
    
    public function getEnemiesByZone($zone_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `zone_enemy_map`
                    JOIN `enemies`
                    ON `zone_enemy_map`.enemy_id = `enemies`.enemy_id
                    WHERE `zone_id` = :zone_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'zone_id' => $zone_id
        ]);
        
        $result = $statement->fetchAll();
        return $result;
    }
    
}