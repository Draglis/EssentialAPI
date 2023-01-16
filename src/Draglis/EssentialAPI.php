<?php

namespace Draglis;

use Closure;
use Draglis\block\CustomBlockFactory;
use Draglis\entity\EntityManager;
use Draglis\utils\Cache;
use Draglis\world\LevelDB;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\format\io\WritableWorldProviderManagerEntry;
use ReflectionException;

class EssentialAPI extends PluginBase {

    private static EssentialAPI $instance;
    private EntityManager $entityManager;

    protected function onLoad(): void {
        Cache::setInstance(new Cache($this->getDataFolder() . "idcache"));
        $provider = new WritableWorldProviderManagerEntry(Closure::fromCallable([LevelDB::class, 'isValid']), fn(string $path) => new LevelDB($path), Closure::fromCallable([LevelDB::class, 'generate']));
        $this->getServer()->getWorldManager()->getProviderManager()->addProvider($provider, "leveldb", true);
        $this->getServer()->getWorldManager()->getProviderManager()->setDefault($provider);
    }

    /**
     * @throws ReflectionException
     */
    protected function onEnable(): void {
        self::$instance = $this;
        $this->getPluginManager()->registerEvents(new EssentialAPIListener(), $this);
        $cachePath = $this->getDataFolder() . "idcache";
        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(static function () use ($cachePath): void {
            // This task is scheduled with a 0-tick delay so it runs as soon as the server has started. Plugins should
            // register their custom blocks and entities in onEnable() before this is executed.
            Cache::getInstance()->save();
            CustomBlockFactory::getInstance()->registerCustomRuntimeMappings();
            CustomBlockFactory::getInstance()->addWorkerInitHook($cachePath);
        }), 0);
        //Entity Registry
        $this->entityManager = new EntityManager();
        $this->entityManager->initEntity();
    }

    protected function onDisable(): void {

    }

    public static function getInstance(): EssentialAPI {
        return self::$instance;
    }

    public function getPluginManager(): PluginManager {
        return $this->getServer()->getPluginManager();
    }


}
