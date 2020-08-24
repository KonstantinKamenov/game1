<?php
namespace Model\Repository;

class ShopRepository
{
    
    public function getSellOffers($zone_id){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `shop_offers`
                    JOIN `items`
                    ON `shop_offers`.item_id = `items`.item_id
                    WHERE `zone_id` = :zone_id
                    AND `sell` = 1';
        $statement = $conn->prepare($query);
        $statement->execute([
            'zone_id' => $zone_id
        ]);
        
        $result = $statement->fetchAll();
        
        return $result;
    }
    public function getOffer($item_id,$zone_id,$sell){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `shop_offers`
                    WHERE `item_id` = :item_id
                    AND `zone_id` = :zone_id
                    AND `sell` = :sell';
        $statement = $conn->prepare($query);
        $statement->execute([
            'item_id' => $item_id,
            'zone_id' => $zone_id,
            'sell' => $sell
        ]);
        
        $result = $statement->fetch();
        
        return $result;
    }
    public function getBuyOffers($zone_id){
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `shop_offers`
                    JOIN `items`
                    ON `shop_offers`.item_id = `items`.item_id
                    WHERE `zone_id` = :zone_id
                    AND `sell` = 0';
        $statement = $conn->prepare($query);
        $statement->execute([
            'zone_id' => $zone_id
        ]);
        
        $result = $statement->fetchAll();
        
        return $result;
    }
}