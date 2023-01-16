<?php


namespace Draglis\entity\animal;


use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntitySquid extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.95, 0.95);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:squid";
    }
}