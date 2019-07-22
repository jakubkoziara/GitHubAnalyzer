<?php
declare(strict_types=1);


namespace App\Service\Compare;


use App\Model\RepoDetails;

class RepoDetailsCompare implements CompareInterface
{
    /**
     * @var CompareHelper
     */
    private $compareHelper;
    /**
     * @var RepoDetails
     */
    private $firstRepoData;
    /**
     * @var RepoDetails
     */
    private $secondRepoData;

    public function __construct(CompareHelper $compareHelper)
    {
        $this->compareHelper = $compareHelper;
    }

    public function compare(array $gitHubData): array
    {
        $this->firstRepoData = $this->prepareData($gitHubData['firstRepoData']);
        $this->secondRepoData = $this->prepareData($gitHubData['secondRepoData']);

        $this->compareStarsNumber();
        $this->compareForksNumber();
        $this->compareWatchersNumber();

        return ['firstRepo' => $this->firstRepoData, 'secondRepo' => $this->secondRepoData];
    }

    private function compareStarsNumber(): void
    {
        if ($this->compareHelper->checkEquals($this->firstRepoData->getStarsCount(), $this->secondRepoData->getStarsCount())) {
            $this->firstRepoData->setHasEqualStarsNumber(true);

            $this->secondRepoData->setHasEqualStarsNumber(true);
        } elseif ($this->compareHelper->checkGreaterThan($this->firstRepoData->getStarsCount(), $this->secondRepoData->getStarsCount())) {
            $this->firstRepoData->setHasMoreStars(true);
        } else {
            $this->secondRepoData->setHasMoreStars(true);
        }
    }

    private function compareForksNumber(): void
    {
        if ($this->compareHelper->checkEquals($this->firstRepoData->getForksCount(), $this->secondRepoData->getForksCount())) {
            $this->firstRepoData->setHasEqualForksNumber(true);

            $this->secondRepoData->setHasEqualForksNumber(true);
        } elseif ($this->compareHelper->checkGreaterThan($this->firstRepoData->getForksCount(), $this->secondRepoData->getForksCount())) {
            $this->firstRepoData->setHasMoreForks(true);
        } else {
            $this->secondRepoData->setHasMoreForks(true);
        }
    }

    private function compareWatchersNumber(): void
    {
        if ($this->compareHelper->checkEquals($this->firstRepoData->getWatchersCount(), $this->secondRepoData->getWatchersCount())) {
            $this->firstRepoData->setHasEqualWatchersNumber(true);

            $this->secondRepoData->setHasEqualWatchersNumber(true);
        } elseif ($this->compareHelper->checkGreaterThan($this->firstRepoData->getWatchersCount(), $this->secondRepoData->getWatchersCount())) {
            $this->firstRepoData->setHasMoreWatchers(true);
        } else {
            $this->secondRepoData->setHasMoreWatchers(true);
        }
    }


    public function prepareData(array $repoData): RepoDetails
    {
        return new RepoDetails
        (
            $repoData['stargazers_count'],
            $repoData['forks_count'],
            $repoData['subscribers_count'],
            $repoData['full_name']
        );
    }
}