<?php

namespace Language\Expression;

interface ExpressionInterface
{
    public function getCatchablePattern();
    public function matches(&$value);
    public function execute($current, $value);
    public function token();
}