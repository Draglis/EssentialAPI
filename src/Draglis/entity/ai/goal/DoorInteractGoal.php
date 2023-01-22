<?php

namespace Draglis\entity\ai\goal;

use pocketmine\block\Door;
use pocketmine\entity\Entity;

class DoorInteractGoal implements EntityGoal {
    private Entity $entity;
    private $minDistanceSquared;
    private bool $isRunning = true;
    private int $searchRadius = 10;
    private $lastDoorInteractTime = 0;
    private $timeBetweenDoorInteract = 0.5;

    public function __construct(Entity $entity, float $minDistance) {
        $this->entity = $entity;
        $this->minDistanceSquared = $minDistance ** 2;
    }

    /**
     * If there are nearby doors, open/close the closest one
     */
    public function tick() : void {
        $nearbyDoors = $this->getNearbyDoors();
        if (count($nearbyDoors) > 0) {
            $door = $this->getClosestDoor($nearbyDoors);
            $x = $door->getPosition()->x - $this->entity->getPosition()->getX();
            $y = $door->getPosition()->y - $this->entity->getPosition()->getY();
            $z = $door->getPosition()->z - $this->entity->getPosition()->getZ();
            $distanceSquared = ($x ** 2) + ($y ** 2) + ($z ** 2);
            if ($distanceSquared <= $this->minDistanceSquared) {
                $currentTime = time();
                if($currentTime - $this->lastDoorInteractTime > $this->timeBetweenDoorInteract) {
                    $door->setOpen(!$door->isOpen());
                    $this->entity->getWorld()->setBlock($door->getPosition(), $door);
                    $this->lastDoorInteractTime = $currentTime;
                }
            }
        }
    }

    /**
     * It gets all the doors within a certain radius of the entity
     *
     * @return array An array of doors.
     */
    protected function getNearbyDoors() : array {
        $doors = [];
        $world = $this->entity->getWorld();
        $Pos = $this->entity->getPosition();
        for ($x = floor($Pos->getX()) - $this->searchRadius; $x <= floor($Pos->getX()) + $this->searchRadius; $x++) {
            for ($y = floor($Pos->getY()) - $this->searchRadius; $y <= floor($Pos->getY()) + $this->searchRadius; $y++) {
                for ($z = floor($Pos->getZ()) - $this->searchRadius; $z <= floor($Pos->getZ()) + $this->searchRadius; $z++) {
                    $block = $world->getBlockAt($x, $y, $z);
                    if ($block instanceof Door) {
                        $doors[] = $block;
                    }
                }
            }
        }
        return $doors;
    }

    /**
     * It finds the closest door to the entity
     *
     * @param array doors An array of doors to choose from.
     *
     * @return Door|null The closest door to the entity.
     */
    protected function getClosestDoor(array $doors): ?Door {
        if(count($doors) === 0) {
            return null;
        }
        $closest = null;
        $closestDistanceSquared = INF;
        foreach ($doors as $door) {
            $x = $door->getPosition()->x - $this->entity->getPosition()->getX();
            $y = $door->getPosition()->y - $this->entity->getPosition()->getY();
            $z = $door->getPosition()->z - $this->entity->getPosition()->getZ();
            $distanceSquared = ($x ** 2) + ($y ** 2) + ($z ** 2);
            if ($distanceSquared < $closestDistanceSquared) {
                $closest = $door;
                $closestDistanceSquared = $distanceSquared;
            }
        }
        return $closest;
    }


    public function getSearchRadius(): int {
        return $this->searchRadius;
    }

    public function setSearchRadius(int $searchRadius): void {
        $this->searchRadius = $searchRadius;
    }

    public function isRunning() : bool {
        return $this->isRunning;
    }

    public function setRunning(bool $value) : void {
        $this->isRunning = $value;
    }

    public function start(): void {
        $this->isRunning = true;
    }

    public function stop(): void {
        $this->isRunning = false;
    }

}