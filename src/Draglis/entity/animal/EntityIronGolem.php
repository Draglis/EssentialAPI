<?php


namespace Draglis\entity\animal;


use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityIronGolem extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(2.9, 1.4);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:iron_golem";
    }

}