<?php

namespace App\Controller;

use App\Entity\EmployeeDesk;
use App\Repository\EmployeeDeskRepository;
use App\Response\QueueResponse\QueueTaskNewSuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/desk/managment")
 */
class EmployeeDeskManagementController extends AbstractController
{
    /**
     * @Route("/", name="employee_desk_management_index", methods={"GET"})
     * @param EmployeeDeskRepository $employeeDeskRepository
     * @return Response
     */
    public function index(EmployeeDeskRepository $employeeDeskRepository): Response
    {
        return $this->render('employee_desk_managment/index.html.twig', [
            'employee_desks' => $employeeDeskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/request/task", name="employee_desk_request_queue_task", methods={"GET"})
     * @param EmployeeDesk $employeeDesk
     * @return JsonResponse
     */
    public function requestQueueTask(EmployeeDesk $employeeDesk): JsonResponse
    {
        //TODO: Get guys from waiting queue or accept it instantly

        return new QueueTaskNewSuccessResponse('d');
    }


    /**
     * @Route("/{id}/completed/task", name="employee_desk_complete_queue_task", methods={"GET"})
     * @param EmployeeDesk $employeeDesk
     * @return JsonResponse
     */
    public function completeQueueTask(EmployeeDesk $employeeDesk): JsonResponse
    {

        //TODO: Get current desk

        return new QueueTaskNewSuccessResponse('d');
    }
}
