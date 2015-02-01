<?php

namespace Dnoegel\Rules\Rule\Container;

use Dnoegel\Rules\Rule;

/**
 * Container defines the interface for special rules, which conjunct child rules
 *
 * Interface Container
 * @package Dnoegel\Rules\Rule\Container
 */
interface Container extends Rule
{
    /**
     * Set the internal rule collection to $rules
     *
     * @param $rules
     * @return mixed
     */
    public function setRules($rules);

    /**
     * Add one rule to the internal rule collection
     *
     * @param Rule $rule
     * @return mixed
     */
    public function addRule(Rule $rule);
}