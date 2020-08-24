<?php
namespace Model\Repository;

class UserRepository
{

    public function getUserByName($name)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `users`
                    WHERE `username` = :name';
        $statement = $conn->prepare($query);
        $statement->execute([
            'name' => $name
        ]);

        $result = $statement->fetch();
        return $result;
    }

    public function insertUser($username, $password)
    {
        $conn = DBManager::getInstance()->getConnection();

        $query = 'INSERT INTO `users` (`username`, `password`)
                VALUES (:username, :password)';

        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);
    }

    public function changeLocation($zone_id, $user_id)
    {
        $conn = DBManager::getInstance()->getConnection();

        $query = 'UPDATE `users`
                SET `current_zone` = :zone_id
                WHERE `user_id` = :user_id';

        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'zone_id' => $zone_id,
            'user_id' => $user_id
        ]);
    }
}