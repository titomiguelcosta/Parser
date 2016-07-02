<?php 

namespace Language\Expression;

use Language\Lexer;

class ReplaceWordExpression implements ExpressionInterface
{
    public function getCatchablePattern()
    {
        return 'REPLACE WORD "(.*)" WITH "(.*)"';
    }

    public function matches(&$value)
    {
        $match = preg_match(sprintf('/%s/', $this->getCatchablePattern()), $value, $matches);

        if ($match) {
            $value = [$matches[1], $matches[2]];
        }

        return $match;
    }

    public function execute($current, $value)
    {
        return str_replace($value[0], $value[1], $current);
    }
    
    public function token()
    {
        return Lexer::T_REPLACE_WORD;
    }
}