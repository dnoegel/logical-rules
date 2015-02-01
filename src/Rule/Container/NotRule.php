<?php

namespace Dnoegel\Rules\Rule\Container;

use Dnoegel\Rules\Rule;

/**
 * NotRule inverses the return value of the child rule. Only one child is possible
 *
 * Class NotRule
 * @package Dnoegel\Rules\Rule\Container
 */
class NotRule extends AbstractContainer
{
    public function addRule(Rule $rule)
    {
        parent::addRule($rule);
        $this->checkRules();
    }

    public function setRules($rules)
    {
        parent::setRules($rules);
        $this->checkRules();
    }

    /**
     * Enforce that NOT only handles ONE child rule
     *
     * @throws \RuntimeException
     */
    protected function checkRules()
    {
        if (count($this->rules) > 1) {
            throw new \RuntimeException("NOT rule can only hold one rule");
        }
    }


    public function validate()
    {
        return !$this->rules[0]->validate();
    }

}