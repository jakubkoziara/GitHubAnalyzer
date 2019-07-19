<?php

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
class ReleaseController extends AbstractFOSRestController
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
     */

    public function compareReleases(Request $request): Response
    {
        $firstRepo = $request->query->get('firstRepo');
        $secondRepo = $request->query->get('secondRepo');

        $repoNameAndOwner = $this->repoManager->getRepoNameAndOwner($firstRepo, $secondRepo);

        return $this->handleView($this->view($this->repoManager->getLastRelease(), Response::HTTP_OK));
    }
}