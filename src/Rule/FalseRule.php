<?php

namespace Dnoegel\Rules\Rule;

use Dnoegel\Rules\Rule;

/**
 * FalseRule will always return false
 *
 * Class FalseRule
 * @package Dnoegel\Rules\Rule
 */
class FalseRule implements Rule
{
    public function validate()
    {
        return false;
    }

}
