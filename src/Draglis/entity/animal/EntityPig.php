<?php


namespace Draglis\entity\animal;


use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityPig extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.9, 0.9);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:pig";
    }
}