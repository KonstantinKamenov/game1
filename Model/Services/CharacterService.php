<?php

namespace Model\Services;

use Model\Repository\CharacterRepository;

class CharacterService{
    
    public function getCharacters($user_id){
        $repo = new CharacterRepository();
        $characters = $repo->getCharactersByUserID($user_id);
        $result['characters']=$characters;
        return $result;
    }
    
    public function addCharacter($user_id,$name,$class){
        $result = ['success' => false];
        $repo = new CharacterRepository();
        if($repo->getCharacter($user_id,$name)){
            return $result;
        }
        if($repo->addCharacter($user_id,$name,$class)){
            $result['success']=true;
        }
        $result['character']=$repo->getCharacter($user_id,$name);
        return $result;
    }
    
}