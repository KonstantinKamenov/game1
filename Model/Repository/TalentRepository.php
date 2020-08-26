<?php
namespace Model\Repository;

class TalentRepository
{
    
    public function getTalents($class_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `talents`
                    WHERE `class_id` = :class_id OR `class_id` = 0';
        $statement = $conn->prepare($query);
        $statement->execute([
            'class_id' => $class_id
        ]);
        
        $result = $statement->fetchAll();
        return $result;
    }
    public function setTalents($character_id, $talents)
    {
        $conn = DBManager::getInstance()->getConnection();
        
        $query = 'UPDATE `characters`
                SET `talents` = :talents
                WHERE `character_id` = :character_id';
        
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'character_id' => $character_id,
            'talents' => $talents
        ]);
    }
}