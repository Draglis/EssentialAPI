<?php

namespace Draglis;

use Draglis\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class EssentialAPI extends PluginBase {

    private static EssentialAPI $instance;
    private static Server $server;

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
