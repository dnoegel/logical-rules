<?php

namespace Dnoegel\Rules\Registry\Type;

use Dnoegel\Rules\Registry\Type;

/**
 * The name registry type allows instantiating rules by class name
 *
 * Class Name
 * @package Dnoegel\Rules\Registry\Type
 */
class Name implements Type
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var bool
     */
    private $isContainer;

    public function __construct($className, $isContainer = false)
    {
        $this->className = $className;
        $this->isContainer = $isContainer;
    }

    /**
     * @param $config
     * @return \Dnoegel\Rules\Rule
     */
    public function get($config)
    {
        if ($this->isContainer) {
            return new $this->className();
        }
        return new $this->className($config);
    }

    public function isContainer()
    {
        return $this->isContainer;
    }
}