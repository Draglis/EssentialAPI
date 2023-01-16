<?php

namespace Draglis\entity\animal\goat;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class Goat extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.3, 0.9);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:goat";
    }
}