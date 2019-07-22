<?php
declare(strict_types=1);


namespace App\Controller\Api;

use App\Manager\RepoManager;
use App\Service\Compare\RepoDetailsCompare;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * @Route("/compare")
 */
class RepoDetailsController extends AbstractFOSRestController
{
    /**
     * @var RepoManager
     */
    private $repoManager;
    /**
     * @var RepoDetailsCompare
     */
    private $detailsCompare;

    public function __construct(RepoManager $repoManager, RepoDetailsCompare $detailsCompare)
    {
        $this->repoManager = $repoManager;
        $this->detailsCompare = $detailsCompare;
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
     * @SWG\Response(
     *     response="200",
     *     description="Compare repo details",
     *     )
     *
     * @SWG\Tag(name="Repo details")
     *
     * @Route("/repo-details", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws \App\Exception\RepositoryNotFoundException
     */

    public function compareRepoDetails(Request $request): Response
    {
        $firstRepo = $request->query->get('firstRepo');
        $secondRepo = $request->query->get('secondRepo');

        if(!isset($firstRepo, $secondRepo) || empty($firstRepo) || empty($secondRepo)){
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        }

        $repoNameAndOwner = $this->repoManager->getRepoNameAndOwner($firstRepo, $secondRepo);

        $comparedReposRetails = $this->detailsCompare->compare($this->repoManager->getRepoDetails($repoNameAndOwner));

        return $this->handleView($this->view($comparedReposRetails, Response::HTTP_OK));
    }
}