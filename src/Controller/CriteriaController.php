<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\Criteria as CriteriaDto;
use App\Entity\Criteria;
use App\Entity\CriteriaType;
use App\Repository\CriteriaRepository;
use App\Repository\GroupRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as BaseRoute;

/**
 * @BaseRoute("/criteria", name="criteria_")
 */
class CriteriaController extends AbstractFOSRestController //implements TokenAuthenticatedControllerInterface
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var CriteriaRepository
     */
    private $criteriaRepository;

    public function __construct(GroupRepository $groupRepository, CriteriaRepository $criteriaRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->criteriaRepository = $criteriaRepository;
    }

    /**
     * @Rest\Post("/create")
     */
    public function createCriteria(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $group = $this->groupRepository->findOneBy(['id' => (int)$data['groupId']]);
        $criteria = new Criteria;
        $criteria->setName($data['name'])
                 ->setGroup($group)
                 ->setMultiple((bool)$data['multiple']);

        $type = new CriteriaType;
        $type->setId($data['type']['id'])
             ->setName($data['type']['name']);

        $criteria->setCriteriaType($type);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($criteria);
        $entityManager->persist($type);
        $entityManager->flush();

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/list")
     */
    public function criteriasList(): Response
    {
        $items = array_map(
            function (Criteria $group) {
                return CriteriaDto::fromEntity($group)->toArray();
            }, $this->criteriaRepository->findAll());

        return $this->json($items, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/update")
     */
    public function updateCriteria(Request $request): Response
    {
        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/list-by-group/{groupId}")
     */
    public function values(int $groupId): Response
    {
        $criterias = $this->criteriaRepository->getCriteriasByGroup($groupId);
        $items = array_map(function (Criteria $criteria) {
            return CriteriaDto::fromEntity($criteria)->toArray();
        }, $criterias);

        return $this->json($items, Response::HTTP_OK);
    }
}
