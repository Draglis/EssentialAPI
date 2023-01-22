<?php

namespace Draglis\entity\ai\goal;

use pocketmine\entity\Entity;

class BegGoal implements EntityGoal {
    private $entity;
    private $minDistance;
    private $isRunning = true;
    private $begging = false;

    public function __construct(Entity $entity, float $minDistance) {
        $this->entity = $entity;
        $this->minDistance = $minDistance;
    }

    public function tick() : void {
        $nearbyPlayers = $this->entity->getWorld()->getPlayers();
        foreach ($nearbyPlayers as $player) {
            $x = $this->entity->getPosition()->x - $player->getPosition()->getX();
            $y = $this->entity->getPosition()->y - $player->getPosition()->getY();
            $z = $this->entity->getPosition()->z - $player->getPosition()->getZ();
            $distance = sqrt(pow($x, 2) + pow($y, 2) + pow($z, 2));
            if ($distance <= $this->minDistance) {
                $this->setBegging(true);
                $direction = $player->getDirectionVector();
                $yaw = (180 - rad2deg(atan2($direction->x, $direction->z)));
                $pitch = -rad2deg(atan2(sqrt($direction->x ** 2 + $direction->z ** 2), $direction->y) - M_PI / 2);
                $this->entity->setRotation($yaw, $pitch);
                return;
            }
        }
        $this->setBegging(false);
    }

    public function setBegging(bool $begging) : void {
        $this->begging = $begging;
    }

    public function isBegging() : bool {
        return $this->begging;
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
