<?php


namespace App\Utilities\StateSwitch;



class AbstractStateSwitch
{
    public function canSwitchState(int $currentState, int $newState, array $relations): bool
    {
        return (in_array($newState,$relations[$currentState]));
    }
}