<?php

namespace Draglis\entity\ai\goal;

use pocketmine\entity\Entity;

class FloatGoal implements EntityGoal {
    private $entity;
    private $isRunning = true;
    private $speed;

    public function __construct(Entity $entity, float $speed) {
        $this->entity = $entity;
        $this->speed = $speed;
    }

    public function tick() : void {
        if ($this->entity->isUnderwater()) {
            $this->entity->addMotion(0, $this->speed, 0);
        }
    }

    public function isRunning() : bool {
        return $this->isRunning;
    }

    public function start() : void {
        $this->isRunning = true;
    }

    public function stop() : void {
        $this->isRunning = false;
    }

    public function setTargetY(float $targetY) : void {
        $this->targetY = $targetY;
    }

    public function getTargetY() : float {
        return $this->targetY;
    }

    public function setSpeed(float $speed) : void {
        $this->speed = $speed;
    }

    public function getSpeed() : float {
        return $this->speed;
    }
}
