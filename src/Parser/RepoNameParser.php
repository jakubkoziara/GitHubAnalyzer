<?php
declare(strict_types=1);


namespace App\Parser;


use App\Model\RepoNameAndOwner;

class RepoNameParser implements ParserInterface
{
    /**
     * @var RepoNameAndOwner
     */
    private $repoNameAndOwner;

    public function __construct(RepoNameAndOwner $repoNameAndOwner)
    {
        $this->repoNameAndOwner = $repoNameAndOwner;
    }

    public function parseRepoNameOrLink(string $firstRepo, string $secondRepo): RepoNameAndOwner
    {
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

        $this->setNameAndOwner($result);

        return $this->repoNameAndOwner;
    }

    private function setNameAndOwner(array $namesAndOwners): void
    {
        $this->repoNameAndOwner->setFirstRepoOwner($namesAndOwners['firstRepoOwnerAndName'][0]);

        $this->repoNameAndOwner->setFirstRepoName($namesAndOwners['firstRepoOwnerAndName'][1]);

        $this->repoNameAndOwner->setSecondRepoOwner($namesAndOwners['secondRepoOwnerAndName'][0]);

        $this->repoNameAndOwner->setSecondRepoName($namesAndOwners['secondRepoOwnerAndName'][1]);
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