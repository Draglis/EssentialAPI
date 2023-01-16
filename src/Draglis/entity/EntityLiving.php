<?php

namespace Draglis\entity;

use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;

abstract class EntityLiving extends Living {

    private $brain;
    private int $maxHealth;
    private bool $baby = false;

    public function __construct(Location $location, int $maxHealth, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);
        $this->maxHealth = $maxHealth;
    }

    public function getMaxHealth(): int
    {
        return $this->maxHealth;
    }

    public function getHealth(): float
    {
        return $this->maxHealth;
    }

    public function isBaby() : bool{
        return $this->baby;
    }

    public function getScale(): float
    {
        return $this->isBaby() ? 0.5 : 1.0;
    }

    public function shouldDropExperience(): bool {
        return !$this->isBaby();
    }

    protected function shouldDropLoot(): bool {
        return !$this->isBaby();
    }

    public function getDrops(): array {
        if ($this->shouldDropLoot() == false) {
            return [];
        } else {
            return $this->getDrops();
        }
    }

    public function getXpDropAmount(): int {
        if ($this->shouldDropExperience() == false) {
            return 0;
        } else {
            return $this->getXpDropAmount();
        }
    }


}