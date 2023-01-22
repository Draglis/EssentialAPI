<?php

namespace Draglis\entity\ai\goal;

use pocketmine\entity\Entity;
use pocketmine\item\VanillaItems;

class BreakDoorGoal extends DoorInteractGoal {

    private Entity $entity;
    private int|float $minDistanceSquared;
    private bool $isRunning = true;
    private $lastDoorBreakTime = 0;
    private $timeBetweenDoorBreak = 5;

    public function __construct(Entity $entity, float $minDistance) {
        parent::__construct($entity, $minDistance);
        $this->entity = $entity;
        $this->minDistanceSquared = $minDistance ** 2;
    }

    /**
     * If there are nearby doors, get the closest one, and if it's close enough, break it
     */
    public function tick(): void {
        $nearbyDoors = $this->getNearbyDoors();
        if (count($nearbyDoors) > 0) {
            $door = $this->getClosestDoor($nearbyDoors);
            $x = $door->getPosition()->x - $this->entity->getPosition()->getX();
            $y = $door->getPosition()->y - $this->entity->getPosition()->getY();
            $z = $door->getPosition()->z - $this->entity->getPosition()->getZ();
            $distanceSquared = ($x ** 2) + ($y ** 2) + ($z ** 2);
            if ($distanceSquared <= $this->minDistanceSquared) {
                $time = $door->getBreakInfo()->getBreakTime(VanillaItems::AIR());
                $this->setTimeBetweenDoorBreak($time);
                $currentTime = time();
                if($currentTime - $this->lastDoorBreakTime > $this->timeBetweenDoorBreak) {
                    $door->getPosition()->getWorld()->useBreakOn($door->getPosition());
                    $this->lastDoorBreakTime = $currentTime;
                }
            }
        }
    }

    public function getTimeBetweenDoorBreak(): int {
        return $this->timeBetweenDoorBreak;
    }

    public function setTimeBetweenDoorBreak(int|float $time): void {
        $this->timeBetweenDoorBreak = $time;
    }

    public function isRunning(): bool {
        return $this->isRunning;
    }

    public function setRunning(bool $value): void {
        $this->isRunning = $value;
    }

}
