<?php
declare(strict_types=1);


namespace App\Model;


class RepoReleases
{
    /**
     * @var bool
     */
    private $hasNewestRelease;
    /**
     * @var string
     */
    private $lastCreatedDate;
    /**
     * @var bool
     */
    private $hasSameReleaseDate;

    public function __construct( string $lastCreatedDate, bool $hasNewestRelease = false, bool $hasSameReleaseDate = false)
    {
        $this->hasNewestRelease = $hasNewestRelease;
        $this->lastCreatedDate = $lastCreatedDate;
        $this->hasSameReleaseDate = $hasSameReleaseDate;
    }

    public function isHasNewestRelease(): bool
    {
        return $this->hasNewestRelease;
    }

    public function setHasNewestRelease(bool $hasNewestRelease): void
    {
        $this->hasNewestRelease = $hasNewestRelease;
    }

    public function getLastCreatedDate(): \DateTime
    {
        return new \DateTime($this->lastCreatedDate);
    }

    public function isHasSameReleaseDate(): bool
    {
        return $this->hasSameReleaseDate;
    }

    public function setHasSameReleaseDate(bool $hasSameReleaseDate): void
    {
        $this->hasSameReleaseDate = $hasSameReleaseDate;
    }
}