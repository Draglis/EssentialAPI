<?php

namespace Draglis\entity\ai\component;

class AdmireItemComponent implements EntityComponent {

    private int $cooldownAfterBeingAttacked;
    private int $duration;

    public function __construct(int $cooldownAfterBeingAttacked, int $duration = 10) {
        $this->cooldownAfterBeingAttacked = $cooldownAfterBeingAttacked;
        $this->duration = $duration;
    }

    public function getName(): string {
        return "minecraft:admire_item";
    }

    public function getValue(): array {
        return [
            "cooldown_after_being_attacked" => $this->cooldownAfterBeingAttacked,
            "duration" => $this->duration
        ];
    }
}