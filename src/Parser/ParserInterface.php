<?php


namespace App\Parser;


interface ParserInterface
{
    public function parseRepoNameOrLink(string $firstRepo, string $secondRepo);
}