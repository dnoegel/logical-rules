<?php

namespace Dnoegel\Rules\Rule\Container;

/**
 * AndRule returns true, if all child-rules are true
 *
 * Class AndRule
 * @package Dnoegel\Rules\Rule\Container
 */
class AndRule extends AbstractContainer
{

    public function validate()
    {
        foreach ($this->rules as $rule) {
            if (!$rule->validate()) {
                return false;
            }
        }

        return true;
    }
}
