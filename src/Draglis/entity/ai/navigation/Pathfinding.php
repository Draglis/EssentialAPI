<?php

namespace Draglis\entity\ai\navigation;

use pocketmine\math\Vector3;
use pocketmine\Server;

class Pathfinding {
    /** @var Vector3[] */
    private $openList = [];
    /** @var Vector3[] */
    private $closedList = [];
    /** @var array */
    private $costs = [];
    /** @var Vector3 */
    private $end;

    /**
     * Finds the shortest path between two points in the game world.
     *
     * @param Vector3 $start The starting point.
     * @param Vector3 $end The target point.
     * @return Vector3[]|null The shortest path, or null if no path was found.
     */
    public function findPath(Vector3 $start, Vector3 $end): ?array {
        $this->end = $end;
        $this->openList = [];
        $this->closedList = [];
        $this->costs = [];

        $this->openList[] = $start;
        $this->costs[$start->x . ":" . $start->y . ":" . $start->z] = 0;

        while (!empty($this->openList)) {
            $current = $this->getLowestCostNode();

            if ($current->equals($end)) {
                return $this->getPath($end);
            }

            $this->closedList[] = $current;

            foreach ($this->getSuccessors($current) as $successor) {
                $cost = $this->costs[$current->x . ":" . $current->y . ":" . $current->z] + $this->calculateCost($current, $successor);

                if (in_array($successor, $this->closedList, true)) {
                    continue;
                }

                if (!isset($this->costs[$successor->x . ":" . $successor->y . ":" . $successor->z]) || $cost < $this->costs[$successor->x . ":" . $successor->y . ":" . $successor->z]) {
                    $this->costs[$successor->x . ":" . $successor->y . ":" . $successor->z] = $cost;
                    $this->openList[] = $successor;
                }
            }
        }

        return null;
    }

    /**
     * Returns the node with the lowest cost from the open list.
     *
     * @return Vector3 The node with the lowest cost.
     */
    protected function getLowestCostNode(): Vector3 {
        $lowestCost = INF;
        $lowestCostNode = null;

        foreach ($this->openList as $node) {
            $cost = $this->costs[$node->x . ":" . $node->y . ":" . $node->z] + $this->calculateCost($node, $this->end);

            if ($cost < $lowestCost) {
                $lowestCost = $cost;
                $lowestCostNode = $node;
            }
        }

        unset($this->openList[array_search($lowestCostNode, $this->openList, true)]);

        return $lowestCostNode;
    }

    /**
     * Returns an array of the successors of the given node.
     *
     * @param Vector3 $node The node to get successors for.
     * @return Vector3[] The successors of the given node.
     */
    protected function getSuccessors(Vector3 $node): array {
        $successors = [];

        for ($x = -1; $x <= 1; $x++) {
            for ($y = -1; $y <= 1; $y++) {
                for ($z = -1; $z <= 1; $z++) {
                    $successor = new Vector3($node->x + $x, $node->y + $y, $node->z + $z);

                    if ($x === 0 && $y === 0 && $z === 0) {
                        continue;
                    }

                    if (!$this->isValidNode($successor)) {
                        continue;
                    }

                    $successors[] = $successor;
                }
            }
        }

        return $successors;
    }

    /**
     * Returns whether the given node is a valid node in the game world.
     *
     * @param Vector3 $node The node to check.
     * @return bool True if the node is a valid node, false otherwise.
     */
    protected function isValidNode(Vector3 $node): bool {
        $serverWorldManager = Server::getInstance()->getWorldManager();
        $block = $serverWorldManager->getWorldByName($serverWorldManager->getDefaultWorld()->getFolderName())->getBlock($node);
        return $block->isTransparent() || $block->canClimb();
    }

    /**
     * Calculates the cost of moving from one node to another.
     *
     * @param Vector3 $from The node to move from.
     * @param Vector3 $to The node to move to.
     * @return float The cost of moving from the first node to the second node.
     */
    protected function calculateCost(Vector3 $from, Vector3 $to): float {
        return abs($from->x - $to->x) + abs($from->y - $to->y) + abs($from->z - $to->z);
    }

    /**
     * Returns the path from the target node back to the start node.
     *
     * @param Vector3 $target The target node.
     * @return Vector3[] The path from the target node back to the start node.
     */
    protected function getPath(Vector3 $target): array {
        $path = [$target];
        $node = $target;

        while (isset($this->costs[$node->x . ":" . $node->y . ":" . $node->z])) {
            $minCost = INF;
            $minNode = null;

            foreach ($this->getSuccessors($node) as $successor) {
                $cost = $this->costs[$successor->x . ":" . $successor->y . ":" . $successor->z] + $this->calculateCost($node, $successor);
                if ($cost < $minCost) {
                    $minCost = $cost;
                    $minNode = $successor;
                }
            }

            $node = $minNode;
            $path[] = $node;
        }

        return array_reverse($path);
    }

}


