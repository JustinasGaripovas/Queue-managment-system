<?php

namespace App\Utilities\StateSwitch;

use App\Utilities\Enum\QueueTaskStatusEnum;

class QueueTaskStateSwitch extends StateSwitch
{
   public function canSwitchState(int $currentState, int $newState, array $relations = QueueTaskStatusEnum::RELATIONS): bool
   {
       return parent::canSwitchState($currentState, $newState, $relations); // TODO: Change the autogenerated stub
   }
}