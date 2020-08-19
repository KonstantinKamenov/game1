<?php
namespace Model\Repository;

class CharacterRepository
{

    public function getClass($class)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `classes`
                    WHERE `name` = :class';
        $statement = $conn->prepare($query);
        $statement->execute([
            'class' => $class
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function getCharactersByUserID($user_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `characters`
                    WHERE `owner_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function getCharacter($user_id, $name)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `characters`
                    WHERE `owner_id` = :user_id
                    AND `name` = :name';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id,
            'name' => $name
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function getCharacterByID($character_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `characters`
                    WHERE `character_id` = :character_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'character_id' => $character_id
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function addCharacter($user_id, $name, $class)
    {
        $template = $this->getClass($class)[0];

        $conn = DBManager::getInstance()->getConnection();

        $query = 'INSERT INTO `characters` (`owner_id`, `name`, `class`, `health`, `attack`, `magic_attack`, `movement_speed`)
                VALUES (:user_id, :name, :class, :health, :attack, :magic_attack, :movement_speed)';

        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'name' => $name,
            'class' => $class,
            'health' => $template['health'],
            'attack' => $template['attack'],
            'magic_attack' => $template['magic_attack'],
            'movement_speed' => $template['speed']
        ]);
    }
}