<?php
declare(strict_types=1);


namespace App\Model;


class RepoDetails
{
    /**
     * @var int
     */
    private $starsCount;
    /**
     * @var int
     */
    private $forksCount;
    /**
     * @var int
     */
    private $watchersCount;
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $hasEqualStarsNumber;
    /**
     * @var bool
     */
    private $hasEqualForksNumber;
    /**
     * @var bool
     */
    private $hasEqualWatchersNumber;
    /**
     * @var bool
     */
    private $hasMoreStars;
    /**
     * @var bool
     */
    private $hasMoreForks;
    /**
     * @var bool
     */
    private $hasMoreWatchers;

    public function __construct
    (
        int $starsCount,
        int $forksCount,
        int $watchersCount,
        string $name,
        bool $hasEqualStarsNumber = false,
        bool $hasEqualForksNumber = false,
        bool $hasEqualWatchersNumber = false,
        bool $hasMoreStars = false,
        bool $hasMoreForks = false,
        bool $hasMoreWatchers = false
    )
    {
        $this->starsCount = $starsCount;
        $this->forksCount = $forksCount;
        $this->watchersCount = $watchersCount;
        $this->name = $name;
        $this->hasEqualStarsNumber = $hasEqualStarsNumber;
        $this->hasEqualForksNumber = $hasEqualForksNumber;
        $this->hasEqualWatchersNumber = $hasEqualWatchersNumber;
        $this->hasMoreStars = $hasMoreStars;
        $this->hasMoreForks = $hasMoreForks;
        $this->hasMoreWatchers = $hasMoreWatchers;
    }

    public function getStarsCount(): int
    {
        return $this->starsCount;
    }

    public function getForksCount(): int
    {
        return $this->forksCount;
    }

    public function getWatchersCount(): int
    {
        return $this->watchersCount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isHasEqualStarsNumber(): bool
    {
        return $this->hasEqualStarsNumber;
    }

    public function setHasEqualStarsNumber(bool $hasEqualStarsNumber): void
    {
        $this->hasEqualStarsNumber = $hasEqualStarsNumber;
    }

    public function isHasEqualForksNumber(): bool
    {
        return $this->hasEqualForksNumber;
    }

    public function setHasEqualForksNumber(bool $hasEqualForksNumber): void
    {
        $this->hasEqualForksNumber = $hasEqualForksNumber;
    }

    public function isHasEqualWatchersNumber(): bool
    {
        return $this->hasEqualWatchersNumber;
    }

    public function setHasEqualWatchersNumber(bool $hasEqualWatchersNumber): void
    {
        $this->hasEqualWatchersNumber = $hasEqualWatchersNumber;
    }

    public function isHasMoreStars(): bool
    {
        return $this->hasMoreStars;
    }

    public function setHasMoreStars(bool $hasMoreStars): void
    {
        $this->hasMoreStars = $hasMoreStars;
    }

    public function isHasMoreForks(): bool
    {
        return $this->hasMoreForks;
    }

    public function setHasMoreForks(bool $hasMoreForks): void
    {
        $this->hasMoreForks = $hasMoreForks;
    }

    public function isHasMoreWatchers(): bool
    {
        return $this->hasMoreWatchers;
    }

    public function setHasMoreWatchers(bool $hasMoreWatchers): void
    {
        $this->hasMoreWatchers = $hasMoreWatchers;
    }
}