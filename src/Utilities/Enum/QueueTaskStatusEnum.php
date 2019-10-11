<?php


namespace App\Utilities\Enum;


class QueueTaskStatusEnum
{
    // Values
    const NONE = 0;
    const NEW = 1;
    const WAITING = 2;
    const ACCEPTED = 3;
    const SOLVED = 4;
    const DENIED = 5;
    const UNSOLVABLE = 6;

    // Value relations
    const RELATIONS = [
        [1],        // NONE
        [2],        // NEW
        [3,5,6],    // WAITING
        [],         // SOLVED
        [],         // DENIED
        [],         // UNSOLVABLE
    ];

    const END = [
        4, 5, 6
    ];

}