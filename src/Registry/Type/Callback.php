<?php

namespace Dnoegel\Rules\Registry\Type;

use Dnoegel\Rules\Registry\Type;

/**
 * The callback registry items allows creating rules via callback functions
 *
 * Class Callback
 * @package Dnoegel\Rules\Registry\Type
 */
class Callback implements Type
{
    /**
     * @var callable
     */
    private $callable;
    /**
     * @var bool
     */
    private $isContainer;

    public function __construct(callable $callable, $isContainer = false)
    {
        $this->callable = $callable;
        $this->isContainer = $isContainer;
    }

    /**
     * @param $config
     * @return \Dnoegel\Rules\Rule
     */
    public function get($config)
    {
        return call_user_func($this->callable, $config);
    }

    public function isContainer()
    {
        return $this->isContainer;
    }
}