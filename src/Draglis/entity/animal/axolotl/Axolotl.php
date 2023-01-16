<?php

namespace Draglis\entity\animal\axolotl;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class Axolotl extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.42, 0.75);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:axolotl";
    }
}