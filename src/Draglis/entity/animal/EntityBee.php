<?php

namespace Draglis\entity\animal;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityBee extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.5, 0.55);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:bee";
    }

}