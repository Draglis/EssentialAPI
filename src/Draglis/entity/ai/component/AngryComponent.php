<?php

namespace Draglis\entity\ai\component;

class AngryComponent implements EntityComponent {

    private string $angrySound;
    private bool $broadcastAnger;
    private bool $broadcastAngerOnAttack;
    private bool $broadcastAngerOnBeingAttacked;
    private int $broadcastRange;
    private array $broadcastTargets;
    private int $duration;
    private int $durationDelta;
    private int $soundInterval;
    private string $calmEvent;
    private string $target;

    public function __construct(string $angrySound, bool $broadcastAnger = false, bool $broadcastAngerOnAttack = false, bool $broadcastAngerOnBeingAttacked = false, int $broadcastRange = 20, array $broadcastTargets = [], int $duration = 25, string $calmEvent = "minecraft:on_calm", string $target = "self", int $durationDelta = 0, int $soundInterval = 0) {
        $this->angrySound = $angrySound;
        $this->broadcastAnger = $broadcastAnger;
        $this->broadcastAngerOnAttack = $broadcastAngerOnAttack;
        $this->broadcastAngerOnBeingAttacked = $broadcastAngerOnBeingAttacked;
        $this->broadcastRange = $broadcastRange;
        $this->broadcastTargets = $broadcastTargets;
        $this->duration = $duration;
        $this->durationDelta = $durationDelta;
        $this->soundInterval = $soundInterval;
        $this->calmEvent = $calmEvent;
        $this->target = $target;
    }

    public function getName(): string {
        return "minecraft:angry";
    }

    public function getValue(): array {
        return [
            "angry_sound" => $this->angrySound,
            "broadcast_anger" => $this->broadcastAnger,
            "broadcast_anger_on_attack" => $this->broadcastAngerOnAttack,
            "broadcast_anger_on_being_attacked" => $this->broadcastAngerOnBeingAttacked,
            "broadcast_range" => $this->broadcastRange,
            "broadcast_targets" => $this->broadcastTargets,
            "duration" => $this->duration,
            "calm_event" => ["event" => $this->calmEvent, "target" => $this->target],
            "duration_delta" => $this->durationDelta,
            "sound_interval" => $this->soundInterval
        ];
    }
}