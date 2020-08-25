<?php
namespace Model\Repository;

class CraftingRepository
{

    public function getRecipes()
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `recipes`
                    JOIN `items` ON `recipes`.item_id = `items`.item_id';
        $statement = $conn->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public function getRecipe($recipe_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `recipes`
                    WHERE `recipe_id` = :recipe_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'recipe_id' => $recipe_id
        ]);

        $result = $statement->fetch();

        return $result;
    }

    public function getIngredients($recipe_id)
    {
        $conn = DBManager::getInstance()->getConnection();
        $query = 'SELECT *
                    FROM `recipes_ingredients`
                    JOIN `items` ON `items`.item_id = `recipes_ingredients`.ingredient_id
                    WHERE `recipe_id` = :recipe_id';
        $statement = $conn->prepare($query);
        $statement->execute([
            'recipe_id' => $recipe_id
        ]);

        $result = $statement->fetchAll();

        return $result;
    }
}