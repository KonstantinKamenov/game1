<?php
namespace Model\Services;

use Model\Repository\ShopRepository;
use Model\Repository\InventoryRepository;

class ShopService
{
    public function getSellOffers($zone_id){
        $repo = new ShopRepository();
        $offers = $repo->getSellOffers($zone_id);
        $result['offers']=$offers;
        return $result;
    }
    public function getBuyOffers($zone_id){
        $repo = new ShopRepository();
        $offers = $repo->getBuyOffers($zone_id);
        $result['offers']=$offers;
        return $result;
    }
    
    public function sellItem($item_id,$user_id,$zone_id){
        $shopRepo = new ShopRepository();
        $invRepo = new InventoryRepository();
        $offer = $shopRepo->getOffer($item_id, $zone_id, 0);
        $item = $invRepo->getItemCount($user_id, $item_id);
        $gold = $invRepo->getGold($user_id)['gold'];
        var_dump($offer);
        if($item){
            $invRepo->changeItemCount($user_id, $item_id, $item['quantity']-1);
            $invRepo->changeGold($user_id, $gold+$offer['cost']);
        }
    }
    public function buyItem($item_id,$user_id,$zone_id){
        $shopRepo = new ShopRepository();
        $invRepo = new InventoryRepository();
        $offer = $shopRepo->getOffer($item_id, $zone_id, 1);
        $item = $invRepo->getItemCount($user_id, $item_id);
        $gold = $invRepo->getGold($user_id)['gold'];
        if($gold<$offer['cost'])return;
        if(!$item){
            $invRepo->insertItem($user_id, $item_id);
            $item = $invRepo->getItemCount($user_id, $item_id);
        }
        $invRepo->changeItemCount($user_id, $item_id, $item['quantity']+1);
        $invRepo->changeGold($user_id, $gold-$offer['cost']);
    }
}