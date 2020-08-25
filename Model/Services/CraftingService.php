<?php
namespace Model\Services;

use Model\Repository\CraftingRepository;
use Model\Repository\InventoryRepository;

class CraftingService
{

    public function getRecipes()
    {
        $craftingRepo = new CraftingRepository();
        $recipes = $craftingRepo->getRecipes();
        for ($i = 0; $i < count($recipes); $i ++) {
            $ingredients = $craftingRepo->getIngredients($recipes[$i]['recipe_id']);
            $recipes[$i]['ingredients'] = $ingredients;
        }
        return $recipes;
    }
    
    public function craftItem($recipe_id){
        $craftingRepo = new CraftingRepository();
        $recipe = $craftingRepo->getRecipe($recipe_id);
        $ingredients = $craftingRepo->getIngredients($recipe_id);
        $invRepo = new InventoryRepository();
        $user_id = $_SESSION['user_id'];
        foreach ($ingredients as $ingr){
            $item = $invRepo->getItemCount($user_id, $ingr['ingredient_id']);
            if(!$item || $item['quantity']<$ingr['quantity'])return;
        }
        $crafted = $invRepo->getItemCount($user_id, $recipe['item_id']);
        if(!$crafted){
            $invRepo->insertItem($user_id, $recipe['item_id']);
            $item = $invRepo->getItemCount($user_id, $recipe['item_id']);
        }
        $invRepo->changeItemCount($user_id, $recipe['item_id'], $crafted['quantity']+1);
        foreach ($ingredients as $ingr){
            $item = $invRepo->getItemCount($user_id, $ingr['ingredient_id']);
            $invRepo->changeItemCount($user_id, $ingr['ingredient_id'], $item['quantity']-$ingr['quantity']);
        }
    }
}