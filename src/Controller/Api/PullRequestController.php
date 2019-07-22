<?php
declare(strict_types=1);


namespace App\Controller\Api;

use App\Manager\RepoManager;
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

    public function __construct(RepoManager $repoManager)
    {
        $this->repoManager = $repoManager;
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
     */

    public function comparePullRequests(Request $request): Response
    {
        $firstRepo = $request->query->get('firstRepo');
        $secondRepo = $request->query->get('secondRepo');

        if(!isset($firstRepo, $secondRepo) || empty($firstRepo) || empty($secondRepo)){
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        }

        $state = $request->query->get('state');

        $repoNameAndOwner = $this->repoManager->getRepoNameAndOwner($firstRepo, $secondRepo);

        return $this->handleView($this->view($this->repoManager->getPullRequests($repoNameAndOwner), Response::HTTP_OK));
    }
}