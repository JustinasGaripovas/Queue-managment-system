<?php


namespace App\Response\InterestResponse;


use App\Response\AbstractResponse;

class InterestTypeInvalidResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'response' => [
                "error_code" => "01",
                "error_message" => $this->message,
            ]
        ];
    }

    /**
     * @return int
     */
    protected function status(): int
    {
        return 409;
    }
}