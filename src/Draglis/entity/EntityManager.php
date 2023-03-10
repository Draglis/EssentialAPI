<?php

namespace Draglis\entity;

use Closure;
use Draglis\entity\ambient\EntityBat;
use Draglis\entity\animal\allay\Allay;
use Draglis\entity\animal\axolotl\Axolotl;
use Draglis\entity\animal\EntityBee;
use Draglis\entity\animal\EntityCat;
use Draglis\entity\animal\EntityChicken;
use Draglis\entity\animal\EntityCow;
use Draglis\entity\animal\EntityDolphin;
use Draglis\entity\animal\EntityFox;
use Draglis\entity\animal\EntityIronGolem;
use Draglis\entity\animal\EntityMushroomCow;
use Draglis\entity\animal\EntityOcelot;
use Draglis\entity\animal\EntityPanda;
use Draglis\entity\animal\EntityParrot;
use Draglis\entity\animal\EntityPig;
use Draglis\entity\animal\EntityPufferFish;
use Draglis\entity\animal\EntityRabbit;
use Draglis\entity\animal\EntitySheep;
use Draglis\entity\animal\EntitySnowman;
use Draglis\entity\animal\EntitySquid;
use Draglis\entity\animal\EntityTurtle;
use Draglis\entity\animal\EntityWolf;
use Draglis\entity\animal\frog\Tadpole;
use Draglis\entity\animal\goat\Goat;
use Draglis\entity\animal\horse\EntityHorseAbstract;
use Draglis\item\CustomItemFactory;
use Draglis\item\egg\CustomSpawnEgg;
use ReflectionException;

class EntityManager {

    /**
     * It registers all the entities that are in the game
     * @throws ReflectionException
     */
    public function initEntity() {
        $this->register(EntityBat::class, EntityBat::getNetworkTypeId(), "Bat");
        $this->register(Allay::class, Allay::getNetworkTypeId(), "Allay");
        $this->register(Axolotl::class, Axolotl::getNetworkTypeId(), "Axolotl");
        $this->register(Tadpole::class, Tadpole::getNetworkTypeId(), "Tadpole");
        $this->register(Goat::class, Goat::getNetworkTypeId(), "Goat");
        $this->register(EntityHorseAbstract::class, EntityHorseAbstract::getNetworkTypeId(), "Horse");
        $this->register(EntityBee::class, EntityBee::getNetworkTypeId(), "Bee");
        $this->register(EntityCat::class, EntityCat::getNetworkTypeId(), "Cat");
        $this->register(EntityChicken::class, EntityChicken::getNetworkTypeId(), "Chicken");
        $this->register(EntityCow::class, EntityCow::getNetworkTypeId(), "Cow");
        $this->register(EntityDolphin::class, EntityDolphin::getNetworkTypeId(), "Dolphin");
        $this->register(EntityFox::class, EntityFox::getNetworkTypeId(), "Fox");
        $this->register(EntityIronGolem::class, EntityIronGolem::getNetworkTypeId(), "IronGolem");
        $this->register(EntityMushroomCow::class, EntityMushroomCow::getNetworkTypeId(), "MushroomCow");
        $this->register(EntityOcelot::class, EntityOcelot::getNetworkTypeId(), "Ocelot");
        $this->register(EntityPanda::class, EntityPanda::getNetworkTypeId(), "Panda");
        $this->register(EntityParrot::class, EntityParrot::getNetworkTypeId(), "Parrot");
        $this->register(EntityPig::class, EntityPig::getNetworkTypeId(), "Pig");
        $this->register(EntityPufferFish::class, EntityPufferFish::getNetworkTypeId(), "PufferFish");
        $this->register(EntityRabbit::class, EntityRabbit::getNetworkTypeId(), "Rabbit");
        $this->register(EntitySheep::class, EntitySheep::getNetworkTypeId(), "Sheep");
        $this->register(EntitySnowman::class, EntitySnowman::getNetworkTypeId(), "Snowman");
        $this->register(EntitySquid::class, EntitySquid::getNetworkTypeId(), "Squid");
        $this->register(EntityTurtle::class, EntityTurtle::getNetworkTypeId(), "Turtle");
        $this->register(EntityWolf::class, EntityWolf::getNetworkTypeId(), "Wolf");

    }

    /**
     * It registers a custom entity and a custom spawn egg
     *
     * @param string $className The class name of the entity.
     * @param string $identifier The identifier of the entity.
     * @param string $name The name of the entity.
     * @param Closure|null $creationFunc A function that returns an instance of the entity.
     * @param string behaviourId The behaviour id of the entity.
     * @throws ReflectionException
     */
    public function register(string $className, string $identifier, string $name, ?Closure $creationFunc = null, string $behaviourId = "") {
        CustomEntityFactory::getInstance()->registerEntity($className, $identifier, $creationFunc, $behaviourId);
        CustomItemFactory::getInstance()->registerItem(CustomSpawnEgg::class, $identifier . "_spawn_egg", $name);
    }

    public static function getClasses(): array {
        return [
            "Bat" => EntityBat::class,
            "Allay" => Allay::class,
            "Axolotl" => Axolotl::class,
            "Tadpole" => Tadpole::class,
            "Goat" => Goat::class,
            "Horse" => EntityHorseAbstract::class,
            "Bee" => EntityBee::class,
            "Cat" => EntityCat::class,
            "Chicken" => EntityChicken::class,
            "Cow" => EntityCow::class,
            "Dolphin" => EntityDolphin::class,
            "Fox" => EntityFox::class,
            "IronGolem" => EntityIronGolem::class,
            "MushroomCow" => EntityMushroomCow::class,
            "Ocelot" => EntityOcelot::class,
            "Panda" => EntityPanda::class,
            "Parrot" => EntityParrot::class,
            "Pig" => EntityPig::class,
            "PufferFish" => EntityPufferFish::class,
            "Rabbit" => EntityRabbit::class,
            "Sheep" => EntitySheep::class,
            "Snowman" => EntitySnowman::class,
            "Squid" => EntitySquid::class,
            "Turtle" => EntityTurtle::class,
            "Wolf" => EntityWolf::class,
        ];
    }

}