<?php

namespace Draglis\entity\ai\component;

interface EntityComponent {

    public function getName(): string;

    public function getValue(): array;

}
