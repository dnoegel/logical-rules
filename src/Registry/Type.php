<?php

namespace Dnoegel\Rules\Registry;

/**
 * Type represents a registry type. Its basically a wrapper for for a rule in the rule registry
 * and takes care of the proper instantiation of a new rule object in the get method.
 *
 * Also it knows whether or not a rule is a container.
 *
 * Interface Type
 * @package Dnoegel\Rules\Registry
 */
interface Type
{
    /**
     * Return true, if the rule is a container
     *
     * @return bool
     */
    public function isContainer();

    /**
     * Return an instance of your rule / container
     *
     * @param $config
     * @return Rule
     */
    public function get($config);
}