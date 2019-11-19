<?php

namespace App\Controller;

use App\Entity\EmployeeDesk;
use App\Entity\QueueTask;
use App\Repository\EmployeeDeskRepository;
use App\Service\DeskAssigmentHelper;
use App\Utilities\Enum\QueueTaskStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ActiveDeskController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/active/desk", name="active_desk")
     */
    public function index(EmployeeDeskRepository  $employeeDeskRepository)
    {
        return $this->render('active_desk/list.html.twig', [
            'desks' => $employeeDeskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/active/desk/{id}/dashboard", name="active_desk_dashboard")
     */
    public function manageDesk(EmployeeDesk $employeeDesk)
    {
        return $this->render('active_desk/index.html.twig', [
            'desk' => $employeeDesk,
            'queueTask' => $employeeDesk->getQueueTask()
        ]);
    }

    /**
     * @Route("/active/desk/{id}/completed", name="active_desk_complete_task")
     */
    public function completedTask(EmployeeDeskRepository $employeeDeskRepository,EmployeeDesk $employeeDesk, Request $request, DeskAssigmentHelper $deskAssigmentHelper)
    {
        $completed = $request->request->get('completed');

        if ($completed == QueueTaskStatusEnum::SOLVED) {
            $employeeDesk->getQueueTask()->addStatus(QueueTaskStatusEnum::SOLVED);
        }

        if ($completed == QueueTaskStatusEnum::UNSOLVABLE) {
            $employeeDesk->getQueueTask()->addStatus(QueueTaskStatusEnum::UNSOLVABLE);
        }

        if ($completed == QueueTaskStatusEnum::DENIED) {
            $employeeDesk->getQueueTask()->addStatus(QueueTaskStatusEnum::DENIED);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $array = [];
        /** @var QueueTask $queueTask */
        $queueTask = $deskAssigmentHelper->assignQueueTaskToDesk($employeeDesk, $employeeDesk->getEmployee()->getInterestType());

        if ($employeeDesk->getIsOnline()) {
            $desk = $employeeDeskRepository->findOneBy(['id'=>$employeeDesk->getId()]);
            $desk->setQueueTask($queueTask);
            $desk->setInUse(false);
            $this->entityManager->flush();
        } else {
            return new JsonResponse([
                $array = [
                    'in_use' => false,
                    'queue_task' => [
                        'number' => '',
                        'name' => '',
                        'status' => ''
                    ]
                ]
            ]);
        }

        return new JsonResponse([
            $this->returnFormattedQueueTask($queueTask)
        ]);
    }

    private function returnFormattedQueueTask($queueTask)
    {
        $array = array();

        if ($queueTask != null)
            $array = [
                'in_use' => true,
                'queue_task' => [
                    'number' => $queueTask->getFormattedQueueNumber(),
                    'name' => $queueTask->getInterestType()->getFullName(),
                    'status' => $queueTask->getStatusList()
                ]
            ];
        else
            $array = [
                'in_use' => true,
                'queue_task' => [
                    'number' => '',
                    'name' => '',
                    'status' => ''
                ]
            ];

        return $array;

    }

    /**
     * @Route("/active/desk/{id}/queue/task", name="active_desk_get_queue_task")
     */
    public function getQueueTask(EmployeeDesk $employeeDesk)
    {
        return new JsonResponse([
            $this->returnFormattedQueueTask($employeeDesk->getQueueTask())
        ]);
    }

    /**
     * @Route("/active/desk/{id}/toggle", name="active_desk_toggle")
     */
    public function toggleDesk(EmployeeDesk $employeeDesk, Request $request)
    {
        $toggle = ($request->request->get('toggle') == 'true')?true:false;

        $employeeDesk->setIsOnline($toggle);

        $this->entityManager->flush();

        return new JsonResponse(['toggle'=>$employeeDesk->getIsOnline()]);
    }


}
