<?php


namespace Draglis\entity\animal;

use Draglis\entity\ai\goal\PlayerNearGoal;
use Draglis\entity\EntityLiving;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;

class EntityCow extends EntityLiving {

    public function __construct(Location $location, ?CompoundTag $nbt = null) {
        parent::__construct($location, $nbt);
    }

    protected function registerGoals(): void {
    }

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo($this->isBaby() ? 0.7:1.4, $this->isBaby() ? 0.45:0.9);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:cow";
    }

    public function getName(): string {
        return "Cow";
    }

    public function getDrops(): array{
        if ($this->isOnFire() === true) {
            return [
                VanillaItems::STEAK()->setCount(mt_rand(1, 3)),
                VanillaItems::LEATHER()->setCount(mt_rand(0, 2))
            ];
        } else {
            return [
                VanillaItems::RAW_BEEF()->setCount(mt_rand(1, 3)),
                VanillaItems::LEATHER()->setCount(mt_rand(0, 2))
            ];
        }
    }

    public function getMaxHealth(): int {
        return 10;
    }

}