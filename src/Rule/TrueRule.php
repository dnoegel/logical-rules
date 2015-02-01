<?php

namespace Dnoegel\Rules\Rule;

use Dnoegel\Rules\Rule;

/**
 * True rule will always return true
 *
 * Class TrueRule
 * @package Dnoegel\Rules\Rule
 */
class TrueRule implements Rule
{
    public function validate()
    {
        return true;
    }

}
