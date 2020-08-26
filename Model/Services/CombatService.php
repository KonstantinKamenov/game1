<?php
namespace Model\Services;

use Model\Repository\CharacterRepository;
use Model\Repository\EnemyRepository;
use Model\Repository\CombatRepository;

class CombatService
{

    const MAX_WIDTH = 5;

    const MAX_HEIGHT = 5;

    const TARGET_TYPE_ENEMY = "enemy";

    const TARGET_TYPE_ENEMY_ANY = "enemy_any";

    const TARGET_TYPE_FRIENDLY_FREE = "free_friendly";

    const TARGET_TYPE_FRIENDLY = "friendly";

    public function initCombat($characters, $enemies)
    {
        $characterField = json_decode($characters);
        $enemyField = json_decode($enemies);
        //$characterRepo = new CharacterRepository();
        $charService = new CharacterService();
        $enemyRepo = new EnemyRepository();
        $cnt = 0;
        for ($y = 0; $y < self::MAX_HEIGHT; $y ++) {
            for ($x = 0; $x < self::MAX_WIDTH; $x ++) {
                if ($characterField[$x][$y] != 0) {
                    $loadedCharacters[$cnt] = $charService->evaluateCharacter($characterField[$x][$y]);
                    $loadedCharacters[$cnt]['x'] = $x;
                    $loadedCharacters[$cnt]['y'] = $y;
                    $loadedCharacters[$cnt]['id'] = $cnt + 1;
                    $cnt ++;
                }
            }
        }
        $charCnt = $cnt;
        $cnt = 0;
        for ($y = 0; $y < self::MAX_HEIGHT; $y ++) {
            for ($x = 0; $x < self::MAX_WIDTH; $x ++) {
                if ($enemyField[$x][$y] != 0) {
                    $loadedEnemies[$cnt] = $enemyRepo->getEnemyByID($enemyField[$x][$y]);
                    $loadedEnemies[$cnt]['id'] = $cnt + $charCnt + 1;
                    $loadedEnemies[$cnt]['x'] = $x;
                    $loadedEnemies[$cnt]['y'] = $y;
                    $cnt ++;
                }
            }
        }
        $combatRepo = new CombatRepository();
        for ($i = 1; $i <= $charCnt + $cnt; $i ++) {
            $turn_order[] = $i;
        }
        shuffle($turn_order);
        $user_id = $_SESSION['user_id'];
        if ($combatRepo->getCombatByUserID($user_id)) {
            $combatRepo->deleteCombatByUserID($user_id);
        }
        // var_dump(json_encode($loadedCharacters));
        // var_dump(json_encode($loadedEnemies));
        $combatRepo->insertCombat($user_id, json_encode($loadedCharacters), json_encode($loadedEnemies), json_encode($turn_order), 0);
    }

    public function getState()
    {
        $repo = new CombatRepository();
        $state = $repo->getCombatByUserID($_SESSION['user_id']);
        // var_dump($state);
        return $state;
    }

    public function advanceTurn()
    {
        $state = $this->getState();
        $turnInd = $state['turn'];
        $turnInd ++;
        $turns = json_decode($state['turn_order']);
        $all = array_merge(json_decode($state['characters'], true), json_decode($state['enemies'], true));

        var_dump($all);
        if ($turnInd >= count($turns)) {
            $turnInd = 0;
        }
        $turn = $turns[$turnInd];
        while ($all[$turn - 1]['health'] <= 0) {
            $turnInd ++;
            if ($turnInd >= count($turns)) {
                $turnInd = 0;
            }
            $turn = $turns[$turnInd];
        }
        return $turnInd;
    }

    public function getTurn()
    {
        $state = $this->getState();
        $turnNumber = json_decode($state['turn_order'])[$state['turn']];
        $characters = json_decode($state['characters'], true);
        $enemies = json_decode($state['enemies'], true);
        // var_dump($turnNumber);
        $turn['success'] = false;
        $turn['outcome'] = "ongoing";
        $deadChar = 0;
        $deadEnemies = 0;
        foreach ($characters as $char) {
            if ($char['health'] <= 0) {
                $deadChar ++;
            }
        }
        foreach ($enemies as $enemy) {
            if ($enemy['health'] <= 0) {
                $deadEnemies ++;
            }
        }
        if (count($enemies) - $deadEnemies == 0) {
            $turn['success'] = true;
            $turn['outcome'] = "victory";
            foreach ($enemies as $enemy) {
                $enemyService = new EnemyService();
                $enemyService->dropGold($enemy['enemy_id'], $_SESSION['user_id']);
                $enemyService->dropItems($enemy['enemy_id'], $_SESSION['user_id']);
            }
            return $turn;
        }
        if (count($characters) - $deadChar == 0) {
            $turn['success'] = true;
            $turn['outcome'] = "defeat";
            return $turn;
        }
        if ($turnNumber > count($characters)) {
            $turn['side'] = "enemy";
            $turnNumber -= count($characters);
            if ($enemies[$turnNumber - 1]['health'] <= 0) {
                // $this->advanceTurn();
                return $turn;
            }
        } else {
            $turn['side'] = "friendly";
            if ($characters[$turnNumber - 1]['health'] <= 0) {
                // $this->advanceTurn();
                return $turn;
            }
            $class = $characters[$turnNumber - 1]['class'];
            $repo = new CombatRepository();
            $spells = $repo->getClassSpells($class);
            $turn['spells'] = $spells;
        }
        $turn['error'] = json_decode($state['turn_order']);
        $turn['success'] = true;
        return $turn;
    }
    
    public function resolveSpell($x, $y, $field, $side, $spell_id)
    {
        $result = [
            'success' => false
        ];
        $repo = new CombatRepository();
        $spell = $repo->getSpellByID($spell_id);
        $attributes = $repo->getAttributes($spell['spell_id']);
        foreach ($attributes as $attr) {
            $spell[$attr['attribute_name']] = $attr['attribute_value'];
        }
        $combat = $repo->getCombatByUserID($_SESSION['user_id']);
        $all[0] = json_decode($combat['characters'], true);
        $all[1] = json_decode($combat['enemies'], true);
        $placement[0] = array_fill(0, self::MAX_HEIGHT, array_fill(0, self::MAX_WIDTH, 0));
        $placement[1] = array_fill(0, self::MAX_HEIGHT, array_fill(0, self::MAX_WIDTH, 0));
        $turn = json_decode($combat['turn_order'])[$combat['turn']];

        
        if ($turn > count($all[0])) {
            $turn -= count($all[0]);
        }
        foreach ($all[0] as $char) {
            $placement[0][$char['x']][$char['y']] = $char['id'];
        }
        foreach ($all[1] as $enemy) {
            $placement[1][$enemy['x']][$enemy['y']] = $enemy['id'] - count($all[0]);
        }
        // var_dump($charPlacement);
        if ($spell['target_type'] == self::TARGET_TYPE_ENEMY) {
            if ($field == $side || $placement[$field][$x][$y] == 0) {
                return $result;
            }
        }
        if ($spell['target_type'] == self::TARGET_TYPE_ENEMY_ANY) {
            if ($field == $side) {
                return $result;
            }
        }
        if ($spell['target_type'] == self::TARGET_TYPE_FRIENDLY) {
            if ($field != $side || $placement[$field][$x][$y] == 0) {
                return $result;
            }
        }
        if ($spell['target_type'] == self::TARGET_TYPE_FRIENDLY_FREE) {
            if ($field != $side || $placement[$field][$x][$y] != 0) {
                return $result;
            }
        }
        if ($spell['spell_type'] == 'movement') {
            $all[$side][$turn - 1]['x'] = ($x + 0);
            $all[$side][$turn - 1]['y'] = ($y + 0);
        }
        if ($spell['spell_type'] == 'damage') {
            $all[$field][$placement[$field][$x][$y] - 1]['health'] -= $spell['attack_scale'] * $all[$side][$turn - 1]['attack'] + $spell['magic_scale'] * $all[$side][$turn - 1]['magic_attack'];
        }
        if ($spell['spell_type'] == 'damage_row') {
            for ($ty = 0; $ty < self::MAX_HEIGHT; $ty ++) {
                if ($placement[$field][$x][$ty] != 0) {
                    $all[$field][$placement[$field][$x][$ty] - 1]['health'] -= $spell['attack_scale'] * $all[$side][$turn - 1]['attack'] + $spell['magic_scale'] * $all[$side][$turn - 1]['magic_attack'];
                }
            }
        }
        if ($spell['spell_type'] == 'healing') {
            $all[$field][$placement[$field][$x][$y] - 1]['health'] += $spell['attack_scale'] * $all[$side][$turn - 1]['attack'] + $spell['magic_scale'] * $all[$side][$turn - 1]['magic_attack'];
        }
        if ($spell['spell_type'] == 'damage_piercing') {
            $loss = $spell['dmg_loss'];
            $hit = 0;
            for ($tx = 0; $tx < self::MAX_WIDTH; $tx ++) {
                if ($placement[$field][$tx][$y] != 0) {
                    $all[$field][$placement[$field][$tx][$y] - 1]['health'] -= $spell['attack_scale'] * $all[$side][$turn - 1]['attack'] * (1 - $loss * $hit) + $spell['magic_scale'] * $all[$side][$turn - 1]['magic_attack'] * (1 - $loss * $hit);
                    $hit ++;
                }
            }
        }

        if ($spell['spell_type'] == 'damage_area_square') {
            $area = $spell['dmg_area'];
            for ($tx = max(0, $x - $area); $tx <= min(self::MAX_WIDTH - 1, $x + $area); $tx ++) {
                for ($ty = max(0, $y - $area); $ty <= min(self::MAX_HEIGHT - 1, $y + $area); $ty ++) {
                    if ($placement[$field][$tx][$ty] != 0) {
                        $all[$field][$placement[$field][$tx][$ty] - 1]['health'] -= $spell['attack_scale'] * $all[$side][$turn - 1]['attack'] + $spell['magic_scale'] * $all[$side][$turn - 1]['magic_attack'];
                    }
                }
            }
        }
        if ($spell['spell_type'] == 'damage_area_reduced') {
            $area = $spell['dmg_area'];
            $loss = $spell['dmg_loss'];
            for ($tx = 0; $tx < self::MAX_WIDTH; $tx ++) {
                for ($ty = 0; $ty <= self::MAX_HEIGHT; $ty ++) {
                    $dist = abs($tx - $x) + abs($ty - $y);
                    if ($dist > $area)
                        continue;
                    if ($placement[$field][$tx][$ty] != 0) {
                        $all[$field][$placement[$field][$tx][$ty] - 1]['health'] -= $spell['attack_scale'] * $all[$side][$turn - 1]['attack'] * (1 - $loss * $dist) + $spell['magic_scale'] * $all[$side][$turn - 1]['magic_attack'] * (1 - $loss * $dist);
                    }
                }
            }
        }

        $repo->updateCombat($_SESSION['user_id'], json_encode($all[0]), json_encode($all[1]), $combat['turn_order'], $combat['turn']);
        $nextTurn = $this->advanceTurn();
        $repo->changeTurn($_SESSION['user_id'], $nextTurn);
        return $result;
    }

    public function enemyTurn()
    {
        $repo = new CombatRepository();
        $combat = $repo->getCombatByUserID($_SESSION['user_id']);
        $characters = json_decode($combat['characters'], true);
        $enemies = json_decode($combat['enemies'], true);
        foreach ($characters as $char) {
            if ($char['health'] > 0) {
                $all[0][] = $char;
            }
        }
        foreach ($enemies as $enemy) {
            if ($enemy['health'] > 0) {
                $all[1][] = $enemy;
            }
        }
        $turn = json_decode($combat['turn_order'])[$combat['turn']];
        // var_dump($all);
        $enemy = $enemies[$turn - count($characters) - 1];
        $spell = $repo->getEnemySpells($enemy['enemy_id'])[0];
        var_dump($spell);
        $target = $all[0][rand(0, count($all[0]) - 1)];
        return $this->resolveSpell($target['x'], $target['y'], 0, 1, $spell['spell_id']);
    }
}