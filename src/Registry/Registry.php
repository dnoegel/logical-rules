<?php
namespace Dnoegel\Rules\Registry;

use Dnoegel\Rules\Registry\Type\Instance;
use Dnoegel\Rules\Registry\Type\Name;
use Dnoegel\Rules\Rule\Container;
use Dnoegel\Rules\Rule;

/**
 * Registry keeps track of all known rules. If you want to add own rules, use the add() method.
 *
 * Class Registry
 * @package Dnoegel\Rules
 */
class Registry
{
    /** @var Type[] */
    protected $rules = array();

    public function __construct()
    {
        $this->add('and', new Container\AndRule());
        $this->add('or', new Container\OrRule());
        $this->add('xor', new Container\XorRule());
        $this->add('not', new Container\NotRule());

        $this->add('false', new Rule\FalseRule());
        $this->add('true', new Rule\TrueRule());
    }


    /**
     * Add a rule to the registry. Rule can be an instance of
     *  * Type\Callback
     *  * Type\Instance
     *  * Type\Name
     *
     * @param $name
     * @param $rule     Type|Rule
     * @throws \RuntimeException
     *
     * @return Registry
     */
    public function add($name, $rule)
    {
        // Convenience fallback: When having a rule instance, we can safely wrap it into a Type object
        if ($rule instanceof Rule) {
            $rule = new Instance($rule, $rule instanceof Container\Container);
        }

        // Enforce type objects
        if (!$rule instanceof Type) {
            throw new \RuntimeException("Rule must be an instance of Registry\\Type or Rule");
        }

        $this->rules[$name] = $rule;
        return $this;
    }

    /**
     * @param   $name   string  name of the rule to load
     * @param   $config mixed   additional config to apply to the rule
     * @return  Rule
     * @throws  \RuntimeException
     */
    public function get($name, $config = null)
    {
        if (!isset($this->rules[$name])) {
            throw new \RuntimeException("Rule $name not found");
        }

        return $this->rules[$name]->get($config);
    }

    /**
     * Check if the requested rule is a container or not
     *
     * @param $name
     * @return bool
     * @throws \RuntimeException
     */
    public function isContainer($name)
    {
        if (!isset($this->rules[$name])) {
            throw new \RuntimeException("Rule $name not found");
        }

        return $this->rules[$name]->isContainer();
    }

}