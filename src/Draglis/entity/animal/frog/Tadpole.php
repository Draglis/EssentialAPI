<?php

namespace Draglis\entity\animal\frog;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class Tadpole extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.6, 0.8);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:tadpole";
    }

}
