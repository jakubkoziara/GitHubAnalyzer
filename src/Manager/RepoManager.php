<?php
declare(strict_types=1);


namespace App\Manager;


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

    public function getLastRelease($repoNameAndOwner): array
    {
        return $this->client->api('repo')->releases()->latest('KnpLabs', 'php-github-api');
    }

    public function getRepoDetails(): array
    {
        return $this->client->api('repo')->show('KnpLabs', 'php-github-api');
    }

    public function getPullRequests(): array
    {
        $pullRequestApi = $this->client->api('pull_request');

        $paginator = new ResultPager($this->client);

        $parameters = array('KnpLabs', 'php-github-api', array('state' => 'closed'));

        return $paginator->fetchAll($pullRequestApi, 'all', $parameters);
    }

    public function getRepoNameAndOwner(string $firstRepo, string $secondRepo): array
    {
        return $this->parser->parseRepoNameOrLink($firstRepo, $secondRepo);
    }
}