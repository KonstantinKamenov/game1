<?php
namespace Model\Repository;

class LocationRepository
{
    
    public function getAllLocations()
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `zones`';
        $statement = $conn->prepare($query);
        $statement->execute();
        
        $result = $statement->fetchAll();
        return $result;
    }
    
}