<?php


namespace Draglis\entity\animal;

use Draglis\entity\ai\goal\FloatGoal;
use Draglis\entity\ai\goal\GoalSelector;
use Draglis\entity\ai\goal\PanicGoal;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;

class EntityCow extends Living {

    private GoalSelector $goalSelector;

    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);
        $this->goalSelector = new GoalSelector();
        $this->registerGoals();
    }

    private function registerGoals(): void {
        $this->goalSelector->addGoal(0, new FloatGoal($this, 0.085));
        $this->goalSelector->addGoal(1, new PanicGoal($this, 1));
    }

    public function onUpdate(int $currentTick): bool {
        $this->goalSelector->tick();
        return parent::onUpdate($currentTick);
    }


    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.3, 0.9);
    }

    public static function getNetworkTypeId(): string {
        return "minecraft:cow";
    }

    public function getName(): string {
        return "Cow";
    }

}