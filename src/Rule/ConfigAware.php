<?php

namespace Dnoegel\Rules\Rule;

/**
 * Config aware rules can automatically be populated by the fromArray method of the RuleBuilder
 *
 * Interface ConfigAware
 * @package Dnoegel\Rules\Rule
 */
interface ConfigAware
{
    /**
     * @param $config
     * @return mixed
     */
    public function setConfig($config);
}