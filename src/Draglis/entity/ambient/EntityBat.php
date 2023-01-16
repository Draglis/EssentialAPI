<?php

namespace Draglis\entity\ambient;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;

class EntityBat extends Entity {

    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);
        $this->setScale(1);
    }

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.9, 0.5);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:bat";
    }

}