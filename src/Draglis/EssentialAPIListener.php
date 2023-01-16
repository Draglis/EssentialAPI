<?php

/*
 * Some Code Came from the Plugin Customies
 * https://github.com/CustomiesDevs/Customies
 */

namespace Draglis;

use Draglis\block\CustomBlockFactory;
use Draglis\item\CustomItemFactory;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\BiomeDefinitionListPacket;
use pocketmine\network\mcpe\protocol\ItemComponentPacket;
use pocketmine\network\mcpe\protocol\ResourcePackStackPacket;
use pocketmine\network\mcpe\protocol\StartGamePacket;
use pocketmine\network\mcpe\protocol\types\BlockPaletteEntry;
use pocketmine\network\mcpe\protocol\types\Experiments;
use pocketmine\network\mcpe\protocol\types\ItemTypeEntry;
use function array_merge;

final class EssentialAPIListener implements Listener {

    private ?ItemComponentPacket $cachedItemComponentPacket = null;
    /**
     * @var ItemTypeEntry[]
     */
    private array $cachedItemTable = [];
    /**
     * @var BlockPaletteEntry[]
     */
    private array $cachedBlockPalette = [];
    private Experiments $experiments;

    public function __construct() {
        $this->experiments = new Experiments([
            // "data_driven_items" is required for custom blocks to render in-game. With this disabled, they will be
            // shown as the UPDATE texture block.
            "data_driven_items" => true,
        ], true);
    }

    public function onDataPacketSend(DataPacketSendEvent $event): void {
        foreach($event->getPackets() as $packet){
            if($packet instanceof BiomeDefinitionListPacket) {
                // ItemComponentPacket needs to be sent after the BiomeDefinitionListPacket.
                if($this->cachedItemComponentPacket === null) {
                    // Wait for the data to be needed before it is actually cached. Allows for all blocks and items to be
                    // registered before they are cached for the rest of the runtime.
                    $this->cachedItemComponentPacket = ItemComponentPacket::create(CustomItemFactory::getInstance()->getItemComponentEntries());
                }
                foreach($event->getTargets() as $session){
                    $session->sendDataPacket($this->cachedItemComponentPacket);
                }
            } elseif($packet instanceof StartGamePacket) {
                if(count($this->cachedItemTable) === 0) {
                    // Wait for the data to be needed before it is actually cached. Allows for all blocks and items to be
                    // registered before they are cached for the rest of the runtime.
                    $this->cachedItemTable = array_merge($packet->itemTable, CustomItemFactory::getInstance()->getItemTableEntries());
                    $this->cachedBlockPalette = CustomBlockFactory::getInstance()->getBlockPaletteEntries();
                }
                $packet->levelSettings->experiments = $this->experiments;
                $packet->itemTable = $this->cachedItemTable;
                $packet->blockPalette = $this->cachedBlockPalette;
            } else if($packet instanceof ResourcePackStackPacket) {
                $packet->experiments = $this->experiments;
            }
        }
    }
}