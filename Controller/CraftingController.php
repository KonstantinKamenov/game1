<?php
namespace Controller;

use Model\Services\CraftingService;

class CraftingController
{

    public function load()
    {
        require ("View/CraftingView.php");
    }

    public function getRecipes()
    {
        $service = new CraftingService();
        $result = $service->getRecipes();
        echo json_encode($result);
    }

    function craftItem()
    {
        $recipe_id = $_POST['recipe_id'];
        $service = new CraftingService();
        $service->craftItem($recipe_id);
    }
}