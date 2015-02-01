<?php
use Dnoegel\Rules\Rule;

class BasketAmountRule implements Rule\ConfigAware, Rule
{
    private $currentAmount;
    private $config;
    public function __construct($currentAmount)
    {
        $this->currentAmount = $currentAmount;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function validate()
    {
        return $this->currentAmount <= $this->config;
    }
}

class RuleBuilderTest extends PHPUnit_Framework_TestCase
{

    public function testRuleBuilder()
    {
        $registry = new \Dnoegel\Rules\RuleRegistry();
        $registry->add('maxAmount', new BasketAmountRule(100));
        $registry->add('true', new Rule\TrueRule());
        $registry->add('false', new Rule\FalseRule());

        $builder = new \Dnoegel\Rules\RuleBuilder($registry);

        $result = $builder->fromArray(array(
                'and' => array(
                    'maxAmount' => 300,
                    new Rule\TrueRule()
                ),
                'or' => array(
                    'false',
                    new Rule\TrueRule()
                )
        ));

        $this->assertTrue($result->validate());
    }
}