<?php

require_once 'vendor/autoload.php';

$input = <<<INPUT
PICK WORD "Amigo" 
APPEND WORD " " 
APPEND WORD "do Alheio"
REPLACE WORD "Alheio" WITH "Vizinho"
APPEND WORD "!!!"
INPUT;

$parser = new \Language\Parser($input);
$parser->parse();

printf("Final word is: %s", $parser->getWord());
