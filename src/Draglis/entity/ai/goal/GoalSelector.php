<?php

declare(strict_types=1);

namespace Draglis\entity\ai\goal;

class GoalSelector {

    /** @var Goal[][] */
    private array $goals = [];

    public function addGoal(int $priority, Goal $goal): void {
        $this->goals[$priority][] = $goal;
        ksort($this->goals);
    }

    public function tick(): void {
        foreach ($this->goals as $goals) {
            $canStart = false;
            foreach ($goals as $goal) {
                if ($goal->canStart()) {
                    $canStart = true;
                    $goal->tick();
                }
            }
            if ($canStart) {
                break;
            }
        }
    }

}
