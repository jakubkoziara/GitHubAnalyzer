<?php
declare(strict_types=1);


namespace App\Manager;

use Github\Client;

class ClientManager
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client, string $githubCredentials)
    {
        $this->client = $client;
        $this->client->authenticate($githubCredentials, null, Client::AUTH_HTTP_TOKEN);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}