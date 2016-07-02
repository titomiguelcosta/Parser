<?php

namespace Language;

use Language\Expression\AppendWordExpression;
use Language\Expression\ExpressionInterface;
use Language\Expression\PickWordExpression;
use Language\Expression\ReplaceWordExpression;

class Parser
{
    protected $lexer;
    protected $word;

    /**
     * @param string $input
     */
    public function __construct($input)
    {
        $this->word = null;
        $this->lexer = new Lexer();
        $this->lexer->addExpression(new PickWordExpression());
        $this->lexer->addExpression(new AppendWordExpression());
        $this->lexer->addExpression(new ReplaceWordExpression());
        $this->lexer->setInput($input);
    }

    public function parse()
    {
        $this->lexer->moveNext();

        if ($this->lexer->lookahead['type'] != Lexer::T_PICK_WORD) {
            throw new \LogicException('Pick a word first');
        }

        while ($this->lexer->lookahead !== null) {
            $expression = $this->lexer->getExpression($this->lexer->lookahead['type']);

            if ($expression instanceof ExpressionInterface) {
                $this->word = $expression->execute($this->word, $this->lexer->lookahead['value']);
            }

            $this->lexer->moveNext();
        }
    }

    /**
     * @return null|string
     */
    public function getWord()
    {
        return $this->word;
    }
}