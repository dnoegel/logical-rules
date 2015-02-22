<?php

namespace Dnoegel\Rules;
use Dnoegel\Rules\Registry\Registry;
use Dnoegel\Rules\Rule\Container\Container;

/**
 * RuleBuilder helps you creating nested rules from an array structure
 *
 * Class RuleBuilder
 * @package Dnoegel\Rules
 */
class RuleBuilder
{
    /**
     * @var Registry
     */
    private $ruleRegistry;

    public function __construct(Registry $ruleRegistry)
    {
        $this->ruleRegistry = $ruleRegistry;
    }

    /**
     * @param $array         Array   Array to automatically create rule tree from
     * @param $containerType string  Type of the overlaying container
     * @return Rule\Container\Container
     */
    public function fromArray($array, $containerType = 'and')
    {
        /** @var Rule\Container\Container $container */
        $container = $this->ruleRegistry->get($containerType);

        foreach ($array as $name => $value) {
            if (is_array($value) && $this->ruleRegistry->isContainer($name)) {
                // array = container. Build it by recursively the fromArray method
                $container->addRule($this->fromArray($value, $name));
            } elseif ($value instanceof Rule) {
                // instance of rule
                $container->addRule($value);
            } elseif (is_numeric($name) && is_string($value)) {
                // numeric $name && string $value => only the name of a rule was passed
                // e.g. 'false'
                $container->addRule($this->ruleRegistry->get($value));
            } elseif (is_string($name)) {
                // e.g. 'maxAmount' => 300
                $container->addRule($this->ruleRegistry->get($name, $value));
            }
        }

        return $container;
    }
}
