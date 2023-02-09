<?php

declare(strict_types=1);

namespace Draglis\entity;

use Draglis\entity\ai\goal\GoalSelector;
use pocketmine\block\VanillaBlocks;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;

abstract class EntityLiving extends Living {

    private GoalSelector $goalSelector;

    private bool $baby = false;
    private bool $hasAi = true;
    private int $duration;

    public function __construct(Location $location, ?CompoundTag $nbt = null) {
        parent::__construct($location, $nbt);
        $this->goalSelector = new GoalSelector();
        $this->registerGoals();
    }

    abstract protected function registerGoals(): void;

    public function getGoalSelector(): GoalSelector {
        return $this->goalSelector;
    }

    public function onUpdate(int $currentTick): bool {
        if ($this->hasAi()) {
            $this->getGoalSelector()->tick();
        }
        return parent::onUpdate($currentTick);
    }

    public function isBaby() : bool{
        return $this->baby;
    }

    public function setBaby(bool $baby): void {
        $this->baby = $baby;
    }

    public function getScale(): float {
        return $this->isBaby() ? 0.5 : 1.0;
    }

    public function shouldDropExperience(): bool {
        return !$this->isBaby();
    }

    protected function shouldDropLoot(): bool {
        return !$this->isBaby();
    }

    public function getDrops(): array {
        return $this->shouldDropLoot() ? parent::getDrops() : [];
    }

    public function getXpDropAmount(): int {
        return $this->shouldDropExperience() ? parent::getXpDropAmount() : 0;
    }

    public function getDuration(): int {
        if ($this->isBaby() === true) {
            return $this->duration;
        } else {
            return 0;
        }
    }

    public function setDuration(int $duration): void {
        $this->duration = $duration;
    }

    public function hasAi(): bool {
        return $this->hasAi;
    }

    public function setHasAi(bool $hasAi): void {
        $this->hasAi = $hasAi;
    }

    public function getNearestEntity(Vector3 $pos, int $maxDistance): ?Entity {
        $center = new Vector3($pos->x, $pos->y, $pos->z);
        for($i = 0; $i <= 360; $i += 45){
            $angle = $i * (M_PI / 180);
            $x = $center->x + cos($angle) ;
            $z = $center->z + sin($angle) ;
            $vector = new Vector3($x, $center->y, $z);
            $entities = $this->getWorld()->getEntities();
            foreach($entities as $entity){
                if($entity->getPosition()->distance($vector) <= $maxDistance){
                    return $entity;
                }
            }
        }
        return null;
    }


}