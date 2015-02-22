<?php

use Dnoegel\Rules\Registry\Type\Callback;

class TestRule implements \Dnoegel\Rules\Rule
{
    public function validate()
    {
        return true;
    }
}

class RuleFactory
{
    public static function getTestRule()
    {
        return new TestRule();
    }
}

class RuleRegistryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Dnoegel\Rules\Registry\Registry
     */
    private function getRuleRegistry()
    {
        return new \Dnoegel\Rules\Registry\Registry();
    }

    public function testClosure()
    {
        $registry = $this->getRuleRegistry();
        $registry->add('test', new Callback(function () {
                return new TestRule();
            })
        );
        $this->assertTrue($registry->get('test')->validate());
    }

    public function testStatic()
    {
        $registry = $this->getRuleRegistry();
        $registry->add('test2', new Callback(array('RuleFactory', 'getTestRule')));
        $this->assertTrue($registry->get('test2')->validate());
    }

    public function testInstance()
    {
        $registry = $this->getRuleRegistry();
        $registry->add('test3', new Callback(array(new RuleFactory(), 'getTestRule')));
        $this->assertTrue($registry->get('test3')->validate());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNotExistingRule()
    {
        $this->getRuleRegistry()->get('notExistingRule');
    }
}