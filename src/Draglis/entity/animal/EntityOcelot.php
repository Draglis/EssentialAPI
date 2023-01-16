<?php


namespace Draglis\entity\animal;


use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityOcelot extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.7, 0.6);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:ocelot";
    }
}