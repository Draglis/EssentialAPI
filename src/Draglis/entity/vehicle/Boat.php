<?php

namespace Draglis\entity\vehicle;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class Boat extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.455, 1.4);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:boat";
    }

}