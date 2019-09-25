<?php

namespace App\Utilities\StateSwitch;

use App\Entity\QueueTask;

class QueueTaskStateSwitch
{
    public function switchState(QueueTask $queueTask, $state)
    {
        $currentState = $queueTask->getId();
    }
}