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

    public function getPullRequests(RepoNameAndOwner $repoNameAndOwner, string $state = 'open'): array
    {
        $pullRequestApi = $this->client->api('pull_request');

        $paginator = new ResultPager($this->client);

        $parameters = array($repoNameAndOwner->getFirstRepoOwner(), $repoNameAndOwner->getFirstRepoName(), array('state' => $state));

        return $paginator->fetchAll($pullRequestApi, 'all', $parameters);
    }

    public function getRepoNameAndOwner(string $firstRepo, string $secondRepo): RepoNameAndOwner
    {
        return $this->parser->parseRepoNameOrLink($firstRepo, $secondRepo);
    }
}