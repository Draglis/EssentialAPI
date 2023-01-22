<?php

namespace Draglis\entity\ai\goal;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;

class AvoidEntityGoal implements EntityGoal {
    private $targetType;
    private $speed;
    private $minDistance;
    private $isRunning = true;
    private Entity $entity;

    public function __construct(Entity $entity, string $targetType, float $speed, float $minDistance) {
        $this->targetType = $targetType;
        $this->speed = $speed;
        $this->minDistance = $minDistance;
        $this->entity = $entity;
    }

    /**
     * If the entity is too close to the target, it will move away from the target
     *
     * @return void The closest entity of the type specified in the constructor.
     */
    public function tick() : void {
        $target = $this->getClosestEntity($this->targetType);
        if ($target === null) {
            return;
        }

        $x = $target->getPosition()->getX() - $this->entity->getPosition()->x;
        $y = $target->getPosition()->getY() - $this->entity->getPosition()->y;
        $z = $target->getPosition()->getZ() - $this->entity->getPosition()->z;
        $distance = sqrt(pow($x, 2) + pow($y, 2) + pow($z, 2));
        $yaw = (270 - atan2($target->getPosition()->getX() - $this->entity->getPosition()->getX(), $target->getPosition()->getZ() - $this->entity->getPosition()->getZ()) / M_PI * 180 - 90);
        if ($distance < $this->minDistance) {
            $this->entity->setMotion(new Vector3(-$x / $distance * $this->speed, -$y / $distance * $this->speed, -$z / $distance * $this->speed));
            $this->entity->setRotation($yaw, 0);
            $block = $this->entity->getWorld()->getBlock(new Vector3(
                $this->entity->getPosition()->getX() + $this->entity->getDirectionVector()->x,
                $this->entity->getPosition()->getY(),
                $this->entity->getPosition()->getZ() + $this->entity->getDirectionVector()->z
            ));

            if (!$block->isTransparent() and $block->isSolid()) {
                $this->entity->setMotion(new Vector3($this->entity->getMotion()->getX(), $this->entity->getMotion()->getY() + 0.6, $this->entity->getMotion()->getZ()));
            }
        } else {
            $this->entity->setMotion(new Vector3(0, 0, 0));
        }
    }

    /**
     * It returns the closest entity of the specified type to the entity that the AI is attached to
     *
     * @param string targetType The type of entity to look for.
     *
     * @return ?Entity The closest entity of the type specified.
     */
    protected function getClosestEntity(string $targetType) : ?Entity {
        $entities = $this->entity->getWorld()->getEntities();
        $minDistance = PHP_INT_MAX;
        $closest = null;
        foreach ($entities as $entity) {
            if ($entity instanceof $targetType) {
                $dx = $entity->getPosition()->getX() - $this->entity->getPosition()->getX();
                $dy = $entity->getPosition()->getY() - $this->entity->getPosition()->getY();
                $dz = $entity->getPosition()->getZ() - $this->entity->getPosition()->getZ();
                $distance = sqrt(pow($dx, 2) + pow($dy, 2) + pow($dz, 2));
                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $closest = $entity;
                }
            }
        }
        return $closest;
    }

    public function isRunning() : bool {
        return $this->isRunning;
    }

    public function start(): void {
        $this->isRunning = true;
    }

    public function stop(): void {
        $this->isRunning = false;
    }

    public function setSpeed(float $speed): void {
        $this->speed = $speed;
    }

    public function getSpeed() : float {
        return $this->speed;
    }

    public function setMinDistance(float $minDistance) {
        $this->minDistance = $minDistance;
    }

    public function getMinDistance() : float {
        return $this->minDistance;
    }
}