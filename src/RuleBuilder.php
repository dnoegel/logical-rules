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
            $container->addRule($this->getRule($name, $value));
        }

        return $container;
    }

    /**
     * Return a rule object depending on the current array element
     *
     * @param $name
     * @param $value
     * @return Rule|Container
     */
    private function getRule($name, $value)
    {
        if (is_array($value) && $this->ruleRegistry->isContainer($name)) {
            // array = container. Build it by recursively the fromArray method
            return $this->fromArray($value, $name);
        } elseif ($value instanceof Rule) {
            // instance of rule
            return $value;
        }

        // If only a rule name was passed, normalize the form
        // e.g. array('false') is normalized to $name = 'false'
        if (is_numeric($name) && is_string($value)) {
            $name = $value;
            $value = null;
        }

        // any other form like array('myRule' => 333)
        return $this->ruleRegistry->get($name, $value);
    }
}
