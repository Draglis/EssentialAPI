<?php

namespace Draglis\entity\ai\goal;

interface EntityGoal {
    public function tick(): void;
    public function isRunning(): bool;
    public function start(): void;
    public function stop(): void;
}