<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Group;
use App\Dto\Group as GroupDto;
use App\Repository\GroupRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route as BaseRoute;

/**
 * @BaseRoute("/group", name="group_")
 */
class GroupController extends AbstractFOSRestController
{
    /**
     * @var GroupRepository|RepositoryFactory
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @Rest\Get("/list")
     */
    public function groupsList(): Response
    {
        $items = array_map(function (Group $group) {
            return GroupDto::fromEntity($group)->toArray();
        }, $this->groupRepository->findAll());

        return $this->json($items, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/create")
     */
    public function createGroup(Request $request): Response
    {
         $data = json_decode($request->getContent(), true);
         $group = new Group();
         $group->setName($data['name']);
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($group);
         $entityManager->flush();

        return $this->json([], Response::HTTP_CREATED);
    }
}
