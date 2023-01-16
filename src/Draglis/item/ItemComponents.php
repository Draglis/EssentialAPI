<?php

/*
 * The Code Came from the Plugin Customies
 * https://github.com/CustomiesDevs/Customies
 */

namespace Draglis\item;

use pocketmine\nbt\tag\CompoundTag;

interface ItemComponents {

    /**
     * Returns the fully-structured CompoundTag that can be sent to a client in the ItemComponentsPacket.
     */
    public function getComponents(): CompoundTag;
}