<?php
namespace Model\Repository;

class InventoryRepository
{

    public function getItems($user_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `inventory_items`
                    JOIN `items`
                    ON `inventory_items`.item_id = `items`.item_id
                    WHERE `owner_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id
        ]);

        $result = $statement->fetchAll();

        return $result;
    }

    public function getItemCount($user_id, $item_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `inventory_items`
                    JOIN `items`
                    ON `inventory_items`.item_id = `items`.item_id
                    WHERE `owner_id` = :user_id
                    AND `items`.`item_id` = :item_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id,
            'item_id' => $item_id
        ]);

        $result = $statement->fetch();

        return $result;
    }
    
    public function insertItem($user_id,$item_id){
        $conn = DBManager::getInstance()->getConnection();
        
        $query = 'INSERT INTO `INVENTORY_ITEMS` (`owner_id`, `item_id`, `quantity`)
                VALUES (:user_id, :item_id, 0)';
        
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'item_id' => $item_id
        ]);
    }

    public function changeItemCount($user_id, $item_id, $count)
    {
        if ($count == 0) {
            $conn = DBManager::getInstance()->getConnection();
            $query = 'DELETE
                    FROM `inventory_items`
                    WHERE `owner_id` = :user_id
                    AND `item_id` = :item_id';
            $statement = $conn->prepare($query);
            $statement->execute([
                'user_id' => $user_id,
                'item_id' => $item_id
            ]);
        } else {
            $conn = DBManager::getInstance()->getConnection();

            $query = 'UPDATE `inventory_items`
                SET `quantity` = :count
                WHERE `owner_id` = :user_id
                AND `item_id` = :item_id';

            $stmt = $conn->prepare($query);
            return $stmt->execute([
                'user_id' => $user_id,
                'item_id' => $item_id,
                'count' => $count
            ]);
        }
    }

    public function getGold($user_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT gold
                    FROM `users`
                    WHERE `user_id` = :user_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'user_id' => $user_id
        ]);

        $result = $statement->fetch();

        return $result;
    }

    public function changeGold($user_id, $gold)
    {
        $conn = DBManager::getInstance()->getConnection();

        $query = 'UPDATE `users`
                SET `gold` = :gold
                WHERE `user_id` = :user_id';

        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'gold' => $gold
        ]);
    }
}