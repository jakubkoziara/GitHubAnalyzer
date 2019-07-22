<?php
declare(strict_types=1);


namespace App\Service\Compare;


use App\Model\RepoPullRequests;

class PullRequestsCompare implements CompareInterface
{
    /**
     * @var RepoPullRequests
     */
    private $firstRepoData;
    /**
     * @var RepoPullRequests
     */
    private $secondRepoData;
    /**
     * @var CompareHelper
     */
    private $compareHelper;

    public function __construct(CompareHelper $compareHelper)
    {
        $this->compareHelper = $compareHelper;
    }

    public function compare(array $gitHubData): array
    {
        $this->prepareData($gitHubData);
        $this->comparePullRequestsNumber();

        return ['firstRepo' => $this->firstRepoData, 'secondRepo' => $this->secondRepoData];
    }

    private function comparePullRequestsNumber(): void
    {
        if ($this->compareHelper->checkEquals($this->firstRepoData->getPullRequestNumber(), $this->secondRepoData->getPullRequestNumber())) {
            $this->firstRepoData->setHasEqualPullRequestsNumber(true);

            $this->secondRepoData->setHasEqualPullRequestsNumber(true);
        } elseif ($this->compareHelper->checkGreaterThan($this->firstRepoData->getPullRequestNumber(), $this->secondRepoData->getPullRequestNumber())) {
            $this->firstRepoData->setHasMorePullRequests(true);
        } else {
            $this->secondRepoData->setHasMorePullRequests(true);
        }
    }

    public function prepareData(array $repoData): void
    {
        $this->firstRepoData = new RepoPullRequests($repoData['firstRepoPullRequestsNumber']);
        $this->secondRepoData =  new RepoPullRequests($repoData['secondRepoPullRequestsNumber']);
    }
}