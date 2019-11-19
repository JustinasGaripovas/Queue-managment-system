<?php


namespace App\EventListener;


use App\Entity\EmployeeDesk;
use App\Entity\QueueTask;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QueueTaskEventListener
{
    public function preFlush(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof QueueTask){
            return;
        }
    }

}