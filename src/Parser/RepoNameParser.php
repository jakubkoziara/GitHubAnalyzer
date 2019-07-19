<?php
declare(strict_types=1);


namespace App\Parser;


class RepoNameParser implements ParserInterface
{
    public function parseRepoNameOrLink(string $firstRepo, string $secondRepo): array
    {
        //TODO: Make class for RepoOwnerAndName with getName() etc.
        $result = [];

        if ($this->isGitHubUrl($firstRepo)) {
            $result['firstRepoOwnerAndName'] = $this->extractOwnerAndName($firstRepo);
        } else {
            $result['firstRepoOwnerAndName'] = $this->explodeBySlash($firstRepo);
        }

        if ($this->isGitHubUrl($secondRepo)) {
            $result['secondRepoOwnerAndName'] = $this->extractOwnerAndName($secondRepo);
        } else {
            $result['secondRepoOwnerAndName'] = $this->explodeBySlash($secondRepo);
        }

        return $result;
    }

    private function isGitHubUrl(string $text): bool
    {
        return false !== strpos($text, 'https://github.com');
    }

    private function extractOwnerAndName(string $text): array
    {
        $explodedByHost = explode('https://github.com/', $text);

        $ownerAndRepo = end($explodedByHost);

        return $this->explodeBySlash($ownerAndRepo);
    }

    private function explodeBySlash(string $text): array
    {
        return explode('/', $text);
    }
}