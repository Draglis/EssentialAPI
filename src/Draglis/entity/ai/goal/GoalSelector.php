<?php

namespace Draglis\entity\ai\goal;

class GoalSelector {
    /** @var array<EntityGoal[]> */
    private $goals = [];
    /** @var EntityGoal[] */
    private $temp = [];

    /**
     * It adds a goal to the entity's goal list
     *
     * @param int priority The priority of the goal.
     * @param EntityGoal goal The goal to add.
     */
    public function addGoal(int $priority, EntityGoal $goal) {
        if (!isset($this->goals[$priority])) {
            $this->goals[$priority] = [];
        }
        $this->goals[$priority][] = $goal;
        ksort($this->goals);
    }

    /**
     * It removes a goal from the entity's goal list
     *
     * @param EntityGoal goal The goal to add.
     */
    public function removeGoal(EntityGoal $goal) {
        foreach ($this->goals as $priority => $goals) {
            if (($index = array_search($goal, $goals)) !== false) {
                unset($this->goals[$priority][$index]);
                if (empty($this->goals[$priority])) {
                    unset($this->goals[$priority]);
                }
                break;
            }
        }
    }

    /**
     * It ticks all the goals, and if they're still running, it adds them to the temp array
     */
    public function tick(): void {
        $this->temp = [];
        foreach ($this->goals as $goals) {
            foreach ($goals as $goal) {
                $goal->tick();
                if ($goal->isRunning()) {
                    $this->temp[] = $goal;
                }
            }
        }
        $this->goals = array_merge($this->goals, $this->temp);
    }
}