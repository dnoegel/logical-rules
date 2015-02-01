<?php

namespace Dnoegel\Rules;

/**
 * RuleBuilder helps you creating nested rules from an array structure
 *
 * Class RuleBuilder
 * @package Dnoegel\Rules
 */
class RuleBuilder
{
    /**
     * @var RuleRegistry
     */
    private $ruleRegistry;

    public function __construct(RuleRegistry $ruleRegistry)
    {
        $this->ruleRegistry = $ruleRegistry;
    }

    /**
     * @param $array         Array   Array to automatically create rule tree from
     * @param $containerType string  Type of the overlaying container
     * @return Rule\Container\Container
     */
    public function fromArray($array, $containerType='and')
    {
        /** @var Rule\Container\Container $container */
        $container = $this->ruleRegistry->get($containerType);

        foreach ($array as $name => $value) {
            if (is_array($value)) {
                $container->addRule($this->fromArray($value, $name));
            } elseif ($value instanceof Rule){
                $container->addRule($value);
            } elseif (is_numeric($name) && is_string($value)) {
                $container->addRule($this->ruleRegistry->get($value));
            } else {
                $container->addRule($this->ruleRegistry->get($name, $value));
            }
        }

        return $container;
    }
}
