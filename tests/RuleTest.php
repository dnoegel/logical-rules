<?php

use Dnoegel\Rules\Rule\Container\AndRule;
use Dnoegel\Rules\Rule\Container\NotRule;
use Dnoegel\Rules\Rule\Container\OrRule;
use Dnoegel\Rules\Rule\FalseRule;
use Dnoegel\Rules\Rule\TrueRule;

class RuleTest extends PHPUnit_Framework_TestCase
{
    private function getRuleBuilder()
    {
        return new \Dnoegel\Rules\RuleBuilder(new \Dnoegel\Rules\RuleRegistry());
    }

    public function testConstructorContainer()
    {
        $rule = new AndRule(
            new TrueRule(),
            new OrRule(
                new FalseRule(),
                new TrueRule()
            ),
            new NotRule(
                new FalseRule()
            )
        );

        $this->assertTrue($rule->validate());
    }

    public function testNotRule()
    {
        $rule = new NotRule();
        $rule->addRule(new TrueRule());

        $this->assertFalse($rule->validate());

        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
        ), 'not');
        $this->assertTrue($rule->validate());


        try {
            $rule = $this->getRuleBuilder()->fromArray(array(
                'false',
                'true',
            ), 'not');
        } catch (\RuntimeException $e) {
            $rule = null;
        }
        $this->assertNull($rule);

    }

    public function testOrRule()
    {
        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
            'true'
        ), 'or');
        $this->assertTrue($rule->validate());

        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
            'false'
        ), 'or');
        $this->assertFalse($rule->validate());
    }

    public function testAndRule()
    {
        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
            'true'
        ), 'and');
        $this->assertFalse($rule->validate());

        $rule = $this->getRuleBuilder()->fromArray(array(
            'true',
            'true'
        ), 'and');
        $this->assertTrue($rule->validate());
    }

    public function testXorRule()
    {
        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
            'true',
            'false'
        ), 'xor');
        $this->assertTrue($rule->validate());

        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
            'false'
        ), 'xor');
        $this->assertFalse($rule->validate());

        $rule = $this->getRuleBuilder()->fromArray(array(
            'false',
            'true',
            'true'
        ), 'xor');
        $this->assertFalse($rule->validate());
    }
}