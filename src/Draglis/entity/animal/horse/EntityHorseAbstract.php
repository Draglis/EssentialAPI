<?php

namespace Draglis\entity\animal\horse;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;

class EntityHorseAbstract extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.6, 1.4);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:horse";
    }
}