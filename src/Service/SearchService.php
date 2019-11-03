<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\SearchRequest;
use App\Dto\UserCriteria as UserCriteriaDto;
use App\Entity\Criteria;
use App\Entity\Group;
use App\Entity\UserProperties;
use App\Entity\UserSelectedValue;
use App\Repository\CriteriaRepository;
use App\Repository\CriteriaValuesRepository;
use App\Repository\GroupRepository;
use App\Repository\UserPropertiesRepository;
use App\Repository\UserRepository;
use App\Service\CriteriaTypes\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class SearchService
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var UserPropertiesRepository
     */
    private $propertiesRepository;

    /**
     * @var UserProperties
     */
    private $userPropertiesService;

    /**
     * @var CriteriaRepository
     */
    private $criteriaRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPropertiesRepository
     */
    private $userPropertiesRepository;
    /**
     * @var CriteriaValuesRepository
     */
    private $criteriaValuesRepository;

    public function __construct(
        AuthService $authService,
        UserRepository $userRepository,
        GroupRepository $groupRepository,
        UserPropertiesRepository $userPropertiesRepository,
        CriteriaRepository $criteriaRepository,
        CriteriaValuesRepository $criteriaValuesRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->userPropertiesRepository = $userPropertiesRepository;
        $this->criteriaRepository = $criteriaRepository;
        $this->entityManager = $entityManager;
        $this->criteriaValuesRepository = $criteriaValuesRepository;
    }

    public function saveUserProperties(SearchRequest $request): void
    {
        if (!$user = $this->userRepository->find($request->getUserId())) {
            throw new Exception('User not found');
        }

        /** @var UserCriteriaDto $criteria */
        foreach ($request->getUserCriterias() as $criteriaDto) {

            if (!$criteria = $this->criteriaRepository->find($criteriaDto->getCriteriaId())) {
                throw new Exception(sprintf('Criteria with id %s not found', $criteriaDto->getCriteriaId()));
            }

            $criteriaValues = $this->criteriaValuesRepository->find($criteriaDto->getCriteriaId());

            $userProperties = (new UserProperties())
                ->setUser($user)
                ->setCriteria($criteria)
                ->setWeight($criteriaDto->getWeight());
            $this->entityManager->persist($userProperties);

            foreach ($criteriaDto->getValues() as $value) {
                $userSelectedValue = (new UserSelectedValue())
                    ->setUserProperty($userProperties)
                    ->setCriteriaValues($criteriaValues)
                    ->setValue($value);
                $this->entityManager->persist($userSelectedValue);
            }

            $this->entityManager->flush();
        }
    }

    public function search(SearchRequest $request) // todo: return SearchResult entity
    {
        $result = [];
        $users = $this->userRepository->findAll();
        //TODO:получить текущего пользователя
        $currentUser = $this->userRepository->find(1);
        /** @var Group $group */
        $group = $this->groupRepository->find($request->getGroupId());
        foreach ($users as $user) {
            $total_weight = 0;
            $criterias = $this->criteriaRepository->getCriteriasByGroup(1);
            foreach ($criterias as $critery) {
                /** @var Criteria $critery */
                $criteryType = Factory::create($critery->getCriteriaType()->getName());
                $weight = $this->getWeightFromRequest($request, $critery->getId());
                $userProperties = [];
                $currentUserProperties= [];
                $total_weight += $criteryType->execute($userProperties, $currentUserProperties, $weight);
            }

            $result[] = [
                'user' => $user,
                'weight' => $total_weight,
            ];
        }

        return $result;
    }

    private function getWeightFromRequest(SearchRequest $request, $criteriaId)
    {
        foreach ($request->getUserCriterias() as $userCriteria) {
            if ($userCriteria->getCriteriaId() == $criteriaId) {
                return $userCriteria->getWeight();
            }
        }

    }
}
