<?php

namespace Draglis;

use pocketmine\plugin\PluginBase;

class EssentialAPI extends PluginBase {

    private static EssentialAPI $instance;


    protected function onEnable(): void {
        self::$instance = $this;
    }

    protected function onDisable(): void {

    }

    /**
     * @return EssentialAPI
     */
    public static function getInstance(): EssentialAPI {
        return self::$instance;
    }

}
