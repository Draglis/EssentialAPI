<?php

namespace Draglis\entity\animal\allay;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class Allay extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.6, 0.6);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:allay";
    }

    public function getMaxHealth(): int {
        return 20;
    }

}