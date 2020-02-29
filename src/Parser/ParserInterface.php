<?php


namespace App\Parser;


interface ParserInterface
{
    public function parse(string $content): array;
}