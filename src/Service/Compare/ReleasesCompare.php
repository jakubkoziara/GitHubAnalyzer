<?php
declare(strict_types=1);


namespace App\Service\Compare;


use App\Model\RepoReleases;

class ReleasesCompare implements CompareInterface
{
    /**
     * @var CompareHelper
     */
    private $compareHelper;
    /**
     * @var RepoReleases
     */
    private $firstRepoData;
    /**
     * @var RepoReleases
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

        $this->compareReleasesDates();

        return ['firstRepo' => $this->firstRepoData, 'secondRepo' => $this->secondRepoData];
    }

    private function compareReleasesDates(): void
    {
        if($this->compareHelper->checkSameDate($this->firstRepoData->getLastCreatedDate(), $this->secondRepoData->getLastCreatedDate())){
            $this->firstRepoData->setHasSameReleaseDate(true);
            $this->secondRepoData->setHasSameReleaseDate(true);
        } elseif ($this->compareHelper->checkLastDate($this->firstRepoData->getLastCreatedDate(), $this->secondRepoData->getLastCreatedDate())){
            $this->firstRepoData->setHasNewestRelease(true);
        }else{
            $this->secondRepoData->setHasNewestRelease(true);
        }
    }

    public function prepareData(array $repoData): RepoReleases
    {
        return new RepoReleases
        (
            $repoData['created_at']
        );
    }
}