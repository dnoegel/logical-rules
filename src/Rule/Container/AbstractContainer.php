<?php
namespace Dnoegel\Rules\Rule\Container;

use Dnoegel\Rules\Rule;

/**
 * AbstractContainer implements setRule and addRule of the container interface
 *
 * Class AbstractContainer
 * @package Dnoegel\Rules\Rule\Container
 */
abstract class AbstractContainer implements Container
{
    /** @var  Rule[] */
    protected $rules;

    public function __construct($rules = null)
    {
        if ($rules) {
            $this->rules = $rules;
        }
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }
}
