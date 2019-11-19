<?php


namespace App\Exception\QueueTaskException;


use App\Exception\AbstractException;

class InterestTypeInvalid extends AbstractException
{
    /** @var string */
    protected $message;

    public function __construct(\Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($previous, $headers, $code);
    }

    protected function statusCode(): int
    {
        return 502;
    }

    protected function message(): string
    {
        return "Not valid interest type selected";
    }
}