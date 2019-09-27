<?php

namespace App\Controller;

use App\Entity\QueueTask;
use App\Repository\QueueTaskRepository;
use App\Utilities\Enum\QueueTaskStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QueueTaskController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/queue/task/registration", name="queue_task_registration")
     */
    public function queueTaskRegistration()
    {
        return $this->render('abstract_queue_task/index.html.twig', [
            'controller_name' => 'QueueTaskController',
        ]);
    }

    //, condition="request.isXmlHttpRequest()"

    /**
     * @Route("/queue/task/new" , name="queue_task_new")
     */
    public function queueTaskNew(Request $request, QueueTaskRepository $queueTaskRepository): JsonResponse
    {
        $queueTask = new QueueTask();

        $queueTask->addStatus(QueueTaskStatusEnum::NEW);
        $queueTask->addStatus(QueueTaskStatusEnum::WAITING);
        $queueTask->addStatus(QueueTaskStatusEnum::NONE);

        if (!empty($queueTaskRepository->findOldestIdToday()))
            $queueTask->setQueueNumber($queueTaskRepository->findOldestIdToday()[0]['queue_number'] + 1);
        else
            $queueTask->setQueueNumber(0);

        $this->entityManager->persist($queueTask);
        $this->entityManager->flush();

        return new JsonResponse(['task'=>$queueTask]);
    }
}
