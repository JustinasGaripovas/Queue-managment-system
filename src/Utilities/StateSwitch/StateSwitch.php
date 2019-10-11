<?php


namespace App\Utilities\StateSwitch;



class StateSwitch
{
    public function canSwitchState(int $currentState, int $newState, array $relations): bool
    {
        return (in_array($newState,$relations[$currentState]));
    }
}