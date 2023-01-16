<?php

namespace Draglis\item\egg;

use Draglis\entity\EntityManager;
use Draglis\item\CreativeInventoryInfo;
use Draglis\item\ItemComponents;
use Draglis\item\ItemComponentsTrait;
use pocketmine\block\Block;
use pocketmine\entity\Location;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class CustomSpawnEgg extends Item implements ItemComponents {
    use ItemComponentsTrait;

    private string $className;
    private array $typeClass;

    public function __construct(ItemIdentifier $identifier, string $name) {
        parent::__construct($identifier, $name);
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_NATURE, CreativeInventoryInfo::GROUP_MOB_EGGS);
        $this->initComponent("spawn_egg", 64, $creativeInfo);
        $this->typeClass = EntityManager::getClasses();
        $this->className = $this->typeClass[$name];
    }

    public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector) : ItemUseResult{
        $entity = new $this->className(Location::fromObject($blockReplace->getPosition()->add(0.5, 0, 0.5), $player->getWorld(), lcg_value() * 360, 0));

        if($this->hasCustomName()){
            $entity->setNameTag($this->getCustomName());
        }
        $this->pop();
        $entity->spawnToAll();
        return ItemUseResult::SUCCESS();
    }

}