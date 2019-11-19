<?php

namespace App\Controller;

use App\Entity\EmployeeDesk;
use App\Entity\QueueTask;
use App\Repository\EmployeeDeskRepository;
use App\Repository\QueueTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class JumbotronController extends AbstractController
{
    private $employeeDeskRepository;
    private $queueTaskRepository;

    public function __construct(QueueTaskRepository $queueTaskRepository,EmployeeDeskRepository $employeeDeskRepository)
    {
        $this->queueTaskRepository = $queueTaskRepository;
        $this->employeeDeskRepository = $employeeDeskRepository;
    }

    /**
     * @Route("/jumbotron", name="jumbotron")
     */
    public function index()
    {
        $allDesks = $this->employeeDeskRepository->findOnlineTables();
        return $this->render('jumbotron/index.html.twig', [
            'desks' => $allDesks
        ]);
    }

    /**
     * @Route("/api/jumbotron/refresh/assignments-table", name="jumbotron_refresh_assignments")
     */
    public function refreshAssignments(): JsonResponse
    {
        $array = [];

        foreach ($this->employeeDeskRepository->findOnlineTables() as $t){
            /* @var EmployeeDesk $t */
            $array[] = [
                'number' => $t->getNumber(),
                'queueNumber' => ($t->getQueueTask()!=null) ? $t->getQueueTask()->getFormattedQueueNumber() : 'Tuscia'
            ];
        }
        return new JsonResponse($array);
    }

    /**
     * @Route("/api/jumbotron/refresh/waiting-line", name="jumbotron_refresh_waiting")
     */
    public function refreshWaitingLine()
    {
        $array = [];
        foreach ($this->queueTaskRepository->findOldest() as $qt)
            $array[] = $qt->getFormattedQueueNumber();

        return new JsonResponse($array);
    }



}
