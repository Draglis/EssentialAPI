<?php

/*
 * The Code Came from the Plugin Customies
 * https://github.com/CustomiesDevs/Customies
 */

namespace Draglis\block\permutations;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\Tag;

final class Permutation {

    private string $condition;
    private CompoundTag $components;

    public function __construct(string $condition) {
        $this->condition = $condition;
        $this->components = CompoundTag::create();
    }

    /**
     * Returns the permutation with the provided component added to the current list of components.
     */
    public function withComponent(string $component, Tag $tag) : self {
        $this->components->setTag($component, $tag);
        return $this;
    }

    /**
     * Returns the permutation in the correct NBT format supported by the client.
     */
    public function toNBT(): CompoundTag {
        return CompoundTag::create()
            ->setString("condition", $this->condition)
            ->setTag("components", $this->components);
    }
}