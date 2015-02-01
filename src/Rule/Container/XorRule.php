<?php

namespace Dnoegel\Rules\Rule\Container;


/**
 * XorRule returns true, if exactly one child rule is true
 *
 * Class XorRule
 * @package Dnoegel\Rules\Rule\Container
 */
class XorRule extends AbstractContainer
{
    public function validate()
    {
        $true = 0;
        foreach ($this->rules as $rule) {
            if ($rule->validate()) {
                $true ++;
                if ($true > 1) {
                    return false;
                }
            }
        }

        return $true == 1;
    }

}