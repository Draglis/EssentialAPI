<?php

/*
 * The Code Came from the Plugin Customies
 * https://github.com/CustomiesDevs/Customies
 */

namespace Draglis\block\permutations;

use Draglis\utils\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use function array_map;

final class BlockProperty {

    private string $name;
    private array $values;

    public function __construct(string $name, array $values) {
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * Returns the name of the block property provided in the constructor.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Returns the array of possible values of the block property provided in the constructor.
     */
    public function getValues(): array {
        return $this->values;
    }

    /**
     * Returns the block property in the correct NBT format supported by the client.
     */
    public function toNBT(): CompoundTag {
        $values = array_map(static fn($value) => NBT::getTagType($value), $this->values);
        return CompoundTag::create()
            ->setString("name", $this->name)
            ->setTag("enum", new ListTag($values));
    }
}