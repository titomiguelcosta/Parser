<?php

namespace Language;

use Doctrine\Common\Lexer\AbstractLexer;
use Language\Expression\ExpressionInterface;

class Lexer extends AbstractLexer
{
    const T_NONE = 1;
    const T_PICK_WORD = 100;
    const T_APPEND_WORD = 101;
    const T_REPLACE_WORD = 102;

    protected $expressions = [];

    /**
     * @param ExpressionInterface $expression
     */
    public function addExpression(ExpressionInterface $expression)
    {
        $this->expressions[$expression->token()] = $expression;
    }

    /**
     * @param $token
     * @return ExpressionInterface|null
     */
    public function getExpression($token)
    {
        return array_key_exists($token, $this->expressions)
            ? $this->expressions[$token]
            : null;
    }
    /**
     * Lexical catchable patterns.
     *
     * @return array
     */
    protected function getCatchablePatterns() {
        $expressions = array_map(
            function (ExpressionInterface $expr) {
                return $expr->getCatchablePattern();
            },
            $this->expressions
        );

        return $expressions;
    }

    /**
     * Lexical non-catchable patterns.
     *
     * @return array
     */
    protected function getNonCatchablePatterns() 
    {
        return ['\s+', '(.)'];
    }

    /**
     * Retrieve token type. Also processes the token value if necessary.
     *
     * @param string $value
     * @return integer
     */
    protected function getType(&$value)
    {
        /** @var ExpressionInterface $expression */
        foreach ($this->expressions as $expression) {
            if ($expression->matches($value)) {
                return $expression->token();
            }
        }

        return self::T_NONE;
    }
}