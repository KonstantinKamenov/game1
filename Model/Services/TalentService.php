<?php
namespace Model\Services;

use Model\Repository\TalentRepository;
use Model\Repository\CharacterRepository;

class TalentService
{
    
    const TALENTS_RESET = "0, 0, 0, 0, 0, 0, 0, 0, 0, 0";

    public function getTalents($class_id)
    {
        $repo = new TalentRepository();
        $result = $repo->getTalents($class_id);
        return $result;
    }

    public function getTalentRanks($character_id)
    {
        $charRepo = new CharacterRepository();
        $character = $charRepo->getCharacterByID($character_id);
        $talents = $this->getTalents(CharacterService::CLASSES[$character['class']]);
        $talentLevels = explode(',', $character['talents']);
        foreach ($talents as $talent) {
            $result[$talent['name']] = $talentLevels[$talent['ind']];
        }
        return $result;
    }

    public function getCharacterTalents($character_id)
    {
        $charRepo = new CharacterRepository();
        $character = $charRepo->getCharacterByID($character_id);
        $talents = $this->getTalents(CharacterService::CLASSES[$character['class']]);
        $talentLevels = explode(',', $character['talents']);
        for ($i = 0; $i < count($talents); $i ++) {
            $talents[$i]['rank'] = $talentLevels[$talents[$i]['ind']];
        }
        return $talents;
    }
    
    public function resetTalents($character_id){
        $talentRepo = new TalentRepository();
        $talentRepo->setTalents($character_id, self::TALENTS_RESET);
    }
    
    public function levelTalent($character_id,$talent){
        $charRepo = new CharacterRepository();
        $talentRepo = new TalentRepository();
        $character = $charRepo->getCharacterByID($character_id);
        $talents = $this->getTalents(CharacterService::CLASSES[$character['class']]);
        $talentLevels = explode(', ', $character['talents']);
        if($talentLevels[$talent]<$talents[$talent]['max_rank']){
            $talentLevels[$talent]++;
        }
        if($talents[$talent]['requirement']!=0 && $talentLevels[$talents[$talent]['requirement']]<$talents[$talents[$talent]['requirement']]['max_rank']){
            return;
        }
        $talentLevels = implode(', ', $talentLevels);
        $talentRepo->setTalents($character_id, $talentLevels);
    }
    
}