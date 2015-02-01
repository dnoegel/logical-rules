<?php

namespace Dnoegel\Rules;

/**
 * Rule is the generic interface for any kind of rule (simple or container)
 *
 * Interface Rule
 * @package Dnoegel\Rules
 */
interface Rule
{
    /**
     * Validate the current rule and return boolean to indicate if the current
     * rule applied (true) or not (false)
     *
     * @return bool
     */
    public function validate();
}