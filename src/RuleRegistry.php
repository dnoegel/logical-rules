<?php
namespace Dnoegel\Rules;

use Dnoegel\Rules\Rule\Container\AndRule;
use Dnoegel\Rules\Rule\Container\NotRule;
use Dnoegel\Rules\Rule\Container\OrRule;
use Dnoegel\Rules\Rule\Container\XorRule;
use Dnoegel\Rules\Rule\ConfigAware;
use Dnoegel\Rules\Rule\ContextAware;
use Dnoegel\Rules\Rule\FalseRule;
use Dnoegel\Rules\Rule\TrueRule;

/**
 * RuleRegistry keeps track of all known rules. If you want to add own rules, use the add() method
 *
 * Class RuleRegistry
 * @package Dnoegel\Rules
 */
class RuleRegistry
{
    protected $rules = array();

    public function __construct()
    {
        $this->rules['and'] = new AndRule();
        $this->rules['or'] = new OrRule();
        $this->rules['xor'] = new XorRule();
        $this->rules['not'] = new NotRule();

        $this->rules['false'] = new FalseRule();
        $this->rules['true'] = new TrueRule();
    }


    /**
     * Add a new rule object to the registry.
     *
     * @param $name     string  Unique name of your rule
     * @param $instance Rule    Instance of your rule
     */
    public function add($name, Rule $instance)
    {
        $this->rules[$name] = $instance;
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


        $class = clone $this->rules[$name];

        if ($class instanceof ConfigAware) {
            $class->setConfig($config);
        }

        return $class;
    }

}