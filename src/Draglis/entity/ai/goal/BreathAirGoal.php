<?php

namespace Draglis\entity\ai\goal;

use pocketmine\block\VanillaBlocks;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;

class BreathAirGoal implements EntityGoal {
    private $entity;
    private $isRunning = true;
    private $maxAir;
    private $air;
    private $lastTick;

    public function __construct(Entity $entity, int $maxAir) {
        $this->entity = $entity;
        $this->maxAir = $maxAir;
        $this->air = $this->maxAir;
        $this->lastTick = time();
    }

    public function tick() : void {
        $block = $this->entity->getWorld()->getBlock(new Vector3(
            $this->entity->getPosition()->getX(),
            $this->entity->getPosition()->getY()-1,
            $this->entity->getPosition()->getZ()
        ));
        if($block === VanillaBlocks::WATER()){
            $currentTick = time();
            $timePassed = $currentTick - $this->lastTick;
            $this->lastTick = $currentTick;
            if($timePassed >= 1) {
                $this->air -= $timePassed * 2;
                if($this->air <= 0){
                    $this->entity->attack(new EntityDamageEvent($this->entity, EntityDamageEvent::CAUSE_DROWNING, 2));
                }
            }
        }else{
            $this->air = $this->maxAir;
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

}