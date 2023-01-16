<?php


namespace Draglis\entity\animal;


use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityPanda extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.5, 1.7);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:panda";
    }
}