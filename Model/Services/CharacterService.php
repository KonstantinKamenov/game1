<?php
namespace Model\Services;

use Model\Repository\CharacterRepository;
use Model\Repository\InventoryRepository;

class CharacterService
{

    const ARMOR_SLOTS = [
        "helm",
        "chest",
       "weapon"
    ];
    const CLASSES = [
        "Mage" => 1,
        "Warrior" => 2,
        "Marksman" => 3,
        "Priest" => 4,
        "Rogue" => 5
    ];

    public function getCharacters($user_id)
    {
        $repo = new CharacterRepository();
        $characters = $repo->getCharactersByUserID($user_id);
        $result['characters'] = $characters;
        return $result;
    }

    public function getCharacter($character_id)
    {
        $repo = new CharacterRepository();
        $result = $repo->getCharacterByID($character_id);
        return $result;
    }

    public function addCharacter($user_id, $name, $class)
    {
        $result = [
            'success' => false
        ];
        $repo = new CharacterRepository();
        if ($repo->getCharacter($user_id, $name)) {
            return $result;
        }
        if ($repo->addCharacter($user_id, $name, $class)) {
            $result['success'] = true;
        }
        $result['character'] = $repo->getCharacter($user_id, $name);
        return $result;
    }

    public function evaluateCharacter($character_id)
    {
        $charRepo = new CharacterRepository();
        $invRepo = new InventoryRepository();
        $character = $charRepo->getCharacterByID($character_id);
        foreach (self::ARMOR_SLOTS as $slot) {
            if ($character[$slot] != 0) {
                $armor = $invRepo->getArmor($character[$slot]);
                $character['health'] += $armor['health'];
                $character['attack'] += $armor['attack'];
                $character['magic_attack'] += $armor['magic_attack'];
                $character['movement_speed'] += $armor['speed'];
            }
        }
        $talentService = new TalentService();
        $talents = $talentService->getTalentRanks($character_id);
        $character['attack']+=$talents['attack boost']*8;
        $character['magic_attack']+=$talents['magic boost']*8;
        $character['health']+=$talents['health boost']*25;
        return $character;
    }

    public function getArmor($character_id)
    {
        $character = $this->getCharacter($character_id);
        $invRepo = new InventoryRepository();
        foreach (CharacterService::ARMOR_SLOTS as $slot) {
            $result[$slot] = $invRepo->getArmor($character[$slot]);
        }
        return $result;
    }
    
    public function unequipItem($character_id, $slot){
        $character = $this->getCharacter($character_id);
        if($character[$slot]==0)return;
        $item_id = $character[$slot];
        $user_id = $_SESSION['user_id'];
        $invRepo = new InventoryRepository();
        $invRepo->changeArmor($character_id, $slot, 0);
        $item = $invRepo->getItemCount($user_id, $item_id);
        if(!$item){
            $invRepo->insertItem($user_id, $item_id);
            $item = $invRepo->getItemCount($user_id, $item_id);
        }
        $invRepo->changeItemCount($user_id, $item_id, $item['quantity']+1);
    }
    public function equipItem($character_id, $slot, $item_id){
        $user_id = $_SESSION['user_id'];
        $invRepo = new InventoryRepository();
        $armor = $invRepo->getArmor($item_id);
        if(!$armor || $armor['slot']!=$slot)return;
        $invRepo->changeArmor($character_id, $slot, $item_id);
        $item = $invRepo->getItemCount($user_id, $item_id);
        $invRepo->changeItemCount($user_id, $item_id, $item['quantity']-1);
    }
}