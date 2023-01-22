<?php

namespace Draglis\entity\ambient;

use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;

class EntityBat extends Living {

    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);
        $this->setScale(1);
    }

    public function getMaxHealth(): int {
        return 6;
    }

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.9, 0.5);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:bat";
    }

    public function getName(): string {
        return "Bat";
    }

}