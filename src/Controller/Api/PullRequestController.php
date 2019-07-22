<?php
declare(strict_types=1);


namespace App\Controller\Api;

use App\Manager\RepoManager;
use App\Service\Compare\PullRequestsCompare;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * @Route("/compare")
 */
class PullRequestController extends AbstractFOSRestController
{
    /**
     * @var RepoManager
     */
    private $repoManager;
    /**
     * @var PullRequestsCompare
     */
    private $pullRequestsCompare;

    public function __construct(RepoManager $repoManager, PullRequestsCompare $pullRequestsCompare)
    {
        $this->repoManager = $repoManager;
        $this->pullRequestsCompare = $pullRequestsCompare;
    }

    /**
     * @SWG\Parameter(
     *     name="firstRepo",
     *     in="query",
     *     type="string",
     *     description="First repo link or repository owner and name like: KnpLabs/php-github-api"
     * )
     *
     * @SWG\Parameter(
     *     name="secondRepo",
     *     in="query",
     *     type="string",
     *     description="Second repo link or repository owner and name like: KnpLabs/php-github-api"
     * )
     *
     * @SWG\Parameter(
     *     name="state",
     *     in="query",
     *     type="string",
     *     description="State of pull request. Default is open"
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Compare pull requests",
     *     )
     *
     * @SWG\Tag(name="Pull requests")
     *
     * @Route("/pull-requests", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws \App\Exception\RepositoryNotFoundException
     */

    public function comparePullRequests(Request $request): Response
    {
        $firstRepo = $request->query->get('firstRepo');
        $secondRepo = $request->query->get('secondRepo');
        $state = 'open';

        if (!isset($firstRepo, $secondRepo) || empty($firstRepo) || empty($secondRepo)) {
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        }

        if (null !== $request->query->get('state')) {
            $state = $request->query->get('state');
        }

        $repoNameAndOwner = $this->repoManager->getRepoNameAndOwner($firstRepo, $secondRepo);

        $comparedPullRequests = $this->pullRequestsCompare->compare($this->repoManager->getPullRequests($repoNameAndOwner, $state));

        return $this->handleView($this->view($comparedPullRequests, Response::HTTP_OK));
    }
}