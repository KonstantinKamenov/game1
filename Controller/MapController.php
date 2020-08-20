<?php
namespace Controller;

use Model\Services\LocationService;

class MapController
{
    
    public function load()
    {
        require ("View/MapView.php");
    }
    
    public function getLocations(){
        $service = new LocationService();
        $result = $service->getLocations();
        echo json_encode($result);
    }
    
    public function changeLocation(){
        $zone_id=$_POST['zone_id'];
        $service = new LocationService();
        $service->changeLocation($zone_id);
    }
    
}