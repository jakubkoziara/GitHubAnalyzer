<?php
declare(strict_types=1);


namespace App\Model;


class RepoNameAndOwner
{
    private $firstRepoName;

    private $firstRepoOwner;

    private $secondRepoName;

    private $secondRepoOwner;


    public function getFirstRepoName(): string
    {
        return $this->firstRepoName;
    }

    public function setFirstRepoName(string $firstRepoName): void
    {
        $this->firstRepoName = $firstRepoName;
    }

    public function getFirstRepoOwner(): string
    {
        return $this->firstRepoOwner;
    }

    public function setFirstRepoOwner(string$firstRepoOwner): void
    {
        $this->firstRepoOwner = $firstRepoOwner;
    }

    public function getSecondRepoName(): string
    {
        return $this->secondRepoName;
    }

    public function setSecondRepoName(string$secondRepoName): void
    {
        $this->secondRepoName = $secondRepoName;
    }

    public function getSecondRepoOwner(): string
    {
        return $this->secondRepoOwner;
    }

    public function setSecondRepoOwner(string$secondRepoOwner): void
    {
        $this->secondRepoOwner = $secondRepoOwner;
    }
}