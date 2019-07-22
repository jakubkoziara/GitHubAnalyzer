<?php
declare(strict_types=1);


namespace App\Manager;


use App\Exception\RepositoryNotFoundException;
use App\Model\RepoNameAndOwner;
use App\Parser\RepoNameParser;
use Github\Client;
use Github\ResultPager;

class RepoManager
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var RepoNameParser
     */
    private $parser;

    public function __construct(ClientManager $clientManager, RepoNameParser $parser)
    {
        $this->parser = $parser;
        $this->client = $clientManager->getClient();
    }

    public function getLastRelease(RepoNameAndOwner $repoNameAndOwner): array
    {
        try {
            $firstRepoData = $this->client->api('repo')->releases()->latest($repoNameAndOwner->getFirstRepoOwner(), $repoNameAndOwner->getFirstRepoName());
            $secondRepoData = $this->client->api('repo')->releases()->latest($repoNameAndOwner->getSecondRepoOwner(), $repoNameAndOwner->getSecondRepoName());
        } catch (\Exception $exception) {
            throw RepositoryNotFoundException::notFound();
        }

        return ['firstRepoData' => $firstRepoData, 'secondRepoData' => $secondRepoData];
    }

    public function getRepoDetails(RepoNameAndOwner $repoNameAndOwner): array
    {
        try {
            $firstRepoData = $this->client->api('repo')->show($repoNameAndOwner->getFirstRepoOwner(), $repoNameAndOwner->getFirstRepoName());
            $secondRepoData = $this->client->api('repo')->show($repoNameAndOwner->getSecondRepoOwner(), $repoNameAndOwner->getSecondRepoName());
        } catch (\Exception $exception) {
            throw RepositoryNotFoundException::notFound();
        }

        return ['firstRepoData' => $firstRepoData, 'secondRepoData' => $secondRepoData];
    }

    public function getPullRequests(RepoNameAndOwner $repoNameAndOwner, string $state): array
    {
        $pullRequestApi = $this->client->api('pull_request');

        $paginator = new ResultPager($this->client);

        try {
            $parameters = [$repoNameAndOwner->getFirstRepoOwner(), $repoNameAndOwner->getFirstRepoName(), ['state' => $state]];

            $firstRepoData = $paginator->fetchAll($pullRequestApi, 'all', $parameters);

            $parameters = [$repoNameAndOwner->getSecondRepoOwner(), $repoNameAndOwner->getSecondRepoName(), ['state' => $state]];

            $secondRepoData = $paginator->fetchAll($pullRequestApi, 'all', $parameters);
        } catch (\Exception $exception) {
            throw RepositoryNotFoundException::notFound();
        }

        return ['firstRepoPullRequestsNumber' => count($firstRepoData), 'secondRepoPullRequestsNumber' => count($secondRepoData)];
    }

    public function getRepoNameAndOwner(string $firstRepo, string $secondRepo): RepoNameAndOwner
    {
        return $this->parser->parseRepoNameOrLink($firstRepo, $secondRepo);
    }
}