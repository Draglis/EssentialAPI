<?php

namespace Draglis\entity\ai\component;

class AddRiderComponent implements EntityComponent {

    private string $entityType;
    private string $spawnEvent;

    public function __construct(string $entityType, string $spawnEvent = "") {
        $this->entityType = $entityType;
        $this->spawnEvent = $spawnEvent;
    }

    public function getName(): string {
        return "minecraft:addrider";
    }

    public function getValue(): array {
        return [
            "entity_type" => $this->entityType,
            "spawn_event" => $this->spawnEvent
        ];
    }

}