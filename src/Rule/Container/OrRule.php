<?php

namespace Dnoegel\Rules\Rule\Container;

/**
 * OrRule returns true, if at least one child rule is true
 *
 * Class OrRule
 * @package Dnoegel\Rules\Rule\Container
 */
class OrRule extends AbstractContainer
{
    public function validate()
    {
        foreach ($this->rules as $rule) {
            if ($rule->validate()) {
                return true;
            }
        }

        return false;
    }

}