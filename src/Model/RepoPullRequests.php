<?php
declare(strict_types=1);


namespace App\Model;


class RepoPullRequests
{
    /**
     * @var int
     */
    private $pullRequestNumber;
    /**
     * @var bool
     */
    private $hasMorePullRequests;
    /**
     * @var bool
     */
    private $hasEqualPullRequestsNumber;

    public function __construct
    (
        int $pullRequestNumber, bool $hasMorePullRequests = false, bool $hasEqualPullRequestsNumber = false
    )
    {
        $this->pullRequestNumber = $pullRequestNumber;
        $this->hasMorePullRequests = $hasMorePullRequests;
        $this->hasEqualPullRequestsNumber = $hasEqualPullRequestsNumber;
    }

    public function getPullRequestNumber(): int
    {
        return $this->pullRequestNumber;
    }

    public function isHasMorePullRequests(): bool
    {
        return $this->hasMorePullRequests;
    }

    public function setHasMorePullRequests(bool $hasMorePullRequests): void
    {
        $this->hasMorePullRequests = $hasMorePullRequests;
    }

    public function isHasEqualPullRequestsNumber(): bool
    {
        return $this->hasEqualPullRequestsNumber;
    }

    public function setHasEqualPullRequestsNumber(bool $hasEqualPullRequestsNumber): void
    {
        $this->hasEqualPullRequestsNumber = $hasEqualPullRequestsNumber;
    }
}