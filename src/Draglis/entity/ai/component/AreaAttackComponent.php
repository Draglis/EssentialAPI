<?php

namespace Draglis\entity\ai\component;

class AreaAttackComponent implements EntityComponent {

    private string $cause;
    private int $damagePerTick;
    private float $damageRange;
    private string $target1;
    private string $target2;

    public function __construct(string $cause, int $damagePerTick = 2, float $damageRange = 0.2, string $target1 = "player", string $target2 = "monster") {
        $this->cause = $cause;
        $this->damagePerTick = $damagePerTick;
        $this->damageRange = $damageRange;
        $this->target1 = $target1;
        $this->target2 = $target2;
    }

    public function getName(): string {
        return "minecraft:area_attack";
    }

    public function getValue(): array {
        return [
            "cause" => $this->cause,
            "damage_per_tick" => $this->damagePerTick,
            "damage_range" => $this->damageRange,
            "entity_filter" => ["any_of" => [
                ["test" => "is_family", "subject" => "other", "value" => $this->target1],
                ["test" => "is_family", "subject" => "other", "value" => $this->target2]]]
        ];
    }
}