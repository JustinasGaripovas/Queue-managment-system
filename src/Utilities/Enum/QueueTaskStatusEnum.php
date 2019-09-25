<?php


namespace App\Utilities\Enum;


class QueueTaskStatusEnum
{
    const NONE = 0;
    const NEW = 1;
    const WAITING = 2;
    const ACCEPTED = 3;
    const REDIRECTED = 4;
    const FINISHED = 5;
}