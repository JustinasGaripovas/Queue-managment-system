<?php

namespace App\Service;

use App\Entity\EmployeeDesk;
use App\Entity\QueueTask;
use App\Repository\EmployeeDeskRepository;
use App\Repository\QueueTaskRepository;
use App\Utilities\Enum\QueueTaskStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeskAssigmentHelper
{
    private $employeeDeskRepository;
    private $queueTaskRepository;
    private $entityManager;

    public function __construct(QueueTaskRepository $queueTaskRepository,EntityManagerInterface $entityManager, EmployeeDeskRepository $employeeDeskRepository)
    {
        $this->queueTaskRepository = $queueTaskRepository;
        $this->entityManager = $entityManager;
        $this->employeeDeskRepository = $employeeDeskRepository;
    }

    public function assignQueueTaskToDesk(EmployeeDesk $employeeDesk, $interestTypes)
    {
        $queueTaskArray = $this->queueTaskRepository->findNextQueueTaskForDesk();

        $queueTask = null;

        $interestTypeArray = [];

        foreach ($interestTypes as $type)
            $interestTypeArray[] = $type->getId();

        foreach ($queueTaskArray as $item)
        {
            /** @var QueueTask $item */
            if (!$item->getIsComplete())
                if ( in_array($item->getInterestType()->getId(), $interestTypeArray))
                {
                    $queueTask = $item;
                    break;
                }
        }

        if($queueTask == null)
            return $queueTask;

        if ($queueTask->getNewestStatusList() != QueueTaskStatusEnum::ACCEPTED)
            $queueTask->addStatus(QueueTaskStatusEnum::ACCEPTED);

        $employeeDesk->setQueueTask($queueTask);
        $employeeDesk->setInUse(true);

        $this->entityManager->flush();

        return $queueTask;
    }

    public function assignDesk(QueueTask $queueTask)
    {
        $correctDesks = $this->employeeDeskRepository->findCorrectDeskForQueueTask($queueTask);

        if($correctDesks == null || empty($correctDesks))
        {
            return null;
        }

        foreach ($correctDesks as $desk)
        {
            /* @var EmployeeDesk $desk */
            if (!$desk->getInUse())
            {
                $correctDesk = $desk;
                $correctDesk->setQueueTask($queueTask);
                $correctDesk->setInUse(true);
                $queueTask->addStatus(QueueTaskStatusEnum::ACCEPTED, $correctDesk, $correctDesk->getEmployee());

                $this->entityManager->flush();
                return $correctDesk;
            }
        }

        return null;
    }
}