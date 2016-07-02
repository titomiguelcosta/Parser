<?php 

namespace Language\Expression;

use Language\Lexer;

class AppendWordExpression implements ExpressionInterface
{
    public function getCatchablePattern()
    {
        return 'APPEND WORD "(.*)"';
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
        return $current.$value;
    }
    
    public function token()
    {
        return Lexer::T_APPEND_WORD;
    }
}