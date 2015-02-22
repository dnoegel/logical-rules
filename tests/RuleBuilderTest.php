<?php
use Dnoegel\Rules\Registry\Type\Callback;
use Dnoegel\Rules\Rule;

class BasketAmountRule implements Rule
{
    private $currentAmount;
    private $maxAmount;

    public function __construct($currentAmount, $maxAmount)
    {
        $this->currentAmount = $currentAmount;
        $this->maxAmount = $maxAmount;
    }

    public function validate()
    {
        return $this->currentAmount <= $this->maxAmount;
    }
}

class RuleBuilderTest extends PHPUnit_Framework_TestCase
{

    public function testRuleBuilder()
    {
        $registry = new \Dnoegel\Rules\Registry\Registry();
        $currentBasketAmount = 199;
        $registry->add('maxAmountWithCallable', new Callback(
                function ($maxAmount) use ($currentBasketAmount) {
                    return new BasketAmountRule($currentBasketAmount, $maxAmount);
                }
            )
        );
        $registry->add('true', new Rule\TrueRule());
        $registry->add('false', new Rule\FalseRule());

        $builder = new \Dnoegel\Rules\RuleBuilder($registry);

        $result = $builder->fromArray(array(
            'and' => array(
                'maxAmountWithCallable' => 200,
                new Rule\TrueRule()
            ),
            'or' => array(
                'false',
                new Rule\TrueRule()
            )
        ));

        $this->assertTrue($result->validate());
    }

    public function testRuleBuilderWithArrayValue()
    {
        $registry = new \Dnoegel\Rules\Registry\Registry();
        $registry->add('test', new Callback(
                function ($x) {
                    return new Rule\TrueRule();
                }
            )
        );

        $builder = new \Dnoegel\Rules\RuleBuilder($registry);
        $builder->fromArray(array(
            'test' => array(1, 2, 3)
        ));
    }
}