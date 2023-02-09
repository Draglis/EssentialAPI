<?php

declare(strict_types=1);

namespace Draglis\entity\ai\goal;

abstract class Goal {

    public function canStart(): bool {
        return true;
    }

    abstract public function tick(): void;

}