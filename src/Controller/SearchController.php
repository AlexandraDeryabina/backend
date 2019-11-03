<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\SearchRequest;
use App\Service\SearchService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractFOSRestController
{
    /**
     * @var SearchService
     */
    private $searchService;

    public function __construct(
        SearchService $searchService
    )
    {
        $this->searchService = $searchService;
    }

    /**
     * @Rest\Post("/search")
     */
    public function search(Request $request): Response
    {
        $searchRequest = SearchRequest::fromRequest($request);

        $this->searchService->saveUserProperties($searchRequest);

        $this->searchService->search($searchRequest);

        return $this->json([], Response::HTTP_CREATED);
    }
}
