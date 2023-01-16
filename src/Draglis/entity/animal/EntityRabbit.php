<?php


namespace Draglis\entity\animal;


use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityRabbit extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.67, 0.67);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:rabbit";
    }

}