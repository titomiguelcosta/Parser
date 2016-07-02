<?php 

namespace Language\Expression;

use Language\Lexer;

class PickWordExpression implements ExpressionInterface
{
    public function getCatchablePattern()
    {
        return 'PICK WORD "(.*)"';
    }

    public function matches(&$value)
    {
        $match = preg_match(sprintf('/%s/', $this->getCatchablePattern()), $value, $matches);

        if ($match) {
            $value = $matches[1];
        }

        return $match;
    }

    public function execute($current, $value)
    {
        return $value;
    }
    
    public function token()
    {
        return Lexer::T_PICK_WORD;
    }
}