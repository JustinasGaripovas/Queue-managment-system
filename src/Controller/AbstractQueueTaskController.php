<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AbstractQueueTaskController extends AbstractController
{
    /**
     * @Route("/queue/task/registration", name="queue_task_registration")
     */
    public function queueTaskRegistration()
    {
        return $this->render('abstract_queue_task/index.html.twig', [
            'controller_name' => 'AbstractQueueTaskController',
        ]);
    }

    /**
     * @Route("/queue/task/new" , name="queue_task_new", condition="request.isXmlHttpRequest()")
     */
    public function queueTaskNew(Request $request): JsonResponse
    {



        return new JsonResponse();
    }
}
