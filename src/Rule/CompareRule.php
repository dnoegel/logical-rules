<?php

namespace Dnoegel\Rules\Rule;

use Dnoegel\Rules\Rule;

/**
 * CompareRule allows simple comparisons of two operands.
 *
 * Class CompareRule
 * @package Dnoegel\Rules\Rule
 */
class CompareRule implements Rule, ConfigAware
{
    /**
     * @var
     */
    private $operator;
    /**
     * @var
     */
    private $leftOperand;

    private $rightOperand;

    public function __construct($leftOperand, $operator, $rightOperand = null)
    {
        $this->leftOperand = $leftOperand;
        $this->operator = $operator;
        $this->rightOperand = $rightOperand;
    }

    /**
     * @param $config
     * @return mixed
     */
    public function setConfig($config)
    {
        $this->rightOperand = $config;
    }

    /**
     * Validate the current rule and return boolean to indicate if the current
     * rule applied (true) or not (false)
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function validate()
    {
        if ($this->leftOperand === null) {
            throw new \RuntimeException("Left operand not defined");
        }
        if ($this->rightOperand === null) {
            throw new \RuntimeException("Right operand not defined");
        }

        switch ($this->operator) {
            case '>':
                return $this->leftOperand > $this->rightOperand;
            case '>=':
                return $this->leftOperand >= $this->rightOperand;
            case '<':
                return $this->leftOperand < $this->rightOperand;
            case '<=':
                return $this->leftOperand <= $this->rightOperand;
            case '=':
                return $this->leftOperand == $this->rightOperand;
            case '<>':
            case '!=':
                return $this->leftOperand != $this->rightOperand;
        }

        throw new \RuntimeException("Unknown operator {$this->operator}");
    }
}