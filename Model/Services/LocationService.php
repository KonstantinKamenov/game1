<?php

namespace Model\Services;

use Model\Repository\LocationRepository;
use Model\Repository\UserRepository;

class LocationService{
    
    public function getLocations(){
        $repo = new LocationRepository();
        $zones = $repo->getAllLocations();
        $result['zones']=$zones;
        $result['current']=$_SESSION['zone_id'];
        return $result;
    }
    
    public function changeLocation($zone_id){
        $_SESSION['zone_id']=$zone_id;
        $repo = new UserRepository();
        $repo->changeLocation($zone_id, $_SESSION['user_id']);
    }
    
}