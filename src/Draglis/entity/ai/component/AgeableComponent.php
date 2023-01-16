<?php

namespace Draglis\entity\ai\component;

use pocketmine\nbt\tag\StringTag;

class AgeableComponent implements EntityComponent {

    private array $dropItems;
    private int $duration;
    private array $feedItems;
    private string $growUpEvent;
    private string $target;

    public function __construct(int $duration, array $feedItems = [], array $dropItems = [], string $growUpEvent = "minecraft:ageable_grow_up", string $target = "self") {
        $this->duration = $duration;
        $this->feedItems = $feedItems;
        $this->dropItems = $dropItems;
        $this->growUpEvent = $growUpEvent;
        $this->target = $target;
    }

    public function getName(): string {
        return "minecraft:ageable";
    }

    public function getValue(): array {
        return [
            "drop_items" => $this->dropItems,
            "duration" => $this->duration,
            "feed_items" => $this->feedItems,
            "grow_up" => ["event" => $this->growUpEvent, "target" => $this->target],
        ];
    }

    public function getGrowUpEvent(): array {
        return [$this->growUpEvent, $this->target];
    }

}