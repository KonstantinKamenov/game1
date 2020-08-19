<?php
namespace Model\Repository;

class CombatRepository
{

    public function insertCombat($user_id, $characters, $enemies, $turn_order, $turn)
    {
        $conn = DBManager::getInstance()->getConnection();

        $query = 'INSERT INTO `combats` (`user_id`, `characters`, `enemies`, `turn_order`, `turn`)
                VALUES (:user_id, :characters, :enemies, :turn_order, :turn)';

        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'characters' => $characters,
            'enemies' => $enemies,
            'turn_order' => $turn_order,
            'turn' => $turn
        ]);
    }
    public function updateCombat($user_id, $characters, $enemies, $turn_order, $turn)
    {
        $conn = DBManager::getInstance()->getConnection();
        
        $query = 'UPDATE `combats`
                SET `characters` = :characters, `enemies` = :enemies, `turn_order` = :turn_order, `turn` = :turn
                WHERE `user_id` = :user_id';
        
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'characters' => $characters,
            'enemies' => $enemies,
            'turn_order' => $turn_order,
            'turn' => $turn
        ]);
    }
    public function getCombatByUserID($user_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `combats`
                    WHERE `user_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function deleteCombatByUserID($user_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'DELETE
                    FROM `combats`
                    WHERE `user_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id
        ]);
        return;
    }

    public function getClassSpells($class)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `class_spell_map`
                    JOIN `classes`
                    ON `class_spell_map`.class_id = `classes`.class_id
                    JOIN `spells`
                    ON `class_spell_map`.spell_id = `spells`.spell_id
                    WHERE `classes`.name = :class_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'class_id' => $class
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function getSpellByID($spell_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `spells`
                    WHERE `spell_id` = :spell_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'spell_id' => $spell_id
        ]);

        $result = $statement->fetch();
        return $result;
    }
    public function getEnemySpells($enemy_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `enemy_spell_map`
                    JOIN `spells`
                    ON `enemy_spell_map`.spell_id = `spells`.spell_id
                    WHERE `enemy_spell_map`.enemy_id = :enemy_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'enemy_id' => $enemy_id
        ]);
        
        $result = $statement->fetchAll();
        return $result;
    }
    public function changeTurn($user_id,$turn){
        $conn = DBManager::getInstance()->getConnection();
        
        $query = 'UPDATE `combats`
                SET `turn` = :turn
                WHERE `user_id` = :user_id';
        
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'turn' => $turn
        ]);
    }
}