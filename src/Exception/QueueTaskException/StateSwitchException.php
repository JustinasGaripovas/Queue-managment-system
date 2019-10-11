<?php


namespace App\Exception\QueueTaskException;


use App\Exception\AbstractException;

class StateSwitchException extends AbstractException
{
    /** @var string */
    protected $message;

    public function __construct(\Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($previous, $headers, $code);
    }

    protected function statusCode(): int
    {
        return 501;
    }

    protected function message(): string
    {
        return "State switch server error";
    }
}