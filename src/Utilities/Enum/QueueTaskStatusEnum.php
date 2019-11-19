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
    const CLOSED = 7;

    // Value relations
    const RELATIONS = [
        [1],        // NONE
        [2,3],        // NEW
        [3],        // WAITING
        [4,5,6],    // ACCEPTED
        [7],    // SOLVED
        [7],    // DENIED
        [7],    // UNSOLVABLE
        [7],    // CLOSED
    ];

    const END = [
        4, 5, 6
    ];

}