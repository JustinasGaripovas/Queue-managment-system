<?php


namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse extends JsonResponse
{

    public function __construct()
    {
        parent::__construct($this->serialize(), $this->status());
    }

    /**
     * @return array
     */
    abstract public function serialize(): array;

    /**
     * @return int
     */
    abstract protected function status(): int;
}