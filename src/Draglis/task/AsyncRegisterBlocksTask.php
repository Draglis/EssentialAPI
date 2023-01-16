<?php

/*
 * The Code Came from the Plugin Customies
 * https://github.com/CustomiesDevs/Customies
 */

namespace Draglis\task;

use Closure;
use Draglis\block\CustomBlockFactory;
use Draglis\utils\Cache;
use pocketmine\block\Block;
use pocketmine\scheduler\AsyncTask;
use Threaded;

final class AsyncRegisterBlocksTask extends AsyncTask {

    private Threaded $blockFuncs;

    /**
     * @param string $cachePath
     * @param Closure[] $blockFuncs
     * @phpstan-param array<string, Closure(int): Block> $blockFuncs
     */
    public function __construct(private string $cachePath, array $blockFuncs) {
        $this->blockFuncs = new Threaded();
        foreach($blockFuncs as $identifier => $blockFunc){
            $this->blockFuncs[$identifier] = $blockFunc;
        }
    }

    public function onRun(): void {
        Cache::setInstance(new Cache($this->cachePath));
        foreach($this->blockFuncs as $identifier => $blockFunc){
            // We do not care about the model or creative inventory data in other threads since it is unused outside of
            // the main thread.
            CustomBlockFactory::getInstance()->registerBlock($blockFunc, $identifier);
        }
        CustomBlockFactory::getInstance()->registerCustomRuntimeMappings();
    }
}