<?php

namespace Dnoegel\Rules\Registry\Type;

use Dnoegel\Rules\Registry\Type;
use Dnoegel\Rules\Rule;

/**
 * The instance registry items allows creating rules by cloning the reference instance
 *
 * Class Instance
 * @package Dnoegel\Rules\Registry\Type
 */
class Instance implements Type
{
    /**
     * @var Rule
     */
    private $rule;
    /**
     * @var bool
     */
    private $isContainer;

    public function __construct(Rule $rule, $isContainer = false)
    {
        $this->rule = $rule;
        $this->isContainer = $isContainer;
    }

    public function get($config)
    {
        return clone $this->rule;
    }

    public function isContainer()
    {
        return $this->isContainer;
    }


}