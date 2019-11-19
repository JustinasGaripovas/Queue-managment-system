<?php


namespace App\Exception;


use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractException extends HttpException
{
    public function __construct(\Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($this->statusCode(), $this->message(), $previous, $headers, $code);
    }

    abstract protected function statusCode(): int;

    abstract protected function message(): string;

}