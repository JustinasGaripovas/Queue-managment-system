<?php

namespace App\Controller;

use App\Entity\QueueTask;
use App\Exception\QueueTaskException\InterestTypeInvalid;
use App\Repository\InterestTypeRepository;
use App\Repository\QueueTaskRepository;
use App\Response\QueueResponse\QueueTaskNewSuccessResponse;
use App\Response\QueueResponse\QueueTaskNoAvalibleNumbersResponse;
use App\Service\DeskAssigmentHelper;
use App\Utilities\Enum\QueueTaskStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QueueTaskController extends AbstractController
{
    private $entityManager;
    private $queueTaskRepository = QueueTaskRepository::class;

    public function __construct(EntityManagerInterface $entityManager, QueueTaskRepository $queueTaskRepository)
    {
        $this->entityManager = $entityManager;
        $this->queueTaskRepository = $queueTaskRepository;
    }

    /**
     * @Route("/", name="registration")
     */
    public function index(InterestTypeRepository $interestTypeRepository)
    {
        return $this->render('registration/index.html.twig', [
            'baseInterest' => $interestTypeRepository->findAllRoots()
        ]);
    }

    /**
     * @param QueueTask $queueTask
     * @return int
     * @throws NonUniqueResultException
     */
    private function getQueueNumber(QueueTask $queueTask)
    {
        $interestTypeId = $queueTask->getInterestType()->getId();
        $oldestId = $this->queueTaskRepository->findOldestIdToday($interestTypeId);
        $nextAvailable = $this->queueTaskRepository->findNextAvailable($interestTypeId);

        if (empty($oldestId))
            return 0;

        if ($oldestId->getQueueNumber() >= 99) {
            if ($nextAvailable === null)
                return null;

            return $nextAvailable->getQueueNumber();
        }

        return $oldestId->getQueueNumber() + 1;
    }

    /**
     * @Route("/new" , name="queue_task_new", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param InterestTypeRepository $interestTypeRepository
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function queueTaskNew(Request $request, InterestTypeRepository $interestTypeRepository, DeskAssigmentHelper $deskAssigmentHelper): JsonResponse
    {
        $queueTask = new QueueTask();

        // Gets user selected ticket option.
        $interestId = $request->request->get('interestId');

        if (($interestType = $interestTypeRepository->findOneById($interestId)) === null)
            throw new InterestTypeInvalid();

        $queueTask->setInterestType($interestType);

        if (($queueNumber = $this->getQueueNumber($queueTask)) !== null)
            $queueTask->setQueueNumber($queueNumber);
        else
            return new QueueTaskNoAvalibleNumbersResponse();

        $queueTask->addStatus(QueueTaskStatusEnum::NEW);
        $queueTask->addStatus(QueueTaskStatusEnum::WAITING);


        $this->entityManager->persist($queueTask);
        $this->entityManager->flush();

        $deskAssigmentHelper->assignDesk($queueTask);

        return new QueueTaskNewSuccessResponse('Success', ['queue_number' => $queueTask->getFormattedQueueNumber()]);
    }
}
