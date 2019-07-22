<?php

namespace App\Controller\Api;


use App\Manager\RepoManager;
use App\Service\Compare\ReleasesCompare;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * @Route("/compare")
 */
class ReleaseController extends AbstractFOSRestController
{
    /**
     * @var RepoManager
     */
    private $repoManager;
    /**
     * @var ReleasesCompare
     */
    private $releasesCompare;

    public function __construct(RepoManager $repoManager, ReleasesCompare $releasesCompare)
    {
        $this->repoManager = $repoManager;
        $this->releasesCompare = $releasesCompare;
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
     *     description="Compare last releases",
     *     )
     *
     * @SWG\Tag(name="Releases")
     *
     * @Route("/releases", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws \App\Exception\RepositoryNotFoundException
     */

    public function compareLastReleases(Request $request): Response
    {
        $firstRepo = $request->query->get('firstRepo');
        $secondRepo = $request->query->get('secondRepo');

        if(!isset($firstRepo, $secondRepo) || empty($firstRepo) || empty($secondRepo)){
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        }

        $repoNameAndOwner = $this->repoManager->getRepoNameAndOwner($firstRepo, $secondRepo);

        $comparedReleases = $this->releasesCompare->compare($this->repoManager->getLastRelease($repoNameAndOwner));

        return $this->handleView($this->view($comparedReleases, Response::HTTP_OK));
    }
}